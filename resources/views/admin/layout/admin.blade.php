<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.ico') }}" />


    <title>پنل ادمین</title>


    <!-- Global stylesheets -->
    <link href="{{ url('global_assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" />
    <link href="{{ url('css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ url('css/bootstrap_limitless.css') }}" rel="stylesheet" />
    <link href="{{ url('css/layout.css') }}" rel="stylesheet" />
    <link href="{{ url('css/components.css') }}" rel="stylesheet" />
    <link href="{{ url('css/colors.css') }}" rel="stylesheet" />
    <link href="{{ url('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ url('css/adminStyles.css') }}" rel="stylesheet" />
    <!-- /global stylesheets -->
    @yield('style')
    <style>
        a {
            color: #fff;
        }

        .card a {
            color: #333;
        }

        .content {
            position: relative;
        }

        body {
            font-size: 0.85rem;
        }

        a>img {
            outline: none;
        }
    </style>
</head>

<body>
    <!-- Main navbar -->
    <div class="navbar navbar-expand-md bg-indigo navbar-static">

        @include('admin.layout.navbar')

    </div>
    <!-- /main navbar -->

    <!-- Page content -->
    <div id="app" class="page-content">

        @include('admin.layout.sidebar')

        <!-- Main content -->
        <div class="content-wrapper">

            @include('admin.layout.header')

            <!-- Content area -->
            <div class="content" id="ivi3">
                @if (session('success'))
                <div class="alert bg-teal-400 alert-rounded mt-10">
                    {{ session('success') }}
                </div> @endif
                @if (session('error'))
                <div class="alert bg-danger-400 alert-rounded mt-10">
                    {{ session('error') }}
                </div> @endif
                @yield('content')

            </div>
            <!-- /content area -->

            @include('admin.layout.footer')
        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->
    <script src="{{ url('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ url('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
    <script src="{{ url('global_assets/js/plugins/ui/ripple.min.js') }}"></script>
    <script src="{{ url('global_assets/js/app.js') }}"></script>

    <!-- /core JS files -->

    <!-- Theme JS files -->
    @yield('scripts')
    <!-- /theme JS files -->
    <script>
        $('.nav-item a').each(function(i, obj) {
            if (obj.href === window.location.href) {
                $(obj).addClass("active");
                $(obj).parents('.nav.nav-group-sub').addClass("d--block");
            }
        });
    </script>
    <script>
        $(document).ready(function() {

            // $('.toggle_notify_btn').click(function() {
            //     $(".notify_main_div").fadeToggle(250);
            // });

            function showNotifications() {

                console.log('Go');

              //  var audio = new Audio("{{ url('img/zapsplat_multimedia_game_sound_tone_wooden_mallet_nudge_remind_warn_004_38426.mp3')}}");
                $.ajax({
                    url: '<?= url('admin/checkHasNotifications')  ?>',
                    type: "POST",
                    data: {
                        yes: 'are',
                        '_token': "{{csrf_token()}}"
                    },
                    success: function(result) {
                        if (result > 0) {
                            $("#notify_count").text(result);
                         //   audio.play();
                        } else {
                            $("#notify_count").text(0);
                        }
                    }
                });



            }


            showNotifications();


            setInterval(function(){
                showNotifications();
            },7000);


        });
    </script>
</body>

</html>