@extends('site.layout.site')
@section('meta')
    <title>  کلیک سفر -  قوانین کلیک سفر   </title>

@endsection
@section('head')
    <link href="{{ url("css/site/pages/index.css") }}" rel="stylesheet">
    <link href="{{ url("css/site/scss/navbarmodal.css") }}" rel="stylesheet">
    <script src="{{ url("js/site/navbarmodal.js") }}" ></script>


@endsection
@section('content')


    <main id="index">


        <div class="main-block">

            <div id="rules">
                <div class="content mt-10 mb-40 container">
                    <div class="container">
                        <h4 class="mb-20 col-12 lowh" > قوانین
                        </h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="content-box mb-20">
                                    <div class="row">
                                        <div class="col-md-12">

                                        {!!  $rules['body'] !!}

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
