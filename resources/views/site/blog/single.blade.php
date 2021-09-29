@extends('site.layout.site')
@section('meta')
<title> کلیک سفر - {{$post->title}} </title>

<meta name="keywords" content="{{$post->tags}}">
<meta name="description" content="{{$post->title}}">

<style type="text/css">
    .postContainer img {

        display: inline-block !important;
        max-width: 100%;

    }

    .single-div *{
        font-family: IRANSans !important;
    }

</style>

@endsection
@section('head')
<link href="{{ url("css/site/pages/index.css") }}" rel="stylesheet">
<link href="{{ url("css/site/scss/navbarmodal.css") }}" rel="stylesheet">
<script src="{{ url("js/site/navbarmodal.js") }}" ></script>
@endsection
@section('content')



<main id="index">


    <div class="main-block">
        <div id="aboutUs">
            <div class="content mt-10 mb-40 container">
                <div class="container">
                    <h4 class="mb-20 col-12" style="color:white; border-bottom:2px solid #efefef; padding: 15px 25px; background-color: gray ">
                        {{$post->title}}
                        <span class='pull-left' style="font-size:15px;padding-top:8px"> {{ \Morilog\Jalali\CalendarUtils::strftime('d / F / Y ', strtotime($post->created_at))  }} <i class="fa fa-calendar"></i> </span>
                    </h4>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="content-box mb-20">
                                <div class="row">
                                    <div class="col-md-12 postContainer">
                                        <div class="single-div">
                                        {!! $post->body !!}
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <span style="border-right:1px solid green;padding-right:3px"> تورهای مرتبط  :  </span>
                            <ul>
                                @foreach($post->packages as $rowPackage)
                                <i style="padding: 5px;"><a href="{{ url('Tour/'.$rowPackage->id).'/'.$rowPackage->title }}">{{$rowPackage->title}}</a></i>
                                @endforeach
                            </ul>
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
