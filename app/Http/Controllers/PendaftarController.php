<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\TestResult;
use App\Models\SoalUjian;
use App\Models\PeriodePendaftaran; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 
use Barryvdh\DomPDF\Facade\Pdf;
use RealRashid\SweetAlert\Facades\Alert;

class PendaftarController extends Controller
{
    
    public function create()
    {
        $activePeriode = PeriodePendaftaran::where('is_active', true)
                                           ->where('tanggal_mulai', '<=', Carbon::now()->toDateString())
                                           ->where('tanggal_berakhir', '>=', Carbon::now()->toDateString())
                                           ->first();

        if (!$activePeriode) {
            $lastPeriode = PeriodePendaftaran::where('tanggal_berakhir', '<', Carbon::now()->toDateString())
                                            ->orderBy('tanggal_berakhir', 'desc')->first();
            $nextPeriode = PeriodePendaftaran::where('tanggal_mulai', '>', Carbon::now()->toDateString())
                                            ->orderBy('tanggal_mulai', 'asc')->first();

            $statusMessage = 'Pendaftaran saat ini ditutup.';
            if ($nextPeriode) {
                $statusMessage .= ' Periode pendaftaran berikutnya akan dibuka pada ' . 
                $nextPeriode->tanggal_mulai->format('d F Y') . ' hingga ' . 
                $nextPeriode->tanggal_berakhir->format('d F Y') . '.';
            } else if ($lastPeriode) {
                $statusMessage .= ' Periode pendaftaran terakhir telah berakhir pada ' . 
                $lastPeriode->tanggal_berakhir->format('d F Y') . '.';
            }

            return redirect()->route('dashboard')->with('error', $statusMessage);
        }

        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->first();

        if ($pendaftar) {
            alert::info('Pemberitahuan','Anda sudah mengisi formulir pendaftaran.')->autoClose(3000);
            return redirect()->route('pendaftar.status');
        }

        return view('calon_siswa.pendaftaran.create');
    }

    public function store(Request $request)
    {
        $activePeriode = PeriodePendaftaran::where('is_active', true)
                                           ->where('tanggal_mulai', '<=', Carbon::now()->toDateString())
                                           ->where('tanggal_berakhir', '>=', Carbon::now()->toDateString())
                                           ->first();

        if (!$activePeriode) {
            return redirect()->route('dashboard')->with('error', 'Pendaftaran saat ini ditutup. Anda tidak dapat mengirimkan formulir.');
        }

        $request->validate([
            'nisn' => 'required|string|max:10|unique:pendaftars,nisn',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'agama' => 'required|string|max:255',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'nomor_telepon_orang_tua' => 'required|string|max:20',
            'pendapatan => required',
            'kartu_keluarga_doc' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'akta_lahir_doc' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ijazah_tk_doc' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ],[
            'nisn.required' => 'Nomor Induk Siswa Nasional (NISN) wajib diisi.',
            'nisn.unique' => 'NISN sudah digunakan oleh orang lain.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'alamat.required' => 'Alamat wajib diisi.',
            'agama.required' => 'Agama wajib diisi.',
            'nama_ayah.required' => 'Nama ayah wajib diisi.',
            'nama_ibu.required' => 'Nama ibu wajib diisi.',
            'nomor_telepon_orang_tua.required' => 'Nomor telepon orang tua wajib diisi.',
            'pendapatan.required' => 'Pendapatan wajib diisi.',
            'kartu_keluarga_doc.required' => 'Dokumen Kartu Keluarga wajib diunggah.',
            'kartu_keluarga_doc.mimes' => 'Dokumen Kartu Keluarga hanya dapat berupa file PDF, JPG, JPEG, dan PNG.',
            'kartu_keluarga_doc.max' => 'Dokumen Kartu Keluarga hanya dapat berukuran maksimal 2 MB.',
            'akta_lahir_doc.required' => 'Dokumen Akta Lahir wajib diunggah.',
            'akta_lahir_doc.mimes' => 'Dokumen Akta Lahir hanya dapat berupa file PDF, JPG, JPEG, dan PNG.',
            'akta_lahir_doc.max' => 'Dokumen Akta Lahir hanya dapat berukuran maksimal 2 MB.',
            'ijazah_tk_doc.required' => 'Dokumen Ijazah TK wajib diunggah.',
            'ijazah_tk_doc.mimes' => 'Dokumen Ijazah TK hanya dapat berupa file PDF, JPG, JPEG, dan PNG.',
            'ijazah_tk_doc.max' => 'Dokumen Ijazah TK hanya dapat berukuran maksimal 2 MB.'
        ]);

        $kartuKeluargaPath = null;
        if ($request->hasFile('kartu_keluarga_doc')) {
            $kartuKeluargaPath = $request->file('kartu_keluarga_doc')->store('documents/kartu_keluarga', 'public');
        }

        $aktaLahirPath = null;
        if ($request->hasFile('akta_lahir_doc')) {
            $aktaLahirPath = $request->file('akta_lahir_doc')->store('documents/akta_lahir', 'public');
        }

        $ijazahTkPath = null;
        if ($request->hasFile('ijazah_tk_doc')) {
            $ijazahTkPath = $request->file('ijazah_tk_doc')->store('documents/ijazah_tk', 'public');
        }

        $currentYear = date('Y');
        $lastPendaftarWithNo = Pendaftar::whereNotNull('no_pendaftaran')
                                        ->where('no_pendaftaran', 'like', '30/dftr/' . $currentYear . '/%')
                                        ->orderBy('no_pendaftaran', 'desc')
                                        ->first();

        $lastSequence = 0;
        if ($lastPendaftarWithNo) {
            $lastSequence = (int) substr($lastPendaftarWithNo->no_pendaftaran, -3);
        }
        $newSequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT); 
        $noPendaftaran = '30/dftr/' . $currentYear . '/' . $newSequence; 

        Pendaftar::create([
            'user_id' => Auth::id(),
            'no_pendaftaran' => $noPendaftaran, 
            'nisn' => $request->nisn,
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'agama' => $request->agama,
            'nama_ayah' => $request->nama_ayah,
            'nama_ibu' => $request->nama_ibu,
            'nomor_telepon_orang_tua' => $request->nomor_telepon_orang_tua,
            'pendapatan'=> $request->pendapatan,
            'kartu_keluarga_doc' => $kartuKeluargaPath,
            'akta_lahir_doc' => $aktaLahirPath,
            'ijazah_tk_doc' => $ijazahTkPath,
            'status_pendaftaran' => 'pending',
        ]);
        alert::success('Berhasil!',
        'Formulir pendaftaran berhasil dikirim! No. Pendaftaran Anda: ' . $noPendaftaran . '. Dokumen Anda sedang ditinjau.');
        return redirect()->route('pendaftar.status');
    }

    public function status() 
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->first();
        $testResult = TestResult::where('user_id', $user->id)->first();

        return view('calon_siswa.pendaftaran.status', compact('pendaftar', 'testResult'));
    }

    public function showTestPage(Request $request) 
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->first();
        if (!$pendaftar) {
            Alert::error('Akses Ditolak!', 'Silakan isi formulir pendaftaran terlebih dahulu.')
            ->autoClose(false)->showConfirmButton(true);
            return redirect()->route('dashboard');
        }
        $testResult = TestResult::where('user_id', $user->id)->first();
        if ($testResult) {
            Alert::info('Informasi', 'Anda sudah mengikuti tes. Silakan lihat hasilnya.')
            ->autoClose(3000);
            return redirect()->route('pendaftar.test_review');
        }
        if ( ($pendaftar->status_pendaftaran !== 'pending' && $pendaftar->status_pendaftaran !== 'diterima') || 
            !$pendaftar->kartu_keluarga_doc || !$pendaftar->akta_lahir_doc || !$pendaftar->ijazah_tk_doc) {
             Alert::error('Akses Ditolak!',
            'Anda belum dapat mengikuti tes. Pastikan status pendaftaran Anda pending/diterima dan semua dokumen telah dikirim.')
            ->autoClose(false)->showConfirmButton(true);
            return redirect()->route('dashboard');
        }
        if ($request->query('start_test')) {
            $soal_ujians = SoalUjian::all();
            if ($soal_ujians->isEmpty()) {
                Alert::error('Kesalahan!', 'Soal ujian belum tersedia. Silakan hubungi admin.')
                ->autoClose(false)->showConfirmButton(true);
                return redirect()->route('dashboard');
            }
            return view('calon_siswa.test_page', compact('soal_ujians'));
        }
        $total_soal = SoalUjian::count();
        $durasi_menit = 30;
        return view('calon_siswa.test_start_page', compact('total_soal', 'durasi_menit'));
    }

    public function submitTest(Request $request)
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->first();

       if (!$pendaftar || ($pendaftar->status_pendaftaran !== 'pending' && $pendaftar->status_pendaftaran !== 'diterima') ||
            !$pendaftar->kartu_keluarga_doc || !$pendaftar->akta_lahir_doc || !$pendaftar->ijazah_tk_doc) {
            Alert::error('Akses Ditolak!', 
            'Anda belum dapat mengikuti tes. Pastikan formulir dan semua dokumen telah dikirim.')
            ->autoClose(3000)->showConfirmButton(true);
            return redirect()->route('dashboard');
        }
        $testResult = TestResult::where('user_id', $user->id)->first();
        if ($testResult) {
            Alert::info('Informasi', 'Anda sudah mengikuti tes. Silakan lihat hasilnya')
            ->autoClose(3000);
            return redirect()->route('pendaftar.test_review');
        }

        $all_soal = SoalUjian::all()->keyBy('id');
        $nilai_benar = 0;
        $total_soal_dijawab = 0;
        $jawaban_user_raw = $request->except('_token');
        foreach ($jawaban_user_raw as $soal_id => $jawaban_user) {
            if (is_numeric($soal_id) && isset($all_soal[$soal_id])) {
                $soal = $all_soal[$soal_id];
                $total_soal_dijawab++;

                if ($soal->jawaban_benar === $jawaban_user) {
                    $nilai_benar++;
                }
            }
        }
        $total_soal_seharusnya = SoalUjian::count();
        if ($total_soal_dijawab < $total_soal_seharusnya) {
            Alert::error('Kesalahan!', 'Anda belum menjawab semua soal');
            return back()->withInput();
        }

        $nilai_keseluruhan = ($nilai_benar / $total_soal_seharusnya) * 100;

        TestResult::create([
            'user_id' => $user->id,
            'nilai_keseluruhan' => $nilai_keseluruhan,
            'catatan_admin' => null,
        ]);
        Alert::success('Selamat!', 'Anda telah menyelesaikan tes. Silahkan lihat hasilnya');
        return redirect()->route('pendaftar.test_review');
    }

    public function showTestReview()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->first();
        $testResult = TestResult::where('user_id', $user->id)->first();
        $soal_ujians = SoalUjian::all();

        if (!$pendaftar || !$testResult || $soal_ujians->isEmpty()) {
            alert::error('Kesalahan','Data tes tidak ditemukan atau soal tidak tersedia.');
            return redirect()->route('dashboard');
        }
        return view('calon_siswa.test_review', compact('pendaftar', 'testResult', 'soal_ujians'));
    }

    public function showDaftarUlangForm()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->first();

        if (!$pendaftar || $pendaftar->status_pendaftaran !== 'diterima') {
            alert::error('Kesalahan','Anda tidak dapat mengajukan daftar ulang');
            return redirect()->route('pendaftar.status');
        }
        if ($pendaftar->sudah_daftar_ulang) {
            alert::info('Pendaftaran','Anda telah mengajukan daftar ulang');
             return redirect()->route('pendaftar.status');
        }

        return view('calon_siswa.daftar_ulang', compact('pendaftar'));
    }

    public function submitDaftarUlang(Request $request)
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->first();
        if (!$pendaftar || $pendaftar->status_pendaftaran !== 'diterima') {
            alert::error('Kesalahan','Anda belum diterima sebagai calon siswa atau sudah daftar ulang.');
            return redirect()->route('pendaftar.status');
        }
        if ($pendaftar->sudah_daftar_ulang) {
            alert::info('Pemberitahuan','Anda telah mengajukan daftar ulang');
             return redirect()->route('pendaftar.status');
        }
        $request->validate([
            'foto_siswa' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ],[
            'foto_siswa.required' => 'Anda harus mengupload foto siswa',
            'foto_siswa.image' => 'Format foto tidak sesuai',
            'foto_siswa.mimes' => 'Format foto tidak sesuai',
            'foto_siswa.max' => 'Ukuran foto tidak boleh lebih dari 2MB'
        ]);
        $fotoSiswaPath = null;
        if ($request->hasFile('foto_siswa')) {
            $fotoSiswaPath = $request->file('foto_siswa')->store('documents/foto_siswa', 'public');
        }
        $currentYear = date('Y');
        $lastRegisteredStudent = Pendaftar::where('sudah_daftar_ulang', true)
                                         ->whereNotNull('nis_sekolah')
                                         ->where('nis_sekolah', 'like', $currentYear . '%')
                                         ->orderBy('nis_sekolah', 'desc')
                                         ->first();

        $lastNumber = 0;
        if ($lastRegisteredStudent) {
            $lastNumber = (int) substr($lastRegisteredStudent->nis_sekolah, -3);
        }
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $nisSekolah = $currentYear . $newNumber;

        $pendaftar->update([
            'sudah_daftar_ulang' => true,
            'nis_sekolah' => $nisSekolah,
            'foto_siswa' => $fotoSiswaPath
        ]);
        alert::success('Berhasil!','Daftar ulang berhasil dilakukan! NIS Sekolah Anda: ' . $nisSekolah);
        return redirect()->route('pendaftar.status');
    }

    public function cetakBuktiPendaftaran()
    {
        $user = Auth::user();
        $pendaftar = Pendaftar::with('user', 'user.testResult')->where('user_id', $user->id)->first();

        if (!$pendaftar || !$pendaftar->sudah_daftar_ulang) {
            alert::error('Kesalahan','Anda belum melakukan daftar ulang atau data tidak ditemukan.');
            return redirect()->route('pendaftar.status');
        }
        $testResult = $pendaftar->user->testResult;
        $pdf = Pdf::loadView('calon_siswa.bukti_pendaftaran_pdf', compact('pendaftar', 'testResult'));
        return $pdf->download('bukti_pendaftaran_' . $pendaftar->nis_sekolah . '.pdf');
    }
}