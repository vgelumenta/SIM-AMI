<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Category;
use App\Models\Document;
use App\Models\Standard;
use App\Models\Indicator;
use App\Models\Competency;
use App\Models\FormAccess;
use Illuminate\Http\Request;
use App\Models\FormEvaluation;
use App\Models\Status;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the ID of the logged-in user
        $userId = auth()->id();

        $forms = Form::whereHas('formAccesses', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->where(function ($query) {
                    $query->where('position', 'Pimpinan')
                        ->orWhere('position', 'LIKE', 'PIC%');
                });
        })->get();

        return view('evaluations.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('evaluations.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $form = Form::findOrFail($id);

        $formAccesses = FormAccess::where('form_id', $id)
            ->where('user_id', auth()->id())->get();

        $statuses = Status::orderBy('id', 'desc')->get();

        // $statuses = Status::get();

        // dd($formAccess);

        $formEvaluations = FormEvaluation::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $id)->get();

        // Kelompokkan data berdasarkan ID kategori, standar, kompetensi, dan indikator
        $grouped = $formEvaluations->groupBy(function ($item) {
            return $item->indicator->competency->standard->category->id;
        });

        return view('evaluations.edit', compact('statuses', 'form', 'formAccesses', 'grouped'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        // Validasi input untuk evaluasi
        $validatedData = $request->validate([
            'evaluations.*.id' => 'required|integer|exists:form_evaluations,id',
            'evaluations.*.validation' => 'nullable|string',
            'evaluations.*.verification_link' => 'nullable',
            'evaluations.*.status' => 'nullable|integer|exists:statuses,id',
        ]);

        // Gunakan operator ternary untuk menentukan nilai berdasarkan tombol yang ditekan
        Form::updateOrCreate(
            ['id' => $id], // Kondisi untuk mencari form
            [
                'stage_id' => $request->input('action') === 'draft' ? 1 : 2,
                'submitted_at' => $request->input('action') === 'draft' ? null : now(),
            ]
        );

        // Update evaluasi seperti sebelumnya menggunakan updateOrCreate
        foreach ($validatedData['evaluations'] as $evaluationData) {
            FormEvaluation::updateOrCreate(
                ['id' => $evaluationData['id']], // Cari evaluasi berdasarkan ID
                [
                    'evaluation_status' => $evaluationData['status'] ?? null,
                    'validation' => $evaluationData['validation'] ?? null,
                    'verification_link' => $evaluationData['verification_link'] ?? null,
                ]
            );
        }

        // Redirect setelah semua perubahan tersimpan
        return redirect('evaluations')->with('status', 'Form berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
