<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.ico') }}" />

    <title>{{ __('admin.Admin panel') }}</title>

    <!-- Global stylesheets -->
    <link href="{{ url('global_assets/css/icons/icomoon/styles.css') }}" rel="stylesheet" />
    <link href="{{ url('css/bootstrap.css') }}" rel="stylesheet" />
    <link href="{{ url('css/bootstrap_limitless.css') }}" rel="stylesheet" />
    <link href="{{ url('css/layout.css') }}" rel="stylesheet" />
    <link href="{{ url('css/components.css') }}" rel="stylesheet" />
    <link href="{{ url('css/colors.css') }}" rel="stylesheet" />
    <link href="{{ url('css/styles.css') }}" rel="stylesheet" />
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ url('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ url('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
    <script src="{{ url('global_assets/js/plugins/ui/ripple.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ url('global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>

    <script src="{{ url('js/admin/app.js') }}"></script>
    <script src="{{ url('global_assets/js/demo_pages/login.js') }}"></script>
    <!-- /theme JS files -->

    <style>
        .vpd-input-group input {
            border-left: none !important;
        }

        .invalid-feedback {
            display: block !important;
        }

        #passwordShows {
            position: absolute;
            float: left;
            left: 5px;
            margin-top: 12px;
            cursor: pointer
        }
    </style>

</head>

<body>
    <div id="app" class="page-content login-cover">
        <div class="content-wrapper">
            <div class="content d-flex justify-content-center align-items-center">
                <div class="card mb-0">
                    <div class="tab-content card-body">
                        <div class="tab-pane fade show active" id="login-tab1">
                            <div class="text-center mb-3">
                                <h5 class="mb-0">ورود به پنل مدیریت</h5>
                            </div>
                            <form class="login-form wmin-sm-400" action="{{ url('/login')}}" method="post">
                                @csrf
                                <div class="form-group form-group-feedback form-group-feedback-left">
                                    <input type="text" class="form-control" name="username" placeholder="نام کاربری" value="{{ old('username') }}" />
                                    <div class="form-control-feedback">
                                        <i class="icon-user text-muted"></i>
                                    </div>
                                    @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group form-group-feedback form-group-feedback-left">
                                    <input type="password" class="form-control" name="password" id="passwordInp" placeholder="رمز ورود" value="{{ old('password') }}" />
                                    <span id='passwordShows' class='icon-eye text-muted'></span>
                                    <div class="form-control-feedback">
                                        <i class="icon-lock2 text-muted"></i>
                                    </div>
                                    @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group d-flex align-items-center">
                                    <div class="form-check mb-0"><input type="checkbox" name="remember" class="form-input-styled" {{ old('remember') ? 'checked' : '' }} data-fouc=""><span>من را به خاطر بسپار</span></div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">ورود</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>

            </div>
            <div class="text-center text-white mb-3">
                <span>کلیه حقوق طرح متعلق به شرکت فناوری اطلاعات مهاب (MIT) می باشد.</span>
            </div>
        </div>

    </div>


    <script>
        // $(document).ready(function(e) {
        //     $("#passwordShows").mousedown(function(e) {
        //         $("#passwordInp").prop('type', 'text');
        //     });
        //     $("#passwordShows").mouseup(function(e) {
        //         $("#passwordInp").prop('type', 'password');
        //     });
        // });
    </script>

</body>

</html>