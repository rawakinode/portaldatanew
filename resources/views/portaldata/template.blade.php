<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Portal Data | Pangkalan Data Universitas Tadulako</title>
</head>


<link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/main/app-dark.css') }}">

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.2/chart.min.js"
    integrity="sha512-zjlf0U0eJmSo1Le4/zcZI51ks5SjuQXkU0yOdsOBubjSmio9iCUp8XPLkEAADZNBdR9crRy3cniZ65LF2w8sRA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ asset('/assets/extensions/jquery/jquery.min.js') }}"></script>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom p-3">
        <div class="container-fluid">
            <img src="/images/untadlogo.png" width="30" height="30" class="d-inline-block align-top"
                style="margin-right: 20px" alt=""><a class="navbar-brand fw-bold text-primary"
                href="/data/mahasiswa/aktif">Portal Data Untad</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                style="border-color:transparent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav" style="background: white; padding: 1rem; z-index:999">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Akreditasi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/data/instrumen_perguruan_tinggi">Instrumen Akreditasi PT</a></li>
                            <li><a class="dropdown-item" href="/data/instrumen">Instrumen Akreditasi PS</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Mahasiswa
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/data/mahasiswa/aktif">Mahasiswa Aktif/Nonaktif/Cuti</a></li>
                            <li><a class="dropdown-item" href="/data/mahasiswa/baru">Mahasiswa Diterima/Daftar Ulang</a></li>
                            <li><a class="dropdown-item" href="/data/mahasiswa/bidikmisi">Mahasiswa Beasiswa Bidikmisi</a></li>
                            <li><a class="dropdown-item" href="/data/mahasiswa/lulus">Mahasiswa Lulus/Tepat Waktu</a></li>
                            {{-- <li><a class="dropdown-item" href="/data/mahasiswa/lulus">Mahasiswa Lulus/Tepat Waktu</a></li>
                            <li><a class="dropdown-item" href="/data/mahasiswa/tugas_akhir">Mahasiswa Tugas Akhir</a>
                            </li> --}}
                            <li><a class="dropdown-item" href="/data/mahasiswa/prestasi">Prestasi Mahasiswa</a></li>
                            <li><a class="dropdown-item" href="/data/kerjasama">Kerjasama</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Akademik
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/data/jadwalpengajar">Jadwal Pengajar</a></li>
                            <li><a class="dropdown-item" href="/data/kurikulum">Kurikulum</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Dosen
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/data/dosen">Dosen</a></li>
                            <li><a class="dropdown-item" href="/data/publikasi">Publikasi</a></li>
                        </ul>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="/data/peminat">Peminat</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="/data/penelitian">Penelitian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/data/pengabdian">Pengabdian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/data/spmi">SPMI</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/home/dashboard">Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <section class="text-light p-5" style="background-color: #04183d">
        <div class="container">
            <div style="text-align: center">
                <span><img src="/images/untadlogo.png" alt="" height="50px"></span>
                <h2 style="color:aliceblue">Portaldata.</h2>
            </div>
        </div>
    </section>

    <section class="text-light p-3 pt-5" style="background-color: #01224a">
        <div class="container">
            <p class="text-center">2023 © Copyright <strong>Universitas Tadulako</strong><br> <span
                    style="font-size: 10pt">Developed by LPPMP Universitas Tadulako</span></p>
        </div>
    </section>

</body>

</html>
