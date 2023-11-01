@role('prodi')
<li class="sidebar-item {{ Request::is('prodi/profil') ? 'active' : '' }}">
    <a href="/prodi/profil" class='sidebar-link'>
        <i class="bi bi-person-fill"></i>
        <span>Profil</span>
    </a>
</li>

<li class="sidebar-item  has-sub {{ Request::is('prodi/data*') ? 'active' : '' }}">
    <a href="#" class="sidebar-link">
        <i class="bi bi-pie-chart-fill"></i>
        <span>Pangkalan Data</span>
    </a>
    <ul class="submenu {{ Request::is('prodi/data*') ? 'active' : '' }}" style="display: {{ Request::is('prodi/data*') ? 'block' : 'none' }};">
        <li class="submenu-item {{ Request::is('prodi/data/seleksi_mahasiswa_baru*') ? 'active' : '' }}">
            <a href="/prodi/data/seleksi_mahasiswa_baru">Seleksi Mahasiswa</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/data/mahasiswa') ? 'active' : '' }}">
            <a href="/prodi/data/mahasiswa">Mahasiswa</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/data/statusmahasiswa*') ? 'active' : '' }}">
            <a href="/prodi/data/statusmahasiswa">Status Perkuliahan</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/data/mahasiswa_lulus*') ? 'active' : '' }}">
            <a href="/prodi/data/mahasiswa_lulus">Mahasiswa Lulus</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/data/dosen') ? 'active' : '' }}">
            <a href="/prodi/data/dosen">Dosen</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/data/dosen_tt') ? 'active' : '' }}">
            <a href="/prodi/data/dosen_tt">Dosen Tidak Tetap</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/data/pembimbing_tugas_akhir') ? 'active' : '' }}">
            <a href="/prodi/data/pembimbing_tugas_akhir">Pembimbing Tugas Akhir</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/data/kurikulum*') ? 'active' : '' }}">
            <a href="/prodi/data/kurikulum">Kurikulum</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/data/jadwalkuliah*') ? 'active' : '' }}">
            <a href="/prodi/data/jadwalkuliah">Jadwal Kuliah</a>
        </li>

        <li class="submenu-item {{ Request::is('prodi/data/prestasi*') ? 'active' : '' }}">
            <a href="/prodi/data/prestasi">Prestasi</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/data/kerjasama*') ? 'active' : '' }}">
            <a href="/prodi/data/kerjasama">Kerjasama</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/data/penelitian*') ? 'active' : '' }}">
            <a href="/prodi/data/penelitian">Penelitian</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/data/pengabdian*') ? 'active' : '' }}">
            <a href="/prodi/data/pengabdian">Pengabdian</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/data/publikasi*') ? 'active' : '' }}">
            <a href="/prodi/data/publikasi">Publikasi</a>
        </li>
    </ul>
</li>

<li class="sidebar-item  has-sub {{ Request::is('prodi/akreditasi*') ? 'active' : '' }}">
    <a href="#" class="sidebar-link">
        <i class="bi bi-pie-chart-fill"></i>
        <span>Borang Akreditasi</span>
    </a>
    <ul class="submenu {{ Request::is('prodi/akreditasi*') ? 'active' : '' }}" style="display: {{ Request::is('prodi/akreditasi*') ? 'block' : 'none' }};">
        <li class="submenu-item {{ Request::is('prodi/akreditasi/instrumen*') ? 'active' : '' }}">
            <a href="/prodi/akreditasi/instrumen">Instrumen</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/akreditasi/rekognisi*') ? 'active' : '' }}">
            <a href="/prodi/akreditasi/rekognisi">Rekognisi Dosen</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/akreditasi/produk*') ? 'active' : '' }}">
            <a href="/prodi/akreditasi/produk">Produk & Jasa</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/akreditasi/hki*') ? 'active' : '' }}">
            <a href="/prodi/akreditasi/hki">Hak Cipta</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/akreditasi/buku*') ? 'active' : '' }}">
            <a href="/prodi/akreditasi/buku">Buku</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/akreditasi/perolehan_dana*') ? 'active' : '' }}">
            <a href="/prodi/akreditasi/perolehan_dana">Perolehan Dana</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/akreditasi/tracer_study*') ? 'active' : '' }}">
            <a href="/prodi/akreditasi/tracer_study">Tracer Study</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/akreditasi/pengguna_lulusan*') ? 'active' : '' }}">
            <a href="/prodi/akreditasi/pengguna_lulusan">Pengguna Lulusan</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/akreditasi/kepuasan_mahasiswa*') ? 'active' : '' }}">
            <a href="/prodi/akreditasi/kepuasan_mahasiswa">Kepuasan Mahasiswa</a>
        </li>
        <li class="submenu-item {{ Request::is('prodi/akreditasi/peralatan_laboratorium*') ? 'active' : '' }}">
            <a href="/prodi/akreditasi/peralatan_laboratorium">Peralatan Laboratorium</a>
        </li>

    </ul>
</li>

@endrole

@role('prodi|universitas')

<li class="sidebar-item  has-sub {{ Request::is('spmi/*') ? 'active' : '' }}">
    <a href="#" class="sidebar-link">
        <i class="bi bi-collection-fill"></i>
        <span>SPMI Online</span>
    </a>
    <ul class="submenu {{ Request::is('spmi/*') ? 'active' : '' }}" style="display: {{ Request::is('spmi/*') ? 'block' : 'none' }};">
        <li class="submenu-item {{ Request::is('spmi/penetapan') ? 'active' : '' }}">
            <a href="/spmi/penetapan">Penetapan</a>
        </li>
        <li class="submenu-item {{ Request::is('spmi/pelaksanaan') ? 'active' : '' }}">
            <a href="/spmi/pelaksanaan">Pelaksanaan</a>
        </li>
        <li class="submenu-item {{ Request::is('spmi/pengendalian') ? 'active' : '' }}">
            <a href="/spmi/pengendalian">Pengendalian</a>
        </li>
        <li class="submenu-item {{ Request::is('spmi/peningkatan') ? 'active' : '' }}">
            <a href="/spmi/peningkatan">Peningkatan</a>
        </li>
        <li class="submenu-item {{ Request::is('spmi/evaluasi') ? 'active' : '' }}">
            <a href="/spmi/evaluasi">Evaluasi</a>
        </li>
    </ul>
</li>

@endrole