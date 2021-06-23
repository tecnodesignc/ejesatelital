<li class="@if($item->getItemClass()) {{$item->getItemClass()}} @endif @if($active)active @endif">
    <a href="{{$item->getUrl()}}" class="waves-effect @if(count($appends) > 0) hasAppend @endif  @if($item->hasItems())has-arrow @endif " @if($item->getNewTab()) target="_blank" @endif>
        <i class="{{ $item->getIcon() }}"></i>
        <span>{{ $item->getName() }}</span>
        @foreach($badges as $badge)
            {!! $badge !!}
        @endforeach
    </a>

    @foreach($appends as $append)
        {!! $append !!}
    @endforeach

    @if(count($items) > 0)
        <ul class="sub-menu" aria-expanded="false">
            @foreach($items as $item)
                {!! $item !!}
            @endforeach
        </ul>
    @endif
</li>
