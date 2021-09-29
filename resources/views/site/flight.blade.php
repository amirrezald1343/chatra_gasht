@extends('site.layout.site')
@section('meta')
    <title>پرواز</title>

@endsection
@section('head')
    <link href="{{ url("css/site/pages/index.css") }}" rel="stylesheet">
    <link href="{{ url("css/site/scss/navbarmodal.css") }}" rel="stylesheet">
    <script src="{{ url("js/site/navbarmodal.js") }}"></script>

@endsection
@section('content')


    <main id="index">


        <div class="main-block">


            <div id="flight">

                <div class="container">

                    <div class="row">
                        <div class="col-lg-12">

                            <div class="searchdiv">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <i class="fa fa-map-marker map-marker2"></i><input type="text" class="destination"
                                                                                           placeholder="  از کجا">

                                        <i class="fa fa-map-marker map-marker2"></i> <input type="text" class="origin"
                                                                                            placeholder=" به کجا">
                                    </div>

                                    <div class="col-lg-4"><i class="fa fa-calendar map-marker2"></i> <input type="text"
                                                                                                            class="ddate">
                                        <button class="btn btn-info">جستجو</button>
                                    </div>
                                    <div class="col-lg-2">
                                        <button class="btn btn-info">روز قبل</button>
                                        <button class="btn btn-info">روز بعد</button>
                                    </div>
                                </div>

                            </div>




                        </div>
                    </div>

                    <br>


                    <div class="row">
                        <div class="col-lg-3" style="border:1px solid white;">

                            <div style="min-height: 1200px;">

                                <div aria-multiselectable="true" id="accordion" role="tablist">
                                    <div class="card">
                                        <div class="card-header" id="headingOne" role="tab">
                                            <h5 class="mb-0"><a aria-controls="collapseOne" aria-expanded="true"
                                                                data-parent="#accordion" data-toggle="collapse"
                                                                href="#collapseOne">#1</a></h5>
                                        </div>
                                        <div aria-labelledby="headingOne" class="collapse show" id="collapseOne"
                                             role="tabpanel">
                                            <div class="card-block">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                                                terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                                skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
                                                Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid
                                                single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh
                                                helvetica, craft beer labore wes anderson cred nesciunt sapiente ea
                                                proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                                                beer farm-to-table, raw denim aesthetic synth nesciunt you probably
                                                haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingTwo" role="tab">
                                            <h5 class="mb-0"><a aria-controls="collapseTwo" aria-expanded="false"
                                                                class="collapsed" data-parent="#accordion"
                                                                data-toggle="collapse" href="#collapseTwo"> #2</a></h5>
                                        </div>
                                        <div aria-labelledby="headingTwo" class="collapse" id="collapseTwo"
                                             role="tabpanel">
                                            <div class="card-block">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                                                terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                                skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
                                                Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid
                                                single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh
                                                helvetica, craft beer labore wes anderson cred nesciunt sapiente ea
                                                proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                                                beer farm-to-table, raw denim aesthetic synth nesciunt you probably
                                                haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="headingThree" role="tab">
                                            <h5 class="mb-0"><a aria-controls="collapseThree" aria-expanded="false"
                                                                class="collapsed" data-parent="#accordion"
                                                                data-toggle="collapse" href="#collapseThree"> #3</a>
                                            </h5>
                                        </div>
                                        <div aria-labelledby="headingThree" class="collapse" id="collapseThree"
                                             role="tabpanel">
                                            <div class="card-block">
                                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
                                                terry richardson ad squid. 3 wolf moon officia aute, non cupidatat
                                                skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
                                                Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid
                                                single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh
                                                helvetica, craft beer labore wes anderson cred nesciunt sapiente ea
                                                proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                                                beer farm-to-table, raw denim aesthetic synth nesciunt you probably
                                                haven't heard of them accusamus labore sustainable VHS.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="col-lg-9" style="border:1px solid white;">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="owl-carousel owl-theme">


                                        <div class="item">
                                            <div class="datetime">

                                                <div class="datediv">
                                                    <span class="spandate">شنبه</span>
                                                    <br>
                                                    <span class="spandate datd">   30 آذر</span>
                                                    <br>
                                                    <span class="spandate prdate"  >250000</span>

                                                    <br>
                                                    <span class="spandate vaheddate">تومان</span>

                                                </div>

                                            </div>
                                        </div>


                                    </div>


                                </div>

                            </div>

                            <div class="row">

                                <div class="col-lg-12">

                                    <div class="boxagn">

                                        <div class="row">

                                            <div class="col-lg-3">19980 تومان</div>
                                            <div class="col-lg-2"><img src="" alt="" class="airline"></div>
                                            <div class="col-lg-2">05:30 </div>
                                            <div class="col-lg-3"><div style="background: url('img/none-stop.png') no-repeat;"></div></div>
                                            <div class="col-lg-2">06:30</div>

                                        </div>

                                        <div class="row">

                                            <div class="col-lg-9 ">شماره پرواز:24989</div>
                                            <div class="col-lg-3">kkk</div>


                                        </div>


                                    </div>

                                </div>


                            </div>

                        </div>
                        {{--<div class="col-lg-2" style="border:1px solid white;">ttt</div>--}}
                    </div>


                </div>
            </div>


        </div>

    </main>
@endsection
@section('footer')

    <script>
        $('.owl-carousel').owlCarousel({
            rtl: true,
            responsiveClass: true,
            loop: true,
            margin: 3,
            nav: true,
            autoplay: true,
            rtl: true,
            responsive: {
                0: {
                    items: 3
                },
                600: {
                    items: 6
                },
                1000: {
                    items: 8
                }
            }
        });

    </script>



@endsection
