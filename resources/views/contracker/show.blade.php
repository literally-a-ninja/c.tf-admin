@extends('layouts.app')

@php
  /**
   * @var $player \App\Models\User
   * @var $econCampaign \App\Definitions\EconCampaignDD20
   * @var $campaign \App\Models\Interpretations\Campaign
   * @var $quests \App\Models\Interpretations\Quest
   * @var $econQuests \App\Definitions\EconQuest
   *
  **/
@endphp

@section('content')
  <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <a href="{{route('contracker.index')}}">Back to index</a>
                </div>
            </div>
        </div>
    </section>

  @include('layouts/flash-messages')

  <article class="content px-4">
        <div class="d-flex justify-content-between">
          @include('partial/player-block')
        </div>
        <div class="card">
            <div class="card-body">
              @foreach($quests as $quest)
                <div class="row">
                  <div class='col'>{{$quest->target}}</div>
                  @foreach($quest->progress as $k => $v)
                    <div class='col'>{{$k}}</div>
                  @endforeach
                </div>
                <div class="row">
                  <div class='col'></div>
                  @foreach($quest->progress as $k => $v)
                    <div class='col'>{{$v}}</div>
                  @endforeach
                </div>
              @endforeach
            </div>
        </div>
  </article>
@endsection
