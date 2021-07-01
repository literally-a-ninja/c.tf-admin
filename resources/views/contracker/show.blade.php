@extends('layouts.app')

@php
    /**
     * @var $player \App\Models\User
     * @var $campaign \App\Models\Interpretations\Campaign
     * @var $quests \App\Models\Interpretations\Quest[]
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
                              <form action='{{route ('contracker.update')}}' method='post'>
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
                                  <input type='submit'>
                              </form>
                          </td>
                          <td><div class='btn btn-primary'></div></td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
        </div>
  </article>
@endsection
