@extends('site.layout.site')
@section('meta')
    <title> کلیک سفر - مرجع مقایسه ی تورهای مسافرتی </title>
    <meta name="description"
          content="تور خارجي و داخلي کليک سفر خاطره يک سفر رويايي را براي شما به ارمغان خواهند آورد. لحظه آخري مشهد،کيش،اروپا، آفريقا، شرق آسيا يا خاورميانه، گرجستان، استانبول، دبي، فرانسه، ايتاليا، اسپانيا"/>
    <meta name="keywords"
          content="گردشگری,طبیعت گردی,تور,ترکیه,ایران,ارمنستان,تورهای خارحی,تورهای داخلی,بوم گردی,لحضه آخری,سفر,توریست,توریسم">
    <link href="{{ url("css/site/scss/style.css") }}" rel="stylesheet">
@endsection
@section('head')

    <link href="{{ url("css/site/pages/index.css") }}" rel="stylesheet">

@endsection
@section('content')
    <main id="index">
        <div class="search-relative serachindex" style="background-image: url(img/slidtour.jpg); ">
            <!-- slider -->
            <div class="" id="fullscreen-slider">
                <div class="item height100vh heightCustomVh">
                    <div class="page-head-wrap">
                        <div class="page-head-inner">
                            <div class="page-head-caption container text-right">
                                <div class="container">
                                    <div class="row justify-content-center index-slogan">
                                        <div class="col-11 text-center coldivh">
                                            <ul class="icon-content">
                                                <li><a href="#"><img src="/icons/air-transport.png" width="40"></a></li>
                                                <li><a href="#"><img src="/icons/travel.png" width="40"></a></li>
                                                <li><a href="#"><img src="/icons/backpack.png" width="40"></a></li>
                                                <li><a href="#"><img src="/icons/underground.png" width="40"></a></li>
                                                <li><a href="#"><img src="/icons/umbrella.png" width="40"></a></li>
                                                <li><a href="#"><img src="/icons/hotel.png" width="30" class="hotel"></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- order form -->
            <div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <!-- filter horizontal form -->
                            <div>
                                {{--<nav>--}}
                                    {{--<div class="nav nav-tabs" id="nav-tab" role="tablist">--}}
                                        {{--<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>--}}
                                        {{--<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>--}}
                                        {{--<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>--}}
                                    {{--</div>--}}
                                {{--</nav>--}}
                                {{--<div class="tab-content" id="nav-tabContent">--}}
                                    {{--<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...</div>--}}
                                    {{--<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>--}}
                                    {{--<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>--}}
                                {{--</div>--}}


                                <form action="{{ url('Tours') }}" method="get" id="form-search-tour"
                                      class="order-form filter-form filter-form-slider " data-animation="fadeInUp"
                                      data-timeout="1000">
                                    <div class="form-row">


                                        <div class="form-group col-md-7">
                                            <v-select :options="options" @search="onSearch" dir="rtl" label="title_fa"
                                                      v-model="value_destination_tour" placeholder="مقصد را وارد کنید"
                                                      @if(old('destination') and old('destination') !='null' ) v-init:value_destination_tour="{ id: '{{  json_decode(old('destination'))->id   }}', title_fa: '{{     json_decode(old('destination'))->title_fa  }}' }" @endif>
                                                <template slot="no-options">هیچ موردی یافت نشد..</template>
                                                <template slot="option" slot-scope="option">
                                                    <div class="d-center">
                                                        @{{ option.title_fa }}
                                                    </div>
                                                </template>
                                                <template slot="selected-option" slot-scope="option">
                                                    <div class="selected d-center">
                                                        @{{ option.title_fa }}
                                                    </div>
                                                </template>
                                            </v-select>
                                            <input name="destination" type="hidden" v-model="valueDestinationTour">
                                            {!! getError($errors,'destination') !!}
                                        </div>
                                        <div class="form-group col-md-4 p-relative">
                                            <date-picker value=""
                                                         initial-value=""
                                                         display-format="jMMMM" :auto-submit="true" locale="fa"
                                                         name="start_in" placeholder="انتخاب ماه" type="month"
                                                         color="#db34eb">
                                            </date-picker>
                                            {!! getError($errors,'start_in') !!}
                                        </div>
                                        <div class="form-group col-md-1">
                                            <button type="submit" class="submit-form-search-tour btn btn-1 width100">
                                                <i class="fa fa-search searchcn"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                            <!-- / filter horizontal form -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- / order form -->
        </div> <!-- / search-relative -->

        <div class="bg-under-search bg-gray">
            <div class="box-infography">
                <div class="row">
                    <!-- Infography item style 1 -->
                    <div class="col-md-4">
                        <div class="infography infography-1">
                            <div class="infography-icon">
                                <img src="/img/itemA_min.png" alt="مرجع تورهای مسافرتی">
                            </div>
                            <div class="infography-text">
                                <h4 class="font15">مرجع تورهای مسافرتی</h4>
                                <p>تور خود را به راحتی جست و جو کنید.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="infography infography-1">
                            <div class="infography-icon">
                                <img src="/img/itemB_min.png" alt="کلیک کن سفر کن">
                            </div>
                            <div class="infography-text">
                                <h4 class="font15">مقایسه پاییـن تـرین قیمت</h4>
                                <p>تورهای مورد علاقه خود را مقایسه نمایید.</p>
                            </div>
                        </div>
                    </div>
                    <!-- / Infography item style 1 -->

                    <!-- Infography item style 1 -->
                    <div class="col-md-4">
                        <div class="infography infography-1">
                            <div class="infography-icon">
                                <img src="/img/itemC_min.png" alt="کلیک سفر">
                            </div>
                            <div class="infography-text">
                                <h4 class="font15">آژانس های گردشگری تمام ایران</h4>
                                <p>با آژانس مجری جهت خرید تور تماس بگیرید.</p>
                            </div>
                        </div>
                    </div>
                    <!-- / Infography item style 1 -->
                </div>
            </div>
        </div>


        <br>

        @if(count($ToursSpecials))
            <div class="main-block" id="ToursMoment">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center block width100 mb-50 block-title">
                                <h5>تورهای ویژه</h5>
                                <div class="separator"><span> تورهای ویژه با مناسب ترین قیمت ها </span></div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="owl-carousel">
                            @foreach($ToursSpecials as $value)
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <div class="tour-item">
                                        <a target="_blank" href="{{ url('Tour/'.$value->id).'/'.$value->title }}">
                                            <div class="img-wrap">

                                                @if(@$value->imageThumb)
                                                    <img src=" {{ url($value->imageThumb) }} " alt="{{$value->title}}">
                                                @else
                                                    <img src="img/distination-3.jpg" alt="{{$value->title}}">
                                                @endif
                                                <p class="price font10">
                                                    @if(count($value->prices) > 1)
                                                        @php
                                                            $min=0;
                                                        @endphp
                                                        @foreach($value->prices ?? [] as $keyPrice=>$valuePrice)
                                                            @php
                                                                $price=$valuePrice->price;
                                                                if($keyPrice == 0) {
                                                                $min=$price;
                                                                @$dollar=$value->prices[$keyPrice]->price_dollar;
                                                                @$currencyMoment=$value->prices[$keyPrice]->currency;
                                                                }
                                                                if($price < $min ) { $min=$price; @$dollar=$value->prices[$keyPrice]->price_dollar;
                                                                    @$currencyMoment=$value->prices[$keyPrice]->currency;
                                                                    }
                                                            @endphp
                                                        @endforeach
                                                        @if($min > 0)
                                                            شروع قیمت از {{ number_format($min) }} تومان
                                                            @if(isset($dollar))
                                                                + {{ $dollar }} {{ @config('defines.currency')[@$currencyMoment] }}
                                                            @endif
                                                        @else
                                                            تماس جهت قیمت
                                                        @endif
                                                    @elseif(count($value->prices) == 1)
                                                        @if($value->prices[0]->price > 0)
                                                            شروع قیمت از {{ number_format($value->prices[0]->price) }}
                                                            تومان
                                                        @else
                                                            تماس جهت قیمت
                                                        @endif
                                                        @if(@$value->prices[0]->price_dollar and $value->prices[0]->price > 0)
                                                            +
                                                            <i>{{@$value->prices[0]->price_dollar}} {{ @config('defines.currency')[@$value->prices[0]->currency] }} </i>
                                                        @endif
                                                    @else
                                                        تماس جهت قیمت
                                                    @endif

                                                </p>
                                            </div>
                                        </a>
                                        <div class="caption text-right">
                                            <a target="_blank" href="{{ url('Tour/'.$value->id).'/'.$value->title }}"
                                               class="titletour">
                                                <p class="title font15 text-center ">{{ $value->title }} </p>
                                            </a>
                                            <div class="row details">
                                                <div class="col-6 colsafar">
                                                    <p class="title ttype font-size-xs   text-center">
                                                        @if(getTravelMethod($value->travel_method)=='هوایی')
                                                            <i class="fa fa-plane "></i>
                                                        @elseif(getTravelMethod($value->travel_method)=='زمینی')
                                                            <i class="fa fa-car "></i>
                                                        @else
                                                            <i class="fa fa-ship "></i>
                                                        @endif
                                                        روش سفر
                                                        : {{ getTravelMethod($value->travel_method) }} </p>
                                                </div>
                                                <div class="col-6 colmabda">
                                                    <p class="title tfirst font-size-xs   text-center">
                                                        <i class="fa fa-map "></i>
                                                        مبدا
                                                        : {{ $value->city->title_fa }} </p>
                                                </div>
                                            </div>

                                            <p class="date text-center"> {{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($value->start_in)) }}
                                                <i class="ti-calendar clnd"></i>
                                            </p>

                                            <p class="time text-center"><span
                                                    class="float-right ti-time p-1 mr-0"></span> {{ $value->number_nights }}
                                                شب</p>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>
        @endif

        <div class="main-block" id="ToursMoment" style="background: url(https://cdn.alibaba.ir/dist/e864d135/img/app-section-bg.ce9db67.png);">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center block width100 mb-50 block-title">
                            <div class="text-center block width100 mb-50 block-title">
                                <h5> جدیدترین تور ها </h5>
                                <div class="separator"><span style="background: none;"> جدیترین تورهای داخلی , خارجی </span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="index-list-div">

                        <ul class="nav nav-tabs nav-tabs-custom" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active nava" id="home-tab" data-toggle="tab" href="#internal"
                                   role="tab"
                                   aria-controls="internal" aria-selected="true">تورهای داخلی</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nava" id="foreign-tab" data-toggle="tab" href="#foreign" role="tab"
                                   aria-controls="foreign" aria-selected="false">تورهای خارجی</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nava" id="lastsecond-tab" data-toggle="tab" href="#lastsecond"
                                   role="tab"
                                   aria-controls="lastsecond" aria-selected="false">تورهای لحظه آخری</a>
                            </li>
                        </ul>

                        <div class=" tab-content" id="myTabContent">

                            <div class="col-lg-12 tab-pane fade active show" id="internal" role="tabpanel"
                                 aria-labelledby="profile-tab">
                                <div class="row">
                                    @foreach($ToursInternal as $rowInetrnal)

                                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 coltourdiv">
                                            <a href="/Tour/{{$rowInetrnal->id}}/{{$rowInetrnal->title}}">
                                                <div class="Tourdiv">
                                                    <div class="imgitm">
                                                        @if(@$rowInetrnal->imageThumb)
                                                            <img src=" {{ url($rowInetrnal->imageThumb) }} "
                                                                 alt="{{$rowInetrnal->title}}">
                                                        @else
                                                            <img src="img/distination-3.jpg"
                                                                 alt="{{$rowInetrnal->title}}">
                                                        @endif
                                                    </div>
                                                    <div class="captiondiv" style="padding-right:4px; padding-left:3px">


                                                        <div class="" style="padding:0px; width:100%; margin-top:-12px; height:50px">
                                                            <div class="" style=" display:inline-block;width:52% ;margin-bottom:20px">
                                                                <h6 class="tour-title" style="; width:95%; line-height:2;padding-right:3px ">
                                                                    <i class="fa fa-map-marker"></i> {{$rowInetrnal->title}}
                                                                </h6>
                                                            </div>

                                                            <div style="display:inline-block;width:46%; float:left ; margin-top:-5px">
                                                                <div class="pricediv" style="; padding:0px;width:100%; float:left;text-align:left"><i class="fa fa-dollar"></i>
                                                                    @if(count($rowInetrnal->prices) > 1)
                                                                        @php
                                                                            $min=0;
                                                                        @endphp
                                                                        @foreach($rowInetrnal->prices ?? [] as $keyPrice=>$valuePrice)
                                                                            @php
                                                                                $price=$valuePrice->price +($valuePrice->price_dollar * 13000);
                                                                                if($keyPrice == 0) $min=$price;
                                                                                if($price < $min ) $min=$price; @endphp @endforeach
                                                                        شروع
                                                                        قیمت
                                                                        از {{ number_format($min) }}
                                                                        تومان @elseif(count($rowInetrnal->prices) == 1)
                                                                        شروع قیمت
                                                                        از {{ number_format($rowInetrnal->prices[0]->price + ($rowInetrnal->prices[0]->price_dollar * 13000)) }}
                                                                        تومان
                                                                    @else
                                                                        تماس جهت قیمت
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>


                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div style="padding-right:3px">
                                                                    <i class="fa fa-calendar-check-o"></i> {{ $rowInetrnal->number_nights }}
                                                                    شب
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="clnder">
                                                                    <i class="fa fa-calendar"></i> {{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', ($rowInetrnal->start_in)) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="typtravel">
                                                                    <i class="fa fa-building"></i> {{ $rowInetrnal->agency->company }}
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <div class="agancy">
                                                                    <i class="fa fa-building"></i> {{ $rowInetrnal->agency->company }}
                                                                </div>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 m-auto">
                                        <a class="buttour" href="/Tours/internal">
                                            نمایش تمام تورهای داخلی
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 tab-pane fade" id="foreign" role="tabpanel"
                                 aria-labelledby="profile-tab">
                                <div class="row">
                                    @foreach($ToursForeign as $rowInetrnal)

                                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 coltourdiv">
                                            <a href="/Tour/{{$rowInetrnal->id}}/{{$rowInetrnal->title}}">
                                                <div class="Tourdiv">
                                                    <div class="imgitm">
                                                        @if(@$rowInetrnal->imageThumb)
                                                            <img src=" {{ url($rowInetrnal->imageThumb) }} "
                                                                 alt="{{$rowInetrnal->title}}">
                                                        @else
                                                            <img src="img/distination-3.jpg"
                                                                 alt="{{$rowInetrnal->title}}">
                                                        @endif
                                                    </div>
                                                    <div class="captiondiv" style="padding-right:4px; padding-left:3px">


                                                        <div class="" style="padding:0px; width:100%; margin-top:-12px; height:50px">
                                                            <div class="" style=" display:inline-block;width:52% ;margin-bottom:20px">
                                                                <h6 class="tour-title" style="; width:95%; line-height:2;padding-right:3px ">
                                                                    <i class="fa fa-map-marker"></i> {{$rowInetrnal->title}}
                                                                </h6>
                                                            </div>

                                                            <div style="display:inline-block;width:46%; float:left ; margin-top:-5px">
                                                                <div class="pricediv" style="; padding:0px;width:100%; float:left;text-align:left"><i class="fa fa-dollar"></i>
                                                                    @if(count($rowInetrnal->prices) > 1)
                                                                        @php
                                                                            $min=0;
                                                                        @endphp
                                                                        @foreach($rowInetrnal->prices ?? [] as $keyPrice=>$valuePrice)
                                                                            @php
                                                                                $price=$valuePrice->price +($valuePrice->price_dollar * 13000);
                                                                                if($keyPrice == 0) $min=$price;
                                                                                if($price < $min ) $min=$price; @endphp @endforeach
                                                                        شروع
                                                                        قیمت
                                                                        از {{ number_format($min) }}
                                                                        تومان @elseif(count($rowInetrnal->prices) == 1)
                                                                        شروع قیمت
                                                                        از {{ number_format($rowInetrnal->prices[0]->price + ($rowInetrnal->prices[0]->price_dollar * 13000)) }}
                                                                        تومان
                                                                    @else
                                                                        تماس جهت قیمت
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>


                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div style="padding-right:3px">
                                                                    <i class="fa fa-calendar-check-o"></i> {{ $rowInetrnal->number_nights }}
                                                                    شب
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="clnder">
                                                                    <i class="fa fa-calendar"></i> {{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', ($rowInetrnal->start_in)) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="typtravel">
                                                                    <i class="fa fa-building"></i> {{ $rowInetrnal->agency->company }}
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <div class="agancy">
                                                                    <i class="fa fa-building"></i> {{ $rowInetrnal->agency->company }}
                                                                </div>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 m-auto">
                                        <a class="buttour" href="/Tours/forign">
                                            نمایش تمام تورهای خارجی
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 tab-pane fade" id="lastsecond" role="tabpanel"
                                 aria-labelledby="profile-tab">
                                <div class="row">
                                    @foreach($ToursMoment as $rowInetrnal)

                                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 coltourdiv">
                                            <a href="/Tour/{{$rowInetrnal->id}}/{{$rowInetrnal->title}}">
                                                <div class="Tourdiv">
                                                    <div class="imgitm">
                                                        @if(@$rowInetrnal->imageThumb)
                                                            <img src=" {{ url($rowInetrnal->imageThumb) }} "
                                                                 alt="{{$rowInetrnal->title}}">
                                                        @else
                                                            <img src="img/distination-3.jpg"
                                                                 alt="{{$rowInetrnal->title}}">
                                                        @endif
                                                    </div>
                                                    <div class="captiondiv" style="padding-right:4px; padding-left:3px">


                                                        <div class="" style="padding:0px; width:100%; margin-top:-12px; height:50px">
                                                            <div class="" style=" display:inline-block;width:52% ;margin-bottom:20px">
                                                                <h6 class="tour-title" style="; width:95%; line-height:2;padding-right:3px ">
                                                                    <i class="fa fa-map-marker"></i> {{$rowInetrnal->title}}
                                                                </h6>
                                                            </div>

                                                            <div style="display:inline-block;width:46%; float:left ; margin-top:-5px">
                                                                <div class="pricediv" style="; padding:0px;width:100%; float:left;text-align:left"><i class="fa fa-dollar"></i>
                                                                    @if(count($rowInetrnal->prices) > 1)
                                                                        @php
                                                                            $min=0;
                                                                        @endphp
                                                                        @foreach($rowInetrnal->prices ?? [] as $keyPrice=>$valuePrice)
                                                                            @php
                                                                                $price=$valuePrice->price +($valuePrice->price_dollar * 13000);
                                                                                if($keyPrice == 0) $min=$price;
                                                                                if($price < $min ) $min=$price; @endphp @endforeach
                                                                        شروع
                                                                        قیمت
                                                                        از {{ number_format($min) }}
                                                                        تومان @elseif(count($rowInetrnal->prices) == 1)
                                                                        شروع قیمت
                                                                        از {{ number_format($rowInetrnal->prices[0]->price + ($rowInetrnal->prices[0]->price_dollar * 13000)) }}
                                                                        تومان
                                                                    @else
                                                                        تماس جهت قیمت
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>


                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div style="padding-right:3px">
                                                                    <i class="fa fa-calendar-check-o"></i> {{ $rowInetrnal->number_nights }}
                                                                    شب
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="clnder">
                                                                    <i class="fa fa-calendar"></i> {{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', ($rowInetrnal->start_in)) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="typtravel">
                                                                    <i class="fa fa-building"></i> {{ $rowInetrnal->agency->company }}
                                                                </div>
                                                            </div>

                                                            <div class="col-6">
                                                                <div class="agancy">
                                                                    <i class="fa fa-building"></i> {{ $rowInetrnal->agency->company }}
                                                                </div>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 m-auto">
                                        <a class="buttour" href="/Tours/lastsecond">
                                            نمایش تمام تورهای لحظه آخری
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <br>
        <br>

        <div class="main-block" id="ToursMoment">
            <div class="container container-sm">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center block width100 mb-50 block-title">
                            <h5>تورهای طبیعت گردی | بوم گردی</h5>
                            <div class="separator"><span>سفر به مناطق طبیعی ایران</span></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="owl-carousel">
                        @foreach($TourIndoors as $rowIndoors)
                            <div class="col-md-12 col-lg-12 col-sm-12 boomgardi">
                                <div class="tour-item">
                                    <a target="_blank" href="{{ url('Tour/'.$rowIndoors->id).$rowIndoors->title}}">                                        <div class="img-wrap">
                                            @if(@$rowIndoors->imageThumb)
                                                <img src="{{ url($rowIndoors->imageThumb) }}"
                                                     alt="{{$rowIndoors->title}}">
                                            @else
                                                <img src="img/distination-3.jpg" alt="{{$rowIndoors->title}}">
                                            @endif
                                            <p class="price font10">
                                                @if(count($rowIndoors->prices) > 1)
                                                    @php
                                                        $min=0;
                                                    @endphp
                                                    @foreach($rowIndoors->prices ?? [] as $keyPrice=>$valuePrice)
                                                        @php
                                                            $price=$valuePrice->price +($valuePrice->price_dollar * 13000);
                                                            if($keyPrice == 0) $min=$price;
                                                            if($price < $min ) $min=$price; @endphp @endforeach شروع
                                                    قیمت
                                                    از {{ number_format($min) }}
                                                    تومان @elseif(count($rowIndoors->prices) == 1)
                                                    شروع قیمت
                                                    از {{ number_format($rowIndoors->prices[0]->price + ($rowIndoors->prices[0]->price_dollar * 13000)) }}
                                                    تومان
                                                @else
                                                    تماس جهت قیمت
                                                @endif

                                            </p>
                                        </div>
                                    </a>
                                    <div class="caption text-right">
                                        <a target="_blank" href="{{ url('Tour/'.$rowIndoors->id).$rowIndoors->title }}">
                                            <p class="title font15 text-center">{{ $rowIndoors->title }} </p>
                                        </a>
                                        <div class="row details">
                                            <div class="col-6 colsafar">
                                                <p class="title ttype font-size-xs   text-center">
                                                    @if(getTravelMethod($rowIndoors->travel_method)=='هوایی')
                                                        <i class="fa fa-plane "></i>
                                                    @elseif(getTravelMethod($rowIndoors->travel_method)=='زمینی')
                                                        <i class="fa fa-car "></i>
                                                    @else
                                                        <i class="fa fa-ship "></i>
                                                    @endif
                                                    روش سفر
                                                    : {{ getTravelMethod($rowIndoors->travel_method) }} </p>
                                            </div>
                                            <div class="col-6 colmabda">
                                                <p class="title tfirst font-size-xs   text-center">
                                                    <i class="fa fa-map "></i>
                                                    مبدا
                                                    : {{ $rowIndoors->city->title_fa }} </p>
                                            </div>
                                        </div>

                                        <p class="date text-center"> {{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($rowIndoors->start_in)) }}
                                            <i class="ti-calendar clnd"></i>
                                        </p>

                                        <p class="time text-center"><span
                                                class="float-right ti-time p-1 mr-0"></span> {{ $rowIndoors->number_nights }}
                                            شب</p>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>

        

        <br>
        <br>
        <br>


        <div class="main-block">
            <div class="container container-sm">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center block width100 mb-50 block-title">
                            <h5>کشورهای خارجی محبوب</h5>
                            <div class="separator"><span>بهترین مقصد را انتخاب کنید</span></div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">

                        @foreach($FavoriteTours as $rowFav)
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12   dltr">
                                <div class="category-item effect-2">
                                    <img src="{{ $rowFav['image'] }}" alt="{{$rowFav->countries['title_fa']}}">

                                    <div class="caption text-right">
                                        <div>
                                            <p class="title font15">{{$rowFav->countries['title_fa']}}</p>
                                            <p class="description">{{ strip_tags($rowFav['details'])  }}</p>
                                        </div>
                                        <a href="/Tours/destination/{{$rowFav['origin']}}">جزییات بیشتر</a>
                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>


        <div class="main-block">
            <div class="container-fluid container-sm">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center block width100 mb-50 block-title">
                            <h5>آخرین مطالب</h5>
                            <div class="separator"><span>تازه ترین مطالب</span></div>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="owl-carousel">
                            @foreach($Posts as $post)
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <div class="tour-item2">
                                        <a target="_blank" href="{{str_replace(' ','-',url('/blog/'.$post->id.'/'.$post->title))}}">
                                            <div class="img-wrap">

                                                @if($post->image_thumb)
                                                    <img src=" {{ url($post->image_thumb) }} " alt="{{$post->title}}">
                                                @else
                                                    <img src="img/distination-3.jpg" alt="{{$post->title}}">
                                                @endif


                                            </div>
                                        </a>

                                        <div class="caption2 text-right">
                                            <div class="row details">
                                                <div class="col-12 coltit">
                                                    <a href="{{str_replace(' ','-',url('/blog/'.$post->id.'/'.$post->title))}}">
                                                        <p class="title">{{$post->title}}</p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row details">
                                                <div class="col-12 colsafar2">
                                                    <p class="title ttype font-size-xs   text-right summry">
                                                        <?php
                                                        echo strip_tags($post->summary);
                                                        ?>
                                                    </p>
                                                </div>

                                            </div>

                                            {{--<span class="title post-date-row "><i class="fa fa-calendar"></i> {{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($post->created_at)) }}</span>--}}

                                            <div>
                                                <a   class="btn btn-block buttdark" href="{{str_replace(' ','-',url('/blog/'.$post->id.'/'.$post->title))}}">

                                                    ادامه مطلب
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>


            </div>
        </div>


        <nav class="social">
            <ul>
                <li><a href="http://t.me/clicksafar"> <i class="fa fa-telegram"></i>Telegram</a></li>
                <li><a href="https://instagram.com/clicksafar"> <i class="fa fa-instagram"></i>Instagram</a></li>
                <li><a href="https://wa.me/+989364931600"> <i class="fa fa-whatsapp"></i>WhatsApp</a></li>
                <li><a href="https://www.aparat.com/clicksafar/"> <i class="fa"><img src="{{ url('img/aparat.png') }}" width="20" height="20px" class="fa fa-facebook"></i>Aparat</a></li>
            </ul>
        </nav>

    </main>
@endsection
@section('footer')

    <!-- <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script> -->

    <script type="text/javascript">
        $(document).ready(function () {


            $('img').addClass('lazy');

            setTimeout(function () {
                $('.lazy').Lazy();
            }, 500);


            $('.owl-carousel').owlCarousel({
                rtl: true,
                loop: true,
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
                    },
                    1200: {
                        items: 4
                    }
                }
            });


            $('.owl-carousel2').owlCarousel({
                rtl: true,
                loop: true,
                margin: 10,
                nav: true,
                autoplay: true,
                rtl: true,
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
            $('.owl-carousel3').owlCarousel({
                rtl: true,
                loop: true,
                margin: 10,
                nav: true,
                autoplay: true,
                rtl: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 4
                    }
                }
            });


        });
    </script>

@endsection

