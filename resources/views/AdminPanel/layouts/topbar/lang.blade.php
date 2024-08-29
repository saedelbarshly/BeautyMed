<li class="nav-item dropdown dropdown-language">
    <a class="nav-link dropdown-toggle" id="dropdown-flag" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="flag-icon flag-icon-{{panelLangMenu()['selected']['flag']}}"></i>
        <span class="selected-language">{{panelLangMenu()['selected']['text']}}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag">
        @foreach(panelLangMenu()['list'] as $singleLang)
            <a class="dropdown-item" href="{{url('/SwitchLang/'.$singleLang['lang'])}}" data-language="{{$singleLang['lang']}}">
                <i class="flag-icon flag-icon-{{$singleLang['flag']}}"></i> {{$singleLang['text']}}
            </a>
        @endforeach
    </div>
</li>
