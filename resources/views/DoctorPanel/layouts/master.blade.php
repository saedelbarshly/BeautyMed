<!DOCTYPE html>
<html class="loading semi-dark-layout" lang="en" data-layout="semi-dark-layout" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content=".">
    <meta name="keywords" content=".">
    <meta name="author" content="TechnoMasr Co.">
    <title>{{isset($title) ? $title : 'Biondi'}}</title>
    <link rel="apple-touch-icon" href="{{asset('AdminAssets/app-assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('AdminAssets/app-assets/images/ico/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
    
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/vendors/css/vendors-rtl.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/vendors/css/extensions/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/'.getCssFolder().'/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/'.getCssFolder().'/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/'.getCssFolder().'/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/'.getCssFolder().'/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/'.getCssFolder().'/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/'.getCssFolder().'/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/'.getCssFolder().'/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/'.getCssFolder().'/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/'.getCssFolder().'/plugins/extensions/ext-component-toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/'.getCssFolder().'/pages/app-invoice-list.css')}}">
    <!-- END: Page CSS-->
    <script src="{{asset('AdminAssets/app-assets/vendors/js/jquery/jquery.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('AdminAssets/app-assets/'.getCssFolder().'/plugins/bootstrap-select-1.14.0-beta/dist/css/bootstrap-select.css')}}">
    <!-- default icons used in the plugin are from Bootstrap 5.x icon library (which can be enabled by loading CSS below) -->
    <link rel="stylesheet" href="{{asset('AdminAssets/bootstrap-icons-1.10.5/font/bootstrap-icons.css')}}">
    <!-- fileinput Css -->
    <link href="{{ asset('/AdminAssets/app-assets/js/scripts/bootstrap_fileinput/css/fileinput.min.css')}}"
            media="all" rel="stylesheet" type="text/css"/>
            <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/'.getCssFolder().'/plugins/forms/form-validation.css')}}">
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/app-assets/'.getCssFolder().'/custom-rtl.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('AdminAssets/assets/css/style-rtl.css')}}">
    <!-- END: Custom CSS-->
    @yield('new_style')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item">
                        <a class="nav-link menu-toggle" href="#">
                            <i class="ficon" data-feather="menu"></i>
                        </a>
                    </li>
                </ul> 
                <ul class="nav navbar-nav bookmark-icons">
                    <li class="nav-item d-none d-lg-block">
                        <a class="nav-link" target="_blank" href="https://ilawfair.com" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{trans('common.websiteHome')}}">
                            <i class="ficon" data-feather="home"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <ul class="nav navbar-nav align-items-center ms-auto">
                <?php /*@include('AdminPanel.layouts.topbar.lang')*/ ?>
                <li class="nav-item d-none d-lg-block">
                    <a class="nav-link nav-link-style">
                        <i class="ficon" data-feather="moon"></i>
                    </a>
                </li>
                <?php /*@include('AdminPanel.layouts.topbar.contactMessages') */ ?>
                @include('DoctorPanel.layouts.topbar.notifications')
                @include('DoctorPanel.layouts.topbar.profile')
            </ul>
        </div> 
    </nav>
    <!-- END: Header-->

    @include('DoctorPanel.layouts.DoctorMenu')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-8 col-12 mb-2">
                    @include('DoctorPanel.layouts.common.breadcrumbs')
                </div>
                <div class="content-header-right text-md-end col-md-4 col-12 d-md-block d-none">
                    <div class="mb-1 breadcrumb-right">
                        @yield('page_buttons')
                    </div>
                </div>
            </div>
            <div class="content-body">
                @yield('content') 
            </div>
        </div>
    </div>
    <!-- END: Content-->
    

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        !--<p class="clearfix mb-0">
            <span class="float-md-start d-block d-md-inline-block mt-25">
                {{trans('common.madeBy')}}
                <a class="ms-25" href="https://technomasr.com" target="_blank">
                    {{trans('common.TechnoMasrCo.')}}
                </a>
                <!-- <span class="d-none d-sm-inline-block">, All rights Reserved</span> -->
            </span>
            <!-- <span class="float-md-end d-none d-md-block">
                Hand-crafted & Made with<i data-feather="heart"></i>
            </span> -->
        </p-->
    </footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('AdminAssets/app-assets/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('AdminAssets/app-assets/vendors/js/extensions/toastr.min.js')}}"></script>
    <script src="{{asset('AdminAssets/app-assets/vendors/js/extensions/moment.min.js')}}"></script>
    
    <script src="{{asset('AdminAssets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('AdminAssets/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('AdminAssets/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('AdminAssets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('AdminAssets/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js')}}"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Page JS-->
    <script src="{{asset('AdminAssets/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <!-- END: Page JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('AdminAssets/app-assets/js/core/app-menu.js')}}"></script>
    <script src="{{asset('AdminAssets/app-assets/js/core/app.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- purify.min.js is only needed if you wish to purify HTML content in your preview for HTML files.
     This must be loaded before fileinput.min.js -->
    <script src="{{ asset('/AdminAssets/app-assets/js/scripts/bootstrap_fileinput/js/plugins/purify.min.js')}}"
            type="text/javascript"></script>
    <!-- the main fileinput plugin file -->
    <script src="{{ asset('/AdminAssets/app-assets/js/scripts/bootstrap_fileinput/js/fileinput.js')}}"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="{{asset('AdminAssets/app-assets/'.getCssFolder().'/plugins/bootstrap-select-1.14.0-beta/dist/js/bootstrap-select.js')}}"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="{{asset('AdminAssets/app-assets/'.getCssFolder().'/plugins/bootstrap-select-1.14.0-beta/dist/js/i18n/defaults-ar_AR.js')}}"></script>

    @yield('scripts')
    @include('DoctorPanel.layouts.common.deleteConfirm')
    @include('DoctorPanel.layouts.common.tinymce')

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
            $('.selectpicker').selectpicker();
        })
    </script>
    <script>
        $(document).ready(function() {
            $(".files").fileinput({
                showUpload: false,
                dropZoneEnabled: false,
                maxFileCount: 10,
                inputGroupClass: "input-group-lg"
            });
        });
    </script>

    @if(Session::get('success'))
        <script>
            $(window).on('load', function () {
                setTimeout(function () {
                    toastr['success'](
                    '{{Session::get("success")}}',
                    '👋 {{trans("common.successMessageTitle")}}',
                    {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: '{{trans("common.dir")}}'
                    }
                    );
                }, 100);
            })
        </script>
    @endif

    @if(Session::get('faild'))
        <script>
            $(window).on('load', function () {
                setTimeout(function () {
                    toastr['error'](
                    '{{Session::get("faild")}}',
                    '👋 {{trans("common.faildMessageTitle")}}',
                    {
                        closeButton: true,
                        tapToDismiss: false,
                        rtl: '{{trans("common.dir")}}'
                    }
                    );
                }, 100);
            })
        </script>
        {{Session::forget('faild')}}
    @endif
</body>
<!-- END: Body-->

</html>