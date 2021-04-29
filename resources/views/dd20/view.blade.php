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
                <form>
                    <div class="form-group">
                        <label>Points accumulated</label>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" placeholder="Default input">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <h2>Missions</h2>
        <div id="accordion">
            @foreach(['mvm_autumnnull', 'mvm_example', 'mvm_bigrock'] as $map)
                <div class="card">
                    <div class="card-header" id="heading">
                        <div class="row">
                            <div class="col col-1">
                                <img class="w-100 h-100" src="//creators.tf/api/mapthumb?map={{$map}}"/>
                            </div>
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse" aria-expanded="true" aria-controls="collapse">
                                <h2>{{$map}}</h2>
                            </button>
                        </div>
                    </div>
                    <div id="collapse" class="collapse" aria-labelledby="heading" data-parent="#accordion">
                        <div class="card-body">
                            @foreach($missions as $mission)
                                <form>
                                    <div class="form-group">
                                        <label>{{$mission->target}}</label>
                                        <div class="row">
                                            @for ($i = 1; $i <= 6; $i++)
                                                <div class="col-sm-1">
                                                    <label>Wave {{$i}}</label>
                                                    <input class="form-control" type="text" placeholder="0">
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

@endsection

