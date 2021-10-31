<li class="nav-item">
    <a href="{{ route('dd20.index') }}"
       class="nav-link {{ Request::is('dd20*') ? 'active' : '' }}">
        <p>Digital Directive</p>
    </a>
</li>

<li class="nav-item disabled">
    <a href="{{ route('users.index') }}">
    <a
        class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
        <p >Players</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('items.index') }}"
        class="nav-link {{ Request::is('items*') ? 'active' : '' }}">
        <p >Creators Economy</p>
    </a>
</li>

<li class="nav-item">
    <a 
    {{--href="{{ route('statistics.index') }}"--}}Z
        class="nav-link {{ Request::is('statistics*') ? 'active' : '' }}">
        <p class="text-muted" >Player Experience</p>
    </a>
</li>

<li class="nav-item">
     <a href="{{ route('posts.index') }}"
        class="nav-link {{ Request::is('posts*') ? 'active' : '' }}">
        <p>Posts</p>
    </a>
</li>



<li class="nav-item">
    <a 
    {{--href="{{ route('downloads.index') }}"--}}
        class="nav-link {{ Request::is('downloads*') ? 'active' : '' }}">
        <p class="text-muted" >Asset Packs</p>
    </a>
</li>

<li class="nav-item">
    <a 
    {{--href="{{ route('history.index') }}"--}}
        class="nav-link {{ Request::is('history*') ? 'active' : '' }}">
        <p class="text-muted" >Project History</p>
    </a>
</li>

<li class="nav-item">
    <a 
    {{--href="{{ route('team.index') }}"--}}
        class="nav-link {{ Request::is('team*') ? 'active' : '' }}">
        <p class="text-muted" >Team List</p>
    </a>
</li>

<li class="nav-item">
    <a 
    {{--href="{{ route('contracts.index') }}"--}}
        class="nav-link {{ Request::is('contracts*') ? 'active' : '' }}">
        <p class="text-muted" >Contracts</p>
    </a>
</li>

<li class="nav-item">
    <a 
    {{--href="{{ route('store.index') }}"--}}
        class="nav-link {{ Request::is('store*') ? 'active' : '' }}">
        <p class="text-muted" >Store</p>
    </a>
</li>

<li class="nav-item">
    <a 
    {{--href="{{ route('links.index') }}"--}}
        class="nav-link {{ Request::is('links*') ? 'active' : '' }}">
        <p class="text-muted" >Link Lists</p>
    </a>
</li>

<li class="nav-item">
    <a 
    {{--href="{{ route('media.index') }}"--}}
        class="nav-link {{ Request::is('media*') ? 'active' : '' }}">
        <p class="text-muted" >Media</p>
    </a>
</li>

<li class="nav-item">
    <a 
    {{--href="{{ route('keyvalue.index') }}"--}}
        class="nav-link {{ Request::is('keyvalue*') ? 'active' : '' }}">
        <p class="text-muted" >Misc</p>
    </a>
</li>
