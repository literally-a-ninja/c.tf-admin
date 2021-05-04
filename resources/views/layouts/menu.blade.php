<li class="nav-item">
    <a href="{{ route('dd20.index') }}"
       class="nav-link {{ Request::is('dd20*') ? 'active' : '' }}">
        <p>Digital Directive</p>
    </a>
</li>

<li class="nav-item disabled">
    {{--    <a href="{{ route('users.index') }}"--}}
    <a
        class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
        <p class="text-muted">Players</p>
    </a>
</li>

<li class="nav-item">
    {{--    <a href="{{ route('items.index') }}"--}}
    <a
        class="nav-link {{ Request::is('items*') ? 'active' : '' }}">
        <p class="text-muted">Creators Economy</p>
    </a>
</li>

<li class="nav-item">
    {{--    <a href="{{ route('statistics.index') }}"--}}
    <a
        class="nav-link {{ Request::is('statistics*') ? 'active' : '' }}">
        <p class="text-muted">Player Experience</p>
    </a>
</li>


