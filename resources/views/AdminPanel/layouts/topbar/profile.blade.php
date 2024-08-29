
<li class="nav-item dropdown dropdown-user">
    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div class="user-nav d-sm-flex d-none">
            <span class="user-name fw-bolder">
                {{auth()->user()->name}}
            </span>
            <span class="user-status">
                {{auth()->user()->hisRole['name_'.Session::get('Lang')]}}
            </span>
        </div>
        <span class="avatar">
            <img class="round" src="{{auth()->user()->photoLink()}}" alt="avatar" height="40" width="40">
            <span class="avatar-status-online"></span>
        </span>
    </a>
    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
        <a class="dropdown-item" href="{{ route('admin.myProfile') }}">
            <i class="me-50" data-feather="user"></i> {{trans('common.Profile')}}
        </a>
        @if(env('APP_HR') == 1)
            <a class="dropdown-item" href="{{ route('admin.mySalary') }}">
                <i class="me-50" data-feather="check-square"></i> {{trans('common.mySalary')}}
            </a>
        @endif
        <!-- <a class="dropdown-item" href="app-email.html">
            <i class="me-50" data-feather="mail"></i> Inbox
        </a>
        <a class="dropdown-item" href="app-chat.html">
            <i class="me-50" data-feather="message-square"></i> Chats
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="page-account-settings-account.html">
            <i class="me-50" data-feather="settings"></i> Settings
        </a>
        <a class="dropdown-item" href="page-pricing.html">
            <i class="me-50" data-feather="credit-card"></i> Pricing
        </a>
        <a class="dropdown-item" href="page-faq.html">
            <i class="me-50" data-feather="help-circle"></i> FAQ
        </a> -->

        <a class="dropdown-item"
            href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="me-50" data-feather="power"></i> {{trans('common.Logout')}}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>


    </div>
</li>