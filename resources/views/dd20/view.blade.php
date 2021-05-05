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
                <label for="form-rpc">Website Controls</label>
                <form id="form-rpc" method="GET" class="form-inline" action="{{ route('dd20.rpc', compact('player')) }}">
                    @csrf
                    <button type="submit" name="action" value="reset_cache" class="btn btn-primary"><i class="fas fa-bomb"></i> Update main cache</button>
                </form>
                {{--                <label for="form-summary">Summary</label>--}}
                {{--                <form id="form-summary" class="form-inline">--}}
                {{--                    <div class="form-group">--}}
                {{--                        <label for="campaign.progress">Points accumulated</label>--}}
                {{--                        <div class="col-sm-2">--}}
                {{--                            <input class="form-control" name="campaign.progress" type="text" value="{{$campaign->progress['progress']}}" placeholder="0" disabled>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="form-group">--}}
                {{--                        <label for="campaign.progress_seen">Points seen</label>--}}
                {{--                        <div class="col-sm-2">--}}
                {{--                            <input class="form-control" name="campaign.progress_seen" type="text" value="{{$campaign->progress['progress_seen']}}" placeholder="0" disabled>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="form-group">--}}
                {{--                        <label for="campaign.checked">Has signed contract?</label>--}}
                {{--                        <div class="col-sm-2">--}}
                {{--                            <input class="form-control" name="campaign.checked" type="checkbox" {{$campaign->progress['signed'] ? 'checked' : ''}} disabled>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </form>--}}
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
                                    <img class="img-thumbnail w-100 h-100" src="//creators.tf/api/mapthumb?map={{$map}}"/>
                                </div>
                                <h2 class="mr-2">{{ucfirst(explode('_', $map)[1])}}</h2>
                                @foreach($mapMissions as $i => $mission)
                                    <span class="text-muted">{{$i > 0 ? ', ' : '' }}{{$mission->title}}</span>
                                @endforeach
                            </div>
                        </div>
                    </button>
                    <div id="card-{{$map}}" class="card-body collapse" aria-labelledby="heading" data-parent="#accordion-{{$map}}">
                        @foreach($mapMissions as $mission)
                            <form action="{{route('dd20.save', compact('player'))}}" method="post" class="mb-5">
                                @csrf
                                <input type="hidden" name="reference" value="{{base64_encode($mission->toJson())}}">
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
                                                        <input type="checkbox" name="waves[]" value="{{$i}}" {{ isset($waves[$i]) && $waves[$i] ? 'checked' : ''}}>
                                                    </div>
                                                </div>
                                            @endfor
                                        @else
                                            @for ($i = 1; $i <= $mission->waves; $i++)
                                                <div class="col-sm-1">
                                                    <div class="d-flex flex-column justify-content-center text-center">
                                                        <label for="{{$mission->title}}.{{$i}}">Wave {{$i}}</label>
                                                        <input type="checkbox" id="{{$mission->title}}{{$i}}" name="waves[]" value="{{$i}}">
                                                    </div>
                                                </div>
                                            @endfor
                                        @endisset
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="erase" value="1" class="btn btn-default mr-2"><i class="fas fa-eraser"></i> Reset progress</button>
                                        <button type="submit" name="save" value="1" class="btn btn-default mr-2"><i class="fas fa-save"></i> Save changes</button>
                                        <button type="submit" name="loot" value="1" class="btn btn-warning"><i class="fas fa-magic"></i> Finish & Distribute Loot</button>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
        @endforeach
    </section>
@endsection

