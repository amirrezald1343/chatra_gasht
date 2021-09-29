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
                                    <div class="row justify-content-center index-slogan ">
                                        <div class="col-11 text-center coldivh">

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
                                <nav>
                                    <div class="nav nav-tabs nav-tabs3" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">پرواز</a>
                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">تور</a>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">


                                        <div class="tab-pane active show  pr-3 pr-md-0  pl-3 pl-md-0 " id="flight">
                                            <form  @click="formFlightIndex"   action="{{ url('flights') }}" method="get" class="order-form filter-form filter-form-slider ">

                                                    <div class="row" style="direction: rtl !important;text-align: center;">

                                                        <div class="col-md-5 col-lg-4  pl-md-1">
                                                            <div class="form-group">
                                                                <v-select

                                                                    :options="[@foreach($cities as $citykey=>$cityvalue)
                                                                        { countryCode: '{{$cityvalue}}', countryName: '{{$citykey}}' },
                                                                          @endforeach]"
                                                                    dir="{{ $dir }}"
                                                                    placeholder="{{ __('flight.From') }}"
                                                                    :components="{DeselectFlight}"
                                                                    v-model="from_city_flight"
                                                                    @if(old('fromCityFlight')) v-init:from_city_flight="{ countryCode: '{{old('fromCityFlight')}}', countryName: '{{   array_flip($cities)[old('fromCityFlight')]  }}' }"
                                                                    @endif
                                                                    label="countryName"
                                                                    v-cloak
                                                                >
                                                <span slot="no-options"
                                                      class="no-found-search">{{ __('flightb.No cities found') }}</span>
                                                                </v-select>
                                                                <input name="fromCityFlight"
                                                                       type="hidden"
                                                                       v-model="fromCityFlightCode">
                                                                {!! getError($errors,'fromCityFlight') !!}
                                                                <i class="icon-spin6 position-absolute"
                                                                   aria-hidden="true"
                                                                   :class="(index.search.from.loading) ? 'animate-spin' : 'd-none'"></i>
                                                                <ul class="search-results-flight"
                                                                    v-show="index.search.from.res.count > 0 && index.search.from.showPanel">
                                                                    <li v-for="item in index.search.from.res.items"
                                                                        @click="index.search.from.choosing = item.iata;index.search.from.showPanel = false;index.search.from.city = item.en_city;switchFocus('toCityFlight')">
                                                                        @{{ item.name +' - '+ item.en_country + ' - ' + item.en_city }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto p-0 ">
                                                            <div class="box-icon-exchange ">
                                                                <i  @click="exchangeFlightRoute" class="icon-exchange"></i>
                                                            </div>
                                                        </div>
                                                        <div  class="col-md-5 col-lg-4 pr-md-1">
                                                            <div class="form-group" id="to_city_flight">
                                                                <v-select
                                                                    :options="
                                                            [@foreach($cities as $citykey=>$cityvalue)
                                                                        { countryCode: '{{$cityvalue}}', countryName: '{{$citykey}}' },
                                                             @endforeach]"
                                                                    placeholder="{{ __('flight.To') }}"
                                                                    :components="{DeselectFlight}"
                                                                    dir="{{ $dir }}"
                                                                    v-model="to_city_flight"
                                                                    @if(old('fromCityFlight')) v-init:to_city_flight="{ countryCode: '{{old('toCityFlight')}}', countryName: '{{ (old('toCityFlight')) ?  array_flip($cities)[old('toCityFlight')] :''  }}' }"
                                                                    @endif
                                                                    label="countryName"

                                                                    v-cloak
                                                                >
                                                <span slot="no-options"
                                                      class="no-found-search">{{ __('flightb.No cities found') }}</span>
                                                                </v-select>
                                                                <input name="toCityFlight"
                                                                       type="hidden"
                                                                       v-model="toCityFlightCode">
                                                                {!! getError($errors,'toCityFlight') !!}
                                                                <i class="icon-spin6 position-absolute" aria-hidden="true"
                                                                   :class="(index.search.to.loading) ? 'animate-spin' : 'd-none'"></i>
                                                                <ul class="search-results-flight"
                                                                    v-show="index.search.to.res.count > 0 && index.search.to.showPanel">
                                                                    <li v-for="item in index.search.to.res.items"
                                                                        @click="index.search.to.choosing = item.iata;index.search.to.showPanel = false;index.search.to.city = item.en_city;switchFocus('fromDateFlight')">
                                                                        @{{ item.name +' - '+ item.en_country + ' - ' + item.en_city }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-5 col-lg-3  ivi3calendar pr-md-0 ">
                                                            <div id="flight-date-start"  class="form-group flightDateReturn" >
                                                                <input type="hidden" v-model="start_date_form_flight"  v-init:start_date_form_flight="'{{ old('fromDateFlight') }}'" />
                                                                <date-picker
                                                                    v-model="start_date_form_flight"
                                                                    display-format="jYYYY/jMM/jDD"
                                                                    :auto-submit="true"
                                                                    :color="color"
                                                                    locale="fa,en"
                                                                    placeholder="{{ __('flight.From Date') }}"
                                                                    id="flight-date"
                                                                    min="{{ Morilog\Jalali\Jalalian::now()->format('Y/m/d H:i') }}"
                                                                    name="fromDateFlight"
                                                                    v-cloak
                                                                ></date-picker>
                                                                {!! getError($errors,'fromDateFlight') !!}
                                                            </div>
                                                        </div>


                                                        {{--<div class="col-md-5  col-lg-2   pr-md-0">--}}
                                                            {{--<div class=" form-group" data-increment="Passengers">--}}
                                                                {{--<label><i class="icon-user-7"></i> {{ __('flightb.Passengers') }}</label>--}}
                                                                {{--<input--}}
                                                                    {{--id="passengers-form-flight-index"--}}
                                                                    {{--@click="listflight.form.passenger = true ; listflight.form.click = true"--}}
                                                                    {{--:value="numberpassenger + {{ "' ". __('flightb.Passengers')." '" }} "--}}
                                                                    {{--class="form-control"--}}
                                                                    {{--type="text"--}}
                                                                    {{--readonly--}}
                                                                    {{--v-init:numberpassenger="{{ (old('adults') ?? '1') + old('children') + old('baby') }}">--}}
                                                                {{--{!! getError($errors,'adults') !!}--}}
                                                                {{--<input type="hidden" name="adults" :value="adults"--}}
                                                                       {{--v-init:adults="{{ old('adults') ?? '1' }}">--}}
                                                                {{--<input type="hidden" name="children" :value="children"--}}
                                                                       {{--v-init:children="{{ old('children') ?? '0' }}">--}}
                                                                {{--<input type="hidden" name="baby" :value="baby"--}}
                                                                       {{--v-init:baby="{{ old('baby') ?? '0' }}">--}}
                                                                {{--<div @click="listflight.form.click = true"--}}
                                                                     {{--v-show="listflight.form.passenger" class="quantity-selector-box"--}}
                                                                     {{--id="FlySearchPassengers">--}}
                                                                    {{--<div class="quantity-selector-inner">--}}
                                                                        {{--<ul class="quantity-selector-controls">--}}
                                                                            {{--<li class="quantity-selector-title">{{ __('flightb.Adults') }}--}}
                                                                                {{--<small class="passenger-color">--}}
                                                                                    {{--({{ __('flightb.12 years old') }})--}}
                                                                                {{--</small>--}}
                                                                            {{--</li>--}}
                                                                            {{--<li class="quantity-selector-decrement float-number-passnger ">--}}
                                                        {{--<span @click="passengerPlus('adults')"--}}
                                                              {{--class="plase-passnger"></span>--}}
                                                                            {{--</li>--}}
                                                                            {{--<li class="quantity-selector-current float-number-passnger "--}}
                                                                                {{--v-text="adults"></li>--}}
                                                                            {{--<li class="quantity-selector-increment float-number-passnger ">--}}
                                                        {{--<span @click="passengerZiro('adults')"--}}
                                                              {{--class="mines-passnger"></span>--}}
                                                                            {{--</li>--}}
                                                                        {{--</ul>--}}
                                                                        {{--<ul class="quantity-selector-controls">--}}
                                                                            {{--<li class="quantity-selector-title">{{ __('flightb.Children') }}--}}
                                                                                {{--<small class="passenger-color">--}}
                                                                                    {{--({{ __('flightb.2 to 12 years') }})--}}
                                                                                {{--</small>--}}
                                                                            {{--</li>--}}

                                                                            {{--<li class=" float-number-passnger quantity-selector-decrement">--}}
                                                        {{--<span @click="passengerPlus('children')"--}}
                                                              {{--class="plase-passnger"></span>--}}
                                                                            {{--</li>--}}
                                                                            {{--<li class=" float-number-passnger quantity-selector-current"--}}
                                                                                {{--v-text="children"></li>--}}
                                                                            {{--<li class=" float-number-passnger quantity-selector-increment">--}}
                                                        {{--<span @click="passengerZiro('children')"--}}
                                                              {{--class="mines-passnger"></span>--}}
                                                                            {{--</li>--}}
                                                                        {{--</ul>--}}
                                                                        {{--<ul class="quantity-selector-controls">--}}
                                                                            {{--<li class="quantity-selector-title">{{ __('flightb.Baby') }}--}}
                                                                                {{--<small class="passenger-color">--}}
                                                                                    {{--({{ __('flightb.10 days to 2 years') }})--}}
                                                                                {{--</small>--}}
                                                                            {{--</li>--}}
                                                                            {{--<li class=" float-number-passnger  quantity-selector-decrement ">--}}
                                                        {{--<span @click="passengerPlus('baby')"--}}
                                                              {{--class="plase-passnger"></span>--}}
                                                                            {{--</li>--}}
                                                                            {{--<li class=" float-number-passnger quantity-selector-current"--}}
                                                                                {{--v-text="baby"></li>--}}
                                                                            {{--<li class=" float-number-passnger   quantity-selector-increment">--}}
                                                        {{--<span @click="passengerZiro('baby')"--}}
                                                              {{--class="mines-passnger  "></span>--}}
                                                                            {{--</li>--}}
                                                                        {{--</ul>--}}
                                                                        {{--<ul v-if="this.listflight.form.errorePassnger != ''"--}}
                                                                            {{--class="quantity-selector-controls mb-0">--}}
                                                                            {{--<li class="errore-passnger"><i class="icon-error-alt"></i>--}}
                                                                                {{--<div class="error"--}}
                                                                                     {{--v-text="this.listflight.form.errorePassnger"></div>--}}
                                                                            {{--</li>--}}
                                                                        {{--</ul>--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                        <div class="col-md-5  col-lg-1    pl-md-0 text-center ">
                                                            <div class="form-group">

                                                                <button  value="index" type="submit" name="submit" class="submit-form-search-tour btn btn-1 width100" style="float: right !important ;"><i class="fa fa-search searchcn"></i></button>
                                                            </div>
                                                        </div>


                                                    </div>

                                            </form>
                                        </div>





                                        {{--<form action="{{ url('Tours') }}" method="get" id="form-search-tour"--}}
                                              {{--class="order-form filter-form filter-form-slider " data-animation="fadeInUp"--}}
                                              {{--data-timeout="1000">--}}
                                            {{--<div class="form-row">--}}

                                                {{--<div class="form-group col-md-3">--}}
                                                    {{--<v-select :options="options" @search="onSearch" dir="rtl" label="title_fa"--}}
                                                              {{--v-model="value_destination_tour" placeholder="مقصد را وارد کنید"--}}
                                                              {{--@if(old('destination') and old('destination') !='null' ) v-init:value_destination_tour="{ id: '{{  json_decode(old('destination'))->id   }}', title_fa: '{{     json_decode(old('destination'))->title_fa  }}' }" @endif>--}}
                                                        {{--<template slot="no-options">هیچ موردی یافت نشد..</template>--}}
                                                        {{--<template slot="option" slot-scope="option">--}}
                                                            {{--<div class="d-center">--}}
                                                                {{--@{{ option.title_fa }}--}}
                                                            {{--</div>--}}
                                                        {{--</template>--}}
                                                        {{--<template slot="selected-option" slot-scope="option">--}}
                                                            {{--<div class="selected d-center">--}}
                                                                {{--@{{ option.title_fa }}--}}
                                                            {{--</div>--}}
                                                        {{--</template>--}}
                                                    {{--</v-select>--}}
                                                    {{--<input name="destination" type="hidden" v-model="valueDestinationTour">--}}
                                                    {{--{!! getError($errors,'destination') !!}--}}


                                                {{--</div>--}}
                                                {{--<div class="form-group col-md-3">--}}
                                                    {{--<v-select :options="options" @search="onSearch" dir="rtl" label="title_fa"--}}
                                                              {{--v-model="value_destination_tour" placeholder="مقصد را وارد کنید"--}}
                                                              {{--@if(old('destination') and old('destination') !='null' ) v-init:value_destination_tour="{ id: '{{  json_decode(old('destination'))->id   }}', title_fa: '{{     json_decode(old('destination'))->title_fa  }}' }" @endif>--}}
                                                        {{--<template slot="no-options">هیچ موردی یافت نشد..</template>--}}
                                                        {{--<template slot="option" slot-scope="option">--}}
                                                            {{--<div class="d-center">--}}
                                                                {{--@{{ option.title_fa }}--}}
                                                            {{--</div>--}}
                                                        {{--</template>--}}
                                                        {{--<template slot="selected-option" slot-scope="option">--}}
                                                            {{--<div class="selected d-center">--}}
                                                                {{--@{{ option.title_fa }}--}}
                                                            {{--</div>--}}
                                                        {{--</template>--}}
                                                    {{--</v-select>--}}
                                                    {{--<input name="destination" type="hidden" v-model="valueDestinationTour">--}}
                                                    {{--{!! getError($errors,'destination') !!}--}}
                                                {{--</div>--}}
                                                {{--<div class="form-group col-md-3 p-relative">--}}
                                                    {{--<date-picker value=""--}}
                                                                 {{--initial-value=""--}}
                                                                 {{--display-format="jMMMM" :auto-submit="true" locale="fa"--}}
                                                                 {{--name="start_in" placeholder="انتخاب ماه" type="month"--}}
                                                                 {{--color="#ffda0c">--}}
                                                    {{--</date-picker>--}}
                                                    {{--{!! getError($errors,'start_in') !!}--}}
                                                {{--</div>--}}
                                                {{--<div class="form-group col-md-2">--}}
                                                    {{--<v-select :options="options" @search="onSearch" dir="rtl" label="title_fa"--}}
                                                              {{--v-model="value_destination_tour" placeholder="مقصد را وارد کنید"--}}
                                                              {{--@if(old('destination') and old('destination') !='null' ) v-init:value_destination_tour="{ id: '{{  json_decode(old('destination'))->id   }}', title_fa: '{{     json_decode(old('destination'))->title_fa  }}' }" @endif>--}}
                                                        {{--<template slot="no-options">هیچ موردی یافت نشد..</template>--}}
                                                        {{--<template slot="option" slot-scope="option">--}}
                                                            {{--<div class="d-center">--}}
                                                                {{--@{{ option.title_fa }}--}}
                                                            {{--</div>--}}
                                                        {{--</template>--}}
                                                        {{--<template slot="selected-option" slot-scope="option">--}}
                                                            {{--<div class="selected d-center">--}}
                                                                {{--@{{ option.title_fa }}--}}
                                                            {{--</div>--}}
                                                        {{--</template>--}}
                                                    {{--</v-select>--}}
                                                    {{--<input name="destination" type="hidden" v-model="valueDestinationTour">--}}
                                                    {{--{!! getError($errors,'destination') !!}--}}
                                                {{--</div>--}}
                                                {{--<div class="form-group col-md-1">--}}
                                                    {{--<button type="submit" class="submit-form-search-tour btn btn-1 width100">--}}
                                                        {{--<i class="fa fa-search searchcn"></i>--}}
                                                    {{--</button>--}}
                                                {{--</div>--}}

                                            {{--</div>--}}
                                        {{--</form>--}}


                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                                        <form action="{{ url('Tours') }}" method="get" id="form-search-tour"
                                                                                                                                                                        class="order-form filter-form filter-form-slider " data-animation="fadeInUp"
                                                                                                                                                                        data-timeout="1000">
                                            <div class="form-row">

                                                <div class="form-group col-md-6">
                                                    <v-select :options="optionsb" @search="onSearch" dir="rtl" label="title_fa"
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
                                                <div class="form-group col-md-5 p-relative">
                                                    <date-picker value=""
                                                                 initial-value=""
                                                                 display-format="jMMMM" :auto-submit="true" locale="fa"
                                                                 name="start_in" placeholder="انتخاب ماه" type="month"
                                                                 color="#ffda0c">
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

                                </div>



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


        <div class="main-block" id="ToursMoment">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center block width100 mb-50 block-title">
                            <div class="text-center block width100 mb-50 block-title">
                                <h5> جدیدترین تور ها </h5>
                                <div class="separator"><span> جدیترین تورهای داخلی , خارجی </span></div>
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

        <div class="container">
            <div class="ctoa text-center parallax-container color-gray">
                <div class="row">
                    <div class="col-lg-6 col-lg-6 mb-20">
                        <h2 class="mb-30 apph"> اپلیکیشن کلیک سفر </h2>
                        <p class="mb-20"> پیشنهاد ما تورهای ارزان و متفاوت از آژانس های تمام ایران </p>
                        <p class="mb-20"> با جستجو در کلیک سفر همیشه بهترین نتیجه را خواهید دید </p>
                        <a class="mb-20 android-googleplay-btn" target="_blank"
                           href="https://play.google.com/store/apps/details?id=com.it.mahab.clicksafar">
                            <img class="paralleximg " src="{{url("/img/google-play-badge-3.png")}}"/>
                        </a>
                        <a class="mb-20 android-googleplay-btn" target="_blank"
                           href="https://cafebazaar.ir/app/com.it.mahab.clicksafar">
                            <img class="paralleximg " src="{{url("/img/bazar2.png")}}"
                                 style="width:120px;height: 36px;"/>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <img src="/img/app4.jpg" width="100%" height="400" alt="" class="lazy2">
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
                                        <a target="_blank" href="{{ url('Tour/'.$post->id).'/'.$post->title }}">
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

