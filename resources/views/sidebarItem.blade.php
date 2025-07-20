<li class="nav-item @if (($item_url === url('dashboard') && url()->current() === $item_url) || ($item_url !== url('dashboard') && (url()->current() === $item_url || Str::startsWith(url()->current(), $item_url . '/')))) active @endif">
    <a class="nav-link" href="{{ $item_url }}" @if (isset($item_click)) onclick="{{ $item_click }}" @endif>
        <i class="fas fa-fw {{ $item_icon }}"></i>
        <span>{{ $item_title }}</span>
        <span id="{{ str_replace("/dashboard/", "", $item_url) }}_counter" class="odometer bg-danger @if(!isset($item_notification_count) || empty($item_notification_count)) d-none @endif badge ms-2" style="padding-left: .5em;">
            @if(isset($item_notification_count)) {{ $item_notification_count }} @else 0 @endif
        </span>
        <span id="{{ str_replace("/dashboard/", "", $item_url) }}_total" class="odometer opacity-50 @if(!isset($item_total_count)) d-none @endif ms-2" style="padding-left: .5em; font-size: 80%;">{{ isset($item_total_count) ? $item_total_count : 0 }}</span>
    </a>
    @if(isset($item_create_url) && !empty($item_create_url))
    <a href="{{ $item_create_url }}" style="position: absolute; right: 30px; transform: translateY(-38px);" class="bg-success badge py-2 px-2">
        <i class="fas fa-plus me-0"></i>
    </a>
    @endif
</li>