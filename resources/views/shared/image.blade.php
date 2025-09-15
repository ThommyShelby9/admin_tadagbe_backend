


@if(isset($model->image))
<a href="/public/{{ $model->image }}" target="__blank"> <img src="/public/{{ $model->image }}" alt="" title="" width="50" height="40"></a>
@endif