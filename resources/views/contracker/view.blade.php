@extends('layouts.app')

@php
	/**
	 * @var $player \App\Models\User
	 * @var $campaign \App\Models\Interpretations\Campaign
	 * @var $campaignNames \App\Models\Interpretations\Campaign[]
	 * @var $econCampaign \App\Definitions\EconCampaign
	 * @var $econQuests \App\Models\Interpretations\Quest[]
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
		@foreach($campaignNames as $title => $name)
			<a
				href="{{route ('contracker.view', compact ('player'))}}?campaign={{$title}}"
				class="btn {{$name == $econCampaign->name ? 'btn-primary' : 'btn-link'}}">
				{{$name}}
			</a>
		@endforeach
	</section>
@endsection

@section('content')
	<article class="content px-4 d-flex flex-wrap justify-content-center justify-md-content-between">
			@foreach($econQuests as $quest)
				<div class="card m-2" style='width: 32rem'>
				<div class='card-header flex-row d-flex align-items-baseline'>
				<div style='width: 4rem' class='mr-3'><img class='img-thumbnail w-100' src='{{$quest->image}}' /></div>
				<h4 class='font-weight-normal p-0'>{{$quest->name}}</h4>
			</div>
			<div class="card-body d-flex flex-row">
					<form action='{{route ('contracker.update', compact ('player'))}}' class='flex-grow-1' method='post'>
				    <input type='hidden' name='player' value='{{$player->id}}' />
						@csrf
						@method('patch')
						@foreach($quest->objectives as $i => $objective)
							@php($objective['limit'] = max($objective['limit'] ?? 1, 1))
							@php($objective['points'] = $objective['points'] ?? 0)
							<div class='{{ $i ? 'mt-2' : '' }}'>
						  <label for='points-{{$quest->id}}.{{$i}}' class="form-label">{{$objective['name']}}</label>
								<div class='ml-3'>
								@if(($objective['limit'] ?? 1) == 1)
										<div>
									  <div class='form-check'>
										  <input id='points-{{$quest->id}}.{{$i}}:on'
										         name='quests[{{$quest->id}}][{{$i}}]'
										         class="form-check-input"
										         type="radio"
										         value="1"
											  {{$objective['points'] ? '' : 'checked'}}
										  />
										  <label for='points-{{$quest->id}}.{{$i}}:on' class='form-check-label'><i>Pending</i></label>
									  </div>
									  <div class='form-check'>
										  <input id='points-{{$quest->id}}.{{$i}}:off'
										         name='quests[{{$quest->id}}][{{$i}}]'
										         class="form-check-input"
										         type="radio"
										         value="0"
											  {{!$objective['points'] ? '' : 'checked'}}
										  />
										  <label for='points-{{$quest->id}}.{{$i}}:on' class='form-check-label'>Complete</label>
									  </div>
								  </div>
									@else
										<div class='input-group flex-nowrap'>
									  <span style='min-width: 4ex'>0</span>
									  <input type="range"
									         class='form-control-range mx-2'
									         id='points-{{$quest->id}}.{{$i}}'
									         name='quests[{{$quest->id}}][{{$i}}]'
									         value='{{$objective['points']}}'
									         step='1'
									         max='{{$objective['limit'] ?? 1}}'
									         list='points-{{$quest->id}}.{{$i}}:tickmarks'
									  />
									  <span style='min-width: 4ex'>{{$objective['limit'] ?? '1'}}</span>
								  </div>
									@endif
							</div>
						  </div>
						@endforeach
						{{--								  <button class='btn btn-primary' type='submit'><i class='fas fa-save'></i></button>--}}
				</form>
			</div>
		</div>
			@endforeach
	</article>
@endsection
