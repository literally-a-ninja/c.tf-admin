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

  <section class="content px-4">
        <div class="d-flex justify-content-between">
            <div class="d-flex justify-content-center align-items-center">
              <img class="img-thumbnail mr-2" style="width: 4rem" src="{{$player->avatar}}" />
            <h1 class='font-weight-bold'>{{$player->name}}</h1>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <form id="form-rpc" method="POST" class="form-inline"
                      action="{{ route('dd20.rpc', compact('player')) }}"
                >
                    @csrf
                  <button type="submit" name="action" value="reset_cache" class="btn btn-success"><i
                        class="fas fa-bomb"
                    ></i> Update main cache
                    </button>
                </form>
            </div>
        </div>

        @foreach($tours as $i => $tour)
          <header class='mt-2 py-3'>
            <div class='text-muted'>
              <code>{{$tour->getKey()}}</code>
            </div>
            <h2>{{$tour->tour_name}}</h2>
            <p>{{$tour->description}}</p>
          </header>
          @foreach($missions[$i] as $map => $mapMissions)
            <div class="accordion">
              <div class="mx-3 card" id="accordion-{{$map}}">
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
                                  <div class='col col-2 d-flex flex-column align-items-start'>
                                    <div class='text-muted'>
                                      <code>{{$map}}</code>
                                    </div>
                                    <h2 class="mr-2 p-0"> {{ucfirst(explode('_', $map)[1])}} </h2>
                                  </div>
                                  <div class=''>
                                    @foreach($mapMissions as $i => $mission)
                                      <h4 class="text-muted d-none d-md-inline">
                                        {{$i > 0 ? ', ' : '' }}{{$mission->name}}
                                      </h4>
                                    @endforeach
                                  </div>
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
                                      <div class="col-12 col-md-3 text-muted">
                                          <i class='fas fa-fingerprint'></i>
                                          <code>{{$mission->title}}</code>
                                      </div>
                                    </div>
                                      <div class="row">
                                          <div class="col-12 col-md-3">
                                              <h3 class="d-inline">
                                                <label class="text-truncate">{{$mission->name}}</label>
                                              </h3>
                                          </div>
                                          <div class="col d-none d-md-inline col-2"></div>
                                          <div class="col col-md-auto d-flex align-items-center">
                                            <div class='form-check-inline'>
                                              <input class='form-check-input'
                                                     type="checkbox"
                                                     id='{{$mission->title}}}-loot'
                                                     name="give_loot"
                                                     value='1'
                                                     checked />
                                              <label class='form-check-label' for='{{$mission->title}}}-loot'>Loot distributor</label>
                                            </div>
                                            <button type="submit"
                                                    name="procedure" value="normal"
                                                    class="btn btn-sm btn-primary form-inline"
                                                    title="Saves the mission. If all waves are complete loot is distributed."
                                                    aria-haspopup="true"
                                                    aria-expanded="false">
                                              <i class="fas fa-save"></i> Save Mission
                                            </button>
                                          </div>
                                      </div>
                                      <div class="row mt-2 mt-md-0">
                                          @php
                                            $waves = ($stats[$mission->title] ?? new App\Models\Derived\Mission())->waves();
                                          @endphp
                                        @for ($i = 1; $i <= $mission->waves; $i++)
                                          <label
                                              class="col-sm-1 ml-2 ml-md-0 d-flex flex-row-reverse flex-md-column justify-content-end justify-content-md-center text-center"
                                              style="align-items: center"
                                              aria-labelledby=''
                                          >
                                              <label for="{{$mission->title}}.{{$i}}"
                                                     class="pl-2 pl-md-0">
                                                Wave {{$i}}
                                              </label>
                                              <input type="checkbox" name="waves[]"
                                                     id="{{$mission->title}}.{{$i}}"
                                                     value="{{$i}}" {{ $waves[$i] ?? false ? 'checked' : ''}}>
                                          </label>
                                        @endfor
                                      </div>
                                  </div>
                              </form>
                        @endforeach
                      </div>
                </div>
          @endforeach
        @endforeach
    </section>
@endsection

