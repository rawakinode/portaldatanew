@role('dekan')

    <li class="sidebar-item {{ Request::is('universitas/programstudi') ? 'active' : '' }}">
        <a href="/universitas/programstudi" class='sidebar-link'>
            <i class="bi bi-collection-fill"></i>
            <span>Program Studi</span>
        </a>
    </li>

    <li class="sidebar-item {{ Request::is('universitas/akreditasi') ? 'active' : '' }}">
        <a href="/universitas/akreditasi" class='sidebar-link'>
            <i class="bi bi-award-fill"></i>
            <span>Akreditasi</span>
        </a>
    </li>

@endrole