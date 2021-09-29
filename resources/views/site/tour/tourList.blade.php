@extends('site.layout.site')
@section('meta')
<title> کلیک سفر - جستجو و فیلتر تورها </title>
<meta name="description" content="تور خارجي و داخلي کليک سفر خاطره يک سفر رويايي را براي شما به ارمغان خواهند آورد. لحظه آخري مشهد،کيش،اروپا، آفريقا، شرق آسيا يا خاورميانه، گرجستان، استانبول، دبي، فرانسه، ايتاليا، اسپانيا" />
<meta name="keywords" content="گردشگری,طبیعت گردی,تور,ترکیه,ایران,ارمنستان,تورهای خارحی,تورهای داخلی,بوم گردی,لحضه آخری,سفر,توریست,توریسم">


@endsection
@section('head')

<link href="{{ url("css/site/pages/tourList.css") }}" rel="stylesheet">

<link href="{{ url("css/site/pages/index.css") }}" rel="stylesheet">



<style type="text/css">
    .noUi-connect {
        background-color: #ffd903 !important;
        background-image: #ffd903 !important;
        background: #ffd903 !important;
    }


    .noUiSlider {
        margin-top: 45px !important;
    }

    .btn-delete-date {
        font-size: 20px;
        posetion: absolute;
        float: right;
        color: white;
        padding: 8px;
        background-color: #ffd903;
        margin-top: -3px;
        padding: 6px 10px;
        cursor: pointer;
        border-radius: 0px 0px 3px 3px;
        display: none
    }

    .tourListItem {
        width: 100%;
        padding: 5px;
        height: 153px;
        margin-top: 15px;
        margin-right: 0px !important;
        margin-bottom: 0px !important;
        margin-left: 0px !important;
        border: 1px solid rgb(247, 247, 247);
        background-color: white;
    }

    .tourListImage {
        width: 100%;
        height: 100%;
        margin: 0px;
        min-height: 100%;
    }

    .fixBill {
        display: block;
        position: fixed;
        width: 73.2%;
        margin-top: -30px;
        margin-right: -2px;
        top: 90px;
        z-index: 10000 !important;
    }

    .mobile-tour-prices {
        margin-top: -8px;
        display: none;
        margin-bottom: 10px;
    }

    .desktop-tour-Prices {}

    .tour-add-fav-btn {
        position: absolute;
        background-color: rgba(173, 173, 173, 0.5);
        font-size: 11px;
        padding: 4px;
        color: white;
        cursor: pointer;
    }

    .fav-tour-active {
        color: #beff00;
    }


    @media screen and (max-width:768px) {
        .fixBill {
            width: 96.3% !important;
            font-size: 11px !important;
        }

        .filterBoxBtn {
            cursor: pointer;
        }

        #filterBoxDiv {
            display: none;
        }

        .formFilterTop{
            margin-top: -35px;
        }

    }


    @media screen and (max-width:991px) {
        .tourListItem {
            height: 100%;
            width: 48%;
            display: inline-block;
            text-align: center
        }

        .tourListImage {
            max-height: 230px;
            min-height: 230px;
        }

        .mobile-tour-prices {
            display: block;
        }

        .desktop-tour-Prices {
            display: none
        }

    }


    @media screen and (max-width:525px) {
        .tourListItem {
            height: 100%;
            width: 100%;
            display: inline-block;
            text-align: center
        }

        .tourListImage {
            max-height: 230px;
            min-height: 230px;
        }
    }
</style>


@endsection
@section('content')


<main id="index">
    <div class="search-relative serachindex" style="background-image: url({{ url('img/slidtour.jpg') }}); ">
        <!-- slider -->
        <div class="" id="fullscreen-slider">
            <div class="item height100vh heightCustomVh">
                <div class="page-head-wrap">
                    <div class="page-head-inner">
                        <div class="page-head-caption container text-right">
                            <div class="container">
                                <div class="row justify-content-center justify-content-center2 index-slogan">
                                    <div class="col-11 text-center coldivh coldivh2">
                                        <h1 class="big-title mb-10  font30 text-center" data-animation="fadeInDown"
                                            data-timeout="800">کلیک کن سفر کن </h1>
                                        <p class=" bg-main d-inline-block text-center " data-animation="bounceIn"
                                           data-timeout="900">جست و جو ٬ مقایسه ٬ انتخاب</p>
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
                            
                            <form action="{{ url('Tours') }}" method="get" id="form-search-tour" class="order-form filter-form filter-form-slider " data-animation="fadeInUp" data-timeout="1000">
                                <div class="form-row formFilterTop">
                                    <div class="form-group col-md-7">
                                        <v-select :options="options" @search="onSearch" dir="rtl" label="title_fa" v-model="value_destination_tour" placeholder="مقصد را وارد کنید" @if(@old('destination') ?? @$model['destination'] and old('destination') ?? $model['destination'] !='null' ) v-init:value_destination_tour="{ id: '{{   json_decode(@old('destination') ?? @$model['destination'])->id   }}', title_fa: '{{    json_decode(@old('destination') ?? @$model['destination'])->title_fa }}' }" @endif>
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
                                        <date-picker value="{{ getMonthNumber('20/20/20')}}" initial-value="{{ getMonthNumber('20/20/20') }}" display-format="jMMMM" :auto-submit="true" locale="fa" name="start_in" placeholder="انتخاب ماه" type="month" color="#db34eb"></date-picker>
                                        {!! getError($errors,'start_in') !!}
                                        <span class="fa fa-close btn-delete-date"></span>
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

    <!-- / page-head -->
    {{--<div class=" text-right bg mt-3 d-inline-flex col-md-5">--}}
    {{--<p class="p-3">مرتب سازی بر اساس :</p>--}}
    {{--<select class="custom-select col-3 mt-2 pr-4" id="inputGroupSelect01">--}}
    {{--<option selected> قیمت </option>--}}
    {{--<option value="1">تاریخ</option>--}}
    {{--<option value="2">نوع پرواز</option>--}}
    {{--<option value="3">هتل</option>--}}
    {{--</select>--}}
    {{--<select class="custom-select col-3 mt-2 mr-2 pr-4" id="inputGroupSelect02">--}}
    {{--<option selected> صعودی </option>--}}
    {{--<option value="1">نزولی</option>--}}
    {{--</select>--}}
    {{--</div>--}}
    <!-- content -->

    <div class="content mt-2 mb-40 container-fluid mt-60">
        <div class="row">
            <div class="col-md-3">

                <div class="sidebar">
                    @php
                    $urlFilter=\Illuminate\Support\Facades\Request::url();
                    @endphp
                    @if(!isset($noFilter))
                    <form action="{{ $urlFilter }}" class="filter-form .filter-form-slider-h" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="p-3 bg col-md-12 text-center text-white rounded">
                                <h6 class="title-filter filterBoxBtn"><span class="ti-filter"></span><span>فیلتر</span></h6>
                                <div id="filterBoxDiv">
                                    <div>
                                        <div class="border-bottom pb-3">
                                            <p class="text-secondary text-right font10">مبدا</p>
                                            @foreach($origins ?? [] as $keyOrigin=>$valueOrigin)
                                            <div class="input-group-prepend text-dark">
                                                <label>
                                                    <input @isset($modelFilter['origins']) {{ (key_exists($keyOrigin,array_flip($modelFilter['origins']))) ?  'checked' :'' }} @endisset name="origins[]" value="{{ $keyOrigin }}" type="checkbox">
                                                    <i class="fa fa-square-o fa-2x"></i>
                                                    <i class="fa fa-check-square-o fa-2x"></i>
                                                    <span class="title">{{ $valueOrigin }}</span>
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="border-bottom pb-3">
                                            <p class="text-secondary text-right font10 mt-2">درجه هتل</p>
                                            <div class="input-group-prepend text-dark">
                                                <label>
                                                    <input @isset($modelFilter['stars']) {{ (key_exists(1,array_flip($modelFilter['stars']))) ?  'checked' :'' }} @endisset name="stars[]" value="1" type="checkbox">
                                                    <i class="fa fa-square-o fa-2x"></i>
                                                    <i class="fa fa-check-square-o fa-2x"></i>
                                                    <span class="title">
                                                        <i class="fa fa-star"></i>
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="input-group-prepend text-dark">
                                                <label>
                                                    <input @isset($modelFilter['stars']) {{ (key_exists(2,array_flip($modelFilter['stars']))) ?  'checked' :'' }} @endisset name="stars[]" value="2" type="checkbox">
                                                    <i class="fa fa-square-o fa-2x"></i>
                                                    <i class="fa fa-check-square-o fa-2x"></i>
                                                    <span class="title">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="input-group-prepend text-dark">
                                                <label>
                                                    <input @isset($modelFilter['stars']) {{ (key_exists(3,array_flip($modelFilter['stars']))) ?  'checked' :'' }} @endisset name="stars[]" value="3" type="checkbox">
                                                    <i class="fa fa-square-o fa-2x"></i>
                                                    <i class="fa fa-check-square-o fa-2x"></i>
                                                    <span class="title">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="input-group-prepend text-dark">
                                                <label>
                                                    <input @isset($modelFilter['stars']) {{ (key_exists(4,array_flip($modelFilter['stars']))) ?  'checked' :'' }} @endisset name="stars[]" value="4" type="checkbox">
                                                    <i class="fa fa-square-o fa-2x"></i>
                                                    <i class="fa fa-check-square-o fa-2x"></i>
                                                    <span class="title">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="input-group-prepend text-dark">
                                                <label>
                                                    <input @isset($modelFilter['stars']) {{ (key_exists(5,array_flip($modelFilter['stars']))) ?  'checked' :'' }} @endisset name="stars[]" value="5" type="checkbox">
                                                    <i class="fa fa-square-o fa-2x"></i>
                                                    <i class="fa fa-check-square-o fa-2x"></i>
                                                    <span class="title">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="border-bottom pb-3">
                                            <p class="text-secondary text-right font10  mt-2">مدت اقامت</p>
                                            @foreach($numberNights ?? [] as $keyNight=>$valueNight)
                                            <div class="input-group-prepend text-dark">
                                                <label>
                                                    <input @isset($modelFilter['numberNights']) {{ (key_exists($keyNight,array_flip($modelFilter['numberNights']))) ?  'checked' :'' }} @endisset name="numberNights[]" value="{{ $keyNight }}" type="checkbox">
                                                    <i class="fa fa-square-o fa-2x"></i>
                                                    <i class="fa fa-check-square-o fa-2x"></i>
                                                    <span class="title  title-numberNights"> {{ $keyNight }} شب </span>
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>

                                        @if(@$maxPirceTotal)
                                        <div class="border-bottom  pb-3">
                                            <p class="text-secondary text-right font10  mt-2">شروع قیمت</p>
                                            <div id="noUiSlider" class="noUiSlider"></div><br>
                                            <input type='hidden' value="{{$minPirce}}" id="minPriceFilter" name="minPriceFilter">
                                            <input type='hidden' value="{{$maxPirce}}" id="maxPriceFilter" name="maxPriceFilter">
                                        </div>
                                        @endif


                                        <div class="border-bottom  pb-3">
                                            <p class="text-secondary text-right font10  mt-2">نوع سفر</p>
                                            <div class="input-group-prepend text-dark">
                                                <label>
                                                    <input @isset($modelFilter['typeTrip']) {{ (key_exists('aerial',array_flip($modelFilter['typeTrip']))) ?  'checked' :'' }} @endisset name="typeTrip[]" value="aerial" type="checkbox">
                                                    <i class="fa fa-square-o fa-2x"></i>
                                                    <i class="fa fa-check-square-o fa-2x"></i>
                                                    <span class="title"> هوایی </span>
                                                </label>
                                            </div>
                                            <div class="input-group-prepend text-dark">
                                                <label>
                                                    <input @isset($modelFilter['typeTrip']) {{ (key_exists('earthy',array_flip($modelFilter['typeTrip']))) ?  'checked' :'' }} @endisset name="typeTrip[]" value="earthy" type="checkbox">
                                                    <i class="fa fa-square-o fa-2x"></i>
                                                    <i class="fa fa-check-square-o fa-2x"></i>
                                                    <span class="title"> زمینی </span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="pb-3">
                                            <p class="text-secondary text-right font10  mt-2">نوع تور</p>
                                            <div class="input-group-prepend text-dark">
                                                <label>
                                                    <input @isset($modelFilter['typeTour']) {{ (key_exists('internal',array_flip($modelFilter['typeTour']))) ?  'checked' :'' }} @endisset @if($tourInOuts=='y' ) {{ ($tourTypeToChecks=='internal') ?  'checked' :'' }} @endif name="typeTour[]" value="internal" type="checkbox">
                                                    <i class="fa fa-square-o fa-2x"></i>
                                                    <i class="fa fa-check-square-o fa-2x"></i>
                                                    <span class="title"> داخلی </span>
                                                </label>
                                            </div>
                                            <div class="input-group-prepend text-dark">
                                                <label>
                                                    <input @isset($modelFilter['typeTour']) {{ (key_exists('foreign',array_flip($modelFilter['typeTour']))) ?  'checked' :'' }} @endisset name="typeTour[]" @if($tourInOuts=='y' ) {{ ($tourTypeToChecks=='foreign') ?  'checked' :'' }} @endif value="foreign" type="checkbox">
                                                    <i class="fa fa-square-o fa-2x"></i>
                                                    <i class="fa fa-check-square-o fa-2x"></i>
                                                    <span class="title"> خارجی </span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group col-md-12 mb-10">
                                        <button type="submit" name="search_btn" class="btn btn-1 width100">اعمال فیلتر
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class=" col-12">

                        @if(count($Tours)>0)
                        <!-- <div class="pillarHide" style="width: 1px; height: 1px; display: inline-block"></div>
                                <div class="pillar box-shadow" >
                                    <span class="pillar-price">قیمت</span>
                                    <span class="pillar-beginning">مبدا</span>
                                    <span class="pillar-destination">مقصد</span>
                                    <span class="pillar-length">مدت</span>
                                    <span class="tours-items pillar-date showcol">تاریخ رفت</span>
                                    <span class="tours-items pillar-airline">روش سفر</span>
                                    <span class="pillar-agency">آژانس</span>
                                    <span class="pillar-details nobrd">جزيیات</span>
                                </div> -->
                        @endif
                        <!-- <ul class="listoftours">
                                @forelse($Tours as $key=>$value)
                                    <li class="travellist box-shadow hybrid-tours">
                                        <div class="tours-items pillar-price">
                                      <span class="linAl text-center">
                                          <span class="brAc">
                                              <span>
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
                                                            if($price < $min ) {
                                                                $min=$price;
                                                                @$dollar=$value->prices[$keyPrice]->price_dollar;
                                                                @$currencyMoment=$value->prices[$keyPrice]->currency;
                                                             }
                                                        @endphp
                                                    @endforeach
                                                    @if($min > 0)
                                                    شروع قیمت از  {{ number_format($min) }} تومان
                                                        @if(isset($dollar))
                                                           + {{ $dollar }} {{ @config('defines.currency')[@$currencyMoment] }}
                                                         @endif
                                                    @else
                                                    تماس جهت قیمت
                                                    @endif
                                                @elseif(count($value->prices) == 1)
                                                    @if($value->prices[0]->price > 0)
                                                    شروع قیمت از    {{ number_format($value->prices[0]->price) }}
                                                    تومان
                                                    @else
                                                    تماس جهت قیمت
                                                    @endif
                                                    @if(@$value->prices[0]->price_dollar and $value->prices[0]->price > 0)
                                                     + <i>{{@$value->prices[0]->price_dollar}} {{ @config('defines.currency')[@$value->prices[0]->currency] }} </i>
                                                     @endif
                                                @else
                                                    تماس جهت قیمت
                                                @endif
                                              </span>
                                          </span>
                                      </span>
                                        </div>
                                        <div class="tours-items pillar-beginning">
                                            <span>{{ $value->city->title_fa }}</span>
                                        </div>
                                        <div class="tours-items pillar-destination">
                                      <span class="destination-1 color-b">
                                          <span>
                                              @php
                                                  $cities='';
                                              @endphp
                                              @foreach($value->cities as $keyCity=>$valueCity)
                                                  @php
                                                      if($valueCity->pivot->type == 'city')
                                                      {
                                                        $cities=$cities.$valueCity->title_fa.((count(json_decode($value->cities)) == ($keyCity + 1))? '' :' + ');
                                                      }
                                                  @endphp
                                              @endforeach
                                              {{ $cities }}
                                          </span>
                                      </span>
                                        </div>
                                        <div class="tours-items pillar-length">
                                      <span class="destination-1 color-b">
                                          <span>{{ $value->number_nights }} شب </span>
                                      </span>
                                        </div>
                                        <div title="31 فروردین 98, شنبه" class="tours-items pillar-date showcol">
                                        <span class="brAc">
                                            <span>{{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($value->start_in))  }}</span>
                                        </span>
                                        </div>
                                        <div title="هواپیمایی کاسپین" class="tours-items pillar-airline">
                                        <span class="brAc">
                                            <span>{{ getTravelMethod($value->travel_method).'-'. $value->vehicle_type  }}</span>
                                        </span>
                                        </div>
                                        <div title="دیاکو پرواز پارس" class="tours-items pillar-agency">
                                            <span class="text-center agancy-name">{{ $value->agency->company }}</span>
                                        </div>
                                        <div class="tours-items pillar-details whitebg">
                                            <a target="_blank" title="{{ $value->title }}"
                                               href="{{ url('Tour/'.$value->id) }}">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </li>
                                @empty
                                    <div id="NotSearchTour">
                                        <div class="imges">
                                            <img class="around-the-globe"
                                                 src="{{ url('img/icons8-around-the-globe-100.png') }}">
                                            <img class="clear-search"
                                                 src="{{ url('img/icons8-clear-search-100.png') }}">
                                        </div>
                                        <p class="not-found-hero">متاسفانه برای این مقصد برای تاریخ مورد نظر شما توری
                                            وجود ندارد.</p>
                                        <p class="p-1">تاریخ دیگری را جستجو کنید</p>
                                    </div>
                                @endforelse
                            </ul> -->
                        <!-- <div class="pillarHideBottom" style="width: 1px; height: 1px; display: inline-block"></div> -->


                        <div>

                            <ul style="padding:5px">
                                @forelse($Tours as $key=>$value)
                                <li class="tourListItem">
                                    <div class="row" style="height:100%">
                                        <div class="col-lg-3" style='   height:100%'>
                                            <span class="tour-add-fav-btn <?php if (session()->has('tourCompare') and in_array($value->id, array_unique(session()->get('tourCompare')))) {
                                                                                echo "fav-tour-active";
                                                                            } else {
                                                                                echo "";
                                                                            } ?>" data-tourid="{{ $value->id }}">افزودن به لیست مقایسه <i class="fa fa-check-square"></i></span>
                                            @if(@$value->imageThumb)
                                            <img class=" tourListImage" src="{{ url($value->imageThumb) }}" alt="{{$value->title}}">
                                            @else
                                            <img class=" tourListImage" src="/img/distination-3.jpg" alt="{{$value->title}}">
                                            @endif
                                        </div>
                                        <div class="col-lg-5" style='  height:100%'>
                                            <h6>{{ $value->title }}</h6>

                                            <span class="brAc mobile-tour-prices">
                                                <span style="color:#ff6e02;">
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
                                                        + <i>{{@$value->prices[0]->price_dollar}} {{ @config('defines.currency')[@$value->prices[0]->currency] }} </i>
                                                        @endif
                                                        @else
                                                        تماس جهت قیمت
                                                        @endif
                                                </span>
                                            </span>

                                            <p style="margin: 0 0 7px; ">
                                                آژانس : <span class="text-center agancy-name">{{ $value->agency->company }}</span>
                                            </p>


                                            <p style="margin: 0 0 7px; ">
                                                روش سفر : <span class="text-center agancy-name"> <span>{{ getTravelMethod($value->travel_method) }}</span></span>
                                            </p>

                                            <p style="margin: 0 0 7px; ">
                                                نوع وسیله نقلیه : <span class="text-center agancy-name"> <span>{{ $value->vehicle_type }}</span></span>
                                            </p>




                                            <!-- <p style="margin: 0 0 5px; ">
                                                <?php $i = 1 ?>
                                                @foreach($value->services ?? [] as $keyService=>$valueService)
                                                <?php if ($i == 5)  break; ?>
                                                <label style="display:inline-block !important; background-color:#e0e0e0; padding:5px; vertical-align:top !important; height:30px">
                                                    <img src="{{ url($valueService->icon) }}" style="width:15px; height:15px; display:inline-block">
                                                    <span style="display:inline-block; vertical-align:top; font-size:11px" class="title-service"> {{ $valueService->title }}</span>
                                                </label>
                                                <?php $i++; ?>
                                                @endforeach
                                            </p> -->

                                        </div>
                                        <div class="col-lg-4" style=' vertical-align:top;  height:100%'>
                                            <p style="margin: 0 0 8px;">
                                                <span class="brAc desktop-tour-Prices">
                                                    <span style="color:#ff6e02;">
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
                                                            + <i>{{@$value->prices[0]->price_dollar}} {{ @config('defines.currency')[@$value->prices[0]->currency] }} </i>
                                                            @endif
                                                            @else
                                                            تماس جهت قیمت
                                                            @endif
                                                    </span>
                                                </span>
                                            </p>
                                            <p style="margin: 0 0 8px; font-size:11px ">
                                                <i class="fa fa-map-marker"></i> مبدا : <span>{{ $value->city->title_fa }}</span>
                                            </p>

                                            <p style="margin: 0 0 8px;font-size:11px ">
                                                <i class="fa fa-calendar"></i> تاریخ رفت : <span>{{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($value->start_in))  }}</span>

                                            </p>

                                            <p style="margin: 0 0 7px; font-size:11px ">
                                                <i class="fa fa-calendar"></i> به مدت : <span>{{ $value->number_nights }} شب </span>
                                            </p>


                                            <a style="padding: 3px 15px; background-color:#ffd903; color:#383838; display: inline-block; width: 100%;     text-align: center;     border-radius: 2px;" target="_blank" title="{{ $value->title }}" href="{{ url('Tour/'.$value->id.'/'.$value->title) }}">
                                                مشاهده جزيیات تور <i class="fa fa-angle-left"></i>
                                            </a>

                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @php
                        $fullUrl= \Illuminate\Support\Facades\Request::fullUrl();
                        $request= \Illuminate\Support\Facades\Request::toArray();
                        @endphp
                        @if ($Tours->lastPage() > 1)
                        <div class="pagination">
                            <ul class="pagination">
                                <li class="page-item {{ ($Tours->currentPage() == 1) ? ' disabled' : '' }}">
                                    @if($Tours->currentPage() == 1)
                                    <span style="color: #a2a2a2;">قبلی</span>
                                    @else
                                    <a class="active" href="{{   $Tours->url($Tours->currentPage()-1) }}">قبلی</a>
                                    @endif
                                </li>
                                @for ($i = 1; $i <= $Tours->lastPage(); $i++)
                                    <li class=" page-item ">
                                        <a class="{{ ($Tours->currentPage() == $i) ? ' active' : '' }}" href="{{  $Tours->url($i) }}">{{ $i }}</a>
                                    </li>
                                    @endfor
                                    <li class="page-item {{ ($Tours->currentPage() == $Tours->lastPage()) ? ' disabled' : '' }}">
                                        @if($Tours->currentPage() == $Tours->lastPage())
                                        <span style="color: #a2a2a2;">بعدی</span>
                                        @else
                                        <a class="active" href="{{  $Tours->url($Tours->currentPage()+1)  }}">بعدی</a>
                                        @endif
                                    </li>
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('footer')

<script type="text/javascript">
    // $(window).scroll(function(e){

    //     var pillarOfssetTop=$('.pillarHide').offset().top;
    //     var pillarOfssetBottom=$('.pillarHideBottom').offset().top;
    //     var scrollWindows=$(this).scrollTop();
    //     scrollWindows+=55;

    //     console.log("offsetTop:"+pillarOfssetTop+ " scroll:"+scrollWindows+" bottom:"+pillarOfssetBottom);

    //     if(scrollWindows > pillarOfssetTop){
    //         $(".pillar").addClass('fixBill');
    //         $(".header-phone-number").hide();
    //     }

    //     pillarOfssetBottom-=30;
    //     if(scrollWindows > pillarOfssetBottom){
    //     $(".pillar").removeClass('fixBill');
    //     $(".header-phone-number").show();
    //     }

    //     if(scrollWindows < pillarOfssetTop){
    //         $(".pillar").removeClass('fixBill');
    //         $(".header-phone-number").show();
    //     }

    // });

    $(document).ready(function() {

        $('.vpd-input-group,.btn-delete-date').hover(function(){

            var monthName=$("input[name*='start_in']" ).val();

            if(monthName){
                $(".btn-delete-date").toggle();
            }

        });

        @if(@$maxPirceTotal)


        var slider = document.getElementById('noUiSlider');

        noUiSlider.create(slider, {
            start: [{{$minPirce}},{{ $maxPirce}}],
            format: {
                // 'to' the formatted value. Receives a number.
                to: function(value) {
                    return Math.ceil(value);
                },
                // 'from' the formatted value.
                // Receives a string, should return a number.
                from: function(value) {
                    return value;
                },
                decimals: 0

            },
            tooltips: true,
            step: 50000,
            connect: true,
            direction: 'rtl',
            range: {
                'min': 0,
                'max': {{$maxPirceTotal ?? 1}}
            }
        });

        slider.noUiSlider.on('update', function(values, handle) {

            var min = values[0];
            var max = values[1];

            $("#minPriceFilter").val(min);
            $("#maxPriceFilter").val(max);

        });


        @endif


        $(".btn-delete-date").click(function() {
            var url = "{{\URL::current()}}";
            $.ajax({
                url: '/removeFilterCityDate',
                type: 'GET',
                data: {
                    url: url
                },
                success: function(datas) {
                    location.href = datas;
                }
            });
        });


        window.onresize = function(event) {
            var width = $(document).width();
            if (width > 750) {
                $("#filterBoxDiv").slideDown(350);
            }
        };



        $('.tour-add-fav-btn').click(function() {
            var thisIS = $(this);

            var tourID = $(this).data('tourid');
            if (!$(this).hasClass('fav-tour-active')) {

                $.ajax({
                    url: '/favTourAdd',
                    type: 'POST',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'tourID': tourID
                    },
                    success: function(data) {
                        if (data == 'ok') {
                            thisIS.addClass('fav-tour-active');
                            $(".comparePopBox").fadeIn(194);
                        } else if (data == 'moreThenLimit') {
                            alert('بیشتر از 3 تور قابل مقایسه نمی باشد');
                        }
                    }
                });

            } else {

                $.ajax({
                    url: '/favTourRemove',
                    type: 'POST',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'tourID': tourID
                    },
                    success: function(data) {
                        thisIS.removeClass('fav-tour-active');
                        if (data == 'isZero') {
                            $(".comparePopBox").fadeOut(194);
                        }
                    }
                });

            }
        });


    });

    $(".filterBoxBtn").click(function() {
        var width = $(document).width();
        if (width <= 750) {
            $("#filterBoxDiv").slideToggle(350);
        }
    });
</script>

@endsection
