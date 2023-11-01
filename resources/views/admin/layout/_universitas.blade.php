@role('universitas')

    <li class="sidebar-item {{ Request::is('universitas/programstudi') ? 'active' : '' }}">
        <a href="/universitas/programstudi" class='sidebar-link'>
            <i class="bi bi-grid-fill"></i>
            <span>Program Studi</span>
        </a>
    </li>

    <li class="sidebar-item {{ Request::is('universitas/akreditasi') ? 'active' : '' }}">
        <a href="/universitas/akreditasi" class='sidebar-link'>
            <i class="bi bi-grid-fill"></i>
            <span>Akreditasi</span>
        </a>
    </li>

    <li class="sidebar-item  has-sub {{ Request::is('data/universitas/*') ? 'active' : '' }}">
        <a href="#" class="sidebar-link">
            <i class="bi bi-collection-fill"></i>
            <span>Pangkalan Data</span>
        </a>
        <ul class="submenu {{ Request::is('data/universitas/*') ? 'active' : '' }}" style="display: {{ Request::is('data/universitas/*') ? 'block' : 'none' }};">
            <li class="submenu-item {{ Request::is('data/universitas/sertifikasi_akreditasi_eksternal') ? 'active' : '' }}">
                <a href="/data/universitas/sertifikasi_akreditasi_eksternal">Sertifikasi Akreditasi Eksternal</a>
            </li>
            <li class="submenu-item {{ Request::is('data/universitas/audit_keuangan_eksternal') ? 'active' : '' }}">
                <a href="/data/universitas/audit_keuangan_eksternal">Audit Keuangan Eksternal</a>
            </li>
        </ul>
    </li>

@endrole

