@extends('site.layout.site')
@section('meta')
    <title> کلیک سفر -  درباره ما </title>

@endsection
@section('head')
    <link href="{{ url("css/site/pages/index.css") }}" rel="stylesheet">
    <link href="{{ url("css/site/scss/navbarmodal.css") }}" rel="stylesheet">
    <script src="{{ url("js/site/navbarmodal.js") }}" ></script>

@endsection
@section('content')
     @php
      //dd(bcrypt('201000'));
     @endphp

    <main id="index" style=" font-family: IRANSans !important; ">


        <div class="main-block">
            <div id="aboutUs">
                <div class="content mt-10 mb-40 container">
                    <div class="container">
                        <h4 class="mb-20 col-12"
                            style="color:white; border-bottom:2px solid #efefef; padding: 15px 25px; background-color: gray ">
                            درباره ما
                        </h4>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="content-box mb-20">
                                    <div class="row">
                                        <div class="col-md-12">

                                            {!! $about['body'] !!}


                                        </div>
                                    </div>
                                </div>
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
