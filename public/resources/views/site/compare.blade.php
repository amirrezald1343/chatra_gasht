@extends('site.layout.site')
@section('meta')
<title> کلیک سفر -  قوانین کلیک سفر </title>

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
                    <h4 class="mb-20 col-12 compareh" > مقایسه تورها
                    </h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="content-box mb-20">
                                <div class="row">
                                    <div class="col-md-12">

                                        @if($favTours)
                                        <ul class="ulcl">
                                            @foreach($favTours as $key=>$value)
                                            <li class="tourListItem">
                                                <div class="row tourrow" >
                                                    <div class="col-lg-12" >
                                                        <span class="tour-rem-fav-btn <?php if (session()->has('tourCompare') and in_array($value->id, array_unique(session()->get('tourCompare')))) {
                                                                                            echo "fav-tour-active";
                                                                                        } else {
                                                                                            echo "";
                                                                                        } ?>" data-tourid="{{ $value->id }}"> حذف از لیست مقایسه <i class="fa fa-minus-square"></i></span>

                                                        @if(@$value->imageThumb)
                                                        <img class=" tourListImage" src="{{ url($value->imageThumb) }}">
                                                        @else
                                                        <img class=" tourListImage" src="/img/distination-3.jpg">
                                                        @endif
                                                    </div>
                                                    <div class="col-lg-12 titcomp"  >
                                                        <h6 >{{ $value->title }}</h6>


                                                        <span class="brAc mobile-tour-prices">
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

                                                        <br>
                                                        <br>

                                                        <p class="pagansyn">
                                                            آژانس : <span class="text-center agancy-name">{{ $value->agency->company }}</span>
                                                        </p>


                                                        <p class="parag" >
                                                            روش سفر : <span class="text-center agancy-name"> <span>{{ getTravelMethod($value->travel_method) }}</span></span>
                                                        </p>

                                                        <p class=parag"" >
                                                            نوع وسیله نقلیه : <span class="text-center agancy-name"> <span>{{ $value->vehicle_type }}</span></span>
                                                        </p>


                                                    </div>

                                                    <div class="col-lg-12 divmarker" >

                                                        <p class="markerp" >
                                                            <i class="fa fa-map-marker"></i> مبدا : <span>{{ $value->city->title_fa }}</span>
                                                        </p>

                                                        <p class="markerpb" >
                                                            <i class="fa fa-calendar"></i> تاریخ رفت : <span>{{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($value->start_in))  }}</span>

                                                        </p>

                                                        <p class="markerpc" >
                                                            <i class="fa fa-calendar"></i> به مدت : <span>{{ $value->number_nights }} شب </span>
                                                        </p>


                                                        <a  class="complink" target="_blank" title="{{ $value->title }}" href="{{ url('Tour/'.$value->id) }}">
                                                            مشاهده جزيیات تور <i class="fa fa-angle-left"></i>
                                                        </a>

                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>

                                        @else
                                           <h5> لیست مقایسه خالی میباشد </h5>
                                        @endif

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

<script>
    $('.tour-rem-fav-btn').click(function() {
        var thisIS = $(this);
        var tourID = $(this).data('tourid');
        $.ajax({
            url: '/favTourRemove',
            type: 'POST',
            data: {
                '_token': "{{ csrf_token() }}",
                'tourID': tourID
            },
            success: function(data) {
                window.location.reload();
            }
        });

    });
</script>

@endsection
