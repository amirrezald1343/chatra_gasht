@extends('site.layout.site')
@section('meta')
    <title> کلیک سفر - تماس با ما </title>

@endsection
@section('head')
    <link href="{{ url("css/site/pages/index.css") }}" rel="stylesheet">
    <link href="{{ url("css/site/scss/navbarmodal.css") }}" rel="stylesheet">
    <script src="{{ url("js/site/navbarmodal.js") }}" ></script>


@endsection
@section('content')


    <main id="index">


        <div class="main-block">
            <div id="content">
                <div class="content mt-10 mb-10 container">
                    <div class="row">
                        <div class="col-md-12 text-right ">
                            <h4 class="mb-20 col-12"
                                style="color:white; border-bottom:2px solid #efefef; padding: 15px 25px; background-color: gray ">
                                تماس با
                                ما </h4>


                            {{--                            <div class="container">

                                                            <div class="row">

                                                                <div class="col-lg-6 col-md-6 col-sm12">
                                                                    <ul style="font-size: 1.2em">
                                                                        <li> <i style="width: 20px" class="fa fa-phone"></i> <span> 0531-5548458 </span> </li>
                                                                        <li> <i style="width: 20px" class="fa fa-mobile"></i> <span> 09125154485 </span> </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm12">
                                                                    <ul style="font-size: 1.2em">
                                                                        <li> <i style="width: 20px" class="fa fa-envelope"></i> <span> clicksafar@gmail.com </span> </li>
                                                                        <li> <i style="width: 20px" class="fa fa-fax"></i> <span> 0531552154 </span> </li>
                                                                    </ul>
                                                                </div>


                                                            </div>

                                                        </div>--}}

                            {{--{!! $contact['body'] !!}--}}

                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="col-lg-6 col-sm-12 pull-right">
                                        <div style="padding: 10px;">
                                            <ul style="background-color: #efefef; padding: 5px">
                                                <li> آدرس مشهد : بلوار امامت 37 , ساختمان افرا</li>
                                                <li>تلفن مشهد : 31600-051</li>
                                                <li> آدرس تهران : سعادت آباد , کوی فراز , مجتمع بو علی</li>
                                                <li>تلفن تهران : 22387527-021</li>
                                                <li>ایمیل : info@clicksafar.com</li>
                                            </ul>

                                            <div>

                                                @if(session()->has('success'))
                                                    <div class="alert alert-success alert-dismissible fade show"
                                                         role="alert">
                                                        تیکت پشتیبانی شما با موفقیت ثبت گردید
                                                        <button type="button" class="close" data-dismiss="alert"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                @endif

                                                @if($errors->any())
                                                    <div class="alert alert-danger alert-dismissible fade show"
                                                         role="alert">
                                                        <ul>
                                                            @foreach($errors->all() as $rowError)
                                                                <li>{{$rowError}}</li>
                                                            @endforeach
                                                        </ul>
                                                        <button type="button" class="close" data-dismiss="alert"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                @endif

                                                <form class="mt-20 form-block" method="post"
                                                      action="{{Route('sendTicket')}}">
                                                    {{ csrf_field() }}
                                                    <div class="form-row contact-form">
                                                        <div class="col-md-6">
                                                            <input type="name" class="form-control" name="name"
                                                                   placeholder="نام و نام خانوادگی">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="name" class="form-control" name="subject"
                                                                   placeholder="موضوع">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="email" class="form-control" name="email"
                                                                   placeholder="ایمیل">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="tell"
                                                                   placeholder="شماره تماس">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <textarea name="message" placeholder="متن پیام"></textarea>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="captcha"
                                                                   placeholder="کد امنیتی را وارد کنید ">
                                                        </div>

                                                        <div class="col-md-6">
                                                            {{ captcha_img('flat') }}
                                                        </div>

                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-1"> ارسال پیام</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-sm-12 pull-left" style="margin-top: 10px">

                                        <div id="gmap-polyline" style="width:100%;height:380px"></div>

                                    </div>

                                </div>

                            </div>


                        </div>


                        {{--            <div class="col-md-12" style="margin-top: 15px">

                                        <div class="contact-mr">
                                            <h5 class="mb-20 text-center">فرم تماس</h5>

                                            <form id="contact-form" class="mt-20 form-block" novalidate="novalidate">
                                                <div class="form-row contact-form">
                                                    <div class="col-md-6">
                                                        <input type="name" class="form-control" name="email" placeholder="نام">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="lastName" class="form-control" name="email"
                                                               placeholder="نام خانوادگی">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="ایمیل" class="form-control" name="email" placeholder="ایمیل">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="شماره تماس" class="form-control" name="tell"
                                                               placeholder="شماره تماس">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <textarea name="message" placeholder="متن پیام"></textarea>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-1"> ارسال پیام</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>

                                    </div>--}}
                    </div>
                </div>
            </div>
        </div>

    </main>


@endsection
@section('footer')
    <script
        src="https://maps.google.com/maps/api/js?sensor=false&libraries=geometry&v=3.22&key=AIzaSyBATf9eLRVC1xIUeAnhcu8Fgvy677MDlPY"></script>
    <script src="{{ url("js/site/maplace.js") }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            new Maplace({
                show_markers: true,
                locations: [{
                    lat: 36.337495,
                    lon: 59.5380000,
                }],
                map_options: {
                    zoom: 16
                },
                map_div: '#gmap-polyline',
            }).Load();

        })

    </script>


@endsection
