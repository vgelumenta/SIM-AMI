<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Status;
use App\Models\FormAccess;
use Illuminate\Http\Request;
use App\Models\FormEvaluation;

class AuditController extends Controller
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
                    $query->where('position', 'Ketua')
                        ->orWhere('position', 'LIKE', 'Anggota%');
                });
        })->get();

        return view('audits.index', compact('forms'));
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
        return view('audits.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $form = Form::findOrFail($id);

        $statuses = Status::get();

        $formAccesses = FormAccess::where('form_id', $id)
            ->where('user_id', auth()->id())->get();

        $formEvaluations = FormEvaluation::with([
            'indicator.competency.standard.category'
        ])->where('form_id', $id)->get();

        // Kelompokkan data berdasarkan ID kategori, standar, kompetensi, dan indikator
        $grouped = $formEvaluations->groupBy(function ($item) {
            return $item->indicator->competency->standard->category->id;
        });

        return view('audits.edit', compact('statuses', 'form', 'formAccesses', 'grouped'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->input('action'));
        // Validasi input untuk evaluasi
        $validatedData = $request->validate([
            'audits.*.id' => 'required|integer|exists:form_evaluations,id',
            'audits.*.status' => 'nullable|integer|exists:statuses,id',
            'audits.*.desc' => 'nullable',
        ]);

        // Gunakan operator ternary untuk menentukan nilai berdasarkan tombol yang ditekan
        // Form::updateOrCreate(
        //     ['id' => $id], // Kondisi untuk mencari form
        //     [
        //         'stage_id' => $request->input('action') === 'draft' ? 1 : 2,
        //         'submitted_at' => $request->input('action') === 'draft' ? null : now(),
        //     ]
        // );

        // Update evaluasi seperti sebelumnya menggunakan updateOrCreate
        foreach ($validatedData['audits'] as $evaluationData) {
            FormEvaluation::updateOrCreate(
                ['id' => $evaluationData['id']], // Cari evaluasi berdasarkan ID
                [
                    'audit_status' => $evaluationData['status'] ?? null,
                    'audit_desc' => $evaluationData['desc'] ?? null,
                ]
            );
        }

        // Redirect setelah semua perubahan tersimpan
        return redirect('audits')->with('status', 'Form berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
