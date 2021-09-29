@extends('site.layout.site')
@section('meta')
    <title> کلیک سفر -  عضویت آزانس (همکاری با ما) </title>

@endsection
@section('head')
    <link href="{{ url("css/site/pages/index.css") }}" rel="stylesheet">
    <link href="{{ url("css/site/scss/navbarmodal.css") }}" rel="stylesheet">
    <script src="{{ url("js/site/navbarmodal.js") }}" ></script>


@endsection
@section('content')


    <main id="index">

        <div class="main-block maindiv" >
            <div id="content">
                <div class="content mt-60 mb-40 container">
                    <div class="row">
                        <h4 class="mb-20 col-12 pathnerus" >  همکاری با ما
                        </h4>

                        <div class="col-md-12  registerdiv " >

                            <div class="contact-mr">
                                <h5 class="mb-20 text-center">فرم عضویت آژانس</h5>

                                @if(session()->has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>تبریک !</strong> آژانس شما با موفقیت در سیستم ثبت شد و پس از تایید از سوی همکاران ما  ورود به سیستم برای شما امکان پذیر می باشد
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @endif

                                <form class="mt-20 form-block" method="post" action="registerAgencyPost">
                                    {{ csrf_field() }}
                                    <div class="form-row contact-form">

                                        <div class="col-md-6 divform">
                                            <label for="name" >نام و نام خانوادگی : </label>
                                            <span > {!! getError($errors,'name') !!}</span>
                                            <input id="name" value="{{old('name')}}" type="text" class="form-control" name="name" place>
                                        </div>

                                        <div class="col-md-6 divform">
                                            <label for="company" >نام آژانس : </label>
                                            <span> {!! getError($errors,'company') !!}</span>
                                            <input id="company" value="{{old('company')}}" type="text" class="form-control" name="company">
                                        </div>

                                        <div class="col-md-6 divform">
                                            <label for="nationalNumber"  >شماره ملی : </label>
                                            <span> {!! getError($errors,'nationalNumber') !!}</span>
                                            <input id="nationalNumber" value="{{old('nationalNumber')}}" type="text" class="form-control"
                                                   name="nationalNumber">
                                        </div>

                                        <div class="col-md-6 divform">
                                            <label for="tellPhone"  >شماره تلفن : </label>
                                            <span> {!! getError($errors,'tellPhone') !!}</span>
                                            <input id="tellPhone" value="{{old('tellPhone')}}" type="text" class="form-control" name="tellPhone">
                                        </div>

                                        <div class="col-md-6 divform">
                                            <label for="cellPhone"  >تلفن همراه : </label>
                                            <span> {!! getError($errors,'cellPhone') !!}</span>
                                            <input id="cellPhone" value="{{old('cellPhone')}}" type="text" class="form-control" name="cellPhone">
                                        </div>

                                        <div class="col-md-6 divform">
                                            <label for="agencyLicense"  >شماره مجوز : </label>
                                            <span> {!! getError($errors,'agencyLicense') !!}</span>
                                            <input id="agencyLicense" value="{{old('agencyLicense')}}" type="text" class="form-control"
                                                   name="agencyLicense">
                                        </div>
                                        <div class="col-md-6 divform">
                                            <label for="email"  >آدرس ایمیل : </label>
                                            <span  > {!! getError($errors,'email') !!}</span>
                                            <input id="email" value="{{old('email')}}" type="text" class="form-control"
                                                   name="email">
                                        </div>
                                        <div class="col-md-6 divform">
                                            <label for="domain"  >آدرس دامنه سایت : </label>
                                            <span  > {!! getError($errors,'domain') !!}</span>
                                            <input id="domain" value="{{old('domain')}}" type="text" class="form-control" name="domain">
                                        </div>
                                        <div class="col-md-12">
                                            <label for="address"  >آدرس آژانس : </label>
                                            <span  > {!! getError($errors,'address') !!}</span>
                                            <input id="address" value="{{old('address')}}" type="text" class="form-control"
                                                   name="address">
                                        </div>

                                        <div class="col-md-6" >
                                            <input type="text" class="form-control" name="captcha"
                                                   placeholder="کد امنیتی را وارد کنید ">
                                            <span  > {!! getError($errors,'captcha') !!}</span>
                                        </div>

                                        <div class="col-md-6 captcha-div">
                                                {{ captcha_img('flat') }}
                                        </div>


                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-1"> عضویت </button>
                                        </div>

                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
@section('footer')

@endsection
