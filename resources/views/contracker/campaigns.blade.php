<div class="card-group">
  @foreach($campaigns as $campaign)
    <label for="{{$campaign->title}}">
    <div class='card p-3 m-3'>
      <div class="card-header">
        <input type="radio" name="campaign" value="{{ $campaign->title }}">
      </div>
      <div class="card-body">
        <h3 for="{{ $campaign->title }}">{{$campaign->name}}</h3>
      </div>
    </div></label>
  @endforeach
</div>