<!DOCTYPE html>
<html>
<head>
    <title>Bukti Pendaftaran Siswa Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            color: #333;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            border: 1px solid #ddd;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #007bff;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .section-title {
            background-color: #e6f2ff;
            color: #007bff;
            padding: 8px 15px;
            margin-top: 20px;
            margin-bottom: 15px;
            border-left: 5px solid #0056b3;
            font-size: 16px;
            font-weight: bold;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table td {
            padding: 8px 10px;
            border: 1px solid #eee;
            vertical-align: top;
        }
        .data-table td:first-child {
            width: 30%;
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .text-center {
            text-align: center;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }  
        .info-section {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 10px;
        }
        .info-section td {
            padding: 0;
            vertical-align: top;
            border: none;
        }
        .foto-cell {
            width: 120px;
            text-align: left;
            padding-right: 15px;
        }
        .foto-siswa {
            width: 100px; 
            height: 120px; 
            object-fit: cover;
            border: 1px solid #ddd;
        }
        .info-cell {
            padding-left: 0;
            vertical-align: top;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 3px 0;
            vertical-align: top;
            border: none;
        }
        .info-label {
            width: 180px;
            font-weight: bold;
        }
        .info-colon {
            width: 20px;
            font-weight: bold;
            text-align: center;
        }
        .info-value {
            font-weight: bold;
        }
        .status-diterima {
            color: green;
        }
        .nis-value {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bukti Pendaftaran Siswa Baru</h1>
            <p>Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
            <p>SDN 30 Bukik Kanduang</p>
            <p>Desa Bukik Kandung, Kecamatan X Koto Diatas, Kabupaten Solok, Sumatera Barat</p>
        </div>

        <table class="info-section">
            <tr>
                <td class="foto-cell">
                    @if($pendaftar->foto_siswa)
                        <img src="{{ public_path('storage/' . $pendaftar->foto_siswa) }}" class="foto-siswa" alt="Foto Siswa">
                    @else
                        <div style="width: 100px; height: 120px; border: 1px solid #ddd; display: flex; align-items: center; justify-content: center; background-color: #f5f5f5; font-size: 10px; color: #666;">
                            Foto Tidak Ada
                        </div>
                    @endif
                </td>
                <td class="info-cell">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Nomor Pendaftaran</td>
                            <td class="info-colon">:</td>
                            <td class="info-value">{{ $pendaftar->no_pendaftaran }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Tanggal Pendaftaran</td>
                            <td class="info-colon">:</td>
                            <td>{{ $pendaftar->created_at->format('d M Y H:i') }} WIB</td>
                        </tr>
                        <tr>
                            <td class="info-label">Status Final Pendaftaran</td>
                            <td class="info-colon">:</td>
                            <td class="info-value status-diterima">DITERIMA</td>
                        </tr>
                        <tr>
                            <td class="info-label">Status Daftar Ulang</td>
                            <td class="info-colon">:</td>
                            <td class="info-value status-diterima">SUDAH DAFTAR ULANG</td>
                        </tr>
                        <tr>
                            <td class="info-label">NIS Sekolah</td>
                            <td class="info-colon">:</td>
                            <td class="info-value nis-value">{{ $pendaftar->nis_sekolah ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="section-title">Data Calon Siswa</div>
        <table class="data-table">
            <tr><td>NISN</td><td>{{ $pendaftar->nisn ?? '-' }}</td></tr>
            <tr><td>Nama Lengkap</td><td>{{ $pendaftar->nama_lengkap }}</td></tr>
            <tr><td>Tempat, Tgl. Lahir</td><td>{{ $pendaftar->tempat_lahir }}, {{ $pendaftar->tanggal_lahir->format('d F Y') }}</td></tr>
            <tr><td>Jenis Kelamin</td><td>{{ $pendaftar->jenis_kelamin }}</td></tr>
            <tr><td>Agama</td><td>{{ $pendaftar->agama }}</td></tr>
            <tr><td>Alamat Lengkap</td><td>{{ $pendaftar->alamat }}</td></tr>
        </table>

        <div class="section-title">Data Orang Tua</div>
        <table class="data-table">
            <tr><td>Nama Ayah</td><td>{{ $pendaftar->nama_ayah }}</td></tr>
            <tr><td>Nama Ibu</td><td>{{ $pendaftar->nama_ibu }}</td></tr>
            <tr><td>No. Telepon Orang Tua</td><td>{{ $pendaftar->nomor_telepon_orang_tua }}</td></tr>
        </table>

        @if($testResult)
        <div class="section-title">Hasil Tes Seleksi</div>
        <table class="data-table">
            <tr><td>Nilai Keseluruhan</td><td>{{ $testResult->nilai_keseluruhan }}</td></tr>
            @if($testResult->catatan_admin)
            <tr><td>Catatan Admin</td><td>{{ $testResult->catatan_admin }}</td></tr>
            @endif
        </table>
        @endif

        <div style="margin-top: 30px; text-align: right;">
            <p>Bukik Kandung, {{ date('d F Y') }}</p>
            <p>Hormat kami,</p>
            <br><br><br>
            <p>(Panitia PPDB SDN 30 Bukik Kanduang)</p>
        </div>
        
        <div class="footer">
            <p>Bukti pendaftaran ini sah jika telah diverifikasi oleh pihak sekolah.</p>
            <p>Mohon simpan dokumen ini sebagai bukti daftar ulang Anda.</p>
        </div>
    </div>
</body>
</html>