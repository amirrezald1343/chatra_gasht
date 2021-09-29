@extends('site.layout.site')
@section('meta')
    <title> کلیک سفر -   {{ $tour->title }}   </title>
    @if($tour['description'] and $tour['description']!='' and $tour['description']!=null)
    @endif
    <meta name="description" content="{{    $tour->title  }} , تور خارجي و داخلي کليک سفر خاطره يک سفر رويايي را براي شما به ارمغان خواهند آورد. لحظه آخري ">

    <meta name="keywords" content="تور,گردشگری,ایرانگردی,جهانگردی,بوم گردی,{{$tour->title}}">

@endsection
@section('head')
    <link href="{{ url("css/site/pages/index.css") }}" rel="stylesheet">
    <link href="{{ url("css/site/pages/tourDetails.css") }}" rel="stylesheet">

    <style type='text/css'>
        .form-group table{
            display:block;
        }

        h2.big-title{
            color:white;
        }

        .goTOp2{
            bottom:20px;
        }

        .goTOp2 h2{
            text-align: left;
            margin-left: 50px;
        }

        .display-a{
            top:20%;
        }

        @media screen and (max-width:767px) {

            .goTop1 h1{
                text-align: right;
            }

        }

    </style>

@endsection
@section('content')
    <main id="tourDetails">
        <div class="page-head white-content">
            <div class="height60vh parallax-container" style="background-image: url(/img/budapest.jpg); height: 400px">
                <div class="page-head-wrap">
                    <div class="display-r">
                        <div class="display-a">
                            <div class="container">
                                <div class="row justify-content-center justify-content-center2 animate m-0" data-animation="fadeInUp"
                                     data-timeout="500">
                                    <div class="col-md-6 text-center goTop1">
                                        <h1 class="big-title mt-60">{{ $tour->title }}</h1>
                                    </div>
                                    <div class="col-md-6 text-center goTOp2">
                                        <h2 class="big-title mt-20 ">
                                            <span>آژانس : </span><span>{{ @$tour->agency->company }}</span></h2>
                                        <h2 class="big-title mt-20"><span class="box-fa-phone"> </span><span> <i class="fa fa-phone"></i> {{ $tour->agency->tellPhone  }}</span></h2>
                                        @if(@$tour->agency->internalCode)
                                            <h2 class="big-title mt-20"><span class="box-fa-phone"> </span><span><i class="fa fa-phone"></i> 051-31600{{ $tour->agency->internalCode  }}</span>
                                            </h2>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tour-single-info">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="tour-single-sidebar-info-item">
                            <span class="ti-calendar"></span>
                            <p>تاریخ
                                رفت {{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($tour->start_in)) }} </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="tour-single-sidebar-info-item">
                            <span class="ti-timer"></span>
                            <p>{{ $tour->number_nights }} شب</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="tour-single-sidebar-info-item">
                            <span class="ti-location-pin"></span>
                            <p>از {{ $tour->city->title_fa }}

                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="tour-single-sidebar-info-item">
                            <span class="ti-credit-card"></span>
                            <p class="price">
                                <?php
                                $currency=array();
                                $getCunrrencies=DB::table('currencies')->get();
                                if(count($getCunrrencies)){
                                    foreach($getCunrrencies as $row){
                                        $currency[$row->type]=$row->amount;

                                    }
                                }else{
                                    $currency=['usd'=>0,'euro'=>0];
                                }


                                ?>
                                @if(count($tour->prices) > 1)
                                    @php
                                        $min=0;
                                    @endphp
                                    @foreach($tour->prices ?? [] as $keyPrice=>$valuePrice)
                                        @php
                                            $price=$valuePrice->price +($valuePrice->price_dollar * $currency[$valuePrice->currency] );
                                            if($keyPrice == 0) $min=$price;
                                            if($price < $min ) $min=$price;
                                        @endphp
                                    @endforeach
                                    شروع قیمت از  {{ number_format($min) }} تومان
                                @elseif(count($tour->prices) == 1)
                                    {{ number_format($tour->prices[0]->price + ($tour->prices[0]->price_dollar * $currency[$tour->prices[0]->currency])) }}
                                    تومان
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-20 mb-40">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- tab-1 -->
                        <div class="tab-1">
                            <ul class="nav nav-tabs" role=tablist>

                                <li class="nav-item">
                                    <a class="nav-link active" id="gallery-tab" data-toggle="tab" href="#tab-4" role="tab"
                                       aria-selected="false">قیمت</a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link " id="itinerary-tab" data-toggle="tab" href="#tab-2" role="tab"
                                       aria-selected="false">خدمات</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link " id="highlights-tab" data-toggle="tab" href="#tab-1"
                                       role="tab" aria-selected="true">جزئیات تور</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link " id="map-tab" data-toggle="tab" href="#tab-3" role="tab"
                                       aria-selected="false">قوانین</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link " id="book-tab" data-toggle="tab" href="#tab-5" role="tab"
                                       aria-selected="false">مراحل تور</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="book-tab" data-toggle="tab" href="#tab-6" role="tab"
                                       aria-selected="false">نقشه</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="book-tab" data-toggle="tab" href="#tab-7" role="tab"
                                       aria-selected="false">تصاویر</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade  " id="tab-1" role="tabpanel"
                                     aria-labelledby="highlights-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="tour-single-sidebar mb-30 tour-single-sidebar-padding">
                                                        <div class="tour-slingle-sidebar-form">
                                                            <form id="modal-book" class="form-block text-center"
                                                                  method="POST" novalidate="novalidate">
                                                                <div class="form-group col-md-12">
                                                                    <label class="col-form-label">نوع سفر : </label>
                                                                    <label class="col-form-label">{{  getTravelMethod($tour->travel_method) }}</label>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label class="col-form-label">وسیله نقلیه : </label>
                                                                    <label class="col-form-label"> {{ $tour->vehicle_type }}</label>
                                                                </div>
                                                                <hr>
                                                                <div class="form-group col-md-12">
                                                                    <label class="col-form-label"> مدارک مورد نیاز
                                                                        :</label>
                                                                    <p class="col-form-label">{!! $tour->documents  !!}  </p>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="tour-single-sidebar mb-30 tour-single-sidebar-padding text-right">
                                                        <h5 class="">

                                                            @isset($tour->agency->media->path)
                                                                <img class="logo-agency"
                                                                     src="{{ url($tour->agency->media->path ?? '') }}" alt="{{$tour->title}}"> @endisset


                                                            <span class="logo-title"
                                                                  style="{{ (!isset($tour->agency->media->path) ? 'bottom: 5px;' : '') }}"> {{ $tour->agency->company }} </span>
                                                        </h5>
                                                        <ul class="support mt-3">
                                                            <li>
                                                                <i class="fa fa-map-marker ml-1"></i>{{ $tour->agency->address }}
                                                            </li>
                                                            <li>  {{ $tour->agency->tellPhone }}<span
                                                                    class="ti-headphone-alt pl-1"></span></li>
                                                            <li>
                                                            @if(@$tour->agency->internalCode)
                                                                <li> 051-31600{{ $tour->agency->internalCode }}<span
                                                                        class="ti-headphone-alt pl-1"></span></li>
                                                                <li>
                                                                    @endif

                                                                    <a href="mailto:{{ $tour->agency->email }}">{{ $tour->agency->email }}</a>
                                                                    <span class="ti-email"></span></li>
                                                                @if($tour->agency->domain)
                                                                    <li><i class="fa fa-link ml-1"></i><a target="_blank"
                                                                                                          href="{{ 'http://'.$tour->agency->domain }}">{{ $tour->agency->domain }}</a>
                                                                    </li>
                                                                @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                                <p style="white-space:pre-line; text-align: justify">{!!  $tour->description !!} </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade  " id="tab-2" role="tabpanel" aria-labelledby="itinerary-tab">
                                    <div class="section  text-justify" id="Services">
                                        <div class="list">
                                            @foreach($tour->services ?? [] as $keyService=>$valueService)
                                                <label class="pb-3 service">
                                                    <img src="{{ url($valueService->icon) }}"
                                                         class="fas fa-plane fa-rotate-270 font20" alt="{{$valueService->title}}">
                                                    <span class="title-service"> {{ $valueService->title }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        <h5 class="text-right mt-1">خدمات تکمیلی</h5>
                                        <p> {!! $tour->additional_services !!} </p>
                                    </div>
                                </div>

                                <div class="tab-pane fade " id="tab-3" role="tabpanel" aria-labelledby="map-tab">
                                    <p>{!! $tour->rules !!}</p>
                                </div>

                                <div class="tab-pane fade show active " id="tab-4" role="tabpanel" aria-labelledby="gallery-tab">
                                    <table class="table table-striped text-center prices">
                                        <thead>
                                        <tr>
                                            <th scope="col">نام</th>
                                            <th scope="col">نوع</th>
                                            <th scope="col">درجه هتل</th>
                                            <th scope="col">قیمت</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tour->prices ?? [] as $keyPrice=>$valuePrice)
                                            <tr>
                                                <td class="">{{ $valuePrice->name }}</td>
                                                <td>{{ getResidenceType($valuePrice->type) }}</td>
                                                <td>
                                                     <span class="icon-star-full2 text-small text-warning-800">
                                                        @for($i=0;$i < $valuePrice->star ;$i++)
                                                             <i class="fa fa-star"></i>
                                                         @endfor
                                                    </span>
                                                </td>
                                                <td style="text-align: right;">
                                                    <div style="">
                                                        <label> قیمت برای هم نفر (اتاق استاندارد)  : </label>
                                                        {{ number_format($valuePrice->price) }}
                                                        تومان @if($valuePrice->price_dollar>0)<span>
                                                        <span class="plus"> + </span>  {{ number_format($valuePrice->price_dollar) }}
                                                            {{ config('defines.currency')[$valuePrice->currency] }}
                                                                </span>
                                                        @endif
                                                    </div>

                                                    <div style="border-top:1px solid #d9d9d9">
                                                        <label> قیمت برای  هر نوزاد  : </label>
                                                        @if(@$valuePrice->baby)
                                                            {{ @number_format(@$valuePrice->baby) }}
                                                            تومان
                                                        @else
                                                            - - -
                                                        @endif
                                                    </div>

                                                    <div style="border-top:1px solid #d9d9d9">
                                                        <label> قیمت زیر 5 سال  : </label>
                                                        @if(@$valuePrice->LTF)
                                                            {{ @number_format(@$valuePrice->LTF) }}
                                                            تومان
                                                        @else
                                                            - - -
                                                        @endif
                                                    </div>

                                                    <div style="border-top:1px solid #d9d9d9">
                                                        <label> قیمت 6 تا 14 سال  : </label>
                                                        @if(@$valuePrice->BSF)
                                                            {{ @number_format(@$valuePrice->BSF) }}
                                                            تومان
                                                        @else
                                                            - - -
                                                        @endif
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane fade " id="tab-5" role="tabpanel" aria-labelledby="book-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- accordion-1 -->
                                            <ul class="accordion-element accordion-2">
                                                @foreach($tour->levels ?? [] as $keyLevel=>$valueLevel)
                                                    <li>
                                                        <a class="toggle" href="javascript:void(0);"
                                                           data-item="item-1">{{ $valueLevel->title }}</a>
                                                        <p style="display: {{ ($keyLevel == 0) ? 'block' : 'none'}};"
                                                           class="inner {{ ($keyLevel == 0) ? 'show' : ''}}">{{ $valueLevel->description }}</p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade " id="tab-6" role="tabpanel" aria-labelledby="highlights-tab">
                                    <div id="gmap-polyline" style="width: 100%; height: 400px"></div>
                                </div>

                                <div class="tab-pane fade " id="tab-7" role="tabpanel" aria-labelledby="highlights-tab">
                                    <div class="row images">
                                        <div class="owl-carousel">
                                            @foreach($tour->images as $keyImage=>$valueImage)
                                                @if(@$valueImage->media->path)
                                                    <div class="col-md-12">
                                                        <label>
                                                            <i class="fa fa-map-marker"></i> {{ $valueImage->title }}
                                                        </label>
                                                        <div class="image-grid-item">
                                                            <a href="{{ url($valueImage->media->path ) }}"
                                                               class="image-link">
                                                                <img style="height:250px"
                                                                     src="{{ url($valueImage->media->path) }}"
                                                                     alt="{{$valueImage->title ?? $tour->title}}">
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                        <!-- /.tab-1 -->
                    </div>
                </div>
            </div>

            {{--<div class="container container-sm">--}}
            {{--<div class="row">--}}

            {{--<div class="col-md-12 mt-30">--}}
            {{--<h2>تورهای مشابه</h2>--}}
            {{--</div>--}}
            {{--<div class="col-md-6 col-lg-4">--}}
            {{--<div class="tour-item">--}}
            {{--<a href="#">--}}
            {{--<div class="img-wrap">--}}
            {{--<img src="/img/distination-8.jpg" alt="">--}}
            {{--<p class="price">1450 $</p>--}}
            {{--</div>--}}
            {{--</a>--}}
            {{--<div class="caption">--}}
            {{--<a href="#"><p class="title">Evening Ubud Tour with Cultural Performances</p></a>--}}
            {{--<p class="date"><span class="ti-calendar"></span>August 20, 2018</p>--}}
            {{--<p class="time"><span class="ti-time"></span>10 days</p>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-6 col-lg-4">--}}
            {{--<div class="tour-item">--}}
            {{--<a href="#">--}}
            {{--<div class="img-wrap">--}}
            {{--<img src="/img/distination-7.jpg" alt="">--}}
            {{--<p class="price"><span>1500 $</span>1250 $</p>--}}
            {{--</div>--}}
            {{--</a>--}}
            {{--<div class="caption">--}}
            {{--<a href="#"><p class="title">Private Partner Yoga Class & Thai Massage Lesson</p></a>--}}
            {{--<p class="date"><span class="ti-calendar"></span>August 20, 2018</p>--}}
            {{--<p class="time"><span class="ti-time"></span>15 days</p>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-6 col-lg-4">--}}
            {{--<div class="tour-item">--}}
            {{--<a href="#">--}}
            {{--<div class="img-wrap">--}}
            {{--<img src="/img/distination-9.jpg" alt="">--}}
            {{--<p class="price">1450 $</p>--}}
            {{--</div>--}}
            {{--</a>--}}
            {{--<div class="caption">--}}
            {{--<a href="#"><p class="title">Private Horseback Riding in Tegalalang</p></a>--}}
            {{--<p class="date"><span class="ti-calendar"></span>August 20, 2018</p>--}}
            {{--<p class="time"><span class="ti-time"></span>7 days</p>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--</div>--}}
            {{--</div>--}}

        </div>

    </main>
@endsection
@section('footer')
    <script src="https://maps.google.com/maps/api/js?sensor=false&libraries=geometry&v=3.22&key=AIzaSyBATf9eLRVC1xIUeAnhcu8Fgvy677MDlPY"></script>
    <script src="{{ url("js/site/maplace.js") }}"></script>
    <script type="text/javascript">


        $(document).ready(function () {


            $('.owl-carousel').owlCarousel({
                rtl: true,
                loop: false,
                margin: 10,
                nav: true,
                autoplay: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 3
                    }
                }
            });


        });





        new Maplace({
            locations: [
                    @php
                        $letteren= "A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
                        $letteren=explode(',',$letteren);
                    @endphp
                    @if(count($tour->maps) >= 1)
                    @foreach($tour->maps as $key=>$value)
                {
                    lat: {{ $value->lat }},
                    lon: {{ $value->lon }} ,
                    title: 'a',
                    html: '<h6 style="font-weight: 700;">{{ $value->title }}</h6>',
                    animation: google.maps.Animation.DROP,
                    icon: 'http://maps.google.com/mapfiles/marker{{ $letteren[$key] }}.png',
                    zoom: 4,
                },
                @endforeach
                @endif
            ],
            map_div: '#gmap-polyline',
            controls_div: '#controls-polyline',
            controls_type: 'list',
            controls_on_map: false,
            view_all_text: 'Start',
            type: 'polyline',

        }).Load();
    </script>
@endsection
