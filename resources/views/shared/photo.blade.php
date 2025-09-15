



@if(isset($model->photo))
<a href="/public/{{ $model->photo }}" target="__blank"> <img src="/public/{{ $model->photo }}" alt="" title="" width="50" height="40"></a>
@endif