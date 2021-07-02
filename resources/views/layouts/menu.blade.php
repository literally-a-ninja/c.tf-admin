<li class="nav-item">
    <a href="{{ route('dd20.index') }}"
       class="nav-link {{ Request::is('dd20*') ? 'active' : '' }}">
        <i class="fas fa-meteor"></i> <label>Digital Directive</label>
    </a>
</li>

<li class="nav-item">
    <a href="{{route ('contracker.index')}}" class="nav-link {{ Request::is('contracker*') ? 'active' : '' }}">
      <i class="fas fa-tasks"></i> <label>Contracker</label>
        <span class="badge badge-primary">NEW</span>
    </a>
</li>

<li class="nav-item">
    <a href="{{route ('users.index')}}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
       <i class="text-muted fas fa-users"></i> <label class='text-muted'>Players</label>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('items.index') }}"
       class="nav-link {{ Request::is('items*') ? 'active' : '' }}">
        <i class="text-muted fas fa-luggage-cart"></i> <label class="text-muted">Economy</label>
    </a>
</li>

