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
                <h1><img class="img-thumbnail mr-2" style="width: 4rem"
                         src="{{$player->avatar}}"
                  /><strong>{{$player->name}}</strong></h1>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <label for="form-rpc">Website Controls</label>
                <form id="form-rpc" method="GET" class="form-inline"
                      action="{{ route('dd20.rpc', compact('player')) }}"
                >
                    @csrf
                  <button type="submit" name="action" value="reset_cache" class="btn btn-primary"><i
                      class="fas fa-bomb"
                    ></i> Update main cache
                    </button>
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
                    <button class="card-header btn btn-link" id="heading-{{$map}}" data-toggle="collapse"
                            data-target="#card-{{$map}}" aria-expanded="true" aria-controls="collapse"
                    >
                        <div class="d-flex justify-content-between align-items-center">

                            <div class="d-flex flex-grow-1 align-items-center">
                                <div class="col col-5 col-md-2 col-lg-1">
                                    <img class="img-thumbnail w-100 h-100"
                                         src="//creators.tf/api/mapthumb?map={{$map}}"
                                    />
                                </div>
                                <h2 class="mr-2"> {{ucfirst(explode('_', $map)[1])}} </h2>
                              @foreach($mapMissions as $i => $mission)
                                <span
                                  class="text-muted d-none d-md-inline"
                                >{{$i > 0 ? ', ' : '' }}{{$mission->name}}</span>
                              @endforeach
                            </div>
                        </div>
                    </button>
                    <div id="card-{{$map}}" class="card-body collapse" aria-labelledby="heading"
                         data-parent="#accordion-{{$map}}"
                    >
                        @foreach($mapMissions as $mission)
                        <form action="{{route('dd20.save', compact('player'))}}" method="post" class="mb-5">
                                @csrf
                          <input type="hidden" name="reference" value="{{base64_encode($mission->toJson())}}">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-md-3">
                                            <h4 class="d-inline"><label class="text-truncate">{{$mission->name}}</label>
                                            </h4>
                                        </div>
                                        <div class="col d-none d-md-inline col-2"></div>
                                        <div class="col col-md-auto">
                                            <div class="input-group-sm">
                                                <button type="submit" name="erase" value="1"
                                                        data-toggle="tooltip" data-placement="right"
                                                        title="Reset all progress on this mission (essentially uncheck all)"
                                                        class="btn btn-sm btn-outline-danger d-none d-md-inline mr-2"
                                                ><i class="fas fa-eraser"></i></button>
                                                <button type="button"
                                                        class="btn btn-sm btn-primary dropdown-toggle dropdown-toggle-split"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"
                                                > <i class="fas fa-save"></i> Save Mission </button>
                                                <div class="dropdown-menu">
                                                    <button type="submit" name="save" value="1"
                                                            data-toggle="tooltip" data-placement="right"
                                                            title="The player still has waves to finish"
                                                            class="btn btn-link dropdown-item"
                                                    >... as Selected</button>
                                                    <button type="submit" name="loot" value="1"
                                                            data-toggle="tooltip" data-placement="right"
                                                            title="The player is done with this mission, auto-mark all waves and award loot."
                                                            class="btn btn-link dropdown-item"
                                                    >... as Victory (Gives Loot)</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2 mt-md-0">
                                        @php
                                          $waves = ($stats[$mission->title] ?? new App\Models\Derived\Mission())->waves();
                                        @endphp
                                      @for ($i = 1; $i <= $mission->waves; $i++)
                                        <div
                                          class="col-sm-1 ml-2 ml-md-0 d-flex flex-row-reverse flex-md-column justify-content-end justify-content-md-center text-center"
                                          style="align-items: baseline"
                                        >
                                            <label for="{{$mission->title}}.{{$i}}"
                                                   class="pl-2 pl-md-0">
                                              Wave {{$i}}
                                            </label>
                                            <input type="checkbox" name="waves[]"
                                                   id="{{$mission->title}}.{{$i}}"
                                                   value="{{$i}}" {{ $waves[$i] ?? false ? 'checked' : ''}}>
                                        </div>
                                      @endfor
                                    </div>
                                </div>
                            </form>
                      @endforeach
                    </div>
                </div>
        @endforeach
    </section>
@endsection

