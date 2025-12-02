@extends('layouts.app')

@section('content')

    <section id="beranda" class="hero-section text-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-md-start">
                    <h1 class="display-3 fw-bold mb-4">Penerimaan Peserta Didik Baru <br> SDN 30 Bukik Kanduang</h1>
                    <p class="lead mb-4">Mulai petualangan belajar yang menyenangkan bersama kami! Daftarkan putra-putri
                        Anda untuk tahun ajaran {{ date('Y') }}/{{ date('Y') + 1 }}.</p>
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg me-3">Daftar Sekarang</a>
                    <a href="#info-pendaftaran" class="btn btn-outline-light btn-lg">Informasi PPDB</a>
                </div>
            </div>
        </div>
    </section>

    <section id="informasi-sekolah" class="section-padding bg-light">
        <div class="container">
            <div class="text-center mb-4 mt-5">
                <h2 class="display-5 fw-bold">Tentang SDN 30 Bukik Kanduang</h2>
                <p class="lead text-muted">Pendidikan Dasar yang Menyenangkan dan Berkualitas</p>
            </div>

            <div class="card shadow-sm p-4 rounded-3 border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <img src="{{ asset('image/background/sdn.jpg') }}" alt="Ilustrasi Pembelajaran"
                                class="img-fluid rounded shadow-sm">
                        </div>
                        <div class="col-md-6">
                            <p class="lead" style="text-align:justify">SDN 30 Bukik Kandung didirikan pada tahun
                                1982 dengan komitmen untuk memberikan pendidikan dasar berkualitas dalam
                                suasana belajar yang menyenangkan. Kami percaya bahwa setiap anak memiliki
                                potensi unik yang perlu dikembangkan melalui pendekatan pembelajaran yang
                                kreatif dan inovatif.</p>
                            <p class="lead" style="text-align:justify">Dengan kurikulum merdeka dan fasilitas modern, kami
                                siap
                                membimbing putra-putri Anda mencapai masa depan cerah.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="visi-misi" class="section-padding bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Visi & Misi Kami</h2>
                <!-- <p class="lead text-muted">Membentuk Generasi Emas Berkarakter dan Cerdas</p> -->
            </div>
            <div class="row">
                <!-- Visi Card -->
                <div class="col-md-6">
                    <div class="card card-outline card-info">
                        <div class="card-header bg-info">
                            <h3 class="card-title">
                                <i class="fas fa-eye card-icon"></i>
                                Visi
                            </h3>
                        </div>
                        <div class="card-body">
                            <p class="visi-text h5 text-center">
                                <b><i>"Terwujudnya Siswa yang Berkualitas, Berbudaya, Berimtek dan Berimtaq"</i></b>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Misi Card -->
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">
                                <i class="fas fa-bullseye card-icon"></i>
                                Misi
                            </h3>
                        </div>
                        <div class="card-body h5">
                            <ol>
                                <li class="mb-2">
                                    Melaksanakan ajaran agama dengan benar.
                                </li>
                                <li class="mb-2">
                                    Memberikan bimbingan dan keteladanan akhlak mulia serta pengembangan nilai-nilai budaya
                                    bangsa.
                                </li>
                                <li class="mb-2">
                                    Melaksanakan pembelajaran yang bermutu berkarakter dan berdaya saing dengan berbasis
                                    karakter dan IPTEK, sesuai dengan standar BNSP dan Kurikulum.
                                </li>
                                <li class="mb-2">
                                    Mendorong kemandirian belajar berkomitmen diri, serta bertanggung jawab dalam
                                    merencanakan dan melaksanakan pembelajaran yang bermutu dan berkualitas.
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
    </section>

    <section id="info-pendaftaran" class="section-padding bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Informasi Pendaftaran</h2>
                <p class="lead text-muted">Proses Mudah, Transparan, dan Cepat!</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm p-4 rounded-3 border-0">
                        <div class="card-body">
                            <h3 class="h4 mb-3">Syarat Pendaftaran</h3>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check-circle text-success me-2"></i> Berusia minimal 6 tahun pada bulan
                                    Juli tahun ajaran baru.</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Fotokopi Akta Kelahiran.</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Fotokopi Kartu Keluarga.</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Fotokopi Ijazah TK/Surat
                                    Keterangan Lulus TK.</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Pas Foto 3x4 terbaru.</li>
                            </ul>
                            <h3 class="h4 mt-4 mb-3">Alur Pendaftaran</h3>
                            <ol>
                                <li>Membuat akun di website PPDB ini.</li>
                                <li>Mengisi formulir pendaftaran online dan mengunggah dokumen persyaratan.</li>
                                <li>Mengikuti tes seleksi online.</li>
                                <li>Melihat pengumuman hasil seleksi.</li>
                                <li>Melakukan daftar ulang online dan mengunggah foto siswa.</li>
                                <li>Menerima Nomor Induk Siswa (NIS) Sekolah.</li>
                            </ol>
                            <h3 class="h4 mt-4 mb-3">Status Pendaftaran Saat Ini</h3>
                            @php
                                use Carbon\Carbon;
                                $activePeriode = App\Models\PeriodePendaftaran::where('is_active', true)
                                    ->where('tanggal_mulai', '<=', Carbon::now()->toDateString())
                                    ->where('tanggal_berakhir', '>=', Carbon::now()->toDateString())
                                    ->first();
                                $nextPeriode = App\Models\PeriodePendaftaran::where('tanggal_mulai', '>', Carbon::now()->toDateString())
                                    ->orderBy('tanggal_mulai', 'asc')->first();
                            @endphp

                            @if($activePeriode)
                                <div class="alert alert-success text-center">
                                    Pendaftaran **DIBUKA**! <br> Periode: {{ $activePeriode->nama_periode }} <br> Tanggal:
                                    {{ $activePeriode->tanggal_mulai->format('d F Y') }} -
                                    {{ $activePeriode->tanggal_berakhir->format('d F Y') }}
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg"><i
                                            class="fas fa-user-plus me-2"></i> Daftar Sekarang!</a>
                                </div>
                            @else
                                <div class="alert alert-danger text-center">
                                    Pendaftaran **DITUTUP** saat ini.
                                    @if($nextPeriode)
                                        <br> Periode berikutnya: {{ $nextPeriode->nama_periode }} akan dibuka pada
                                        {{ $nextPeriode->tanggal_mulai->format('d F Y') }}
                                        hingga {{ $nextPeriode->tanggal_berakhir->format('d F Y') }}.
                                    @else
                                        <br> Informasi periode pendaftaran selanjutnya akan diumumkan kemudian.
                                    @endif
                                </div>
                                <div class="text-center">
                                    <a href="{{ route('login') }}" class="btn btn-secondary btn-lg"><i
                                            class="fas fa-sign-in-alt me-2"></i> Masuk ke Akun Anda</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-4 mt-5">
         <a href="https://wa.me/62812345678" target="_blank" class="chat-bubble" title="Chat dengan Admin PPDB">
            <div class="chat-tooltip">Chat dengan Admin PPDB</div>
            <i class="fab fa-whatsapp whatsapp-icon"></i>
            <div class="chat-notification">!</div>
        </a>

        <div class="container">
            <p class="mb-1">Hubungi admin PPDB :</p>
                <a href="https://wa.me/62812345678" target="_blank" class="btn btn-success btn-sm">
                <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            <p class="mb-0">&copy; {{ date('Y') }} SDN 30 Bukik Kandung. Semua Hak Dilindungi.</p>
        </div>
    </footer>

@endsection