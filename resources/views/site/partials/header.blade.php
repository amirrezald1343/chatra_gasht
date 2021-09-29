<header class="headers">

    @section('head')

    @endsection

    <div class="main-header">
        <div class="header-width container-fluid header-cont-items">
            <span class="comparePopBox" <?php if (session()->has('tourCompare') and count(Session::get('tourCompare')) > 0) { ?> style="display: block" <?php } ?>>
                <a href="/favTourList"> مقایسه کن </a>
            </span>

            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-4">
                        <div class="main-header-logo">
                            <a href="{{ url('/') }}"><img class="pull-left header-logo "
                             src="/icons/logo11.jpg" id="logoimg" alt="Site logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-8 col-8">
                        <div class="right-header">

                            <nav id="navigation" class="navigation mt-10">
                                <div class="nav-toggle"><i class='fa fa-bars fa-2x'></i></div>

                                <div class="nav-menus-wrapper">

                                    <ul class="nav-menu align-to-right header-ul">
                                        <li>
                                            <a class="active" href="{{ url('') }}">صفحه اصلی</a>
                                        </li>
                                        <li>
                                            <a href="#">پرواز</a>
                                            <?php
                                            $getInternalTours = App\City::select('id', 'title_fa')->where('types', 'city')
                                                ->where('title_fa', 'NOT LIKE', '%استان%')
                                                ->where('title_fa', 'NOT LIKE', '%جهان%')
                                            ->where('country_id','=','1185')
                                                ->whereIn('id', function ($query) {
                                                    $query->select('city_id')->from('city_package')->whereIn('package_id', function ($q) {
                                                        $q->select('id')->from('packages')->where('tourType', 'internal')
                                                            ->where('status', '1')
                                                            ->where('start_in', '>=', date(Carbon\Carbon::now()->format('Y-m-d')));
                                                    });
                                                })
                                                ->groupBy("cities.id")
                                                ->limit(10)
                                                ->get();
                                            ?>
                                            <ul class="nav-dropdown ulnavhead">
                                                @foreach($getInternalTours as $inTour)
                                                    <li>
                                                        <a href="{{ url("Tours/destination/$inTour->id") }}"> {{$inTour->title_fa}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">تور</a>
                                            <?php
                                            $getExternalTours = App\City::where('types', 'city')
                                                ->where('title_fa', 'NOT LIKE', '%استان%')
                                                ->where('title_fa', 'NOT LIKE', '%جهان%')
                                                ->where('country_id','!=','1185')
                                                ->whereIn('id', function ($query) {
                                                    $query->select('city_id')->from('city_package')->whereIn('package_id', function ($q) {
                                                        $q->select('id')->from('packages')->where('tourType', 'foreign')
                                                            ->where('status', '1')
                                                            ->where('start_in', '>=', date(Carbon\Carbon::now()->format('Y-m-d')));
                                                    });
                                                })
                                                ->groupBy("cities.id")
                                                ->limit(10)->get();
                                            ?>
                                            <ul class="nav-dropdown ulnavhead">
                                                @foreach($getExternalTours as $exTour)
                                                    <li>
                                                        <a href="{{ url("Tours/destination/$exTour->id") }}"> {{$exTour->title_fa}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>

                                    <!-- <li>
                                        <a class="" href="#">بوم گردی</a>
                                        <ul class="nav-dropdown" style="top:50px !important">
                                            <li><a href="{{ url('Tours/indoors/one') }}">یک روزه</a></li>
                                            <li><a href="{{ url('Tours/indoors/several') }}"> چند روزه</a></li>
                                        </ul>
                                    </li>
                                    -->



                                        {{-- <li>
                                            <a class="" href="{{ url('Tours/moment') }}">لحظه آخری</a>
                                        </li> --}}

                                        <li>
                                           <a class="" href="/gashts">هتل</a>
                                        </li>

                                        <li>
                                            @if(Auth::check())
                                                <a class="logincls" href="{{url("/admin")}}">
                                                <span>  پنل کاربری  </span>
                                                </a>
                                            @else
                                                <a  class="logincls"  data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap" >
                                                <span>ورود</span>
                                                </a>
                                            @endif
                                        </li>

                                    </ul>
                                </div>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            {{--<div class="modal-header">--}}

                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                    {{--<span aria-hidden="true">&times;</span>--}}
                {{--</button>--}}
            {{--</div>--}}


            <div class="modal-body">

                        <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                            <span aria-hidden="true">×</span>
                        </button>

                <div class="row">
                    <div class="col-lg-5">

                        <div class="row rowclick" >
                            <div class="col-lg-12" style="padding: 0;">
                                <h3>به کلیک سفر خوش آمدید</h3>
                                <p style="margin-bottom: 9px !important;">برای ورود به پنل مدیریتی آژانس کافیست اطلاعات کاربری خود را وارد کنید</p>
                            </div>
                        </div>
<div class="row">
    <div class="col-lg-12">
        <div class="formlog">
            <form class="login-form wmin-sm-400" action="{{ url('/login')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="recipient-name" class="col-form-label" style="color: #000000 !important;" >نام کاربری:</label>
                    <input type="text" class="form-control" name="username" id="recipient-name" style="height:40px!important" placeholder="نام کاربری" value="{{ old('username') }}" />
                    @if ($errors->has('username'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label" style="color: #000000 !important;">کلمه عبور:</label>
                    <input type="password" class="form-control" name="password" id="passwordInp" style="height:40px!important" placeholder="رمز ورود" value="{{ old('password') }}" />
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btnlogin">ورود به پنل کاربری</button>
                    <a href="" class="forgetpass">فراموشی رمز عبور</a>
                </div>
            </form>
        </div>
    </div>
</div>


                    </div>
                    <div class="col-lg-3">
                        <div class="regis">
                            <h4>هنوز ثبت نام نکردید؟</h4>
                            <p>کافیست فرم ثبت نام را تکمیل نموده تا در نزدیک ترین زمان ممکن با شما تماس بگیرند</p>
                            <a class="btn btn-dark btndark" href="{{url('/RegisterAgency')}}">تکمیل فرم ثبت نام</a>

                        </div>

                    </div>
                    <div class="col-lg-4 divimg">

                        <img src="{{ url('img/travel.png') }}" alt="" class="img-responsive imgtravel" >

                    <div class="caplog">
                        <h4>مزایا دارا بودن حساب کاربری در وبسایت
                        <strongs class="clicks"> کلیک سفر</strongs>
                        </h4>
                        <p><i class="fa fa-user"></i> معرفی تورهای شما به جامعه عظیمی از علاقه مندان به سفر و گردشگری </p>
                        <p><i class="fa fa-link"></i> ارتباط مستقیم مشتری با آژانس مربوطه برای رزرو تور </p>
                        <p><i class="fa fa-dollar"></i> بدون دریافت هزینه عضوین و کاملا رایگان </p>
                    </div>
                    </div>

                </div>



            </div>
            {{--<div class="modal-footer">--}}
            {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
            {{--<button type="button" class="btn btn-primary">Send message</button>--}}
            {{--</div>--}}
        </div>
    </div>
</div>
