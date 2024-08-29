<li class="nav-item dropdown dropdown-notification me-25">
    <a class="nav-link" href="#" data-bs-toggle="dropdown">
        <i class="ficon" data-feather="bell"></i>
        <span class="badge rounded-pill bg-danger badge-up">
            {{Auth::user()->unreadnotifications->count() > 99 ? '+99' : Auth::user()->unreadnotifications->count()}}
        </span>
    </a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
        <li class="dropdown-menu-header">
            <div class="dropdown-header d-flex">
                <h4 class="notification-title mb-0 me-auto">{{trans('common.Notifications')}}</h4>
                @if(Auth::user()->unreadnotifications->count() > 0)
                    <div class="badge rounded-pill badge-light-primary">{{Auth::user()->unreadnotifications->count()}} {{trans('common.New')}}</div>
                @endif
            </div>
        </li>
        <li class="scrollable-container media-list">
            <?php
                $MyNotifications = auth()->user()->unreadnotifications->take(20);
            ?>
            @if(count($MyNotifications) > 0)
                @foreach($MyNotifications as $notification)
                    <a class="d-flex" href="{{route('admin.notification.details',['id'=>$notification->id])}}">
                        <div class="list-item d-flex align-items-start">
                            <div class="me-1">
                                <div class="avatar">
                                    <img src="{{notificationImageLink('newPublisher',$notification['data']['linked_id'])}}" alt="avatar" width="32" height="32">
                                </div>
                            </div>
                            <div class="list-item-body flex-grow-1">
                                <p class="media-heading">
                                    {!!$notification['data']['text']!!}
                                </p>
                                <small class="notification-text">{!!$notification['data']['date']!!}</small>
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <div class="p-1 text-center">
                    <b>{{trans('common.nothingToView')}}</b>
                </div>
            @endif
        </li>
        <li class="dropdown-menu-footer">
            <a class="btn btn-primary w-100" href="{{route('admin.notifications.readAll')}}">{{trans('common.Read all notifications')}}</a>
        </li>
    </ul>
</li>
