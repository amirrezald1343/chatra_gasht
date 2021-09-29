@extends('site.layout.site')
@section('meta')
    <title> کلیک سفر - جستجو و فیلتر تورها </title>
    <meta name="description"
          content="تور خارجي و داخلي کليک سفر خاطره يک سفر رويايي را براي شما به ارمغان خواهند آورد. لحظه آخري مشهد،کيش،اروپا، آفريقا، شرق آسيا يا خاورميانه، گرجستان، استانبول، دبي، فرانسه، ايتاليا، اسپانيا"/>
    <meta name="keywords"
          content="گردشگری,طبیعت گردی,تور,ترکیه,ایران,ارمنستان,تورهای خارحی,تورهای داخلی,بوم گردی,لحضه آخری,سفر,توریست,توریسم">


@endsection
@section('head')
    <link href="{{ url("css/site/pages/index.css") }}" rel="stylesheet">
    <link href="{{ url("css/site/pages/tourList.css") }}" rel="stylesheet">



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
            height: auto;
            min-height: 75px;
            margin-top: 15px;
            margin-right: 0px !important;
            margin-bottom: 0px !important;
            margin-left: 0px !important;
            border: 1px solid rgb(247, 247, 247);
            background-color: white;
            text-align: center;
        }

        .tourListItem .show-details-btn {
            cursor: pointer;
            position: absolute;
            margin-top: -35px;
            font-size: 20px;
            color: #ff6c03;
        }

        .tourListItem .items-div {
            padding: 4px;
            margin-top: 20px;
            max-height: 450px;
            overflow-y: auto;
            position: relative;
            overflow-x: hidden;
            display: none;
            border-top: 1px solid gray;
        }

        .tourListItem .items-row div {
            text-align: right;
            padding: 8px;
        }

        .tourListItem .items-row {
            background-color: #f9f9f9;
            margin-top: 5px;
        }


        .tourListImage {
            width: 100%;
            height: 100%;
            margin: 0px;
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

        .desktop-tour-Prices {
        }

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


        .center {
            text-align: center;
        }

        .tld {
            text-align: right;
        }

        /* @media screen and (max-width:768px) {
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

            .formFilterTop {
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

    */

        .gash-images {
            width: 100%;
        }

        @media screen and (max-width: 575px) {

            .tld {
                text-align: center;
            }

            .gash-images {
                padding: 50px;
            }


        }
        .searchindex {
            background-size: 100% 100%;
            background-blend-mode: multiply;
            height: 500px;
        }


    </style>


@endsection
@section('content')


    <main id="tourList">
        <div class="search-relative divimgtour searchindex" style="background-image: url(img/slidtour.jpg); ">
            <!-- slider -->
            <div class="" id="fullscreen-slider">
                <div class="item height100vh heightCustomVh">
                    <div class="page-head-wrap">
                        <div class="page-head-inner">
                            <div class="page-head-caption container text-right">
                                <div class="container">
                                    <div class="row justify-content-center index-slogan">
                                        <div class="col-11 text-center divclick ">
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

                            <form action="{{ url('gashts') }}" method="get" id="form-search-tour"
                                  class="order-form filter-form filter-form-slider " data-animation="fadeInUp"
                                  data-timeout="1000">
                                <div class="form-row formFilterTop">
                                    <div class="form-group col-md-7">
                                        <v-select :options="options" @search="onSearch" dir="rtl" label="title_fa"
                                                  v-model="value_destination_tour" placeholder="مقصد را وارد کنید"
                                                  v-init:value_destination_tour="{ id: '{{   @json_decode(@$destinationBack)->id ?? @json_decode(@$destinationBack)->id   }}', title_fa: '{{ @json_decode(@$destinationBack)->title_fa ?? @json_decode(@$destinationBack)->title_fa }}' }">
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
                                        <input name="destination" type="hidden" v-model="valueDestinationTour" >
                                        {!! getError($errors,'destination') !!}
                                    </div>
                                    <div class="form-group col-md-4 p-relative">


{{--                                        @dd($monthNumber)--}}

                                        <date-picker
                                           value="@isset($monthNumber) {{$monthNumber}} @endisset"
                                            initial-value=""
                                            display-format="jYYYY/jMM/jDD"
                                            :auto-submit="true"
                                            locale="fa"
                                            name="start_in"
                                            placeholder="انتخاب روز"
                                            type="date"
                                           color="#db34eb"
                                        ></date-picker >
                                        {!! getError($errors,'start_in') !!}
                                        <span class="fa fa-close btn-delete-date"></span>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <button type="submit" class="submit-form-search-tour btn btn-1 ">
                                            <i class="fa fa-search searchcn"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        <!-- / filter horizontal form -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- / order form -->
        </div> <!-- / search-relative -->


        <div class="content mt-2 mb-40 container-fluid mt-60">
            <div class="row">

                <div class="col-md-10 offset-md-1">
                    <div class="row">
                        <div class=" col-12">

                            <h5 class="center">لیست پکیج های گشت</h5>

                            <ul class="ulgasht">
                                @forelse($gashts as $key=>$value)
                                    <li class="tourListItem">
                                        <div class='row'>
                                            <div class="col-lg-2 col-md-3 col-sm-3 col-12 ">
                                                <img class="gash-images" src="{{url("/$value->image")}}">
                                            </div>
                                            <div class='col-lg-4 col-md-3 col-sm-4 col-12 tld'>
                                                {{$value->title}}
                                                <br>
                                                <i class="fa fa-map-marker"></i> {{$value->city->title_fa}}
                                                <br>
                                                <i class="fa fa-calendar"></i> {{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($value->date))  }}
                                            </div>
                                            <div class='col-lg-3 col-md-3 col-sm-4 col-12 tld'>
                                                <i class="fa fa-building"></i> {{$value->agency->company}}
                                                <br>
                                                <i class="fa fa-phone"></i> {{$value->agency->tellPhone}}
                                                <br>
                                                    {{$value->agency->domain}}
                                            </div>
                                            <div class='col-lg-3 col-md-3 col-sm-12 col-12 tld'>

                                                <i class="fa fa-dollar"></i> قیمت بزرگسال
                                                : {{number_format($value->adult)}} تومان
                                                <br>
                                                <i class="fa fa-dollar"></i> قیمت خردسال
                                                : {{number_format($value->child)}} تومان
                                                <br>
                                                <a href=""></a>
                                                <br>
                                                <a
                                                    @if($value->agency->id=='140')
                                                    href="https://{{$value->agency->domain}}"
                                                    @else
                                                    href="{{ "https://worldfly.ir/fa/gashtDetails/".$value->id}}"
                                                    @endif
                                                    class="btn btnshop" type="button" target="_blank">خرید آنلاین </a>
                                            </div>
                                        </div>
                                        <div class="detailmore">
                                            <p class="detail p-0 m-0">  جزئیات بیشتر</p>
                                            <p class="p-0 m-0">
                                                <i class="fa fa-angle-down  show-details-btn"></i>
                                            </p>
                                        </div>


                                        <div class="items-div">
                                            <div class="row">
                                                <div class="col-xl-12 col-12 divservice">

                                                    <p><strong> توضیحات : </strong> {{$value->desc}} </p>

                                                </div>
                                                <div class="col-xl-12 col-12 divservice">

                                                    <p><strong> خدمات
                                                            : </strong> <?php echo ($value->services) ? $value->services : '- - -'  ?>
                                                    </p>

                                                </div>

                                                <div class="col-xl-12 col-12 divservice">

                                                    <p><strong> لوازم مورد نیاز
                                                            : </strong> <?php echo ($value->supplies) ? $value->supplies : '- - -'  ?>
                                                    </p>

                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                            </ul>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            @php
                                $fullUrl= \Illuminate\Support\Facades\Request::fullUrl();
                                $request= \Illuminate\Support\Facades\Request::toArray();
                            @endphp
                            @if ($gashts->lastPage() > 1)
                                <div class="pagination">
                                    <ul class="pagination">
                                        <li class="page-item {{ ($gashts->currentPage() == 1) ? ' disabled' : '' }}">
                                            @if($gashts->currentPage() == 1)
                                                <span class="previus">قبلی</span>
                                            @else
                                                <a class="active" href="{{   $gashts->url($gashts->currentPage()-1) }}">قبلی</a>
                                            @endif
                                        </li>
                                        @for ($i = 1; $i <= $gashts->lastPage(); $i++)
                                            <li class=" page-item ">
                                                <a class="{{ ($gashts->currentPage() == $i) ? ' active' : '' }}"
                                                   href="{{  $gashts->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor
                                        <li class="page-item {{ ($gashts->currentPage() == $gashts->lastPage()) ? ' disabled' : '' }}">
                                            @if($gashts->currentPage() == $gashts->lastPage())
                                                <span class="previus">بعدی</span>
                                            @else
                                                <a class="active" href="{{  $gashts->url($gashts->currentPage()+1)  }}">بعدی</a>
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

        $(document).ready(function () {

            $(".show-details-btn").click(function (e) {

                var thisIs = $(this);

                $(".items-div").closest('.tourListItem').find(".show-details-btn").not(thisIs).closest('.tourListItem').find('.items-div').slideUp(150);
                $(".items-div").closest('.tourListItem').find(".show-details-btn").not(thisIs).closest('.tourListItem').find('.show-details-btn').css("transform", "rotate(180deg)");

                var myvar = $(e.target).attr("class");
                var getclass = myvar.indexOf("fa-angle-down");
                if (getclass >= 0) {
                    $(e.target).removeClass("fa-angle-down");
                    $(e.target).addClass("fa-angle-up");
                } else {
                    $(e.target).removeClass("fa-angle-up");
                    $(e.target).addClass("fa-angle-down");
                }
                //  alert($(e.target).attr("class"));


                thisIs.closest('.tourListItem').find('.items-div').slideToggle(150);
                // thisIs.closest('.tourListItem').find('.show-details-btn').css("transform", "rotate(180deg)");


            });

        });
    </script>

@endsection
