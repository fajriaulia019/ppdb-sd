<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\TestResult;
use App\Models\SoalUjian;
use App\Models\PeriodePendaftaran; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\PendaftaranStatusMail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegisteredStudentsExport;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{ 
    public function index()
    {
        $totalPendaftar = Pendaftar::count();
        $pendingPendaftar = Pendaftar::where('status_pendaftaran', 'pending')->count();
        $diterimaPendaftar = Pendaftar::where('status_pendaftaran', 'diterima')->count();
        $ditolakPendaftar = Pendaftar::where('status_pendaftaran', 'ditolak')->count();
        $sudahDaftarUlang = Pendaftar::where('sudah_daftar_ulang', true)->count();
        $belumDaftarUlang = Pendaftar::where('status_pendaftaran', 'diterima')->where('sudah_daftar_ulang', false)->count();

        return view('admin.dashboard', compact('totalPendaftar', 'pendingPendaftar', 
        'diterimaPendaftar', 'ditolakPendaftar', 'sudahDaftarUlang', 'belumDaftarUlang'));
    }

public function listPendaftar(Request $request)
    {
        $query = Pendaftar::with(['user', 'user.testResult']);
        if ($request->has('search') && in_array($request->search, ['pending', 'diterima', 'ditolak'])) {
            $query->where('status_pendaftaran', $request->search);
        }
        if ($request->has('sudah_daftar_ulang')) {
            $isSudahDaftarUlang = ($request->sudah_daftar_ulang === 'true'); 
            $query->where('sudah_daftar_ulang', $isSudahDaftarUlang);
        }
        if ($request->has('search') && $request->search != '' && !in_array($request->search, ['pending', 'diterima', 'ditolak'])) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nisn', 'like', '%' . $search . '%')
                  ->orWhere('nis_sekolah', 'like', '%' . $search . '%')
                  ->orWhere('nomor_telepon_orang_tua', 'like', '%' . $search . '%');
            });
            $query->orWhereHas('user', function($q) use ($search) {
                $q->where('email', 'like', '%' . $search . '%');
            });
        }
        $pendaftar = $query->orderBy('created_at', 'desc')->paginate(10);
        $pendaftar->appends($request->only('search', 'sudah_daftar_ulang')); 
        return view('admin.pendaftar.index', compact('pendaftar'));
    }

    public function editPendaftar(Pendaftar $pendaftar)
    {
        return view('admin.pendaftar.edit', compact('pendaftar'));
    }

    public function updatePendaftar(Request $request, Pendaftar $pendaftar)
    {
        $request->validate([
            'nisn' => 'required|string|max:10|unique:pendaftars,nisn,' . $pendaftar->id,
            'nis_sekolah' => 'nullable|string|max:20|unique:pendaftars,nis_sekolah,' . $pendaftar->id,
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:126',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'agama' => 'required|string|max:255',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'nomor_telepon_orang_tua' => 'required|string|max:20',
            'pendapatan'=> 'required',
            'status_pendaftaran' => 'required|in:pending,diterima,ditolak',
            'alasan_ditolak' => 'nullable|string|max:500',
            'sudah_daftar_ulang' => 'boolean',
        ],[
            'nisn.unique' => 'NISN sudah digunakan oleh pendaftar lain',
            'nis_sekolah.unique' => 'NIS Sekolah sudah digunakan oleh pendaftar lain',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'agama.required' => 'Agama wajib diisi',
            'nama_ayah.required' => 'Nama ayah wajib diisi',
            'nama_ibu.required' => 'Nama ibu wajib diisi',
            'nomor_telepon_orang_tua.required' => 'Nomor telepon orang tua wajib diisi',
            'pendapatan.required' => 'Pendapatan wajib diisi',
            'status_pendaftaran.required' => 'Status pendaftaran wajib diisi'
        ]);

        $oldStatus = $pendaftar->status_pendaftaran;
        $pendaftar->update($request->except(['_token', '_method']));
        $newStatus = $pendaftar->status_pendaftaran;

        if ($oldStatus !== $newStatus && ($newStatus === 'diterima' || $newStatus === 'ditolak')) {
            try {
                Mail::to($pendaftar->user->email)->send(new PendaftaranStatusMail($pendaftar, $newStatus));
                alert::success('Berhasil','Data pendaftar berhasil diperbarui dan email notifikasi telah dikirim.')
                ->autoClose(3000);
                return redirect()->route('admin.pendaftar.index');
            } catch (\Exception $e) {
                alert::warning('Peringatan','Data pendaftar berhasil diperbarui, tetapi email notifikasi GAGAL dikirim: ' . $e->getMessage()
                )->autoClose(3000);
                return redirect()->route('admin.pendaftar.index');
            }
        }
        alert::success( 'Berhasil','Data pendaftar berhasil diperbarui')->autoClose(3000);
        return redirect()->route('admin.pendaftar.index');
    }

    public function destroyPendaftar(Pendaftar $pendaftar)
    {
        $user = $pendaftar->user;

        if ($pendaftar->kartu_keluarga_doc && Storage::disk('public')->exists($pendaftar->kartu_keluarga_doc)) {
            Storage::disk('public')->delete($pendaftar->kartu_keluarga_doc);
        }
        if ($pendaftar->akta_lahir_doc && Storage::disk('public')->exists($pendaftar->akta_lahir_doc)) {
            Storage::disk('public')->delete($pendaftar->akta_lahir_doc);
        }
        if ($pendaftar->ijazah_tk_doc && Storage::disk('public')->exists($pendaftar->ijazah_tk_doc)) {
            Storage::disk('public')->delete($pendaftar->ijazah_tk_doc);
        }
        if ($pendaftar->foto_siswa && Storage::disk('public')->exists($pendaftar->foto_siswa)) {
            Storage::disk('public')->delete($pendaftar->foto_siswa);
        }
        if ($user && $user->testResult) {
            $user->testResult->delete(); 
        }
       
        $pendaftar->delete();
        Alert::success('Berhasil!', 'Data pendaftar berhasil dihapus beserta dokumen dan hasil tesnya.')->autoClose(5000);
        return redirect()->route('admin.pendaftar.index');
        
    }

    public function listTestResults(Request $request)
    {
        $query = TestResult::with(['user', 'user.pendaftar']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->orWhereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                });
                $q->orWhereHas('user.pendaftar', function($q) use ($search) {
                    $q->where('nisn', 'like', '%' . $search . '%')
                      ->orWhere('nis_sekolah', 'like', '%' . $search . '%');
                });
            });
        }
        $testResults = $query->orderBy('created_at', 'desc')->paginate(10);
        $testResults->appends($request->only('search'));
        return view('admin.testresults.index', compact('testResults'));
    }

    public function editTestResult(TestResult $testResult)
    {
        return view('admin.testresults.edit', compact('testResult'));
    }

    public function updateTestResult(Request $request, TestResult $testResult)
    {
        $request->validate([
            'nilai_keseluruhan' => 'required|integer|min:0|max:100',
            'catatan_admin' => 'nullable|string',
        ],[
            'nilai_keseluruhan.required' => 'Nilai keseluruhan harus diisi.',
        ]);
        $testResult->update($request->all());
        Alert::success('Berhasil!', 'Data hasil tes berhasil diupdate.')->autoClose(3000);
        return redirect()->route('admin.testresults.index');
    }

    public function verifikasiPendaftar(Pendaftar $pendaftar)
    {
        $oldStatus = $pendaftar->status_pendaftaran;
        if ($oldStatus === 'pending' || $oldStatus === 'ditolak') {
            $pendaftar->update(['status_pendaftaran' => 'diterima']);
            $newStatus = $pendaftar->status_pendaftaran;
            if ($pendaftar->alasan_ditolak !== null) {
                $pendaftar->update(['alasan_ditolak' => null]);
            }
            if ($oldStatus !== $newStatus) {
                try {
                    Mail::to($pendaftar->user->email)->send(new PendaftaranStatusMail($pendaftar, $newStatus));
                    Alert::success('Berhasil!', 'Pendaftar berhasil diverifikasi dan email notifikasi telah dikirim.');
                    return back();
                } catch (\Exception $e) {
                    Alert::warning('Peringatan', 'Pendaftar berhasil diverifikasi, tetapi email notifikasi GAGAL dikirim: ' . $e->getMessage());
                    return back();
                }
            }
            alert::info('Info','Status pendaftar sudah diterima sebelumnya.');
            return back();
        }
        alert::error('Kesalahan','Pendaftar tidak bisa diverifikasi dari status ini.');
        return back();
    } 
    public function tolakPendaftar(Request $request, Pendaftar $pendaftar)
    {
        $request->validate([
            'alasan_ditolak' => 'required|string|max:500',
        ],[
            'alasan_ditolak.required' => 'Alasan ditolak harus diisi.'
        ]);

        $oldStatus = $pendaftar->status_pendaftaran;
        if ($oldStatus === 'pending' || $oldStatus === 'diterima') {
            $pendaftar->update([
                'status_pendaftaran' => 'ditolak',
                'alasan_ditolak' => $request->alasan_ditolak,
                'sudah_daftar_ulang' => false,
                'nis_sekolah' => null,
                'foto_siswa' => null 
            ]);
            $newStatus = $pendaftar->status_pendaftaran;          
            if ($pendaftar->foto_siswa && Storage::disk('public')->exists($pendaftar->foto_siswa)) {
                Storage::disk('public')->delete($pendaftar->foto_siswa);
            }
            if ($oldStatus !== $newStatus) {
                try {
                    Mail::to($pendaftar->user->email)->send(new PendaftaranStatusMail($pendaftar, $newStatus));
                     Alert::success('Berhasil!', 'Pendaftar berhasil ditolak dan email notifikasi telah dikirim.');
                    return back();
                } catch (\Exception $e) {
                    Alert::warning('Peringatan', 'Pendaftar berhasil ditolak, tetapi email notifikasi GAGAL dikirim: ' . $e->getMessage());
                    return back();
                }
            }
            alert::info('Info','Status pendaftar sudah ditolak sebelumnya.');
            return back();
        }
        alert::error('Kesalahan','Pendaftar tidak bisa ditolak dari status ini.');
        return back();
    }

   public function batalkanVerifikasiPendaftar(Pendaftar $pendaftar)
    {
        $oldStatus = $pendaftar->status_pendaftaran;
        if ($oldStatus === 'diterima') {
            $pendaftar->update([
                'status_pendaftaran' => 'pending',
                'alasan_ditolak' => null,
                'sudah_daftar_ulang' => false,
                'nis_sekolah' => null, 
                'foto_siswa' => null 
            ]);
            $newStatus = $pendaftar->status_pendaftaran;
            if ($pendaftar->foto_siswa && Storage::disk('public')->exists($pendaftar->foto_siswa)) {
                Storage::disk('public')->delete($pendaftar->foto_siswa);
            }
            if ($oldStatus !== $newStatus) {
                try {
                    Mail::to($pendaftar->user->email)->send(new PendaftaranStatusMail($pendaftar, 'dibatalkan_verifikasi'));
                    Alert::success('Berhasil!', 'Verifikasi pendaftar berhasil dibatalkan dan email notifikasi telah dikirim.');
                    return back();
                } catch (\Exception $e) {
                    Alert::warning('Peringatan', 'Verifikasi pendaftar dibatalkan, tetapi email notifikasi GAGAL dikirim: ' . $e->getMessage());
                    return back();
                }
            }
            alert::info('Info','Verifikasi pendaftar sudah pending.');
            return back();
        }
        alert::error('Kesalahan','Pendaftar tidak bisa dibatalkan dari status ini.');
        return back();
    }

    public function listRegisteredStudents(Request $request)
    {
        $query = Pendaftar::with('user');
        if ($request->has('periode_id') && $request->periode_id != '') {
            $periode = PeriodePendaftaran::find($request->periode_id);
            if ($periode) {
                $query->whereBetween('created_at', [$periode->tanggal_mulai->startOfDay(), 
                $periode->tanggal_berakhir->endOfDay()]);
            }
        }
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhere('nisn', 'like', '%' . $search . '%')
                  ->orWhere('nis_sekolah', 'like', '%' . $search . '%')
                  ->orWhere('nomor_telepon_orang_tua', 'like', '%' . $search . '%');
            });
            $query->orWhereHas('user', function($q) use ($search) {
                $q->where('email', 'like', '%' . $search . '%');
            });
        }
        $registeredStudents = $query->where('status_pendaftaran', 'diterima')
                                ->where('sudah_daftar_ulang', true)
                                ->orderBy('nama_lengkap', 'asc')
                                ->paginate(10);

        $registeredStudents->appends($request->only('search', 'periode_id')); 
        $periodes = PeriodePendaftaran::orderBy('tanggal_mulai', 'desc')->get(); 
        return view('admin.registered_students.index', compact('registeredStudents', 'periodes')); 
    }

    public function exportRegisteredStudents(Request $request) 
    {
        $periodeId = $request->input('periode_id'); 

        $fileName = 'siswa_terdaftar';
        if ($periodeId) {
            $periode = PeriodePendaftaran::find($periodeId);
            if ($periode) {
                $fileName .= '_' . \Illuminate\Support\Str::slug($periode->nama_periode, '_');
            }
        }
        $fileName .= '_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new RegisteredStudentsExport($periodeId), $fileName);
    }

    public function listSoalUjian(Request $request)
    {
        $query = SoalUjian::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('soal', 'like', '%' . $search . '%')
                  ->orWhere('jawaban_benar', 'like', '%' . $search . '%')
                  ->orWhere('opsi_a', 'like', '%' . $search . '%')
                  ->orWhere('opsi_b', 'like', '%' . $search . '%')
                  ->orWhere('opsi_c', 'like', '%' . $search . '%')
                  ->orWhere('opsi_d', 'like', '%' . $search . '%');
            });
        }

        $soalUjians = $query->orderBy('id', 'asc')->paginate(10);
        $soalUjians->appends($request->only('search'));

        return view('admin.soal_ujian.index', compact('soalUjians'));
    }

    public function createSoalUjian()
    {
        return view('admin.soal_ujian.create');
    }

    public function storeSoalUjian(Request $request)
    {
        $request->validate([
            'soal' => 'required|string|max:1000',
            'opsi_a' => 'required|string|max:255',
            'opsi_b' => 'required|string|max:255',
            'opsi_c' => 'required|string|max:255',
            'opsi_d' => 'required|string|max:255',
            'jawaban_benar' => 'required|string|in:A,B,C,D',
        ],[
            'soal.required' => 'Soal Harus Diisi!',
            'opsi_a' => 'Opsi A Harus Diisi!',
            'opsi_b' => 'Opsi B Harus Diisi!',
            'opsi_c' => 'Opsi C Harus Diisi!',
            'opsi_d' => 'Opsi D Harus Diisi!',
            'jawaban_benar.required' => 'Jawaban Benar Harus Dipilih!',
        ]);

        SoalUjian::create($request->all());
        Alert::success('Berhasil','Soal ujian berhasil ditambahkan.');
        return redirect()->route('admin.soal_ujian.index');
    }

    public function editSoalUjian(SoalUjian $soalUjian)
    {
        return view('admin.soal_ujian.edit', compact('soalUjian'));
    }

    public function updateSoalUjian(Request $request, SoalUjian $soalUjian)
    {
        $request->validate([
            'soal' => 'required|string|max:1000',
            'opsi_a' => 'required|string|max:255',
            'opsi_b' => 'required|string|max:255',
            'opsi_c' => 'required|string|max:255',
            'opsi_d' => 'required|string|max:255',
            'jawaban_benar' => 'required|string|in:A,B,C,D',
        ],[
            'soal.required' => 'Soal Harus Diisi!',
            'opsi_a' => 'Opsi A Harus Diisi!',
            'opsi_b' => 'Opsi B Harus Diisi!',
            'opsi_c' => 'Opsi C Harus Diisi!',
            'opsi_d' => 'Opsi D Harus Diisi!',
            'jawaban_benar.required' => 'Jawaban Benar Harus Dipilih!'
        ]);
        $soalUjian->update($request->all());
        alert::success('Berhasil','Soal ujian berhasil diperbarui.');
        return redirect()->route('admin.soal_ujian.index');
    }

    public function destroySoalUjian(SoalUjian $soalUjian)
    {
        $soalUjian->delete();
        alert::success('Berhasil!','Soal ujian berhasil dihapus.');
        return redirect()->route('admin.soal_ujian.index');
    }

    public function listPeriodePendaftaran()
    {
        $periodes = PeriodePendaftaran::orderBy('tanggal_mulai', 'desc')->paginate(10);
        return view('admin.periode_pendaftaran.index', compact('periodes'));
    }

    public function createPeriodePendaftaran()
    {
        return view('admin.periode_pendaftaran.create');
    }

    public function storePeriodePendaftaran(Request $request)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'is_active' => 'boolean',
        ],[
            'nama_periode.required' => 'Nama Periode Harus Diisi!',
            'tanggal_mulai.required' => 'Tanggal Mulai Harus Diisi!',
            'tanggal_berakhir.required' => 'Tanggal Berakhir Harus Diisi!',
            'tanggal_berakhir.after_or_equal' => 'Tanggal Berakhir Harus Lebih Besar Dari Tanggal Mulai!'
        ]);
        if ($request->is_active) {
            PeriodePendaftaran::where('is_active', true)->update(['is_active' => false]);
        }
        PeriodePendaftaran::create($request->all());
        alert::success('Berhasil!','Periode pendaftaran berhasil ditambahkan.');
        return redirect()->route('admin.periode_pendaftaran.index');
    }
    public function editPeriodePendaftaran(PeriodePendaftaran $periodePendaftaran)
    {
        return view('admin.periode_pendaftaran.edit', compact('periodePendaftaran'));
    }

    public function updatePeriodePendaftaran(Request $request, PeriodePendaftaran $periodePendaftaran)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'is_active' => 'boolean',
        ],[
            'nama_periode.required' =>  'Nama Periode Harus Diisi!',
            'tanggal_mulai.required' => 'Tanggal Mulai Harus Diisi!',
            'tanggal_berakhir.required' => 'Tanggal Berakhir Harus Diisi!',
            'tanggal_berakhir.after_or_equal' => 'Tanggal Berakhir Harus Lebih Besar Dari Tanggal Mulai!'
        ]);

        if ($request->is_active) {
            PeriodePendaftaran::where('is_active', true)->where('id', '!=', $periodePendaftaran->id)->update(['is_active' => false]);
        }
        $periodePendaftaran->update($request->all());
        alert::success('Berhasil!','Periode pendaftaran berhasil diperbarui.');
        return redirect()->route('admin.periode_pendaftaran.index');
    }

    public function destroyPeriodePendaftaran(PeriodePendaftaran $periodePendaftaran)
    {
        $periodePendaftaran->delete();
        alert::success('Berhasil','Periode pendaftaran berhasil dihapus.');
        return redirect()->route('admin.periode_pendaftaran.index');
    }
}