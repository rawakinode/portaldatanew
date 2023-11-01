@role('admin')
    <li class="sidebar-item has-sub {{ Request::is('admin*') ? 'active' : '' }}">
        <a href="#" class="sidebar-link">
            <i class="bi bi-collection-fill"></i>
            <span>Admin</span>
        </a>
        <ul class="submenu {{ Request::is('admin*') ? 'active' : '' }}" style="display: {{ Request::is('admin*') ? 'block' : 'none' }};">
            <li class="submenu-item {{ Request::is('admin/user') ? 'active' : '' }}">
                <a href="/admin/user">Akun Pengguna</a>
            </li>
            <li class="submenu-item {{ Request::is('admin/prodi') ? 'active' : '' }}">
                <a href="/admin/prodi">Program Studi</a>
            </li>
            <li class="submenu-item {{ Request::is('admin/spmi') ? 'active' : '' }}">
                <a href="/admin/spmi">Pengaturan SPMI</a>
            </li>
            <li class="submenu-item {{ Request::is('admin/periode') ? 'active' : '' }}">
                <a href="/admin/periode">Periode</a>
            </li>
            <li class="submenu-item {{ Request::is('admin/validasi*') ? 'active' : '' }}">
                <a href="/admin/validasi">Validasi</a>
            </li>
        </ul>
    </li>

    <li class="sidebar-item has-sub {{ Request::is('portaldata*') ? 'active' : '' }}">
        <a href="#" class="sidebar-link">
            <i class="bi bi-collection-fill"></i>
            <span>Portal Data</span>
        </a>
        <ul class="submenu {{ Request::is('portaldata*') ? 'active' : '' }}" style="display: {{ Request::is('portaldata*') ? 'block' : 'none' }};">
            <li class="submenu-item {{ Request::is('portaldata/dosen') ? 'active' : '' }}">
                <a href="/portaldata/dosen">Dosen</a>
            </li>
            
        </ul>
    </li>
    
@endrole