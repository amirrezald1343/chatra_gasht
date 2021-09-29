@extends('admin.layout.admin')
@section('style')
    <link href="{{ url('css/admin/dropzone.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('css/admin/mapsed.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('js/admin/examples/examples.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('css/admin/Package.css') }}" rel="stylesheet" type="text/css">

    <style type="text/css">
        .borderRed{
            border: 1px solid red;
            color: red;
        }
    </style>

@endsection
@section('content')
    <div class="row justify-content-center">
        {{ Form::open(['route'=>['admin.'.$NAME.'.store'],'files'=>true,'method'=>'post','class'=>'form-horizontal w-100 customValidate']) }}
        <div class="col-md-12">
            <div class="card  {{ (session()->has('errors')) ? '' : 'card-collapsed' }}  ">
                <div class="card-header  header-elements-inline mb-3 card-level mb-0">
                    <div class="card-title">
                        <i class="icon-pencil5"></i> <span> تعریف تور</span>
                    </div>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <input type="hidden" name="tmptime" value="{{ $tmptime[0] }}">
                    <div class="row">
                        <div class="row w-100">
                            <div class="form-group col-md-6 col-6 col-sm-6">
                                <label class="d-block" for="name">(شهر) مبدا <span class="required-input">*</span>
                                </label>
                                <v-select
                                        :required="selected"
                                        class="vs__search"
                                        :options="options"
                                        @search="onSearch"
                                        dir="rtl"
                                        label="title_fa"
                                        v-model="value_origin_tour"

                                >
                                    <template slot="no-options">هیچ موردی یافت نشد.</template>
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
                                <input name="origin"
                                       type="hidden"
                                       class='hiddenInputs'
                                       v-model="valueOriginTour"
                                       
                                >
                                {!! getError($errors,'origin') !!}
                            </div>
                            <div class="form-group col-md-6  col-6 col-sm-6">
                                <label class="d-block" for="name">مقاصد تور (قاره)</label>
                                <v-select
                                        multiple
                                        :options="options"
                                        @search="onSearchContinent"
                                        dir="rtl"
                                        label="title_fa"
                                        v-model="value_continents_tour"
                                >
                                    <template slot="no-options">هیچ موردی یافت نشد.</template>
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
                                <input name="continents"
                                       type="hidden"
                                       v-model="valueContinentsTour"
                                >

                                {{--   {!! Form::select('continents[]',config("defines.continents"),null  ,[  'multiple'=>'multiple','class'=>'form-control select-fixed-single select2-hidden-accessible','','data-placeholder'=>'انتخاب کنید..']) !!}
                                  {!! getError($errors,'continents') !!} --}}


                            </div>
                            <div class="form-group col-md-6  col-6 col-sm-6">
                                <label class="d-block" for="name">مقاصد تور (کشور)</label>
                                <v-select
                                        multiple
                                        :options="options"
                                        @search="onSearchCountry"
                                        dir="rtl"
                                        label="title_fa"
                                        v-model="value_countries_tour"

                                >
                                    <template slot="no-options">هیچ موردی یافت نشد.</template>
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
                                <input name="countries"
                                       type="hidden"
                                       v-model="valueCountriesTour"
                                >
                                {!! getError($errors,'countries') !!}
                            </div>
                            <div class="form-group col-md-6  col-6 col-sm-6">
                                <label class="d-block" for="name"> مقاصد تور (شهر) <span class="required-input">*</span>
                                </label>
                                <v-select
                                        multiple
                                        :options="options"
                                        @search="onSearch"
                                        dir="rtl"
                                        label="title_fa"
                                        v-model="value_cities_tour"

                                >
                                    <template slot="no-options">هیچ موردی یافت نشد.</template>
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
                                <input name="cities"
                                       type="hidden"
                                       class='hiddenInputs'
                                       v-model="valueCitiesTour"
                                >
                                {!! getError($errors,'cities') !!}
                            </div>


                        </div>
                        <div class="row w-100">
                            <div class="form-group col-md-6  col-6 col-sm-6">
                                <label for="name">تاریخ شروع
                                    <small>(dd/mm/yyyy)</small>
                                </label>
                                <date-picker
                                        value="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',(\Carbon\Carbon::now())  ) }}"
                                        initial-value="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',(\Carbon\Carbon::now())  ) }}"
                                        display-format="jYYYY/jMM/jDD"
                                        format="YYYY-MM-DD HH:mm:ss"
                                        :auto-submit="true"
                                        :clearable="true"
                                        locale="fa"
                                        name="start_in"
                                        placeholder="تاریخ شروع را وارد کنید"
                                ></date-picker>
                                {!! getError($errors,'start_in') !!}
                            </div>
                            <div class="form-group col-md-6  col-6 col-sm-6">
                                <label for="name" class="d-block"> تعداد شب <span class="required-input">*</span></label>
                                {{ Form::number('number_nights',null,['class'=>'form-control hiddenInputs','min'=>'1','','placeholder'=> 'تعداد شب را وارد کنید']) }}
                                {!! getError($errors,'number_nights') !!}
                            </div>
                            <div class="form-group col-md-6 col-6 col-sm-6">
                                <label class="d-block" for="name">نوع تور</label>
                                {!! Form::select('tourType',['internal'=>'داخلی','foreign'=>'خارجی'],null  ,['class'=>'form-control select-fixed-single select2-hidden-accessible','','data-placeholder'=>'انتخاب کنید..']) !!}
                                {!! getError($errors,'tourType') !!}
                            </div>

                            @can('isSuperAdmin',App\User::Class)


                                <div class="form-group col-md-6  col-6 col-sm-6">
                                    <label class="d-block" for="name">آژانس ها <span class="required-input">*</span></label>
                                    <v-select
                                        
                                            :options="optionsAgencies"
                                            @search="onSearchAgency"
                                            dir="rtl"
                                            label="company"
                                            v-model="value_agencies"

                                    >
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
                                    <input name="agency"
                                           type="hidden"
                                           v-model="valueAgency"
                                           class='hiddenInputs'
                                    >
                                    {!! getError($errors,'agency') !!}
                                </div>

                            @endcan


                            <div class="form-group col-md-4 col-4 col-sm-4">
                                <label for="name">
                                    <span>لحظه آخری</span>
                                    <span class="help-tour" data-popup="tooltip" title=""
                                          data-original-title="با انتخاب این گزینه تور شما در لیست تور های لحظه آخری قرار داده خواهد شد">
                                           <i class="icon-help"></i>
                                      </span>
                                </label>
                                {!! form::checkbox('moment',1,0,['class'=>'form-check-input-switchery']) !!}
                                {!! getError($errors,'moment') !!}
                            </div>
                            <div class="form-group col-md-4 col-4 col-sm-4">
                                <label for="name">بوم گردی</label>
                                {!! form::checkbox('indoors',1,0,['class'=>'form-check-input-switchery']) !!}
                                {!! getError($errors,'indoors') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card {{ (session()->has('errors')) ? '' : 'card-collapsed' }} ">
                <div class="card-header  header-elements-inline mb-3 card-level mb-0">
                    <div class="card-title">
                        <i class="icon-cogs"></i> <span> خدمات</span>
                    </div>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="row">
                        <div class="row w-100">
                            <div class="form-group col-md-12">
                                <label class="d-block" for="name">روش سفر</label>
                                {!! Form::select('travel_method',['aerial'=>'هوایی','earthy'=>'زمینی','marine'=>'دریایی'],null  ,['class'=>'form-control select-fixed-single select2-hidden-accessible','','data-placeholder'=>'انتخاب کنید..']) !!}
                                {!! getError($errors,'travel_method') !!}
                            </div>
                            <div class="form-group col-md-12">
                                <label for="name" class="d-block"> نوع وسیله نقلیه <span class="required-input">*</span> </label>
                                {{ Form::text('vehicle_type',null,['class'=>'hiddenInputs form-control  maxlength-badge-position','maxlength'=>'50','','placeholder'=> '  مثال  : قطار , ایرباس , اتوبوس vip و . . . ']) }}
                                {!! getError($errors,'vehicle_type') !!}
                            </div>
                            <div class="form-group col-md-6 col-sm-12 col-12">
                                <label for="name">خدمات</label>
                                <v-select
                                        multiple
                                        :options="
                                                              [
                                                                   @foreach($Service as $Servicevalue)
                                                {
                                                 id: '{{ $Servicevalue->id }}',
                                                                               title: '{{ $Servicevalue->title }}',
                                                                               icon: '/{{ $Servicevalue->icon }}'
                                                                               },

                                                                   @endforeach
                                                ]
"
                                        dir="rtl"
                                        label="title"
                                        v-model="value_service_tour"
                                >
                                    <template slot="no-options">هیچ موردی یافت نشد.</template>
                                    <template slot="option" slot-scope="option">
                                        <div class="d-center">
                                            <img style="width: 30px ;" :src='option.icon'/>
                                            @{{ option.title }}
                                        </div>
                                    </template>
                                    <template slot="selected-option" slot-scope="option">
                                        <div class="selected d-center">
                                            <img style="width: 30px;margin: 3px 0 3px 0px;" :src='option.icon'/>
                                            @{{ option.title }}
                                        </div>
                                    </template>
                                </v-select>
                                <input name="services"
                                       type="hidden"
                                       v-model="valueServiceTour"
                                >
                                {!! getError($errors,'Services') !!}
                            </div>
                        </div>
                        <div class="row w-100">
                            <div class="form-group col-md-12">
                                <label class="d-block" for="name">خدمات تکمیلی</label>
                                {{ Form::textarea('additional_services',null,['class'=>'summernote','']) }}
                                {!! getError($errors,'additional_services') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card {{ (session()->has('errors')) ? '' : 'card-collapsed' }} ">
                <div class="card-header  header-elements-inline mb-3 card-level mb-0">
                    <div class="card-title">
                        <i class="icon-tree5 "></i> <span> مراحل تور</span>
                    </div>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="row">
                        <div class="row w-100">
                            <div id="maraheltour" class="form-group col-md-12">
                                <label class="d-block" for="name"> مراحل تور</label>
                                <div class="row" id="level_list">
                                    @if(isset($model))
                                        @foreach(unserialize($model->fieldsArray) as $key=>$value)
                                            <div id="field_{{$key+1}}" class="form-group col-md-6 field">
                                                <label for="name">
                                                    <span> {{ __('admin.Field') }} </span><span>{{$key+1}}</span>
                                                </label>
                                                <input name="fieldsArray[]" value="{{ $value }}" type="text"
                                                       class="form-control"
                                                       placeholder=" {{  __('validation.required',['attribute'=>__('admin.Field')]) }}">
                                            </div>
                                        @endforeach
                                    @else
                                        @if(!empty(old('fieldsArray')))
                                            @foreach(old('fieldsArray') as $key=>$value)
                                                <div id="field_{{$key+1}}" class="form-group col-md-6 field ">
                                                    <label for="name">
                                                        <span> {{ __('admin.Field') }} </span><span>{{$key+1}}</span>
                                                    </label>
                                                    <input name="fieldsArray[]" value="{{ $value }}" type="text"
                                                           class="form-control"
                                                           placeholder="{{  __('validation.required',['attribute'=>__('admin.Field')]) }}">
                                                </div>
                                            @endforeach
                                        @endif
                                    @endif
                                </div>

                                <div class="col-sm-6 mt-3">
                                    <div class="d-flex align-items-center  mb-2">
                                        <a href="#1" onclick="add_level()"
                                           class="   btn bg-transparent border-teal text-teal rounded-round border-2 btn-icon mr-2 legitRipple">
                                            <i class="icon-plus3  "></i>
                                        </a>
                                        <div>
                                            <div class="font-weight-semibold">افزودن مرحله ی جدید</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row w-100">
                            <div class="form-group col-md-12">
                                <label class="d-block" for="name"> نقشه</label>
                                <div id="add-places" class="small-map"></div>
                                <div id="place">
                                    <div class="header text-right">
                                        <ul>
                                            <li class="col-4" style="width: 75px ">ردیف</li>
                                            <li class="col-4" style="width: 205px ">عرض جغرافیای</li>
                                            <li class="col-4" style="width: 205px">طول جغرافیای</li>
                                            <li class="col-3" style="width: 205px ">نام مکان</li>
                                            <li class="col-3" style="width: 137px">شماره مکان</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row w-100">
                            <div class="form-group col-md-12">
                                <label class="d-block" for="name"> تصاویر</label>
                                <div class="dropzone needsclick dz-clickable" id="demoupload">
                                    <div class="delay"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row w-100">
                            <div class="form-group col-md-12">
                                <label class="d-block" for="name"> تصویر شاخص </label>
                                <input type="file" name="thumbnail" >    
                                {!! getError($errors,'thumbnail') !!}                                          
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card {{ (session()->has('errors')) ? '' : 'card-collapsed' }} ">
                <div class="card-header  header-elements-inline mb-3 card-level mb-0">
                    <div class="card-title">
                        <i class="icon-price-tag "></i> <span> قیمت گذاری</span>
                    </div>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="row">
                        <div class="row w-100">
                            <div class="form-group col-md-12">
                                <div class="row" id="price_list">

                                </div>
                                <div class="col-sm-4 mt-3">
                                    <div class="d-flex align-items-center  mb-2">
                                        <a href="#1" onclick="add_price()"
                                           class="   btn bg-transparent border-teal text-teal rounded-round border-2 btn-icon mr-2 legitRipple">
                                            <i class="icon-plus3  "></i>
                                        </a>
                                        <div>
                                            <div class="font-weight-semibold">افزودن قیمت جدید</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card {{ (session()->has('errors')) ? '' : 'card-collapsed' }} ">
                <div class="card-header  header-elements-inline mb-3 card-level mb-0">
                    <div class="card-title">
                        <i class="icon-file-text "></i> <span> مدارک و قوانین</span>
                    </div>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="row">
                        <div class="row w-100">

                            <div class="form-group col-md-12">
                                <label class="d-block" for="name"> مدارک مورد نیاز</label>
                                {{ Form::textarea('documents',null,['class'=>'summernote','']) }}
                                {!! getError($errors,'documents') !!}
                            </div>
                        </div>
                        <div class="row w-100">
                            <div class="form-group col-md-12">
                                <label class="d-block" for="name">قوانین</label>
                                {{ Form::textarea('rules',null,['class'=>'summernote','']) }}
                                {!! getError($errors,'rules') !!}
                            </div>
                        </div>
                        <div class="row w-100">
                            <div class="form-group col-md-12">
                                <label class="d-block" for="name"> توضیحات تکمیلی تور </label>
                                {{ Form::textarea('description',null,['class'=>'summernote ','']) }}
                                {!! getError($errors,'description') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 text-center">
                    <button style="width: 300px;height: 60px;font-size: 20px;" type="submit" class="btn btn-primary">ثبت
                        تور <i class="icon-arrow-left13 position-right"></i></button>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
@endsection
@section('scripts')


    

    {{-------------Vue js-------------}}

    <script src="<?= url('js/adminVue.js')?>" type="text/javascript"></script>

    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/uniform.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_inputs.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/switchery.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/switch.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_checkboxes_radios.js') ?>"></script>

    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/selects/select2.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_select2.js') ?>"></script>

    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/inputs/maxlength.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_controls_extended.js') ?>"></script>

    {{-------------editor-------------}}
    <script type="text/javascript"
            src="<?= url('global_assets/js/plugins/editors/summernote/summernote.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/uniform.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/demo_pages/editor_summernote.js') ?>"></script>

    {{-------------dropzone-------------}}
    <script type="text/javascript" src="<?= url('js/admin/dropzone.js') ?>"></script>
    <script>


        $(".customValidate").submit(function(e){
            
            var cnt=$(this).find('.hiddenInputs').length;
            var hasError = false;

            $(".hiddenInputs").each(function(index,value){
                
                    if($(this).val()=='' || $(this).val()=='[]'){
                        $(this).closest('.form-group').find('.d-block').addClass('borderRed');
                        hasError=true;
                    }else{
                        $(this).closest('.form-group').find('.d-block').removeClass('borderRed');
                    }
            });



            if(hasError){
                // if($('.card').hasClass('card-collapsed')){
                //    $(".list-icons-item").click();
                //  }

                 
                $(".list-icons-item").removeClass('rotate-180');   
                $('.card').find('.card-body').slideDown(150);

                alert('فیلد های دارای ستاره را پر نمایید');
                e.preventDefault();
            }
            
            
        })




        $('#iconPicker').find('img').click(function () {
            let address = $(this).data('image');
            let newAddress = "{{ url('/') }}" + "/" + address;
            $("#btnExistFile").find("i").html(" <img src=" + newAddress + " width=40 />");
            $('#existFile').val(address);
            $(".modal-footer .btn").click();
        });
    </script>
    {{-------------dropzone-------------}}
    <script>


        $(".card-header").click(function () {
            $(this).closest('.card').toggleClass('card-collapsed');
            $(this).closest('.card').find('.card-body').slideToggle(150);
            $(this).closest('.card').find('.list-icons-item').toggleClass('rotate-180');
        });


        $(".list-icons-item").click(function (e) {
            e.preventDefault();
            return false;
        });

        $("div#demoupload").dropzone({
            url: "<?=url('admin/uploadImgPackage') . '/' . $tmptime[0] ?>",
            maxFilesize: 5,
            maxFile: 1,
            addRemoveLinks: true,
            dictRemoveFile: "حذف",
            uploadMultiple: false,
            dictDefaultMessage: "<h3 class='sbold'>انتخاب تصویر<h3>",
            sending: function (file, xhr, formData) {
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            },
            init: function () {
                this.on("success", function (file, serverFileName) {
                    $('#idtmpimg').attr('name', 'titleimg[' + serverFileName + ']');
                    $('#idtmpimg').removeAttr('id');
                    $('#RemoveImage').attr('onclick', 'deleteimg(' + serverFileName + ')');
                    $('#RemoveImage').removeAttr('id');
                });
                this.on("removedfile", function (file) {
                });
            }
        });
    </script>
    <script>
        deleteimg = function (id) {
            $('#demoupload .delay').css('display', 'block');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '<?= url('admin/DeleteImgPackage')  ?>',
                type: "POST",
                data: 'id=' + id,
                success: function (result) {
                    if (result == 'ok') {
                        $('#demoupload .delay').css('display', 'none');
                    }
                }
            });
        };
    </script>


    {{-------------add_price-------------}}
    <script>
        add_price = function () {
            var count = document.getElementsByClassName('price').length + 1;
            var html = '<div id="price_' + count + '"   class="price  "  style="direction:rtl; margin-right:85px;margin-top:13px;position: relative">' +
                '<div class="deleteprice"  onclick="deleteprice(' + count + ')"  id="DeletePrice' + count + '" ><i class="icon-cross2 text-danger-400"></i></div>' +
                '<div style="margin-bottom: 6px;color: #5a5c5d;"> <span>قیمت تور</span></div>' +
                '<div> <span style="color: #888585;font-size: 11px;"> نام  :</span>' +
                '<input name="name_price_package[]"   class="form-control" style="width:160px;display: inline-block;margin-right: 97px;margin-bottom: 9px;" type="text" min="0">' +
                ' </div> ' +
                '<div> <span style="color: #888585;font-size: 11px;"> نوع  :</span>' +
                '<select name="type_price_package[]"    class="form-control" style="width:160px;margin-bottom: 11px;display: inline-block;margin-right: 94px;"><option value="1">هتل</option><option value="2">هتل آپارتمان</option><option value="3">مهمانپذیر</option><option value="4">خانه مسافر</option><option value="5">اقامتگاه</option></select>' +
                ' </div> ' +
                '<div> <span style="color: #888585;font-size: 11px;"> انتخاب ستاره :</span>' +
                '<select name="star_price_package[]"    class="   form-control" style="width:160px;margin-bottom: 11px;display: inline-block;margin-right: 42px;"><option value="0">انتخاب ستاره</option> <option value="1">یک ستاره</option><option value="2">دو ستاره</option><option value="3">سه ستاره</option><option value="4">چهار ستاره</option><option value="5">پنج ستاره</option></select>' +
                ' </div> ' +
                '<div> <span style="color: #888585;font-size: 11px;"> مقدار (تومان) :</span> <input name="amount_price_package[]"   class="form-control" style="width:160px;display: inline-block;margin-right: 31px;" type="number" min="1"> </div>' +
                '<div style="text-align: center;padding: 12px 0px 0 0"> <span><i style="font-size: 21px;color: #3f51b5;" class="icon-plus-circle2"></i> </span> </div>' +
                '<div> <span style="color: #888585;font-size: 11px;"> مقدار (ارز خارجی) :</span> <input name="amount_price_dollar_package[]"   class="form-control" style="width:160px;display: inline-block;margin-right: 43px;" type="number" min="1"> </div>' +
                '<select class="form-control" name="currency_price_package[]">'+
                <?php foreach(config('defines.currency') as $rowCu=>$valCu) { ?>
                 "<option value='<?php echo $rowCu ?>'>"+"<?php echo $valCu; ?>"+"</option>"+       
                <?php } ?>
                '</select>'+
                '</div>';
            $("#price_list").append(html);
        };
    </script>
    <script>
        deleteprice = function (id) {
            if (confirm("از حذف قیمت مطمئن هستید؟")) {
                var count = document.getElementsByClassName('price').length;
                for (var i = (id + 1); i <= count; i++) {
                    $('#price_' + i).attr('id', 'price_' + (i - 1));
                    $('#DeletePrice' + i).attr('onclick', 'deleteprice(' + (i - 1) + ')');
                    $('#DeletePrice' + i).attr('id', 'DeletePrice' + (i - 1));
                }
                $('#price_' + id).remove();
                var html = '<span   class="addlevel"  onclick="add_price()" >افزودن قیمت جدید</span>';
                $("#addpricepackage").html(html);
            }
        };
    </script>
    {{-------------add_level-------------}}
    <script>
        add_level = function () {
            var count = document.getElementsByClassName('level').length + 1;
            var html = '<div id="level_' + count + '"   class="level"  style="direction:rtl; margin-right:30px;margin-top:13px;">' +
                '<label style="margin-bottom: 6px;color: #2196f3;border: 1px solid #2196f3;border-radius: 2px;padding: 2px 4px 1px 5px;">  <span class="levelCountTitle"> مرحله' + count + '</span>  </label>' +
                "<span style='color:red; padding:3px;cursor:pointer' class='deleteTourStep'> حذف </span>"+
                '<input type="hidden" class="hiddenInput" name="number_level[]" value="' + count + '"> ' +
                '<div> <span style="color: #707070;font-size: 12px;"> عنوان :</span><input name="title_level[]"   type="text" class="form-control" style="width:300px;margin-bottom: 11px;display: inline-block;margin-right: 42px;"> </div> ' +
                '<div style="display: flex;"> <span style="color: #707070;font-size: 12px;"> توضیحات :</span> <textarea name="description_level[]"  class="form-control" style="width:500px;display: inline-block;margin-right: 20px;"></textarea> </div>' +
                '</div>';
            $("#level_list").append(html);
        };

        $(document).on('click','.deleteTourStep',function(){
            if(confirm('مرحله تور حذف شود ؟')){
                $(this).closest('.level').remove();

                    setTimeout(function(){
                        var i=1;
                            $(".level").each(function(index,value){
                                $(this).find('.hiddenInput').val(i);
                                $(this).find('.levelCountTitle').html('مرحله '+i);
                                i++;
                            })
                    },200);

            } 
        });


    </script>
    {{-------------MAP-------------}}
    <script>
        saveplace = function (id) {
            $('#mlat' + id).val($('#mapsedlat' + id).val());
            $('#mlng' + id).val($('#mapsedlng' + id).val());
            $('#mname' + id).val($('#mapsedname' + id).val());
            $('#mnumber' + id).val($('#mapsednumber' + id).val());
        }
        deletplace = function (id) {

        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBATf9eLRVC1xIUeAnhcu8Fgvy677MDlPY&libraries=places"></script>
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
    <script src="{{url('js/admin/mapsed.js')}}"></script>
    <script>
        $("#add-places").mapsed({
            // Adds the "+" button to the control bar at the top right of the map
            confirmDelete: true,
            allowAdd: true,
            onDelete: function (mapsed, placeToDelete) {
                // here would be code your application to do the actual delete
                // return true to confirm it was deleted OK and remove marker from the map
                // return false if the delete failed
                return true;
            },
            // Enables edit of custom places (to your web application, not Google Maps!)
            // ... again the presence of the callback enables the functionality
            onSave: function (mapsed, newPlace) {
                var missing = [];

                // detect errors starting at bottom
                // ... we only have space for one error at a time, so this way we'll report
                // ... from the top down
                if (newPlace.postCode === "") missing.push("postcode");
                if (newPlace.street === "") missing.push("street");
                if (newPlace.name === "") missing.push("name");

                // anything missing?
                if (missing.length > 0) {
                    // return the error message so the callback doesn't progress
                    return "Required: " + missing.join();
                }

                if (newPlace) {
                    if (newPlace.markerType == "new") {
                        // simulate a primary key being save to a db
                        newPlace.userData = parseInt(Math.random() * 100000);
                    }
                    var title = "";
                    var msg =
                        "userData: " + newPlace.userData +
                        "name: " + newPlace.name +
                        "street: " + newPlace.street + ", " +
                        newPlace.area + ", " +
                        newPlace.town + ", " + newPlace.postCode +
                        "telNo: " + newPlace.telNo +
                        "website: " + newPlace.website +
                        "g+: " + newPlace.url
                    ;
                    if (newPlace.markerType == "new")
                        title = "New place added!";
                    else
                        title = "Place saved!";
                    mapsed.showMsg(title, msg);
                }

                // indicate form was OK and saved
                return "";
            }
        });


        // name = "moment"


$('form').on('focus', 'input[type=number]', function (e) {
    $(this).on('mousewheel.disableScroll', function (e) {
    e.preventDefault()
    })
})
 
$('form').on('blur', 'input[type=number]', function (e) {
     $(this).off('mousewheel.disableScroll')
})



$(document).ready(function(){
    $(document).on('click','.vs__actions .clear',function(){
        $(this).closest('.form-group').find('.hiddenInputs').val('');
    });
});


    </script>

@endsection