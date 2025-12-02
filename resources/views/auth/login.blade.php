<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login PPDB SD</title>
    <link rel="icon" href="{{ asset('image/background/tutwurihandayani.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7UbJgJtGqZ/IfekNDzSA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.min.css">
</head>

<body>
    <main class="form-signin">
        <div class="card login-card">
            <div class="logo-section mb-4">
                <img src="{{ asset('image/background/tutwurihandayani.png') }}" alt="Logo Sekolah"
                    class="mx-auto d-block">
                <h1 class="school-name">PPDB Online</h1>
                <p class="school-tagline">Sekolah Dasar Negeri 30 Bukik Kanduang</p>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email Pengguna</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="w-100 btn btn-lg btn-primary mb-3" type="submit">Masuk</button>
            </form>
            <p class="text-muted mb-3">Belum memiliki akun? <a class="text-link" href="{{ route('register') }}">Daftar
                    Sekarang</a></p>
            <p class="text-muted small mb-0">&copy; {{ date('Y') }} Sekolah Dasar Negeri 30 Bukik Kanduang. Hak Cipta
                Dilindungi.</p>
            <a href="{{ url('/') }}" class="text-link mt-3 d-block"><i class="fas fa-arrow-left me-2"></i> Kembali ke
                Halaman Utama</a>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    @include('sweetalert::alert')
</body>

</html>