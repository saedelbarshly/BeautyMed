<?php
    $countUnreadMessage = App\ContactMessages::where('user_type','user')->where('status','0')->count();
    $UnreadMessage = App\ContactMessages::where('user_type','user')->where('status','0')->take(15)->get();
    if ($countUnreadMessage > 99) {
        $countUnreadMessage = '+99';
    }
?>
<li class="nav-item dropdown dropdown-notification me-25">
    <a class="nav-link" href="#" data-bs-toggle="dropdown">
        <i class="ficon" data-feather="mail"></i>
        @if($countUnreadMessage != 0)
            <span class="badge rounded-pill bg-success badge-up">{{$countUnreadMessage}}</span>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
        <li class="dropdown-menu-header">
            <div class="dropdown-header d-flex">
                <h4 class="notification-title mb-0 me-auto">{{trans('common.contactMessages')}}</h4>
                @if($countUnreadMessage != 0)
                    <div class="badge rounded-pill badge-light-primary">{{$countUnreadMessage}} {{trans('common.unread')}}</div>
                @endif
            </div>
        </li>
        <li class="scrollable-container media-list">
            @forelse($UnreadMessage as $UnreadMessag)
                <a class="d-flex" href="{{route('admin.contactmessages.details',['id'=>$UnreadMessag->id])}}">
                    <div class="list-item d-flex align-items-start">
                        <div class="list-item-body flex-grow-1">
                            <p class="media-heading">
                                <span class="fw-bolder">{{trans('common.YouGotMessageFrom')}}</span>
                                {{$UnreadMessag->name}}
                            </p>
                            <small class="notification-text">{{$UnreadMessag->supject}}</small><br>
                            <small class="notification-text">{{$UnreadMessag->fromTime()}}</small>
                        </div>
                    </div>
                </a>
            @empty

            @endforelse
        </li>
        <li class="dropdown-menu-footer"><a class="btn btn-primary w-100" href="#">Read all notifications</a></li>
    </ul>
</li>
