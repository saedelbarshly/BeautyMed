<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row justify-content-center">
            <img src="{{asset('/AdminAssets/app-assets/images/logo/logo.png')}}" width="160" height="65"/>
            <!-- <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i>
                </a>
            </li> -->
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="@if(isset($active) && $active == 'panelHome') active @endif nav-item" >
                <a class="d-flex align-items-center" href="{{route('admin.index')}}">
                    <i data-feather="home"></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.PanelHome')}}">
                        {{trans('common.PanelHome')}}
                    </span>
                </a>
            </li>
            <li class="nav-item @if(isset($active) && $active == 'setting') active @endif">
                <a class="d-flex align-items-center" href="{{route('admin.settings.general')}}">
                    <i data-feather='settings'></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.setting')}}">
                        {{trans('common.setting')}}
                    </span> 
                </a>
            </li>
            @if(env('APP_BRANCH') == 1)
            <li class="nav-item @if(isset($active) && $active == 'branches') active @endif">
                <a class="d-flex align-items-center" href="{{route('admin.branches.index')}}">
                    <i data-feather='git-branch'></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.branches')}}">
                        {{trans('common.branches')}}
                    </span>
                </a>
            </li>
            @endif
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="shield"></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.UsersManagment')}}">
                        {{trans('common.UsersManagment')}}
                    </span>
                </a>
                <ul class="menu-content">
                    <li @if(isset($active) && $active == 'adminUsers') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.adminUsers')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.AdminUsers')}}">
                                {{trans('common.users')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'doctors') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.doctors')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.doctors')}}">
                                {{trans('common.doctors')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'roles') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.roles')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.Roles')}}">
                                {{trans('common.Roles')}}
                            </span>
                        </a>
                    </li> 
                </ul>
            </li>
            
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='file-text'></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.HrDep')}}">
                        {{trans('common.HrDep')}}
                    </span>
                </a>
                <ul class="menu-content">
                    <li @if(isset($active) && $active == 'managements') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.managements')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.managements')}}">
                                {{trans('common.managements')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'jobs') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.jobs')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.jobs')}}">
                                {{trans('common.jobs')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'employees') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.employees')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.employees')}}">
                                {{trans('common.employees')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'salaries') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.salaries')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.salaries')}}">
                                {{trans('common.salaries')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'attendance') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.attendance')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.attendance')}}">
                                {{trans('common.attendance')}}
                            </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='archive'></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.accounts')}}">
                        {{trans('common.accounts')}}
                    </span>
                </a>
                <ul class="menu-content">
                    <li @if(isset($active) && $active == 'safes') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.safes')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.safes')}}">
                                {{trans('common.safes')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'expenses') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.expenses')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.expenses')}}">
                                {{trans('common.expenses')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'revenues') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.revenues')}}">
                            <i data-feather="circle"></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.revenues')}}">
                                {{trans('common.revenues')}}
                            </span>
                        </a>
                    </li>
                </ul>
            </li>


                <li class=" nav-item ">
                    <a class="d-flex align-items-center" href="#">
                        <i data-feather='airplay'></i>
                        <span class="menu-title text-truncate" data-i18n="{{trans('common.services')}}">
                            {{trans('common.services')}}
                        </span> 
                    </a>
                    <ul class="menu-content">
                        <li @if(isset($active) && $active == 'leaserMachines') class="active" @endif>
                            <a class="d-flex align-items-center" href="{{route('admin.machines')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="{{trans('common.leaserMachines')}}">
                                    {{trans('common.leaserMachines')}}
                                </span>
                            </a>
                        </li>
                        <li @if(isset($active) && $active == 'areas') class="active" @endif>
                            <a class="d-flex align-items-center" href="{{route('admin.areas')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="{{trans('common.areas')}}">
                                    {{trans('common.areas')}}
                                </span> 
                            </a>
                        </li>
                        <li @if(isset($active) && $active == 'services') class="active" @endif>
                            <a class="d-flex align-items-center" href="{{route('admin.services')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="{{trans('common.services')}}">
                                    {{trans('common.services')}}
                                </span>
                            </a>
                        </li>
                        <li @if(isset($active) && $active == 'offers') class="active" @endif>
                            <a class="d-flex align-items-center" href="{{route('admin.offers')}}">
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate" data-i18n="{{trans('common.offers')}}">
                                    {{trans('common.offers')}}
                                </span>
                            </a>
                        </li>
                      
                    </ul>
                </li>

     
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='users'></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.clients')}}">
                        {{trans('common.clients&FollowUps')}}
                    </span>
                </a>
                <ul class="menu-content">
                    <li @if(isset($active) && $active == 'clients') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.clients')}}">
                            <i data-feather='circle'></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.clients')}}">
                                {{trans('common.clients')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'reservations') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.reservations')}}">
                            <i data-feather='circle'></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.reservations')}}">
                                {{trans('common.reservations')}}
                            </span>
                        </a> 
                    </li>
                   
                    <li @if(isset($active) && $active == 'complaints') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.complaints')}}">
                            <i data-feather='circle'></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.followups')}}">
                                {{trans('common.followups')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'refferalClients') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.refferalClients')}}">
                            <i data-feather='circle'></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.refferalClients')}}">
                                {{trans('common.refferalClients')}}
                            </span>
                        </a>
                    </li>
                  
                </ul>
            </li>
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather='layers'></i>
                    <span class="menu-title text-truncate" data-i18n="{{trans('common.reports')}}">
                        {{trans('common.reports')}}
                    </span>
                </a>
                <ul class="menu-content">
                    <?php /*
                    <li @if(isset($active) && $active == 'userFollowUpsReport') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.userFollowUpsReport')}}">
                            <i data-feather='circle'></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.userFollowUpsReport')}}">
                                {{trans('common.userFollowUpsReport')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'teamFollowUpsReport') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.teamFollowUpsReport')}}">
                            <i data-feather='circle'></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.teamFollowUpsReport')}}">
                                {{trans('common.teamFollowUpsReport')}}
                            </span>
                        </a>
                    </li>
                    <li @if(isset($active) && $active == 'branchFollowUpsReport') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.branchFollowUpsReport')}}">
                            <i data-feather='circle'></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.branchFollowUpsReport')}}">
                                {{trans('common.branchFollowUpsReport')}}
                            </span>
                        </a>
                    </li>
                    */ ?>
                    <li @if(isset($active) && $active == 'accountsReport') class="active" @endif>
                        <a class="d-flex align-items-center" href="{{route('admin.accountsReport')}}">
                            <i data-feather='circle'></i>
                            <span class="menu-item text-truncate" data-i18n="{{trans('common.accountsReport')}}">
                                {{trans('common.accountsReport')}}
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
