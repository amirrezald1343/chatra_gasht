@extends('site.layout.site')
@section('meta')
<title> کلیک سفر - وبلاگ </title>

@endsection
@section('head')
<link href="{{ url("css/site/pages/index.css") }}" rel="stylesheet">
<link href="{{ url("css/site/scss/navbarmodal.css") }}" rel="stylesheet">
<script src="{{ url("js/site/navbarmodal.js") }}" ></script>
<style type='text/css'>
    .pagination li {
        display: inline-block;
    }
</style>

@endsection
@section('content')


<main id="index">


    <div class="main-block">
        <div id="aboutUs">
            <div class="content mt-10 mb-40 container">
                <div class="container">
                    <h4 class="mb-20 col-12" style="color:white; border-bottom:2px solid #efefef; padding: 15px 25px; background-color: gray ">
                        وبلاگ
                    </h4>


                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="content-box mb-20">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            @foreach($Posts as $post)

                                            <div class="col-xl-4 col-lg-4 col-md-6">
                                                <div class="row" style="padding:15px;">

                                                    <div style="padding:5px; box-shadow:0px 0px 3px 1px #d4d4d4">

                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                            <img class="img-thumbnail" style="height:100%; width:100%" src="/{{ $post->image_thumb }}">
                                                        </div>

                                                        <div class="col-xl-12">
                                                            <div class="row">
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                                    <p style="text-align:center">{{$post->title}}</p>
                                                                </div>
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12" style="text-align:center">
                                                                    <i class="fa fa-calendar"></i> <span style="font-size:15px;"> {{ \Morilog\Jalali\CalendarUtils::strftime('d / F / Y ', strtotime($post->created_at))  }} </span>
                                                                </div>
                                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12" style="float:left;text-align:center;">
                                                                    <br>
                                                                    <a href="{{str_replace(' ','-',url('/blog/'.$post->id.'/'.$post->title))}}" class="btn" style="padding:7px; background-color: rgb(251, 251, 251)">
                                                                        مشاهده <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            @endforeach
                                        </div>

                                        <!-- {!! $Posts->links() !!} -->
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

<script type="text/javascript">
    $(document).ready(function() {
        $(".citySelect2").change(function() {
            var cityID = $(this).val();
            window.location.href = "searchAgency?cityID=" + cityID;
        });
    });
</script>

@endsection
