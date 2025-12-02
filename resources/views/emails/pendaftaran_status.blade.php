<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pendaftaran PPDB</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; }
        .header { background-color: #007bff; color: white; padding: 10px 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; }
        .footer { text-align: center; margin-top: 20px; font-size: 0.9em; color: #777; }
        .button { display: inline-block; background-color: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
        .button-red { background-color: #dc3545; }
        .status-accepted { color: #28a745; font-weight: bold; }
        .status-rejected { color: #dc3545; font-weight: bold; }
        .status-other { color: #ffc107; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pembaruan Status Pendaftaran PPDB SD</h2>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $namaPendaftar }}</strong>,</p>
            <p>Terima kasih telah mendaftar di Program Penerimaan Peserta Didik Baru (PPDB) SD kami. Kami ingin memberitahukan status pendaftaran Anda:</p>

            <p style="font-size: 1.2em;">Status Pendaftaran Anda:
                @if ($statusFinal === 'diterima')
                    <span class="status-accepted">DITERIMA</span>
                @elseif ($statusFinal === 'ditolak')
                    <span class="status-rejected">DITOLAK</span>
                @else
                    <span class="status-other">{{ strtoupper($statusFinal) }}</span>
                @endif
            </p>

            @if ($statusFinal === 'diterima')
                <p>Selamat! Pendaftaran Anda dengan NISN <strong>{{ $nisnPendaftar ?? '-' }}</strong> telah resmi **DITERIMA**. Kami sangat senang menyambut Anda di sekolah kami.</p>
                <p>Selanjutnya, mohon segera lakukan proses Daftar Ulang melalui sistem kami.</p>
                <p style="text-align: center; margin-top: 20px;">
                    <a href="{{ $linkLogin }}" class="button">Login dan Daftar Ulang</a>
                </p>
            @elseif ($statusFinal === 'ditolak')
                <p>Mohon maaf, setelah melalui proses seleksi, pendaftaran Anda dengan NISN <strong>{{ $nisnPendaftar ?? '-' }}</strong> belum dapat kami terima.</p>
                @if($pendaftar->alasan_ditolak)
                    <p style="font-style: italic;">Alasan Penolakan: "{{ $pendaftar->alasan_ditolak }}"</p>
                @endif
                <p>Terima kasih atas partisipasi Anda. Jika Anda memiliki pertanyaan, silakan hubungi bagian administrasi sekolah.</p>
                <p style="text-align: center; margin-top: 20px;">
                    <a href="{{ $linkLogin }}" class="button button-red">Login ke Akun Anda</a>
                </p>
            @else
                 <p>Status pendaftaran Anda saat ini adalah <strong>{{ strtoupper($statusFinal) }}</strong>. Silakan login ke akun Anda untuk melihat detail lebih lanjut.</p>
                 <p style="text-align: center; margin-top: 20px;">
                    <a href="{{ $linkLogin }}" class="button">Login ke Akun Anda</a>
                </p>
            @endif

            <p>Hormat kami,</p>
            <p>Tim PPDB SD</p>
        </div>
        <div class="footer">
            <p>Ini adalah email otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} PPDB SD. Semua Hak Dilindungi.</p>
        </div>
    </div>
</body>
</html>