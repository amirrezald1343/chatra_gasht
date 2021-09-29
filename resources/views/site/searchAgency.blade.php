@extends('site.layout.site')
@section('meta')
<title> کلیک سفر - جستجوی آژانس </title>

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
                    <h4 class="mb-20 col-12 searchag"  >
                        جستجوی آژانس ها
                    </h4>

                    <form method="get" method="{{Route('siteSearchAgensies')}}">

                        <div class="row">

                            <div class="col-lg-5">
                                <input type="text" name="search" value="{{$searchPost}}" class="form-control" id="text" placeholder="متن جستجو">
                            </div>

                            <div class="col-lg-2">
                                <button type="submit"  class="btn btnsearch">جستجو <i class="fa fa-search"></i></button>
                            </div>
                        </div>

                    </form>



                    <div class="row">
                        <div class="col-md-12">
                            <div class="content-box mb-20">
                                <div class="row">
                                    <div class="col-md-12">

                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">نام آژانس</th>
                                                    <th scope="col"> تلفن</th>
                                                    <th scope="col">آدرس</th>
                                                </tr>
                                            </thead>
                                            <tbody><?php $i = 1; ?>
                                                @foreach($getAgencies as $row)
                                                <tr>
                                                    <th scope="row">{{$i}}</th>
                                                    <td>{{@$row->company}}</td>
                                                    <td>{{@$row->tellPhone}}</td>
                                                    <td>{{@$row->address}}</td>
                                                </tr>
                                                <?php $i++; ?>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        {!! $getAgencies->links() !!}
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
