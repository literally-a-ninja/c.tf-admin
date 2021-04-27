<li class="nav-item">
    <a href="{{ route('users.index') }}"
       class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
        <p>Players</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('items.index') }}"
       class="nav-link {{ Request::is('items*') ? 'active' : '' }}">
        <p>Creators Economy</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('statistics.index') }}"
       class="nav-link {{ Request::is('statistics*') ? 'active' : '' }}">
        <p>Player Experience</p>
    </a>
</li>


