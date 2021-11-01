<div class="table-responsive">
	<table class="table" id="users-table">
		<thead>
			<tr>
				<th>Steamid</th>
		<th>Alias</th>
		<th>Name</th>
		<th>Motd</th>
		<th>Avatar</th>
		<th>Token</th>
		<th>Bans</th>
		<th>Special</th>
		<th>Admin</th>
		<th>Connections</th>
		<th>Loadout</th>
		<th>Settings</th>
		<th>Queried</th>
		<th>Exp</th>
		<th>Credit</th>
		<th>Contract</th>
		<th>Owner</th>
		<th>Lastlogin</th>
		<th>Lastserver</th>
		<th>Backpack Pages</th>
		<th>Presence</th>
				<th colspan="3">Action</th>
			</tr>
		</thead>
		<tbody>
		@foreach($users as $user)
			<tr>
				<td>{{ $user->steamid }}</td>
			<td>{{ $user->alias }}</td>
			<td>{{ $user->name }}</td>
			<td>{{ $user->motd }}</td>
			<td>{{ $user->avatar }}</td>
			<td>{{ $user->token }}</td>
			<td>{{ $user->bans }}</td>
			<td>{{ $user->special }}</td>
			<td>{{ $user->admin }}</td>
			<td>{{ $user->connections }}</td>
			<td>{{ $user->loadout }}</td>
			<td>{{ $user->settings }}</td>
			<td>{{ $user->queried }}</td>
			<td>{{ $user->exp }}</td>
			<td>{{ $user->credit }}</td>
			<td>{{ $user->contract }}</td>
			<td>{{ $user->owner }}</td>
			<td>{{ $user->lastlogin }}</td>
			<td>{{ $user->lastserver }}</td>
			<td>{{ $user->backpack_pages }}</td>
			<td>{{ $user->presence }}</td>
				<td width="120">
					{!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
					<div class='btn-group'>
						<a href="{{ route('users.show', [$user->id]) }}" class='btn btn-default btn-xs'>
							<i class="far fa-eye"></i>
						</a>
						<a href="{{ route('users.edit', [$user->id]) }}" class='btn btn-default btn-xs'>
							<i class="far fa-edit"></i>
						</a>
						{!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
					</div>
					{!! Form::close() !!}
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
