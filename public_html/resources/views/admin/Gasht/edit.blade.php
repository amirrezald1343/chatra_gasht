@extends('admin.layout.admin')
@section('style')
<link href="<?= url('css/admin/user.css') ?>" rel="stylesheet" type="text/css" />
<link href="/css/tagify.css" rel="stylesheet">
<style type="text/css">
    .remove-item-div {
        background-color: #ff7777;
        color: white;
        padding: 3px;
        float: left;
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
</style>
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">

        <div class="card">



            @isset($errorForm)
            <div style="padding:5px">
                <p class='label label-danger'>{{$errorForm}}</p>
            </div>
            <hr>
            @endisset

            <div style="padding: 5px; width: 100%">


                <form method="post" enctype="multipart/form-data" action="{{route('admin.updateGasht',['id'=>$gasht->id])}}" style=" width: 100%">
                    {{ csrf_field()  }}
                    <!-- <input type="hidden" value="sendFilter" name="sendFilter"> -->

                    <div class="row">

                        <div class="form-group col-md-6  col-6 col-sm-12">
                            <label class="d-block" for="name"> عنوان
                            </label>

                            <input name="title" type="text" class="form-control" value="{{$gasht->title}}">
                            {!! getError($errors,'cities') !!}
                        </div>


                        <div class="form-group col-md-6  col-6 col-sm-12">
                            <label class="d-block" for="type"> نوع گشت
                            </label>

                            <select name="type" id="type" class="form-control">
                                @foreach(config('defines.gashtType') as $rowType=>$valType)
                                <option <?php echo ($gasht->type == $rowType) ? "SELECTED" : "";  ?> value="{{$rowType}}">{{$valType}}</option>
                                @endforeach
                            </select>

                            {!! getError($errors,'cities') !!}
                        </div>

                        <div class="form-group col-md-6 col-sm-12 col-12">
                            <label for="name"> خدمات : </label>
                            {{ Form::text('services',"$gasht->services",['class'=>'form-control inputTagSelector','placeholder'=> __('validation.required',['attribute'=>'لیست خدمات'])]) }}
                            {!! getError($errors,'services') !!}
                        </div>


                        <div class="form-group col-md-6 col-sm-12 col-12">
                            <label for="name"> لوازم مورد نیاز : </label>
                            {{ Form::text('supplies',"$gasht->supplies",['class'=>'form-control inputTagSelector','placeholder'=> __('validation.required',['attribute'=>'لوازم مورد نیاز'])]) }}
                            {!! getError($errors,'supplies') !!}
                        </div>


                        <div class="form-group col-md-12  col-12 col-sm-12">
                            <label for="desc"> توضیحات : </label>
                            <textarea id="desc" name="desc" class="form-control">{{$gasht->desc}}</textarea>

                        </div>

                        <div class="form-group col-md-12 col-sm-12 col-12">
                            <label for="file">{{ 'تصویر بند انگشتی' }}: </label>
                            {{ Form::file('file',['class'=>'form-control-uniform-custom']) }}
                            @if($gasht->image)
                            <img src='{{url("/$gasht->image")}}' style="width:300px;height:250px;" />
                            @endif
                            {!! getError($errors,'file') !!}
                        </div>

                    </div>

                    <div class="form-group col-md-12  col-12 col-sm-12">

                        <h5> قیمت گذاری :

                        </h5>

                        <br>
                        <div class="price_container">


                            <div class="price-item">

                                <label>
                                    قیمت بزرگسال
                                    <input value="{{$gasht->adult}}" type="text" required class="form-control fee" min='0' placeholder="تومان" name="adult">
                                </label>

                                <label>
                                    قیمت خردسال
                                    <input value="{{$gasht->child}}" type="text" required class="form-control fee" min='0' placeholder="تومان" name="child">
                                </label>

                                <label>
                                    ظرفیت
                                    <input value="{{$gasht->capacity}}" type="number" required class="form-control" min='0' placeholder="ظرفیت نفر" name="capacity">
                                </label>

                                <label>
                                    حداقل رزرو
                                    <input value="{{$gasht->minCount}}" type="number"  class="form-control" min='0' placeholder="ظرفیت نفر" name="minCount">
                                </label>

                                <label>
                                    تاریخ
                                    <input value="{{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($gasht->date)) }}" type="text" name="date" ُ class="form-control" disabled >
                                </label>


                            </div>


                        </div>


                    </div>



                    <br>

                    <div>

                        <input type="submit" class='btn btn-success' value="ویرایش گشت">


                        @can('isSuperAdmin',App\User::Class)

                        <label style="margin-right:15px; background-color:#ebebeb;padding:3px 7px; border-radius:2px" for="status">
                            <input style="vertical-align: middle" type='checkbox' class="form-check-input-switchery" id="status" name="status" <?php echo ($gasht->status == "1") ? "checked" : ""; ?> />
                            وضعیت
                        </label>
                        @endcan

                    </div>

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

<script>
    $(document).ready(function(e) {



        $(document).on('keyup', '.fee', function() {

            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });

        });



        $('.inputTagSelector').tagify({
            maxTags: 15,
        });


        $(document).on('click', '.remove-item-div', function() {
            if (confirm('حذف شود ؟')) {
                $(this).closest('.row-item-div').remove();
            }
        });

    });
</script>

@endsection
