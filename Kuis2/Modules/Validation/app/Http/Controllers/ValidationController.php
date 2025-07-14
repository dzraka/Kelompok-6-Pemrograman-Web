<?php

namespace Modules\Validation\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JobCategory;
use Modules\Validation\Models\Validation;
use Illuminate\Support\Facades\Log;

class ValidationController extends Controller
{
    /**
     * Menampilkan status validasi
     */
    public function index()
    {
        try {
            $validation = auth('society')->user()->validation;
            return view('validation::index', compact('validation'));
        } catch (\Exception $e) {
            Log::error('Kesalahan pada validasi index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Tidak dapat memuat status validasi.');
        }
    }

    /**
     * Menampilkan formulir pengajuan validasi
     */
    public function create()
    {
        try {
            $jobCategories = JobCategory::all();
            return view('validation::create', compact('jobCategories'));
        } catch (\Exception $e) {
            Log::error('Kesalahan pada pembuatan validasi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Tidak dapat memuat formulir pengajuan.');
        }
    }

    /**
     * Menyimpan data validasi
     */
    public function store(Request $request)
    {
        try {
            // Cek autentikasi pengguna
            if (!auth('society')->check()) {
                return redirect()->route('login')
                    ->with('error', 'Silakan login terlebih dahulu untuk mengajukan validasi.');
            }

            // Validasi request
            $validated = $request->validate([
                'work_experience' => 'required|string|max:1000',
                'job_category_id' => 'required|exists:job_categories,id',
                'job_position' => 'required|string|max:255',
                'reason_accepted' => 'required|string|max:1000'
            ], [
                'work_experience.required' => 'Pengalaman kerja wajib diisi',
                'work_experience.max' => 'Pengalaman kerja tidak boleh lebih dari 1000 karakter',
                'job_category_id.required' => 'Kategori pekerjaan wajib dipilih',
                'job_category_id.exists' => 'Kategori pekerjaan tidak valid',
                'job_position.required' => 'Posisi pekerjaan wajib diisi',
                'job_position.max' => 'Posisi pekerjaan tidak boleh lebih dari 255 karakter',
                'reason_accepted.required' => 'Alasan wajib diisi',
                'reason_accepted.max' => 'Alasan tidak boleh lebih dari 1000 karakter'
            ]);

            // Cek validasi yang masih pending
            $existingValidation = auth('society')->user()->validation()
                ->where('status', 'pending')
                ->first();

            if ($existingValidation) {
                return redirect()->back()
                    ->with('error', 'Anda masih memiliki pengajuan validasi yang sedang diproses.')
                    ->withInput();
            }

            // Buat validasi baru
            auth('society')->user()->validation()->create([
                ...$validated,
                'status' => 'pending'
            ]);

            return redirect()->route('validation.index')
                ->with('success', 'Pengajuan validasi berhasil dikirim.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Kesalahan pada penyimpanan validasi: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengirim pengajuan validasi.')
                ->withInput();
        }
    }
}