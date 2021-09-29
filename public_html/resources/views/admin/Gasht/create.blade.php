@extends('admin.layout.admin')
@section('style')
<link href="<?= url('css/admin/user.css') ?>" rel="stylesheet" type="text/css" />
<link href="/css/persian-datepicker.min.css" rel="stylesheet" type="text/css" />
<link href="/css/tagify.css" rel="stylesheet">
<style type="text/css">
    .remove-item-div {
        background-color: #ff7777;
        color: white;
        padding: 3px;
        vertical-align: top;
        display: inline-block;
        cursor: pointer;
        font-size: 11px;
        border-radius: 4px;
    }

    .row-item-div input,
    .row-item-div textarea,
    .row-item-div select {
        font-size: 13px !important;
    }


    .price-item {
        border-right: 3px solid #3f51b5;
        padding-right: 7px;
        padding-top: 7px;
        margin-top: 18px;
    }


    .dropdown-toggle {
        border-top: none !important;
        border-left: none !important;
        border-right: none !important;
        padding-bottom: 12px !important;
        border-radius: 0px !important;
    }

    /* .v-select .vs__selected-options .form-control{
        margin-bottom: -13px !important;
        margin-top: 0 !important;
        padding: 0 !important;
    } */
</style>
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">

        <div class="card">



            @isset($error)
            <div style="padding:5px">
                <p class='label label-danger'>{{$error}}</p>
            </div>
            <hr>
            @endisset

            <div style="padding: 5px; width: 100%">


                <form method="post" action="{{route('admin.storeGasht')}}" enctype="multipart/form-data" style=" width: 100%">
                    {{ csrf_field()  }}
                    <!-- <input type="hidden" value="sendFilter" name="sendFilter"> -->

                    <div class="row">


                        <div class="form-group col-md-12  col-12 col-sm-12">
                            <label class="d-block" for="name"> عنوان
                            </label>

                            <input name="title" type="text" class="form-control">
                            {!! getError($errors,'cities') !!}
                        </div>


                        <div class="form-group col-md-6  col-6 col-sm-6">
                            <label class="d-block" for="name"> نوع گشت
                            <span class="required-input">*</span>
                            </label>

                            <select name="type" class="form-control">
                                @foreach(config('defines.gashtType') as $rowType=>$valType)
                                <option value="{{$rowType}}">{{$valType}}</option>
                                @endforeach
                            </select>

                            {!! getError($errors,'cities') !!}
                        </div>

                        <div class="form-group col-md-6  col-6 col-sm-6">
                            <label class="d-block" for="name"> شهر
                            <span class="required-input">*</span>
                            </label>
                            <v-select :options="options" @search="onSearch" dir="rtl" label="title_fa" v-model="value_cities_tour_origin">
                                <template slot="no-options">هیچ موری یافت نشد.</template>
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
                            <input name="city" type="hidden" v-model="valueCitiesTourOrigin">
                            {!! getError($errors,'cities') !!}
                        </div>

                        <div class="form-group col-md-6 col-sm-12 col-12">
                            <label for="name"> خدمات : </label>
                            {{ Form::text('services','',['class'=>'form-control inputTagSelector','placeholder'=> __('validation.required',['attribute'=>'لیست خدمات'])]) }}
                            {!! getError($errors,'services') !!}
                        </div>


                        <div class="form-group col-md-6 col-sm-12 col-12">
                            <label for="name"> لوازم مورد نیاز : </label>
                            {{ Form::text('supplies','',['class'=>'form-control inputTagSelector','placeholder'=> __('validation.required',['attribute'=>'لوازم مورد نیاز'])]) }}
                            {!! getError($errors,'supplies') !!}
                        </div>



                        <div class="form-group col-md-12  col-12 col-sm-12">
                            <label for="desc"> توضیحات : </label>
                            <textarea id="desc" name="desc" class="form-control"></textarea>

                        </div>

                        <div class="form-group col-md-6 col-sm-12 col-12">
                            <label for="file">{{ 'تصویر بند انگشتی' }}: </label>
                            {{ Form::file('file',['class'=>'form-control-uniform-custom']) }}

                            {!! getError($errors,'file') !!}
                        </div>

                        @can('isSuperAdmin',App\User::Class)


                        <div class="form-group col-md-6  col-12 col-sm-12">
                            <label class="d-block" for="name">آژانس ها <span class="required-input">*</span></label>
                            <v-select :options="optionsAgencies" @search="onSearchAgency" dir="rtl" label="company" v-model="value_agencies">
                                <template slot="no-options">هیچ موردی یافت نشد.</template>
                                <template slot="option" slot-scope="option">
                                    <div class="d-center">
                                        @{{ option.company }}
                                    </div>
                                </template>
                                <template slot="selected-option" slot-scope="option">
                                    <div class="selected d-center">
                                        @{{ option.company }}
                                    </div>
                                </template>
                            </v-select>
                            <input name="agency" type="hidden" v-model="valueAgency" class='hiddenInputs'>
                            {!! getError($errors,'agency') !!}
                        </div>

                        @endcan

                    </div>

                    <hr>
                    <div class="row">

                        <div class="form-group col-md-12  col-12 col-sm-12">

                            <h5> قیمت گذاری :
                            </h5>

                            <br>
                            <div class="price_container">


                                <div class="price-item">

                                    <label>
                                        قیمت بزرگسال
                                        <input type="text" required class="form-control fee" min='0' placeholder="تومان" name="adult[]">
                                    </label>

                                    <label>
                                        قیمت خردسال
                                        <input type="text" required class="form-control fee" min='0' placeholder="تومان" name="child[]">
                                    </label>

                                    <label>
                                        ظرفیت
                                        <input type="number" required class="form-control" min='0' placeholder="ظرفیت نفر" name="capacity[]">
                                    </label>

                                    <label>
                                        حداقل رزرو
                                        <input type="number" required class="form-control" min='0' placeholder="ظرفیت نفر" name="minCount[]">
                                    </label>

                                    &nbsp;
                                    <label>
                                        از تاریخ
                                        <input type="text" required class="form-control datePickerInput" name="start_date[]">
                                    </label>

                                    <label>
                                        تا تاریخ
                                        <input type="text" required class="form-control datePickerInput" name="end_date[]">
                                    </label>
                                    <br>
                                 <label>زوج   <input type="radio" required class="form-control" name="typedate" value="زوج">
                                    </label>
                                    <label>فرد
                                         <input type="radio" required class="form-control" name="typedate" value="فرد">
                                    </label>
                                    <label>همه <input type="radio" required class="form-control" name="typedate" value="هردو">
                                    </label>

                                    <span style="float:left; font-size:13px; background-color:#3f51b5; padding:1px 5px 1px 5px;color:white; border-radius:4px;cursor:pointer" class="new-row-item-btn">جدید</span>

                                </div>


                            </div>

                        </div>
                    </div>





                    <br>

                    <input type="submit" class='btn btn-success' value="ثبت گشت">

                </form>
            </div>

            <div class="card-body overflow-auto">

            </div>
        </div>

    </div>
</div>
@endsection
@section('scripts')
<script src="<?= url('js/adminVue.js?version2') ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?= url('global_assets/js/plugins/media/fancybox.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/demo_pages/blog_single.js') ?>"></script>
<script type="text/javascript" src="/js/jQuery.tagify.min.js"></script>
<script type="text/javascript" src="/js/persian-date.min.js"></script>
<script type="text/javascript" src="/js/persian-datepicker.js"></script>

<script>
    function number_format(number, decimals, dec_point, thousands_point) {

        if (number == null || !isFinite(number)) {
            throw new TypeError("number is not valid");
        }

        if (!decimals) {
            var len = number.toString().split('.').length;
            decimals = len > 1 ? len : 0;
        }

        if (!dec_point) {
            dec_point = '.';
        }

        if (!thousands_point) {
            thousands_point = ',';
        }

        number = parseFloat(number).toFixed(decimals);

        number = number.replace(".", dec_point);

        var splitNum = number.split(dec_point);
        splitNum[0] = splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_point);
        number = splitNum.join(dec_point);

        return number;
    }


    $(document).ready(function() {
        $('.inputTagSelector').tagify({
            maxTags: 15,
        });



        $(".datePickerInput").pDatepicker({
            observe: true,
            format: 'YYYY/MM/DD'
        });



        $(document).on('keyup', '.fee', function() {

            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });

        });



    });


    //
    $(".new-row-item-btn").click(function() {
        $(".price_container").append("<div class='price-item'>" +
            "<label>  قیمت بزرگسال" +
            "<input required type='text' class='form-control fee' min='0' placeholder='تومان' name='adult[]'>" +
            "</label> &nbsp;" +
            "<label>  قیمت خردسال" +
            "<input required type='text' class='form-control fee' min='0' placeholder='تومان' name='child[]'>" +
            "</label> &nbsp;" +
            "<label>  ظرفیت " +
            "<input required type='number' class='form-control' min='0' placeholder='ظرفیت  نفر' name='capacity[]'>" +
            "</label> &nbsp;" +
            "<label>  حداقل رزرو " +
            "<input required type='number' class='form-control' min='0' placeholder='ظرفیت  نفر' name='minCount[]'>" +
            "</label> &nbsp;" +
            "<label>   از تاریخ " +
            "<input required type='text' class='form-control datePickerInput' min='0'  name='start_date[]'>" +
            "</label> &nbsp;" +
            "<label>   تا تاریخ " +
            "<input required type='text' class='form-control datePickerInput' min='0'  name='end_date[]'>" +
            "</label>" +
            "<span class='remove-item-div'>" + "حذف" + "</span>" +
            "</div>"
        );


        $(".datePickerInput").pDatepicker({
            observe: false,
            initialValue: false,
            format: 'YYYY/MM/DD'
        });


    });

    $(document).ready(function(e) {

        $(document).on('click', '.remove-item-div', function() {
            if (confirm('حذف شود ؟')) {
                $(this).closest('.price-item').remove();
            }
        });

    });
</script>

@endsection
