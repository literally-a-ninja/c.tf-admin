@foreach(Session::get ('feedback', []) as $type => $messages)
  @foreach($messages as $msg)
    <div class="alert alert-{{{$type}}}" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true"><i class='fas fa-times'></i></span>
      </button>
        <h4 class="alert-heading">
          <i class='{{$msg['icon'] ?? 'fas fa-check'}} mr-md-2'></i>
          {!! $msg['title'] ?? '' !!}
        </h4>
      @isset($msg['message'])
      {!! $msg['message'] ?? '' !!}
      @endisset
        </div>
  @endforeach
@endforeach
@php
  Session::put('feedback', []);
@endphp
