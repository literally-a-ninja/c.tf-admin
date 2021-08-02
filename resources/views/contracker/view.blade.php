@extends('layouts.app')

@php
	/**
	 * @var $player \App\Models\User
	 * @var $campaign \App\Models\Interpretations\Campaign
	 * @var $econCampaign \App\Definitions\EconCampaign
	 * @var $campaigns \App\Models\Interpretations\Campaign[]
	 * @var $quests \App\Models\Interpretations\Quest[]
	 *
	**/
@endphp

@section('header')
	<div class="d-flex justify-content-between">
	@include('partial/player-block')
		<div class="d-flex justify-content-center align-items-center">
		<form id="form-rpc" method="POST" class="form-inline"
		      action="{{ route('dd20.rpc', compact('player')) }}"
		>
			@csrf
			<button type="submit" name="action" value="reset_cache" class="btn btn-success">
				<i class="fas fa-bomb"></i> Update main cache
			</button>
		</form>
	</div>
</div>
@endsection

@section('nav')
	<section class="content px-4">
		@foreach($campaigns as $possibleCampaign)
			@if ($possibleCampaign->name == $econCampaign->name)
				<button type="button" class="btn btn-primary">
			@else
				<button type="button" class="btn btn-link">
			@endif
				{{$possibleCampaign->name}}
			</button>
		@endforeach
	</section>
@endsection

@section('content')
	<article class="content px-4">
		<div class="card mt-4 py-3">
			<div class="card-body">
				<table class="table table-hover">
				  <thead>
					<tr>
					  <th scope="col">Id</th>
					  <th scope="col">Contracker Quest</th>
					  <th scope="col">Progress</th>
					  <th scope="col"></th>
					</tr>
				  </thead>
				  <tbody>
					@foreach($quests as $quest)
						<tr>
						  <th scope="row">{{$quest->id}}</th>
						  <td class='d-flex'>
							<div>
							  <img style="width: 64px; height: 64px"
							       src="{{$quest->image}}"
							       alt="img of {{$quest->name}}" />
							</div>
							<div>
								<label>{{$quest->name}}</label>
								<ol>
								@foreach($quest->objectives as $i => $objective)
										<li>{{$objective['name']}}</li>
									@endforeach
								</ol>
							</div>
						  </td>
						  <td>
							  <form action='{{route ('contracker.update', compact ('player'))}}' method='post'>
								  <input type='hidden' name='player' value='{{$player->id}}' />
								  @csrf
								  @method('patch')
								  @foreach($quest->objectives as $i => $objective)
									  <li>
										<div>{{$objective['name']}}</div>
										<input type='text'
										       id='points-{{$quest->id}}.{{$i}}'
										       name='quests[{{$quest->id}}][{{$i}}]'
										       value='{{$objective['points']}}'>
										<input type='text'
										       id='limit-{{$quest->id}}.{{$i}}'
										       value='{{$objective['limit'] ?? '-'}}'
										       disabled
										       readonly>
									</li>
								  @endforeach
								  <button class='btn btn-primary' type='submit'><i class='fas fa-save'></i></button>
							  </form>
						  </td>
						</tr>
					@endforeach
				  </tbody>
				</table>
			</div>
		</div>
  </article>
@endsection
