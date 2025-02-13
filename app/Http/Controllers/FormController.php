<?php

namespace App\Http\Controllers;

use Log;
// use Mpdf\Mpdf;
use Carbon\Carbon;
use App\Models\Form;
use App\Models\Unit;
use App\Models\User;
use App\Models\Status;
use GuzzleHttp\Client;
use App\Models\Category;
use App\Models\Document;
use App\Models\FormTime;
use App\Models\Standard;
use App\Models\FormAudit;
use App\Models\Indicator;
use App\Models\Competency;
use App\Models\FormAccess;
use App\Events\FormUpdated;
use Illuminate\Http\Request;
use App\Models\FormSubmission;
use PhpOffice\PhpWord\IOFactory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\Element\Chart;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
// use PhpOffice\PhpWord\Writer\PDF\TCPDF;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Chart as SpreadsheetChart;
use id;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (app('user_role') === 'PJM') {
            // Jika pengguna masuk sebagai admin, ambil semua formulir
            // $forms = Form::all();
            $forms = Form::orderBy('id', 'desc')->get();
        } else {
            $userId = auth()->id();

            // Jika bukan admin, ambil formulir berdasarkan akses pengguna
            $forms = Form::whereHas('formAccesses', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    // ->where(function ($query) {
                    //     $query->where('position', 'Pimpinan')
                    //         ->orWhere('position', 'LIKE', 'PIC%');
                    // })
                ;
            })->get();

            foreach ($forms as $form) {

                $auditeeAccess = false;

                $auditee = $form->formAccesses->contains(function ($access) {
                    return $access->user_id === auth()->id() &&
                        ($access->position === 'Chief' || strpos($access->position, 'PIC') !== false);
                });

                if ($auditee) {
                    $auditeeAccess = true;
                }

                $form->auditeeAccess = $auditeeAccess;

                $auditor = false;

                $auditorAccess = $form->formAccesses->contains(function ($access) {
                    return $access->user_id === auth()->id() &&
                        ($access->position === 'Leader' || strpos($access->position, 'Member') !== false);
                });

                if ($auditorAccess) {
                    $auditor = true;
                }

                $form->auditorAccess = $auditorAccess;
            }

            // $userId = auth()->id();
            // $userRole = auth()->user()->role; // Asumsi role diambil dari user

            // $forms = Form::with(['formAccesses', 'unit', 'document', 'stage'])
            //     ->get()
            //     ->map(function ($form) use ($userId) {
            //         // Periksa akses Auditee (Pimpinan atau PIC)
            //         $form->auditeeAccess = $form->formAccesses->contains(function ($access) use ($userId) {
            //             return $access->user_id === $userId &&
            //                 ($access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false);
            //         });

            //         // Periksa akses Auditor (Ketua atau Anggota)
            //         $form->auditorAccess = $form->formAccesses->contains(function ($access) use ($userId) {
            //             return $access->user_id === $userId &&
            //                 ($access->position === 'Ketua' || $access->position === 'Anggota');
            //         });

            //         return $form;
            //     });
        }

        return view('forms.index', compact('forms'));
    }

    public function create(Request $request)
    {
        $documents = Document::orderBy('created_at', 'desc')->pluck('name', 'id');

        $documentId = $request->input('document_id', $documents->keys()->first());

        if ($documentId) {
            $categories = Category::where('document_id', $documentId)->get();

            $standards = Standard::whereIn('category_id', $categories->pluck('id'))->get();

            $competencies = Competency::whereIn('standard_id', $standards->pluck('id'))->get();

            $indicators = Indicator::whereIn('competency_id', $competencies->pluck('id'))->get();

            $standardsByCategory = $standards->groupBy('category_id');

            $competenciesByStandard = $competencies->groupBy('standard_id');

            $indicatorsByCompetency = $indicators->groupBy('competency_id');
        } else {
            $categories = collect();
            $standardsByCategory = collect();
            $competenciesByStandard = collect();
            $indicatorsByCompetency = collect();
        }

        $units = Unit::all();
        $users = User::all();

        return view('forms.create', compact('units', 'users',  'documentId', 'documents', 'categories', 'standardsByCategory', 'competenciesByStandard', 'indicatorsByCompetency'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $units = $request->input('units');
        $document = $request->input('document');
        $deadline = str_replace('T', ' ', $request->input('deadline')) . ':00';
        $positions = $request->input('positions');
        $userNames = $request->input('user_names'); // Dapatkan input nama user
        $userUsernames = $request->input('user_usernames'); // Dapatkan input username user
        $userEmails = $request->input('user_emails'); // Dapatkan input email user
        $indicators_id = $request->input('indicators_id');

        foreach ($units as $index => $unit) {
            $form = Form::create([
                'document_id' => $document,
                'unit_id' => $unit,
                'stage_id' => 1,
                'deadline' => $deadline
            ]);

            $unitUserNames = $userNames[$unit] ?? []; // Dapatkan nama user untuk unit ini
            $unitUserUsernames = $userUsernames[$unit] ?? []; // Dapatkan username user untuk unit ini
            $unitUserEmails = $userEmails[$unit] ?? []; // Dapatkan email user untuk unit ini
            $unitPositions = $positions[$unit] ?? []; // Dapatkan data posisi untuk unit ini

            foreach ($unitUserEmails as $index => $email) {
                $name = $unitUserNames[$index] ?? ''; // Ambil nama yang sesuai atau default
                $username = $unitUserUsernames[$index] ?? ''; // Ambil username yang sesuai atau default
                $position = $unitPositions[$index] ?? ''; // Ambil posisi yang sesuai atau default

                // Periksa apakah email dan nama tidak kosong
                if (empty($email) || empty($name)) {
                    continue; // Lewati iterasi jika email atau nama kosong
                }

                $user = User::firstOrCreate(
                    ['email' => $email], // Jika user tidak ditemukan berdasarkan email
                    [
                        'name' => $name,
                        'username' => $username,
                        'email' => $email,
                    ] // Buat user baru dengan nama ini
                );

                if (in_array($position, ['Chief']) || strpos($position, 'PIC') !== false) {
                    $user->assignRole('Auditee');
                } elseif (in_array($position, ['Leader']) || strpos($position, 'Member') !== false) {
                    $user->assignRole('Auditor');
                }

                // Setelah user ditemukan atau dibuat, buat entri FormAccess
                FormAccess::create([
                    'form_id' => $form->id,
                    'user_id' => $user->id,
                    'position' => $position
                ]);
            }

            foreach ($indicators_id as $indicator_id) {
                FormAudit::create([
                    'form_id' => $form->id,
                    'indicator_id' => $indicator_id
                ]);
            }
        }

        return redirect()->route('forms.index')->with('success', 'Data saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        $viewAccess = $formAccesses->contains('user_id', auth()->id());

        if (!$viewAccess && app('user_role') !== 'PJM') {
            abort(403);
        }

        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Chief' || strpos($access->position, 'PIC') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Chief' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Leader' || strpos($access->position, 'Member') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Leader' ? 0 : (intval(str_replace('Member', '', $access->position)) ?: 1);
        });

        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->get();

        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator?->competency?->standard?->category?->id ?? null;
        });

        $statuses = Status::orderBy('id', 'desc')->get();

        return view('forms.show', compact('form', 'auditees', 'auditors', 'grouped', 'statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form, Request $request)
    {
        $documents = Document::orderBy('created_at', 'desc')->pluck('name', 'id');

        $documentId = $request->input('document_id', $documents->keys()->first());

        if ($documentId) {
            $categories = Category::where('document_id', $documentId)->get();

            $standards = Standard::whereIn('category_id', $categories->pluck('id'))->get();

            $competencies = Competency::whereIn('standard_id', $standards->pluck('id'))->get();

            $indicators = Indicator::whereIn('competency_id', $competencies->pluck('id'))->get();

            $standardsByCategory = $standards->groupBy('category_id');

            $competenciesByStandard = $competencies->groupBy('standard_id');

            $indicatorsByCompetency = $indicators->groupBy('competency_id');
        } else {
            $categories = collect();
            $standardsByCategory = collect();
            $competenciesByStandard = collect();
            $indicatorsByCompetency = collect();
        }

        $units = Unit::all();
        $users = User::all();

        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        return view('forms.edit', compact('formAccesses', 'form', 'units', 'users',  'documentId', 'documents', 'categories', 'standardsByCategory', 'competenciesByStandard', 'indicatorsByCompetency'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        Form::destroy($form->id);

        return redirect('/forms')->with('status', 'Form berhasil dihapus.');
    }

    public function editSubmission(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        $editAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() &&
                ($access->position === 'Chief' || strpos($access->position, 'PIC') !== false);
        });

        if (!$editAccess || $form->stage_id !== 1 || app('user_role') !== 'Auditee') {
            abort(403, "The form is currently {$form->stage->name} Stage.");
        }

        $submitAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() && $access->position === 'Chief';
        });

        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Chief' || strpos($access->position, 'PIC') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Chief' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Leader' || strpos($access->position, 'Member') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Leader' ? 0 : (intval(str_replace('Member', '', $access->position)) ?: 1);
        });

        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->get();

        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator?->competency?->standard?->category?->id ?? null;
        });

        $statuses = Status::orderBy('id', 'desc')->get();

        return view('forms.edit-submission', compact('form', 'submitAccess', 'auditees', 'auditors', 'grouped', 'statuses'));
    }

    public function updateSubmission(Request $request, Form $form)
    {
        if ($request->input('action') === 'submit') {

            $indicators = $request->input('indicators');

            foreach ($indicators as $indicator) {
                $indicator = json_decode($indicator, true); // Mengubah JSON string menjadi array

                $code = $indicator['code'];

                Validator::make($indicator, [
                    "id" => 'required|integer|exists:form_audits,id',
                    "submission_status" => 'required|integer|exists:statuses,id',
                    "validation" => 'required|string',
                    "link" => 'required|string',
                ])->setAttributeNames([
                    "submission_status" => "Audit {$code}",
                    "validation" => "Validation {$code}",
                    "link" => "Link {$code}",
                ])->validate();
            }

            FormTime::updateOrCreate(
                ['form_id' => $form->id],
                ['submission_time' => now()]
            );

            // Gunakan operator ternary untuk menentukan nilai berdasarkan tombol yang ditekan
            Form::updateOrCreate(
                ['id' => $form->id],
                ['stage_id' => 2]
            );

            return redirect('forms')->with('success', "Form {$form->unit->code} {$form->document->name} submitted successfully.");
        } else {

            $indicator = $request->input('indicator');

            // Update the FormAudit entry based on the provided indicator data
            FormAudit::updateOrCreate(
                ['id' => $indicator['id']], // Cari evaluasi berdasarkan ID
                [
                    'submission_status' => $indicator['submission_status'],
                    'validation' => $indicator['validation'],
                    'link' => $indicator['link'],
                ]
            );

            // Dispatch the event for the updated indicator
            FormUpdated::dispatch($form->id, $indicator, auth()->user()->name);

            return response()->json(['message' => "{$indicator['code']} updated successfully."]);
        }
    }

    public function editAssessment(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        $editAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() &&
                ($access->position === 'Leader' || strpos($access->position, 'Member') !== false);
        });

        if (!$editAccess || $form->stage_id !== 2 || app('user_role') !== 'Auditor') {
            abort(403, "The form is currently {$form->stage->name} Stage.");
        }

        $submitAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() && $access->position === 'Leader';
        });

        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Chief' || strpos($access->position, 'PIC') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Chief' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Leader' || strpos($access->position, 'Member') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Leader' ? 0 : (intval(str_replace('Member', '', $access->position)) ?: 1);
        });

        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->get();

        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator?->competency?->standard?->category?->id ?? null;
        });

        $statuses = Status::orderBy('id', 'desc')->get();

        return view('forms.edit-assessment', compact('form', 'submitAccess', 'auditees', 'auditors', 'grouped', 'statuses'));
    }

    public function updateAssessment(Request $request, Form $form)
    {
        if ($request->input('action') === 'submit') {

            $indicators = $request->input('indicators');

            foreach ($indicators as $indicator) {
                $indicator = json_decode($indicator, true); // Mengubah JSON string menjadi array

                $code = $indicator['code'];

                Validator::make($indicator, [
                    "id" => 'required|integer|exists:form_audits,id',
                    "assessment_status" => 'required|integer|exists:statuses,id',
                    "description" => 'nullable|string',
                ])->setAttributeNames([
                    "assessment_status" => "Audit {$code}",
                    "description" => "Description {$code}",
                ])->validate();
            }

            FormTime::updateOrCreate(
                ['form_id' => $form->id],
                ['assessment_time' => now()]
            );

            // Gunakan operator ternary untuk menentukan nilai berdasarkan tombol yang ditekan
            Form::updateOrCreate(
                ['id' => $form->id],
                ['stage_id' => 3]
            );

            return redirect('forms')->with('success', "Form {$form->unit->code} {$form->document->name} submitted successfully.");
        } else {

            $indicator = $request->input('indicator');

            // Update the FormAudit entry based on the provided indicator data
            FormAudit::updateOrCreate(
                ['id' => $indicator['id']], // Cari evaluasi berdasarkan ID
                [
                    'assessment_status' => $indicator['assessment_status'],
                    'description' => $indicator['description'],
                ]
            );

            // Dispatch the event for the updated indicator
            FormUpdated::dispatch($form->id, $indicator, auth()->user()->name);

            return response()->json(['message' => "{$indicator['code']} updated successfully."]);
        }
    }

    public function editFeedback(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        $editAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() &&
                ($access->position === 'Chief' || strpos($access->position, 'PIC') !== false);
        });

        if (!$editAccess || $form->stage_id !== 3 || app('user_role') !== 'Auditee') {
            abort(403, "The form is currently {$form->stage->name} Stage.");
        }

        $submitAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() && $access->position === 'Chief';
        });

        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Chief' || strpos($access->position, 'PIC') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Chief' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Leader' || strpos($access->position, 'Member') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Leader' ? 0 : (intval(str_replace('Member', '', $access->position)) ?: 1);
        });

        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->get();

        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator?->competency?->standard?->category?->id ?? null;
        });

        $statuses = Status::orderBy('id', 'desc')->get();

        return view('forms.edit-feedback', compact('form', 'submitAccess', 'auditees', 'auditors', 'grouped', 'statuses'));
    }

    public function updateFeedback(Request $request, Form $form)
    {
        if ($request->input('action') === 'submit') {

            $indicators = $request->input('indicators');

            foreach ($indicators as $indicator) {
                $indicator = json_decode($indicator, true); // Mengubah JSON string menjadi array

                $indicator['feedback'] = $indicator['feedback'] === "" ? 1 : $indicator['feedback'];
                $code = $indicator['code'];

                Validator::make($indicator, [
                    "id" => 'required|integer|exists:form_audits,id',
                    "validation" => 'required|string',
                    "link" => 'required|string',
                    "feedback" => 'required|integer',
                    "comment" => 'nullable|string',
                ])->setAttributeNames([
                    "validation" => "Validation {$code}",
                    "link" => "Link {$code}",
                    "feedback" => "Feedback {$code}",
                    "comment" => "Comment {$code}",
                ])->validate();

                FormAudit::updateOrCreate(
                    ['id' => $indicator['id']], // Cari evaluasi berdasarkan ID
                    [
                        'feedback' => $indicator['feedback'],
                    ]
                );
            }

            FormTime::updateOrCreate(
                ['form_id' => $form->id],
                ['feedback_time' => now()]
            );

            // Gunakan operator ternary untuk menentukan nilai berdasarkan tombol yang ditekan
            Form::updateOrCreate(
                ['id' => $form->id],
                ['stage_id' => 4]
            );

            return redirect('forms')->with('success', "Form {$form->unit->code} {$form->document->name} submitted successfully.");
        } else {

            $indicator = $request->input('indicator');

            // Update the FormAudit entry based on the provided indicator data
            FormAudit::updateOrCreate(
                ['id' => $indicator['id']], // Cari evaluasi berdasarkan ID
                [
                    'validation' => $indicator['validation'],
                    'link' => $indicator['link'],
                    'feedback' => $indicator['feedback'],
                    'comment' => $indicator['comment'],
                ]
            );

            // Dispatch the event for the updated indicator
            FormUpdated::dispatch($form->id, $indicator, auth()->user()->name);

            return response()->json(['message' => "{$indicator['code']} updated successfully."]);
        }
    }

    public function editValidation(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        $editAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() &&
                ($access->position === 'Leader' || strpos($access->position, 'Member') !== false);
        });

        if (!$editAccess || $form->stage_id !== 4 || app('user_role') !== 'Auditor') {
            abort(403, "The form is currently {$form->stage->name} Stage.");
        }

        $submitAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() && $access->position === 'Leader';
        });

        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Chief' || strpos($access->position, 'PIC') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Chief' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Leader' || strpos($access->position, 'Member') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Leader' ? 0 : (intval(str_replace('Member', '', $access->position)) ?: 1);
        });

        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->get();

        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator?->competency?->standard?->category?->id ?? null;
        });

        // $statuses = Status::orderBy('id', 'desc')->get();

        $statuses = Status::whereIn('id', [2, 3])->orderBy('id', 'desc')->get();

        return view('forms.edit-validation', compact('form', 'submitAccess', 'auditees', 'auditors', 'grouped', 'statuses'));
    }

    public function updateValidation(Request $request, Form $form)
    {
        if ($request->input('action') === 'submit') {

            $indicators = $request->input('indicators');

            foreach ($indicators as $indicator) {
                $indicator = json_decode($indicator, true); // Mengubah JSON string menjadi array

                $code = $indicator['code'];

                Validator::make($indicator, [
                    "id" => 'required|integer|exists:form_audits,id',
                    "validation_status" => 'required|integer|exists:statuses,id',
                    "conclusion" => 'required|string',
                ])->setAttributeNames([
                    "validation_status" => "Audit {$code}",
                    "conclusion" => "Conclusion {$code}",
                ])->validate();
            }

            FormTime::updateOrCreate(
                ['form_id' => $form->id],
                ['validation_time' => now()]
            );

            // Gunakan operator ternary untuk menentukan nilai berdasarkan tombol yang ditekan
            Form::updateOrCreate(
                ['id' => $form->id],
                ['stage_id' => 5]
            );

            return redirect('forms')->with('success', "Form {$form->unit->code} {$form->document->name} submitted successfully.");
        } else {

            $indicator = $request->input('indicator');

            // Update the FormAudit entry based on the provided indicator data
            FormAudit::updateOrCreate(
                ['id' => $indicator['id']], // Cari evaluasi berdasarkan ID
                [
                    'validation_status' => $indicator['validation_status'],
                    'conclusion' => $indicator['conclusion'],
                ]
            );

            // Dispatch the event for the updated indicator
            FormUpdated::dispatch($form->id, $indicator, auth()->user()->name);

            return response()->json(['message' => "{$indicator['code']} updated successfully."]);
        }
    }

    public function editMeeting(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        $editAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() &&
                ($access->position === 'Chief' || strpos($access->position, 'PIC') !== false);
        });

        if (!$editAccess || $form->stage_id !== 5 || app('user_role') !== 'Auditee') {
            abort(403, "The form is currently {$form->stage->name} Stage.");
        }

        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Chief' || strpos($access->position, 'PIC') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Chief' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Leader' || strpos($access->position, 'Member') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Leader' ? 0 : (intval(str_replace('Member', '', $access->position)) ?: 1);
        });

        return view('forms.edit-meeting', compact('form', 'auditees', 'auditors'));
    }

    public function updateMeeting(Request $request, Form $form)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf|max:5120', // Validasi file
            'time' => 'required|date',
        ]);

        // Cari data berdasarkan ID
        $form = Form::findOrFail($form->id);

        // Update field `document` jika ada file baru
        if ($request->hasFile('document')) {
            // Hapus file lama jika ada
            if ($form->meeting) {
                Storage::delete('public/' . $form->meeting);
            }

            // Simpan file baru
            $filePath = $request->file('document')->store('meeting', 'public');
        }

        $form->update([
            'meeting' => $filePath,
            'meeting_time' => $request->input('time'),
            'meeting_verification' => null, // Reset verifikasi
            'verification_info' => null, // Reset verifikasi
        ]);

        // Update field `date`

        FormTime::updateOrCreate(
            ['form_id' => $form->id],
            ['meeting_time' => now()]
        );

        return redirect('/forms')->with('success', 'Evidence submitted successfully.');
    }

    public function editMeetingVerification(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        if ($form->stage_id !== 5 || !$form->meeting || app('user_role') !== 'PJM') {
            abort(403, "The form is currently {$form->stage->name} Stage.");
        }

        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Chief' || strpos($access->position, 'PIC') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Chief' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Leader' || strpos($access->position, 'Member') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Leader' ? 0 : (intval(str_replace('Member', '', $access->position)) ?: 1);
        });

        return view('forms.edit-meeting-verification', compact('form', 'auditees', 'auditors'));
    }

    public function updateMeetingVerification(Request $request, Form $form)
    {
        // Cari data berdasarkan ID
        $form = Form::findOrFail($form->id);

        // Update field `date`
        if ($request->input('action') === 'accept') {

            $form->update([
                'meeting_verification' => true,
                'verification_info' => null,
            ]);

            Form::updateOrCreate(
                ['id' => $form->id],
                ['stage_id' => 6]
            );
        } else if ($request->input('action') === 'decline') {

            $request->validate([
                'verification_info' => 'required|string|max:255',
            ]);

            $form->update([
                'meeting_verification' => false,
                'verification_info' => $request->input('verification_info'),
            ]);
        }

        // Simpan perubahan
        $form->save();

        return redirect('/forms')->with('success', 'Verification submitted successfully.');
    }

    public function editPlanning(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        $editAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() &&
                ($access->position === 'Chief' || strpos($access->position, 'PIC') !== false);
        });

        if (!$editAccess || $form->stage_id !== 6 || app('user_role') !== 'Auditee') {
            abort(403, "The form is currently {$form->stage->name} Stage.");
        }

        $submitAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() && $access->position === 'Chief';
        });

        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Chief' || strpos($access->position, 'PIC') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Chief' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Leader' || strpos($access->position, 'Member') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Leader' ? 0 : (intval(str_replace('Member', '', $access->position)) ?: 1);
        });

        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->whereIn('validation_status', [1, 2])->get();


        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator?->competency?->standard?->category?->id ?? null;
        });

        $statuses = Status::orderBy('id', 'desc')->get();

        return view('forms.edit-planning', compact('form', 'submitAccess', 'auditees', 'auditors', 'grouped', 'statuses'));
    }

    public function updatePlanning(Request $request, Form $form)
    {
        if ($request->input('action') === 'submit') {

            $indicators = $request->input('indicators');

            foreach ($indicators as $indicator) {
                $indicator = json_decode($indicator, true); // Mengubah JSON string menjadi array

                $code = $indicator['code'];

                Validator::make($indicator, [
                    "id" => 'required|integer|exists:form_audits,id',
                    "planning" => 'required|string',
                ])->setAttributeNames([
                    "planning" => "Plan {$code}",
                ])->validate();
            }

            FormTime::updateOrCreate(
                ['form_id' => $form->id],
                ['planning_time' => now()]
            );

            // Gunakan operator ternary untuk menentukan nilai berdasarkan tombol yang ditekan
            Form::updateOrCreate(
                ['id' => $form->id],
                ['stage_id' => 7]
            );

            return redirect('forms')->with('success', "Form {$form->unit->code} {$form->document->name} successfully submitted.");
        } else {

            $indicator = $request->input('indicator');

            // Update the FormAudit entry based on the provided indicator data
            FormAudit::updateOrCreate(
                ['id' => $indicator['id']], // Cari evaluasi berdasarkan ID
                [
                    'planning' => $indicator['planning'],
                ]
            );

            // Dispatch the event for the updated indicator
            FormUpdated::dispatch($form->id, $indicator, auth()->user()->name);

            return response()->json(['message' => "{$indicator['code']} successfully updated."]);
        }
    }

    public function editSigning(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        $editAccess = $formAccesses->contains(function ($access) {
            return $access->user_id === auth()->id() &&
                ($access->position === 'Chief' || strpos($access->position, 'PIC') !== false);
        });

        if (!$editAccess || $form->stage_id !== 7 || app('user_role') !== 'Auditee') {
            abort(403, "The form is currently {$form->stage->name} Stage.");
        }

        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Chief' || strpos($access->position, 'PIC') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Chief' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Leader' || strpos($access->position, 'Member') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Leader' ? 0 : (intval(str_replace('Member', '', $access->position)) ?: 1);
        });

        return view('forms.edit-signing', compact('form', 'auditees', 'auditors'));
    }

    public function updateSigning(Request $request, Form $form)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf|max:5120',
        ]);

        // Cari data berdasarkan ID
        $form = Form::findOrFail($form->id);

        // Update field `document` jika ada file baru
        if ($request->hasFile('document')) {
            // Hapus file lama jika ada
            if ($form->signing) {
                Storage::delete('public/' . $form->signing);
            }

            // Simpan file baru
            $filePath = $request->file('document')->store('signing', 'public');
        }

        $form->update([
            'signing' => $filePath,
            'signing_verification' => null, // Reset verifikasi
            'verification_info' => null, // Reset verifikasi
        ]);

        // Update field `date`
        FormTime::updateOrCreate(
            ['form_id' => $form->id],
            ['signing_time' => now()]
        );

        return redirect('/forms')->with('success', 'Signed submitted successfully.');
    }

    public function editSigningVerification(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        if ($form->stage_id !== 7 || !$form->signing || app('user_role') !== 'PJM') {
            abort(403, "The form is currently {$form->stage->name} Stage.");
        }

        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Chief' || strpos($access->position, 'PIC') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Chief' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Leader' || strpos($access->position, 'Member') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Leader' ? 0 : (intval(str_replace('Member', '', $access->position)) ?: 1);
        });

        return view('forms.edit-signing-verification0', compact('form', 'auditees', 'auditors'));
    }

    public function updateSigningVerification(Request $request, Form $form)
    {
        // Cari data berdasarkan ID
        $form = Form::findOrFail($form->id);

        // Update field `date`
        if ($request->input('action') === 'accept') {

            $form->update([
                'signing_verification' => true,
                'verification_info' => null,
            ]);

            Form::updateOrCreate(
                ['id' => $form->id],
                ['stage_id' => 8]
            );
        } else if ($request->input('action') === 'decline') {

            $request->validate([
                'verification_info' => 'required|string|max:255',
            ]);

            $form->update([
                'signing_verification' => false,
                'verification_info' => $request->input('verification_info'),
            ]);
        }

        // Simpan perubahan
        $form->save();

        return redirect('/forms')->with('success', 'Verification submitted successfully.');
    }

    public function showReport(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        if ($form->stage_id !== 8) {
            abort(403, "The form is currently {$form->stage->name} Stage.");
        }

        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Chief' || strpos($access->position, 'PIC') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Chief' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Leader' || strpos($access->position, 'Member') !== false;
        })->sortBy(function ($access) {
            return $access->position === 'Leader' ? 0 : (intval(str_replace('Member', '', $access->position)) ?: 1);
        });

        return view('forms.show-report', compact('form', 'auditees', 'auditors'));
    }

    public function export(Form $form)
    {
        $formAudits = FormAudit::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $form->id)->get();

        // Load template
        $templateProcessor = new TemplateProcessor('templates/AMI Report.docx');

        // Header
        // Set nilai untuk unit
        $document_code = $form->document->code;
        $templateProcessor->setValue('document_code', $document_code);
        $unit = strtoupper($form->unit->name);
        $templateProcessor->setValue('unit', $unit);

        // Ambil akses formulir
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        // A

        $translations = [
            'Chief' => 'Pimpinan',
            'PIC' => 'Penanggungjawab',
            'Leader' => 'Ketua',
            'Member' => 'Anggota',
        ];

        // Filter dan transformasi data untuk auditees
        $auditeesData = $formAccesses->filter(
            fn($access) =>
            in_array($access->position, ['Chief', 'PIC']) || strpos($access->position, 'PIC') !== false
        )->sortBy(function ($access) {
            return $access->position === 'Chief' ? 0 : (intval(str_replace('PIC', '', $access->position)) ?: 1);
        })->map(fn($auditee) => [
            'auditee_position' => str_replace(array_keys($translations), array_values($translations), $auditee->position),
            'auditee_name' => $auditee->user->name ?? '',
            'auditee_contact' => $auditee->user->contact,
        ])->values();

        // Filter dan transformasi data untuk auditors
        $auditorsData = $formAccesses->filter(
            fn($access) =>
            in_array($access->position, ['Leader', 'Member']) || strpos($access->position, 'Member') !== false
        )->sortBy(function ($access) {
            return $access->position === 'Leader' ? 0 : (intval(str_replace('Member', '', $access->position)) ?: 1);
        })->map(fn($auditor) => [
            'auditor_position' => str_replace(array_keys($translations), array_values($translations), $auditor->position),
            'auditor_name' => $auditor->user->name ?? '',
            'auditor_contact' => $auditor->user->contact,
        ])->values();

        // Gabungkan data auditees dan auditors sebagai template
        $combinedData = collect(range(0, max($auditeesData->count(), $auditorsData->count()) - 1))
            ->map(fn($i) => [
                'auditee_position' => $auditeesData[$i]['auditee_position'] ?? '',
                'auditee_name' => $auditeesData[$i]['auditee_name'] ?? '',
                'auditee_contact' => $auditeesData[$i]['auditee_contact'] ?? '',
                'auditor_position' => $auditorsData[$i]['auditor_position'] ?? '',
                'auditor_name' => $auditorsData[$i]['auditor_name'] ?? '',
                'auditor_contact' => $auditorsData[$i]['auditor_contact'] ?? '',
            ])
            ->toArray();

        // Clone rows dan set nilai
        $templateProcessor->cloneRowAndSetValues('auditee_position', $combinedData);

        // B

        // Transformasi nilai dan hitung rata-rata
        $average = $formAudits->map(function ($audit) {
            return match ($audit->validation_status) {
                1 => 0,
                2 => 1,
                3 => 2,
                4 => 3,
                default => 0, // Jaga-jaga jika ada nilai selain 1-4
            };
        })->average();

        $achievements = round(($average / 3 * 100), 2);
        $templateProcessor->setValue('achievements', $achievements . ' %');

        $findings = FormAudit::where('form_id', $form->id)->whereIn('validation_status', [1, 2])->count();
        $templateProcessor->setValue('findings', $findings);

        // Grupkan FormAudit berdasarkan kategori
        $grouped = $formAudits->groupBy(function ($item) {
            return $item->indicator?->competency?->standard?->category?->id ?? null;
        });

        $results = [];
        $counter = 1;

        // Iterasi setiap kategori
        foreach ($grouped as $categoryId => $category) {
            // $totalCompetencies = 0;
            // $passedCompetencies = 0;

            $totalStandards = 0;
            $passedStandards = 0;

            // Grup berdasarkan standar
            foreach ($category->groupBy('indicator.competency.standard.id') as $standardId => $standard) {
                // $totalCompetencies++;

                $totalStandards++;

                // Periksa apakah semua kompetensi dalam standar ini lulus
                $allCompetenciesPassed = true;

                foreach ($standard->groupBy('indicator.competency.id') as $competencyId => $indicators) {
                    // Periksa apakah semua indikator dalam kompetensi ini memiliki validation_status > 3
                    $competencyPassed = $indicators->every(function ($indicator) {
                        return $indicator->validation_status >= 3;
                    });

                    // if ($competencyPassed) {
                    //     $passedCompetencies++;
                    // }

                    if (!$competencyPassed) {
                        $allCompetenciesPassed = false;
                        break;
                    }
                }

                if ($allCompetenciesPassed) {
                    $passedStandards++;
                }
            }

            // Hitung persentase kelulusan
            $results[] = [
                'counter' => $counter++,
                'recap' => $category->first()->indicator->competency->standard->category->name,
                // 'percentage' => $passedCompetencies / $totalCompetencies * 100 . ' %',
                'percentage' => $passedStandards / $totalStandards * 100 . ' %',
            ];
        }

        $templateProcessor->cloneRowAndSetValues('recap', $results);

        // C
        $formTime = FormTime::where('form_id', $form->id)->firstOrFail();

        $templateProcessor->setValue('submission_time', Carbon::parse($formTime->submission_time)->translatedFormat('d F Y H:i'));
        if ($formTime->submission_time <= $formTime->submission_deadline) {
            $templateProcessor->setValue('submission_info', 'Tepat Waktu');
        } else {
            $templateProcessor->setValue('submission_info', 'Terlambat');
        }

        $templateProcessor->setValue('assessment_time', Carbon::parse($formTime->assessment_time)->translatedFormat('d F Y H:i'));
        if ($formTime->assessment_time <= $formTime->assessment_deadline) {
            $templateProcessor->setValue('assessment_info', 'Tepat Waktu');
        } else {
            $templateProcessor->setValue('assessment_info', 'Terlambat');
        }

        $templateProcessor->setValue('feedback_time', Carbon::parse($formTime->feedback_time)->translatedFormat('d F Y H:i'));
        if ($formTime->feedback_time <= $formTime->feedback_deadline) {
            $templateProcessor->setValue('feedback_info', 'Tepat Waktu');
        } else {
            $templateProcessor->setValue('feedback_info', 'Terlambat');
        }

        $templateProcessor->setValue('validation_time', Carbon::parse($formTime->validation_time)->translatedFormat('d F Y H:i'));
        if ($formTime->validation_time <= $formTime->validation_deadline) {
            $templateProcessor->setValue('validation_info', 'Tepat Waktu');
        } else {
            $templateProcessor->setValue('validation_info', 'Terlambat');
        }

        $templateProcessor->setValue('meeting_time', Carbon::parse($form->meeting_time)->translatedFormat('d F Y H:i'));
        if ($form->meeting_time <= $formTime->meeting_deadline) {
            $templateProcessor->setValue('meeting_info', 'Tepat Waktu');
        } else {
            $templateProcessor->setValue('meeting_info', 'Terlambat');
        }

        $templateProcessor->setValue('planning_time', Carbon::parse($formTime->planning_time)->translatedFormat('d F Y H:i'));
        if ($formTime->planning_time <= $formTime->planning_deadline) {
            $templateProcessor->setValue('planning_info', 'Tepat Waktu');
        } else {
            $templateProcessor->setValue('planning_info', 'Terlambat');
        }

        // D
        $filteredFormAudits = $formAudits->whereIn('validation_status', [1, 2]);
        $grouped = $filteredFormAudits->groupBy(fn($item) => $item->indicator->competency->standard->category->id);
        // dd($grouped);

        $rows = [];

        foreach ($grouped as $formAuditsGroup) {
            $category = $formAuditsGroup->first()->indicator->competency->standard->category;

            foreach ($formAuditsGroup as $audit) {
                $rows[] = [
                    'category' => $category->name ?? '',
                    'indicator_code' => $audit->indicator->code ?? '',
                    'indicator_assessment' => $audit->indicator->assessment ?? '',
                    'planning' => $audit->planning ?? '',
                ];

                // Tambahkan baris kosong untuk kompetensi selain pada baris pertama
                $category->name = '';
            }
        }

        $templateProcessor->cloneRowAndSetValues('category', $rows);

        // E
        $competencies = Competency::whereHas('indicators.formAudits', function ($query) use ($form) {
            $query->where('form_id', $form->id);
        })
            ->with(['standard.category', 'indicators.formAudits'])  // Pastikan eager load 'formAudits' pada indikator
            ->get();

        $data = [];
        $printedCategories = []; // Melacak kategori yang sudah dicetak

        foreach ($competencies as $competency) {
            // Ambil kategori melalui relasi standard
            $categoryName = $competency->standard->category->name ?? '';

            // Loop melalui setiap indikator pada kompetensi
            $competencyPassed = $competency->indicators->every(function ($indicator) use ($form) {
                // Pastikan kita memeriksa 'validation_status' dari 'formAudits'
                // Mengambil semua formAudit yang terkait dengan indikator dan memeriksa status validasi
                $validationStatuses = $indicator->formAudits->where('form_id', $form->id)->pluck('validation_status')->toArray();

                // Memastikan semua formAudit memiliki validation_status >= 3
                return collect($validationStatuses)->every(function ($status) {
                    return $status >= 3;
                });
            });

            // Tentukan status berdasarkan kompetensi
            $status = $competencyPassed ? 'Memenuhi' : 'Tidak memenuhi';

            // Tambahkan data dengan nama kategori hanya jika belum dicetak sebelumnya
            $data[] = [
                'category' => in_array($categoryName, $printedCategories) ? '' : $categoryName,
                'competency' => $competency->name ?? '',
                'status' => $status,
            ];

            // Tandai kategori sebagai sudah dicetak
            $printedCategories[] = $categoryName;
        }

        // Clone row and set values
        $templateProcessor->cloneRowAndSetValues('competency', $data);

        // F
        // Set nilai tanggal cetak
        $today = Carbon::now()->translatedFormat('d F Y');
        $templateProcessor->setValue('today', $today);

        // Set nilai untuk Pimpinan Auditee
        $chief = $formAccesses->firstWhere('position', 'Chief');

        $templateProcessor->setValue('chief_name', $chief->user->name);
        $templateProcessor->setValue('chief_username', $chief->user->username);

        // Set nilai untuk Ketua Auditor
        $leader = $formAccesses->firstWhere('position', 'Leader');

        $templateProcessor->setValue('leader_name', $leader->user->name);
        $templateProcessor->setValue('leader_username', $leader->user->username);

        // // $categories = array('A', 'B', 'C', 'D');
        // // $series1 = array(1, 3, 2, 5);
        // // $chart = new Chart('pie', $categories, $series1);

        // // // Atur ukuran chart
        // // $chart->setWidth(600); // Lebar chart dalam piksel
        // // $chart->setHeight(400); // Tinggi chart dalam piksel
        // // $templateProcessor->setChart('chart', $chart);

        // $chartPath = $this->generateChartImageGD();
        // $chartPath = $this->generatePieChartImage();
        // $chartPath = $this->generateChartImage();

        // // Replace Placeholder with Chart Image
        // $templateProcessor->setImageValue('chart_placeholder', [
        //     'path' => $chartPath,
        //     'width' => 600,  // Set width (pixels)
        //     'height' => 400, // Set height (pixels)
        // ]);

        // Simpan file sementara
        $fileName = "Laporan AMI {$form->unit->code}";
        $wordPath = storage_path("app/public/{$fileName}.docx");
        $templateProcessor->saveAs($wordPath);

        // Path lengkap LibreOffice Windows
        $libreOfficePath = '"C:\Program Files\LibreOffice\program\soffice.exe"';

        // Windows
        // $command = "{$libreOfficePath} --headless --convert-to pdf --outdir " . storage_path('app/public') . " " . escapeshellarg($wordPath);
        
        // Server
        $command = "libreoffice --headless --convert-to pdf --outdir " . storage_path('app/public') . " " . escapeshellarg($wordPath);

        shell_exec($command);

        unlink($wordPath);

        $pdfPath = storage_path("app/public/{$fileName}.pdf");

        // Unduh file PDF
        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }

    public function export0(Form $form)
    {
        $unit = $form->unit->name;
        $fileName = "Laporan AMI {$form->unit->code}.docx";

        // Ambil data FormAccess yang terkait dengan form
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        // Filter untuk auditees dan auditors
        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false;
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Ketua' || strpos($access->position, 'Anggota') !== false;
        });

        // Buat instance TemplateProcessor dengan template yang sudah ada
        $phpWord = new \PhpOffice\PhpWord\TemplateProcessor('Laporan AMI.docx');

        // Set nilai untuk unit
        $phpWord->setValue('unit', $unit);

        // Clone blocks untuk Auditees
        $phpWord->cloneBlock('auditee_block', $auditees->count(), true);

        foreach ($auditees as $index => $auditee) {
            $phpWord->setValue("auditee_position#" . ($index + 1), $auditee->position);
            $phpWord->setValue("auditee_name#" . ($index + 1), $auditee->user->name);
        }

        // Clone blocks untuk Auditors
        $phpWord->cloneBlock('auditor_block', $auditors->count(), true);

        foreach ($auditors as $index => $auditor) {
            $phpWord->setValue("auditor_position#" . ($index + 1), $auditor->position);
            $phpWord->setValue("auditor_name#" . ($index + 1), $auditor->user->name);
        }

        // Tentukan path sementara untuk menyimpan file
        $tempFilePath = storage_path("app/{$fileName}");
        $phpWord->saveAs($tempFilePath);

        // Berikan respons unduhan dan hapus file sementara setelah diunduh
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    public function export1(Form $form)
    {
        // Inisialisasi TemplateProcessor
        $templateProcessor = new TemplateProcessor('Laporan AMI.docx');


        $unit = $form->unit->name;
        $templateProcessor->setValue('unit', $unit);

        $data = [
            ['nama' => 'John Doe', 'alamat' => '123 Main Street'],
            ['nama' => 'Jane Smith', 'alamat' => '456 Maple Avenue'],
        ];

        // Siapkan data untuk penggandaan blok
        $replacements = [];
        foreach ($data as $index => $biodata) {
            $replacements[] = [
                'nama' => '${nama_' . $index . '}',
                'alamat' => '${alamat_' . $index . '}',
            ];
        }

        // Clone block
        $templateProcessor->cloneBlock('block_biodata', count($replacements), true, false, $replacements);

        // Menyimpan file sementara
        $fileName = "Laporan AMI {$form->unit->code}.docx";
        $tempFilePath = storage_path("app/{$fileName}");
        $templateProcessor->saveAs($tempFilePath);

        // Memberikan respons untuk mengunduh file dan menghapus file setelah diunduh
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    public function export2(Form $form)
    {
        $unit = $form->unit->name;
        $fileName = "Laporan AMI {$form->unit->code}.docx";

        // Ambil data FormAccess yang terkait dengan form
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        // Filter untuk auditees dan auditors
        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false;
        });

        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Ketua' || strpos($access->position, 'Anggota') !== false;
        });

        // dd($auditees);

        // Buat instance TemplateProcessor dengan template yang sudah ada
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('Laporan AMI.docx');

        // Set nilai untuk unit
        $templateProcessor->setValue('unit', $unit);

        // Buat array data untuk diisi ke dalam tabel
        $rowCount = max($auditees->count(), $auditors->count());
        $rows = [];

        for ($i = 0; $i < $rowCount; $i++) {
            $auditee = $auditees->skip($i)->first();
            $auditor = $auditors->skip($i)->first();

            $rows[] = [
                "auditee_position#" . ($i + 1) => $auditee->position ?? '',
                "auditee_name#" . ($i + 1) => $auditee->user->name ?? '',
                "auditor_position#" . ($i + 1) => $auditor->position ?? '',
                "auditor_name#" . ($i + 1) => $auditor->user->name ?? '',
            ];
        }

        // Clone row di Word berdasarkan data
        $templateProcessor->cloneRowAndSetValues('auditee_position', $rows);

        // Tentukan path sementara untuk menyimpan file
        $tempFilePath = storage_path("app/{$fileName}");
        $templateProcessor->saveAs($tempFilePath);

        // Berikan respons unduhan dan hapus file sementara setelah diunduh
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    public function export3(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        // Filter untuk auditees (Pimpinan & PIC)
        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false;
        });

        // Filter untuk auditors (Ketua & Anggota)
        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Ketua' || strpos($access->position, 'Anggota') !== false;
        });

        // Transformasi data untuk template
        $auditeesData = $auditees->map(function ($auditee) {
            return [
                'auditee_position' => $auditee->position,
                'auditee_name' => $auditee->user->name, // Asumsi relasi user()->name
            ];
        })->toArray();

        $auditorsData = $auditors->map(function ($auditor) {
            return [
                'auditor_position' => $auditor->position,
                'auditor_name' => $auditor->user->name, // Asumsi relasi user()->name
            ];
        })->toArray();

        // Load template Word
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('Laporan AMI.docx');

        // Clone rows dan set nilai
        $templateProcessor->cloneRowAndSetValues('auditee_position', $auditeesData);
        $templateProcessor->cloneRowAndSetValues('auditor_position', $auditorsData);

        // Simpan file sementara
        $fileName = "Laporan AMI {$form->unit->code}.docx";
        $tempFilePath = storage_path("app/{$fileName}");
        $templateProcessor->saveAs($tempFilePath);

        // Kirim file sebagai respons
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    public function export4(Form $form)
    {
        $formAccesses = FormAccess::where('form_id', $form->id)->get();

        // Filter untuk auditees (Pimpinan & PIC)
        $auditees = $formAccesses->filter(function ($access) {
            return $access->position === 'Pimpinan' || strpos($access->position, 'PIC') !== false;
        });

        // Filter untuk auditors (Ketua & Anggota)
        $auditors = $formAccesses->filter(function ($access) {
            return $access->position === 'Ketua' || strpos($access->position, 'Anggota') !== false;
        });

        // Transformasi data untuk template
        $auditeesData = $auditees->map(function ($auditee) {
            return [
                'auditee_position' => $auditee->position,
                'auditee_name' => $auditee->user->name ?? '',
            ];
        })->values()->toArray();

        $auditorsData = $auditors->map(function ($auditor) {
            return [
                'auditor_position' => $auditor->position,
                'auditor_name' => $auditor->user->name ?? '',
            ];
        })->values()->toArray();

        // Gabungkan data
        $maxRows = max(count($auditeesData), count($auditorsData));
        $combinedData = [];

        for ($i = 0; $i < $maxRows; $i++) {
            $combinedData[] = [
                'auditee_position' => $auditeesData[$i]['auditee_position'] ?? '',
                'auditee_name' => $auditeesData[$i]['auditee_name'] ?? '',
                'auditor_position' => $auditorsData[$i]['auditor_position'] ?? '',
                'auditor_name' => $auditorsData[$i]['auditor_name'] ?? '',
            ];
        }

        // Load template Word
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('Laporan AMI.docx');

        // Clone rows dan set nilai
        $templateProcessor->cloneRowAndSetValues('auditee_position', $combinedData);

        // Simpan file sementara
        $fileName = "Laporan AMI {$form->unit->code}.docx";
        $tempFilePath = storage_path("app/{$fileName}");
        $templateProcessor->saveAs($tempFilePath);

        // Kirim file sebagai respons
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    public function export5(Form $form)
    {
        // Load template Word
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('Laporan AMI.docx');

        // Ambil data FormAudit beserta relasi indicator dan competency
        $formAudits = FormAudit::with([
            'indicator.competency'
        ])->where('form_id', $form->id)->get();

        // Kelompokkan data berdasarkan ID kompetensi
        $grouped = $formAudits->groupBy(fn($item) => $item->indicator->competency->id);

        $rows = []; // Menyimpan data kompetensi untuk template

        // Loop untuk memproses kompetensi
        foreach ($grouped as $competencyId => $formAuditsGroup) {
            // Ambil data kompetensi
            $competency = $formAuditsGroup->first()->indicator->competency;

            // Placeholder untuk indikator
            $indicatorPlaceholder = '${indicator_' . $competencyId . '}';

            // Tambahkan data kompetensi ke $rows
            $rows[] = [
                'competency_statement' => $competency->statement ?? '',
                'indicator_placeholder' => $indicatorPlaceholder,
            ];
        }

        // Clone row untuk kompetensi dan set data
        $templateProcessor->cloneRowAndSetValues('competency_statement', $rows);

        // Simpan file sementara
        $fileName = "Laporan AMI {$form->unit->code}.docx";
        $tempFilePath = storage_path("app/{$fileName}");
        $templateProcessor->saveAs($tempFilePath);

        // kemudian masukkan data dibawah ini

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($tempFilePath);

        // Kirim file sebagai respons
        return response()->download($tempFilePath)->deleteFileAfterSend(true);

        // Loop untuk memproses indikator
        foreach ($grouped as $competencyId => $formAuditsGroup) {
            $indicatorPlaceholder = "indicator_{$competencyId}";


            // Data indikator untuk kompetensi ini
            $competencyIndicators = [];

            foreach ($formAuditsGroup as $audit) {
                $competencyIndicators[] = [
                    $indicatorPlaceholder => $audit->indicator->code ?? '',
                    'validation_status' => $audit->validation_status ?? '',
                ];
            }

            // dd($competencyIndicators);
            // Clone row untuk indikator dan set data
            $templateProcessor->cloneRowAndSetValues("$indicatorPlaceholder", $competencyIndicators);

            // dd($indicatorPlaceholder);
        }

        // Simpan file sementara
        $fileName = "Laporan AMI {$form->unit->code}.docx";
        $tempFilePath = storage_path("app/{$fileName}");
        $templateProcessor->saveAs($tempFilePath);

        // Kirim file sebagai respons
        return response()->download($tempFilePath)->deleteFileAfterSend(true);
    }

    private function generateChartImage()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Data for chart
        $categories = ['A', 'B', 'C', 'D', 'E'];
        $values = [1, 3, 2, 5, 4];

        // Add data to spreadsheet
        $sheet->fromArray(
            [['Category', 'Value'], ...array_map(null, $categories, $values)],
            null,
            'A1'
        );

        // Create chart data series
        $dataSeriesValues = [new DataSeriesValues('Number', 'Worksheet!$B$2:$B$6')];
        $xAxisTickValues = [new DataSeriesValues('String', 'Worksheet!$A$2:$A$6')];

        $series = new DataSeries(
            DataSeries::TYPE_BARCHART,
            DataSeries::GROUPING_CLUSTERED,
            range(0, count($dataSeriesValues) - 1),
            [],
            $xAxisTickValues,
            $dataSeriesValues
        );

        $plotArea = new PlotArea(null, [$series]);
        $chart = new SpreadsheetChart(
            'Sample Chart',
            new Title('Example Chart'),
            null,
            $plotArea
        );

        // Position chart in the sheet
        $chart->setTopLeftPosition('A7');
        $chart->setBottomRightPosition('H20');

        $sheet->addChart($chart);

        // Save chart as image
        $chartImagePath = storage_path('app\chart.png');
        $writer = new Xlsx($spreadsheet);
        $writer->setIncludeCharts(true);

        // Save as temporary Excel file first
        $tempXlsx = storage_path('app/chart.xlsx');
        $writer->save($tempXlsx);

        // Convert XLSX to PNG using LibreOffice (or other tools)
        exec("libreoffice --headless --convert-to png --outdir " . dirname($chartImagePath) . " $tempXlsx");

        return $chartImagePath;
    }

    private function generatePieChartImage()
    {
        // Dimensi gambar
        $width = 600;
        $height = 400;

        // Warna untuk setiap bagian
        $colors = [
            [255, 99, 71],   // Tomato
            [60, 179, 113],  // Medium Sea Green
            [30, 144, 255],  // Dodger Blue
            [255, 215, 0],   // Gold
            [148, 0, 211],   // Dark Violet
        ];

        // Data untuk pie chart
        $data = [20, 30, 10, 25, 15]; // Representasi persentase
        $total = array_sum($data);

        // Buat gambar kosong
        $image = imagecreatetruecolor($width, $height);

        // Warna latar belakang
        $backgroundColor = imagecolorallocate($image, 255, 255, 255); // Putih
        imagefilledrectangle($image, 0, 0, $width, $height, $backgroundColor);

        // Warna untuk masing-masing bagian
        $gdColors = [];
        foreach ($colors as $rgb) {
            $gdColors[] = imagecolorallocate($image, $rgb[0], $rgb[1], $rgb[2]);
        }

        // Gambar pie chart
        $centerX = $width / 2;
        $centerY = $height / 2;
        $radius = min($width, $height) / 3;
        $startAngle = 0;

        foreach ($data as $index => $value) {
            $endAngle = $startAngle + ($value / $total) * 360;
            imagefilledarc(
                $image,
                $centerX,
                $centerY,
                $radius * 2,
                $radius * 2,
                $startAngle,
                $endAngle,
                $gdColors[$index % count($gdColors)],
                IMG_ARC_PIE
            );
            $startAngle = $endAngle;
        }

        // Simpan ke file PNG sementara
        $filePath = storage_path('app/pie_chart.png');
        imagepng($image, $filePath);

        // Hapus gambar dari memori
        imagedestroy($image);

        return $filePath;
    }

    private function generateChartImageGD()
    {
        $width = 600;  // Lebar gambar
        $height = 400; // Tinggi gambar
        $image = imagecreatetruecolor($width, $height);

        // Warna
        $backgroundColor = imagecolorallocate($image, 255, 255, 255); // Putih
        $barColor = imagecolorallocate($image, 0, 123, 255);          // Biru
        $textColor = imagecolorallocate($image, 0, 0, 0);             // Hitam

        // Isi background
        imagefilledrectangle($image, 0, 0, $width, $height, $backgroundColor);

        // Data untuk chart
        $categories = ['A', 'B', 'C', 'D', 'E']; // Kategori
        $values = [1, 3, 2, 5, 4];               // Nilai

        // Gambar bar chart
        $barWidth = ($width - 40) / count($values) - 20; // Lebar bar
        $maxValue = max($values); // Nilai maksimal untuk skala
        foreach ($values as $i => $value) {
            $x1 = 20 + $i * ($barWidth + 20);
            $x2 = $x1 + $barWidth;
            $y1 = $height - 20 - ($value / $maxValue) * ($height - 40);
            $y2 = $height - 20;

            // Gambar bar
            imagefilledrectangle($image, $x1, $y1, $x2, $y2, $barColor);

            // Tambahkan teks kategori
            imagestring($image, 5, $x1, $y2 + 5, $categories[$i], $textColor);
        }

        // Simpan sebagai PNG
        $tempPng = storage_path('app/temp_chart.png');
        imagepng($image, $tempPng); // Simpan di path storage
        imagedestroy($image);       // Hapus dari memory

        return $tempPng; // Return path ke file PNG
    }
}
