<li class="nav-item">
	<a href="{{ route('dd20.index') }}" class="nav-link {{ Request::is('dd20*') ? 'active' : '' }}">
		<i class="nav-icon fas fa-meteor"></i> <p><label>Digital Directive</label></p>
	</a>
</li>

<li class="nav-item">
	<a href="#" class="nav-link">
{{--	<a href="{{route ('contracker.index')}}" class="nav-link {{ Request::is('contracker*') ? 'active' : '' }}">--}}
		<i class="text-muted nav-icon fas fa-tasks"></i> <p><label class="text-muted">Contracker</label></p>
{{--		<span class="badge badge-primary">NEW</span>--}}
	</a>
</li>

<li class="nav-item">
	<a href="#" class="nav-link">
{{--	<a href="{{route ('users.index')}}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">--}}
		<i class="text-muted nav-icon fas fa-users"></i> <p><label class='text-muted'>Players</label></p>
	</a>
</li>

<li class="nav-item">
	<a href="#" class="nav-link">
{{--	<a href="{{ route('items.index') }}" class="nav-link {{ Request::is('items*') ? 'active' : '' }}"> --}}
		<i class="text-muted nav-icon fas fa-luggage-cart"></i> <p><label class="text-muted">Economy</label></p>
	</a>
</li>

