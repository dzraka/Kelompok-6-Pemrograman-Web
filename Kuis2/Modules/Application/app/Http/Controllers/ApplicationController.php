<?php
namespace Modules\Application\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JobApplySociety;
use App\Models\JobApplyPosition;
use App\Models\AvailablePosition;

class ApplicationController extends Controller
{
    // Kirim lamaran
    public function store(Request $request)
    {
        $request->validate([
            'job_vacancy_id' => 'required|exists:job_vacancies,id',
            'position_id' => 'required|exists:available_positions,id',
            'notes' => 'required|string'
        ]);

        // Cek apakah sudah pernah apply ke vacancy ini
        $existingApplication = JobApplySociety::where([
            'society_id' => auth('society')->id(),
            'job_vacancy_id' => $request->job_vacancy_id
        ])->first();

        if ($existingApplication) {
            return back()->with('error', 'Anda sudah melamar ke lowongan ini sebelumnya');
        }

        // Buat application utama
        $application = JobApplySociety::create([
            'society_id' => auth('society')->id(),
            'job_vacancy_id' => $request->job_vacancy_id,
            'notes' => $request->notes,
            'date' => now()->format('Y-m-d')
        ]);

        // Tambahkan position yang dilamar
        JobApplyPosition::create([
            'society_id' => auth('society')->id(),
            'job_vacancy_id' => $request->job_vacancy_id,
            'position_id' => $request->position_id,
            'job_apply_societies_id' => $application->id,
            'status' => 'pending',
            'date' => now()->format('Y-m-d')
        ]);

        return redirect()->route('applications.index')->with('success', 'Lamaran berhasil dikirim!');
    }

    // Daftar lamaran saya
    public function index()
    {
        $applications = JobApplySociety::with(['jobVacancy', 'positions.position'])
            ->where('society_id', auth('society')->id())
            ->orderBy('date', 'desc')
            ->get();

        return view('application::index', compact('applications'));
    }
}
