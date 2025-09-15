<div class="btn-group ">
<button class="btn btn-info dropdown-toggle pull-right" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 34px, 0px); top: 0px; left: 0px; will-change: transform;">
    @if(isset($action_list))
        @foreach($action_list as $action)
        @if(isset($action["type"]) && $action["type"]=="link")
        <a class="dropdown-item" href="{{$action['route']}}" target="__blank">{{$action['label']}}</a>
        @elseif(isset($action["type"]) && $action["type"]=="modal")
        <button class="dropdown-item"  onClick="{{$action['onClick']}}" data-target="{{$action['data-target']}}" >{{$action['label']}}</button>
        @else
        <form action="{{$action['route']}}" method="{{$action['method']}}">
            @csrf
        <button class="dropdown-item">{{$action['label']}}</button>
        </form>
        @endif
        @endforeach
    @endif
    
</div>