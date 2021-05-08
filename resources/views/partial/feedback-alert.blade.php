@foreach(Session::get ('feedback', []) as $type => $messages)
  @foreach($messages as $msg)
    <div class="alert alert-{{{$msg['type']}}}" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class='fas fa-times'></i></span>
            </button>
      @isset($msg['header'])
        <i class='fas fa-{{$msg['icon']}}'></i>
        <h4 class="alert-heading">
              @isset($msg['icon'])
            <i class='fas fa-{{$msg['icon']}}'></i>
          @endisset
          {{$msg['header']}}
            </h4>
      @endisset
      {{$msg['message']}}
        </div>
  @endforeach
@endforeach
@php
  Session::put('feedback', []);
@endphp
