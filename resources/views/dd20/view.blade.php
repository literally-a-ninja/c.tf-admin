@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col">
                    <a href="{{route('dd20.index')}}">Back to index</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content px-3">
        @include('flash::message')
        <div class="clearfix"></div>
    </section>

    <section class="content px-3">
        <div class="row">
            <div class="col-sm-6">
                <h1><img class="img-thumbnail mr-2" style="width: 4rem" src="{{$player->avatar}}"/><strong>{{$player->name}}</strong></h1>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form class="form-inline">
                    <div class="form-group">
                        <label for="campaign.progress">Points accumulated</label>
                        <div class="col-sm-2">
                            <input class="form-control" name="campaign.progress" type="text" value="{{$campaign->progress['progress']}}" placeholder="0" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="campaign.progress_seen">Points seen</label>
                        <div class="col-sm-2">
                            <input class="form-control" name="campaign.progress_seen" type="text" value="{{$campaign->progress['progress_seen']}}" placeholder="0" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="campaign.checked">Has signed contract?</label>
                        <div class="col-sm-2">
                            <input class="form-control" name="campaign.checked" type="checkbox" {{$campaign->progress['signed'] ? 'checked' : ''}} disabled>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <h2>Campaign Missions</h2>
        <i class="small">All missions completed by the player, grouped by map.</i>
        <div class="accordion">
            @foreach($missions as $map => $mapMissions)
                <div class="card" id="accordion-{{$map}}">
                    <button class="card-header btn btn-link" id="heading-{{$map}}" data-toggle="collapse" data-target="#card-{{$map}}" aria-expanded="true" aria-controls="collapse">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-grow-1 align-items-center">
                                <div class="col col-1">
                                    <img class="img-thumbnail w-100 h-100" src="//local.creators.tf/api/mapthumb?map={{$map}}"/>
                                </div>
                                <h2>{{ucfirst(explode('_', $map)[1])}}</h2>
                                <span class="ml-2 text-muted">{{sizeof($mapMissions)}} mission(s) available</span>
                            </div>
                        </div>
                    </button>
                    <div id="card-{{$map}}" class="card-body collapse" aria-labelledby="heading" data-parent="#accordion-{{$map}}">
                        @foreach($mapMissions as $mission)
                            <form action="{{route('dd20.save', compact('player'))}}" class="mb-5">
                                @csrf
                                <input type="hidden" name="reference" value="{{$mission->title}}">
                                <div class="form-group">
                                    <div class="d-flex align-items-center">
                                        <h4 class="d-inline"><label>{{$mission->name}}</label></h4>
                                    </div>
                                    <div class="form-group row">
                                        @isset ($stats[$mission->title])
                                            @php
                                                $waves = $stats[$mission->title]->waves();
                                            @endphp
                                            @for ($i = 1; $i <= $mission->waves; $i++)
                                                <div class="col-sm-1">
                                                    <div class="d-flex flex-column justify-content-center text-center">
                                                        <label for="{{$mission->title}}.{{$i}}">Wave {{$i}}</label>
                                                        @isset ($waves[$i - 1])
                                                            <input type="checkbox" name="{{$mission->title}}.{{$i}}" checked>
                                                        @else
                                                            <input type="checkbox" name="{{$mission->title}}.{{$i}}">
                                                        @endisset
                                                    </div>
                                                </div>
                                            @endfor
                                        @else
                                            @for ($i = 1; $i <= $mission->waves; $i++)
                                                <div class="col-sm-1">
                                                    <div class="d-flex flex-column justify-content-center text-center">
                                                        <label for="{{$mission->title}}.{{$i}}">Wave {{$i}}</label>
                                                        <input type="checkbox" name="{{$mission->title}}.{{$i}}">
                                                    </div>
                                                </div>
                                            @endfor
                                        @endisset
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default mr-2"><i class="fas fa-eraser"></i> Reset progress</button>
                                        <button type="submit" class="btn btn-default mr-2"><i class="fas fa-save"></i> Save changes</button>
                                        <button type="submit" class="btn btn-warning"><i class="fas fa-magic"></i> Distribute Loot</button>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
        @endforeach
    </section>
@endsection

