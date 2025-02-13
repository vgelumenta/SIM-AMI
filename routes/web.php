<?php

use App\Events\FormUpdated;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditController;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EvaluationController;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::post('/broadcasting/auth', function () {
    //     return Broadcast::auth(request());
    // });

    Route::get('/', function () {
        return redirect('/dashboard');
    });
    Route::get('/dashboard', [AuthController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AuthController::class, 'index'])->name('dashboard');
    // Route::get('/dashboard', function () {
    //     return view('index');
    // })->name('dashboard');
    
    // Route::get('/test', function () {
    //     FormUpdated::dispatch('test1');
    //     // event(new FormUpdated('test'));
    // })->name('dashboard');

    Route::put('/stages/{stage}', [AuthController::class, 'updateStage'])->name('stages.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('/roles', RoleController::class);

    Route::resource('/departments', DepartmentController::class);
    Route::resource('/units', UnitController::class);
    Route::resource('/users', UserController::class);
    Route::get('/contacts/{id}/edit', [UserController::class, 'editContact'])->name('contacts.edit');
    Route::put('/contacts/{id}', [UserController::class, 'updateContact'])->name('contacts.update');
    Route::get('/getUser', [UserController::class, 'getUser']);
    
    Route::resource('/documents', DocumentController::class);
    Route::get('/documents/drafts/{draft}/edit', [DocumentController::class, 'editDraft'])->name('documents.editDraft');
    Route::delete('/documents/drafts/{draft}', [DocumentController::class, 'destroyDraft'])->name('documents.destroyDraft');
    Route::resource('/forms', FormController::class);
    Route::get('/forms/{form}/submission', [FormController::class, 'editSubmission'])->name('forms.editSubmission');
    Route::put('/forms/{form}/submission', [FormController::class, 'updateSubmission'])->name('forms.updateSubmission');
    Route::get('/forms/{form}/assessment', [FormController::class, 'editAssessment'])->name('forms.editAssessment');
    Route::put('/forms/{form}/assessment', [FormController::class, 'updateAssessment'])->name('forms.updateAssessment');
    Route::get('/forms/{form}/feedback', [FormController::class, 'editFeedback'])->name('forms.editFeedback');
    Route::put('/forms/{form}/feedback', [FormController::class, 'updateFeedback'])->name('forms.updateFeedback');
    Route::get('/forms/{form}/validation', [FormController::class, 'editValidation'])->name('forms.editValidation');
    Route::put('/forms/{form}/validation', [FormController::class, 'updateValidation'])->name('forms.updateValidation');
    Route::get('/forms/{form}/meeting', [FormController::class, 'editMeeting'])->name('forms.editMeeting');
    Route::put('/forms/{form}/meeting', [FormController::class, 'updateMeeting'])->name('forms.updateMeeting');
    Route::get('/forms/{form}/meetingVerification', [FormController::class, 'editMeetingVerification'])->name('forms.editMeetingVerification');
    Route::put('/forms/{form}/meetingVerification', [FormController::class, 'updateMeetingVerification'])->name('forms.updateMeetingVerification');
    Route::get('/forms/{form}/planning', [FormController::class, 'editPlanning'])->name('forms.editPlanning');
    Route::put('/forms/{form}/planning', [FormController::class, 'updatePlanning'])->name('forms.updatePlanning');
    Route::get('/forms/{form}/signing', [FormController::class, 'editSigning'])->name('forms.editSigning');
    Route::put('/forms/{form}/signing', [FormController::class, 'updateSigning'])->name('forms.updateSigning');
    Route::get('/forms/{form}/signingVerification', [FormController::class, 'editSigningVerification'])->name('forms.editSigningVerification');
    Route::put('/forms/{form}/signingVerification', [FormController::class, 'updateSigningVerification'])->name('forms.updateSigningVerification');
    Route::get('/forms/{form}/report', [FormController::class, 'showReport'])->name('forms.showReport');
    
    Route::get('/forms/{form}/export', [FormController::class, 'export'])->name('forms.export');    
});
