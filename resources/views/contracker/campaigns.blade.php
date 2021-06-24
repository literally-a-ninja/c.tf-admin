<div class="card-group">
  @foreach($campaigns as $campaign)
    <div class='card p-3 m-3' style='background: url({{asset ("img/campaign/{$campaign->title}.jpeg")}})'>
      <div class="card text-center">
        <div class='card-body'>
          <h3>{{$campaign->name}}</h3>
        </div>
      </div>
    </div>
  @endforeach
</div>