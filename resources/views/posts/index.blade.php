@extends('layouts.app')



@section('content')
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Posts</h1>
			</div>
			<div class="col-sm-6">
				<a class="btn btn-primary float-right disabled" href="{{ route('posts.create') }}">
					Add New
				</a>
			</div>
		</div>
	</div>
</section>

<div class="content px-3">

	@include('flash::message')

	<div class="clearfix"></div>

	<div class="card">
		<div class="card-body p-0">
			<div class="table-responsive">
				<table class="table" id="users-table">
					<thead>
						<tr>
							<th>id</th>
							<th>Title</th>
							<th>isHTML</th>
							<th>Created</th>
							<th>Published</th>
							<th>Author</th>
							<th>Views</th>
							<th>Likes</th>

							<th colspan="3">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($posts as $post)
						<tr>
							<td>{{ $post->id }}</td>
							<td>{{ $post->title }}</td>
							<td>{{ $post->is_html }}</td>
							<td>{{ $post->created }}</td>
							<td>{{ $post->published }}</td>
							<td>{{ $post->author }}</td>
							<td>
								<i class="fas fa-eye"></i>
								@if (isset($post->views))
									{{ $post->views }}
								@else
									0
								@endif
							</td>
							<td>
								<i class="fas fa-thumbs-up"></i>
								@if (isset($post->likes))
									{{ $post->likes }}
								@else
									0
								@endif
							</td>
							<td width="120">
								{!! Form::open(['route' => ['posts.destroy', $post->id], 'method' => 'delete']) !!}
								<div class='btn-group'>
									<a href="{{ route('posts.show', [$post->id]) }}" class='btn btn-default btn-xs'>
										<i class="far fa-eye"></i>
									</a>
									{{--
									<a href="{{ route('posts.edit', [$post->id]) }}" class='btn btn-default btn-xs disabled'>
										<i class="far fa-edit"></i>
									</a>
									{!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
									--}}
								</div>
								{!! Form::close() !!}
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div class="card-footer clearfix float-right">
				<div class="float-right">

				</div>
			</div>
		</div>

	</div>
</div>

@endsection