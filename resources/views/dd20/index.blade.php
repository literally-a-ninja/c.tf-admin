@extends('layouts.app')

@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1> <i class="fas fa-meteor"></i> Digital Directive</h1>
				</div>
				{{--				<div class="col-sm-6">--}}
				{{--					<a class="btn btn-primary float-right"--}}
				{{--					   href="{{ route('statistics.create') }}">--}}
				{{--						Add New--}}
				{{--					</a>--}}
				{{--				</div>--}}
			</div>
		</div>
	</section>

	<section class="content px-3">

		@include('flash::message')

		<div class="clearfix"></div>

		<h2>Search for a player to begin</h2>
		<form action="{{ route('dd20.find') }}">
			<div class="input-group mb-3">
				<div class="input-group-prepend">
					<span class="input-group-text" id="query-addon"><i class="fas fa-user"></i></span>
				</div>
				<input type="text"
					   class="form-control"
					   name="query"
					   placeholder="Username / Community ID"
					   aria-label="User query"
					   aria-describedby="query-addon">
			</div>
		</form>
	</section>

@endsection

