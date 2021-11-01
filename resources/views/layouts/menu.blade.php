


<li class="nav-header">Game</li>



<li class="nav-item">
    <a 
    {{--href="{{ route('contracts.index') }}"--}}
        class="nav-link {{ Request::is('contracts*') ? 'active' : '' }}">
				<i class="nav-icon fas fa-tablet-alt"></i>
        <p class="text-muted" >Contracts</p>
    </a>
</li>

<li class="nav-item">
    <a 
    {{--href="{{ route('servers.index') }}"--}}
        class="nav-link {{ Request::is('servers*') ? 'active' : '' }}">
				<i class="nav-icon fas fa-server"></i>
        <p class="text-muted" >Servers</p>
    </a>
</li>
<li class="nav-item">
	<a href="{{ route('dd20.index') }}"
	   class="nav-link {{ Request::is('dd20*') ? 'active' : '' }}">
		<i class="fas fa-meteor"></i> <label>Digital Directive</label>
	</a>
</li>

<li class="nav-item disabled">
{{--    <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}"> --}}
	<a href="#" class="nav-link">
				<i class="nav-icon far fa-user"></i>
        <p >Users</p>
    </a>
</li>
<li class="nav-item">
{{--	<a href="{{route ('contracker.index')}}" class="nav-link {{ Request::is('contracker*') ? 'active' : '' }}">--}}
	<a href="#" class="nav-link">
	  <i class="text-muted fas fa-tasks"></i> <label class="text-muted">Contracker</label>
{{--		<span class="badge badge-primary">NEW</span>--}}
	</a>
</li>


<li class="nav-item">
    <a 
    {{--href="{{ route('statistics.index') }}"--}}Z
        class="nav-link {{ Request::is('statistics*') ? 'active' : '' }}">
				<i class="nav-icon fas fa-graph"></i>
        <p class="text-muted" >Statistics</p>
    </a>
</li>


<li class="nav-header">Economy</li>

<li class="nav-item">
    <a
	{{--href="{{ route('items.index') }}"--}}
        class="nav-link {{ Request::is('items*') ? 'active' : '' }}">
        <p class="text-muted">Items</p>
    </a>
</li>

<li class="nav-item">
    <a 
    {{--href="{{ route('store.index') }}"--}}
        class="nav-link {{ Request::is('store*') ? 'active' : '' }}">
        <p class="text-muted" >Store</p>
    </a>
</li>

<li class="nav-header">Website</li>

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
    {{--href="{{ route('links.index') }}"--}}
        class="nav-link {{ Request::is('links*') ? 'active' : '' }}">
        <p class="text-muted" >Link Lists</p>
    </a>
</li>

<li class="nav-item">
    <a 
    {{--href="{{ route('media.index') }}"--}}
        class="nav-link {{ Request::is('media*') ? 'active' : '' }}">
        <p class="text-muted" >Media, Colors, etc.</p>
    </a>
</li>
<li class="nav-item">
    <a 
    {{--href="{{ route('landing.index') }}"--}}
        class="nav-link {{ Request::is('landing*') ? 'active' : '' }}">
        <p class="text-muted" >Landing Pages</p>
    </a>
</li>


<li class="nav-header">Unsorted</li>

<li class="nav-item">
{{--	<a href="{{route ('users.index')}}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">--}}
	<a href="#" class="nav-link">
	   <i class="text-muted fas fa-users"></i> <label class='text-muted'>Players</label>
	</a>
</li>

<li class="nav-item">
{{--	<a href="{{ route('items.index') }}"--}}
{{--	   class="nav-link {{ Request::is('items*') ? 'active' : '' }}">--}}
	<a href="#" class="nav-link">
		<i class="text-muted fas fa-luggage-cart"></i> <label class="text-muted">Economy</label>
	</a>
</li>

