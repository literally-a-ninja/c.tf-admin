@extends('layouts.app')

@section('content')
  <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Contracker</h1>
                </div>
            </div>
        </div>
    </section>

  <div class="content px-3">
    @include('flash::message')
    <div class="clearfix"></div>
    <h2>Find a player</h2>
    <form action="{{ route('contracker.show') }}">
      <div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="query-addon"><i class="fas fa-user"></i></span>
                </div>
                <input type="text"
                       class="form-control"
                       name="user"
                       placeholder="Username / Community ID"
                       aria-label="User query"
                       aria-describedby="query-addon">
            </div>
      </div>
      <h2>Select a campaign</h2>
      <div class="w-75">
          <div class="card-body p-0">
            @include('contracker.campaigns')
            {{--                @include('contracker.table')--}}
          </div>
        {{--          <div class="card-footer clearfix float-right">--}}
        {{--                <div class="float-right">--}}
        {{--                </div>--}}
        {{--          </div>--}}
      </div>
    </form>
@endsection

