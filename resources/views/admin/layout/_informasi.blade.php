<li class="sidebar-item  has-sub {{ Request::is('home/info*') ? 'active' : '' }}">
    <a href="#" class="sidebar-link">
        <i class="bi bi-info-square-fill"></i>
        <span>Tentang</span>
    </a>
    <ul class="submenu {{ Request::is('home/info*') ? 'active' : '' }}" style="display: {{ Request::is('home/info*') ? 'block' : 'none' }};">
        <li class="submenu-item {{ Request::is('home/info/hubungi') ? 'active' : '' }}">
            <a href="/home/info/hubungi">Contact Us</a>
        </li>
        <li class="submenu-item {{ Request::is('home/info/about') ? 'active' : '' }}">
            <a href="/home/info/about">About</a>
        </li>
    </ul>
</li>