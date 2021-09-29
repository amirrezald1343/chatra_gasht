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
        .width100{
            width: 100%
        }

        .priceIsOnline {
            display: none;
            color: red;
        }
    </style>

@endsection
@section('content')
    <div class="row justify-content-center">
        {{ Form::model($model,['route'=>['admin.'.$NAME.'.update',$model->id],'files'=>true,'method'=>'put','class'=>'form-horizontal w-100 customValidate']) }}
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
                    <div class="row">
                        <div class="row w-100">
                            <div class="form-group col-md-3">
                                <label class="d-block" for="name"> مبدا <span class="required-input">*</span></label>
                                <v-select
                                    :options="options"
                                    @search="onSearch"
                                    dir="rtl"
                                    label="title_fa"
                                    v-model="value_origin_tour"
                                    v-init:value_origin_tour="{ id: '{{  $model->city->id }}', title_fa: '{{ $model->city->title_fa  }}' }"

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
                            <div class="form-group col-md-3">
                                <label class="d-block" for="name">مقاصد تور (قاره)</label>
                                <v-select
                                    multiple
                                    :options="options"
                                    @search="onSearchContinent"
                                    dir="rtl"
                                    label="title_fa"
                                    v-model="value_continents_tour"
                                    v-init:value_continents_tour="[
                                @foreach($model->cities as $value)
                                    @if($value->pivot->type == 'continent')  { id: '{{  $value->id }}', title_fa: '{{ $value->title_fa  }}' }, @endif
                                    @endforeach
                                        ]"

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
                                {!! getError($errors,'continents') !!}
                            </div>
                            <div class="form-group col-md-3">
                                <label class="d-block" for="name">مقاصد تور (کشور)</label>
                                <v-select
                                    multiple
                                    :options="options"
                                    @search="onSearchCountry"
                                    dir="rtl"
                                    label="title_fa"
                                    v-model="value_countries_tour"
                                    v-init:value_countries_tour="[
                                @foreach($model->cities as $value)
                                    @if($value->pivot->type == 'country')  { id: '{{  $value->id }}', title_fa: '{{ $value->title_fa  }}' }, @endif
                                    @endforeach
                                        ]"

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
                            <div class="form-group col-md-3">
                                <label class="d-block" for="name">مقاصد تور (شهر) <span class="required-input">*</span></label>
                                <v-select
                                    multiple
                                    :options="options"
                                    @search="onSearch"
                                    dir="rtl"
                                    label="title_fa"
                                    v-model="value_cities_tour"
                                    v-init:value_cities_tour="[
                                @foreach($model->cities as $value)
                                    @if($value->pivot->type == 'city')  { id: '{{  $value->id }}', title_fa: '{{ $value->title_fa  }}' }, @endif
                                    @endforeach
                                        ]"
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
                            <div class="form-group col-md-3">
                                <label for="name">تاریخ شروع
                                    <small>(dd/mm/yyyy)</small>
                                </label>
                                <date-picker
                                    value="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',($model->start_in) )}}"
                                    initial-value="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',($model->start_in)  ) }}"
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
                            <div class="form-group col-md-2">
                                <label for="name" class="d-block"> تعداد شب<span class="required-input">*</span></label>
                                {{ Form::number('number_nights',null,['class'=>'form-control hiddenInputs','min'=>'1','','placeholder'=> 'تعداد شب را وارد کنید']) }}
                                {!! getError($errors,'number_nights') !!}
                            </div>
                            <div class="form-group col-md-3">
                                <label class="d-block" for="name">نوع تور</label>
                                {!! Form::select('tourType',['internal'=>'داخلی','foreign'=>'خارجی'],null  ,['class'=>'form-control select-fixed-single select2-hidden-accessible','','data-placeholder'=>'انتخاب کنید..']) !!}
                                {!! getError($errors,'tourType') !!}
                            </div>
                            <div class="form-group col-md-2">
                                <label for="name">
                                    <sapn>لحظه آخری</sapn>
                                    <span class="help-tour" data-popup="tooltip" title=""
                                          data-original-title="Top tooltip">
                                         <i class="icon-help"></i>
                                    </span>
                                </label>
                                {!! form::checkbox('moment',1,$model->moment ?? 0,['class'=>'form-check-input-switchery']) !!}
                                {!! getError($errors,'moment') !!}
                            </div>
                            <div class="form-group col-md-2">
                                <label for="name">بوم گردی</label>
                                {!! form::checkbox('indoors',1,$model->indoors ?? 0,['class'=>'form-check-input-switchery']) !!}
                                {!! getError($errors,'indoors') !!}
                            </div>





                            @can('isSuperAdmin',App\User::Class)
                                {{--{id:{{$model['agency']['id']}},company:{{$model['agency']['company']}}--}}




                                <div class="form-group col-md-6  col-6 col-sm-6">
                                    <label class="d-block" for="name"> آژانس ها<span
                                            class="required-input">*</span></label>
                                    <v-select
                                        :options="optionsAgencies"
                                        @search="onSearchAgency"
                                        dir="rtl"
                                        label="company"
                                        v-model="value_agencies"
                                        @if(@$model['agency']['id'])
                                        v-init:value_agencies="{id:{{$model['agency']['id']}},company:'{{$model['agency']['company']}}'}">
                                        @endif
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
                                           class='hiddenInputs'
                                           v-model="valueAgency"
                                    >
                                    {!! getError($errors,'agency') !!}
                                </div>


                                <div class="form-group col-md-4 col-4 col-sm-4">
                                    <label for="name"> تور ویژه </label>
                                    {!! form::checkbox('special',1,$model->special ?? 0,['class'=>'form-check-input-switchery']) !!}
                                    {!! getError($errors,'special') !!}
                                </div>

                        @endcan



                        <!-- @can('isSuperAdmin',App\User::Class)
                            <div class="form-group col-md-2">
                                <label for="name">ارسال پیام تایید تور</label>
                                {!! form::checkbox('indoors',1,null,['class'=>'form-check-input-switchery']) !!}
                            {!! getError($errors,'indoors') !!}
                                </div>
@endcan -->


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
                            <div class="form-group col-md-3">
                                <label class="d-block" for="name">روش سفر</label>
                                {!! Form::select('travel_method',['aerial'=>'هوایی','earthy'=>'زمینی','marine'=>'دریایی'],null  ,['class'=>'form-control select-fixed-single select2-hidden-accessible','','data-placeholder'=>'انتخاب کنید..']) !!}
                                {!! getError($errors,'travel_method') !!}
                            </div>
                            <div class="form-group col-md-3">
                                <label for="name" class="d-block"> نوع وسیله نقلیه <span class="required-input">*</span> </label>
                                {{ Form::text('vehicle_type',null,['class'=>'form-control hiddenInputs  maxlength-badge-position','maxlength'=>'50','','placeholder'=> '  مثال  : قطار , ایرباس , اتوبوس vip و . . .  ']) }}
                                {!! getError($errors,'vehicle_type') !!}
                            </div>
                            <div class="form-group col-md-6">
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
                                    v-init:value_service_tour="[
                                            @foreach($model->services as $value)
                                        { id: '{{  $value->id }}', title: '{{ $value->title  }}' ,  icon: '/{{ $value->icon }}' },
                                            @endforeach
                                        ]"
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
                                {{ Form::textarea('additional_services',null,['class'=>'width100','']) }}
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
                            <div class="form-group col-md-12">
                                <label class="d-block" for="name"> مراحل تور</label>
                                <div class="row" id="level_list">
                                    @if(isset($model))
                                        @foreach($model->levels as $key=>$value)
                                            <div id="level_{{$key+1}}" class="level"
                                                 style="direction:rtl; margin-right:30px;margin-top:13px;">
                                                <label style="margin-bottom: 6px;color: #2196f3;border: 1px solid #2196f3;border-radius: 2px;padding: 2px 4px 1px 5px;">
                                                    <span class="levelCountTitle">مرحله {{$key+1}}</span>
                                                </label>
                                                <span style="color:red; padding:3px;cursor:pointer" class="deleteTourStep"> حذف </span>
                                                <input type="hidden" class="hiddenInput" name="number_level[]" value="{{$key+1}}">
                                                <div>
                                                    <span style="color: #707070;font-size: 12px;"> عنوان :</span>
                                                    <input value="{{ $value->title }}" name="title_level[]" type="text"
                                                           class="form-control"
                                                           style="width:300px;margin-bottom: 11px;display: inline-block;margin-right: 42px;">
                                                </div>
                                                <div style="display: flex;">
                                                    <span style="color: #707070;font-size: 12px;"> توضیحات :</span>
                                                    <textarea name="description_level[]" class="form-control"
                                                              style="width:500px;display: inline-block;margin-right: 20px;">{{  $value->description }}</textarea>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        {{--@if(!empty(old('fieldsArray')))--}}
                                        {{--@foreach(old('fieldsArray') as $key=>$value)--}}
                                        {{--<div id="field_{{$key+1}}"  class="form-group col-md-6 field">--}}
                                        {{--<label for="name"> <span> {{ __('admin.Field') }} </span><span>{{$key+1}}</span> </label>--}}
                                        {{--<input name="fieldsArray[]"  value="{{ $value }}"  type="text" class="form-control" placeholder="{{  __('validation.required',['attribute'=>__('admin.Field')]) }}">--}}
                                        {{--</div>--}}
                                        {{--@endforeach--}}
                                        {{--@endif--}}
                                    @endif
                                </div>
                                <div class="col-sm-4 mt-3">
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
                                    <div class="header">
                                        <ul>
                                            <li style="width: 75px ">ردیف</li>
                                            <li style="width: 205px ">عرض جغرافیای</li>
                                            <li style="width: 205px">طول جغرافیای</li>
                                            <li style="width: 205px ">نام مکان</li>
                                            <li style="width: 137px">شماره مکان</li>
                                        </ul>
                                    </div>
                                    @foreach($model->maps as $key=>$value)
                                        <div style="margin: 0 0 9px 0px;" class="udatemapOld" id="mapsed{{$key+1}}">
                                            <span style="color: #2196f3;text-align: center;display: inline-block;width: 70px;margin-left: 9px;border: 1px solid #cbcbcb;padding: 1px 7px 0px 4px;border-radius: 3px;background-color: #fff;"> مکان {{ $key + 1 }} </span>
                                            <input value="{{  $value->lat  }}"
                                                   style="background: #fff;border: 0;border: 1px solid #cbcbcb;border-radius: 3px;color: #777;"
                                                   value="53.175148" id="mlat{{$key +1}}" name="lat[]"
                                                   class="mapsed-lat">
                                            <input value="{{  $value->lon }}"
                                                   style="background: #fff;border: 0;border: 1px solid #cbcbcb;border-radius: 3px;color: #777;"
                                                   value="-1.423907999999983" id="mlng{{$key +1}}" name="lng[]"
                                                   class="mapsed-lng">
                                            <input value="{{  $value->title  }}"
                                                   style="background: #fff;border: 0;border: 1px solid #cbcbcb;border-radius: 3px;color: #777;"
                                                   id="mname{{$key +1}}" name="mapsedname[]" type="text">
                                            <input value="{{  $value->number }}"
                                                   style="background: #fff;border: 0;border: 1px solid #cbcbcb;border-radius: 3px;color: #777;"
                                                   id="mnumber{{$key +1}}" name="mapsednumber[]" type="number" min="1">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row w-100">
                            <div class="form-group col-md-12">
                                <label class="d-block" for="name"> تصاویر</label>
                                <div class="dropzone needsclick dz-clickable " id="demoupload">
                                    @foreach($model->images as $key=>$value)
                                        @if(@$value->media->path)
                                            <div id="id_{{ $value->id }}"
                                                 class="dz-preview dz-processing dz-image-preview dz-success dz-complete"
                                                 style="width: 220px;">
                                                <div class="dz-image">
                                                    <img style="width:100%; height: 180px"
                                                         data-dz-thumbnail=""
                                                         src="{{ url('').'/'.$value->media->path  }}">
                                                </div>
                                                <div class="dz-details">
                                                    <div class="dz-filename">
                                                        <span data-dz-name=""> {{ $value->media->name}}</span>
                                                    </div>
                                                </div>
                                                <div class=" boxtitle">
                                                    <input placeholder="عنوان" name="titleimg[{{ $value->id }}]"
                                                           type="text"
                                                           value="{{ $value->title }}">
                                                </div>
                                                <a class="dz-remove" data-dz-remove=""
                                                   onclick="removeimg('{{ $value->id }}')">حذف</a>
                                            </div>
                                        @endif
                                    @endforeach
                                    <div class="delay" style="display: none"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row w-100">
                            <div class="form-group col-md-12">
                                <label class="d-block" for="name"> تصویر شاخص </label>
                                <input type="file" name="thumbnail" >
                                {!! getError($errors,'thumbnail') !!}
                                @if($model->imageThumb)
                                    <img class="img-thumbnail" src=' {{ url($model->imageThumb) }}' style='width:150px; height: auto; margin-top:10px' />
                                @endif
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

                            <div class="form-group col-md-4 col-4 col-sm-4">
                                <label for="isOnline">فروش آنلاین
                                    <input type="checkbox" name="isOnline" style="vertical-align: middle" value="1" <?php echo ($model->isOnline=="1") ? "CHECKED" : ""; ?> id="isOnline" class="isOnlineBtn">
                                </label>
                            </div>

                            <div class="form-group col-md-4 col-4 col-sm-4">
                                <label for="capacity" class="d-block">ظرفیت تور</label>
                                <input type="number" min=0 name="capacity" value="{{@$model->capacity}}" class="capacity form-control <?php echo ($model->isOnline=="1") ? "hiddenInputs" : ""; ?>">
                            </div>
                            <br>

                            <div class="form-group col-md-12">
                                <label for="" class="d-block price_list">لیست قیمت <i class="priceIsOnline"> برای فروش آنلاین قیمت اجباری می باشد </i> </label>
                                <div class="row" id="price_list">
                                    @if(isset($model))
                                        @foreach($model->prices as $key=>$value)
                                            <div id="price_{{ $key + 1 }}" class="price  "
                                                 style="direction:rtl; margin-right:85px;margin-top:13px;position: relative">
                                                <div class="deleteprice" onclick="deleteprice({{ $key + 1 }})"
                                                     id="DeletePrice{{ $key + 1 }}"><i
                                                        class="icon-cross2 text-danger-400"></i></div>
                                                <div style="margin-bottom: 6px;color: #5a5c5d;"><span>قیمت تور</span>
                                                </div>
                                                <div>
                                                    <span style="color: #888585;font-size: 11px;"> نام  :</span>
                                                    <input value="{{ $value->name }}" name="name_price_package[]"
                                                           class="form-control"
                                                           style="width:160px;display: inline-block;margin-right: 92px;margin-bottom: 9px;"
                                                           type="text" min="0">
                                                </div>
                                                <div>
                                                    <span style="color: #888585;font-size: 11px;"> نوع  :</span>
                                                    <select name="type_price_package[]" class="form-control"
                                                            style="width:160px;margin-bottom: 11px;display: inline-block;margin-right: 89px;">
                                                        <option {{ ($value->type == '1') ? 'selected="selected"' : ''}} value="1">
                                                            هتل
                                                        </option>
                                                        <option {{ ($value->type == '2') ? 'selected="selected"' : ''}} value="2">
                                                            هتل آپارتمان
                                                        </option>
                                                        <option {{ ($value->type == '3') ? 'selected="selected"' : ''}} value="3">
                                                            مهمانپذیر
                                                        </option>
                                                        <option {{ ($value->type == '4') ? 'selected="selected"' : ''}} value="4">
                                                            خانه مسافر
                                                        </option>
                                                        <option {{ ($value->type == '5') ? 'selected="selected"' : ''}} value="5">
                                                            اقامتگاه
                                                        </option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <span style="color: #888585;font-size: 11px;"> انتخاب ستاره :</span>
                                                    <select name="star_price_package[]" class="   form-control"
                                                            style="width:160px;margin-bottom: 11px;display: inline-block;margin-right: 42px;">
                                                        <option {{ ($value->star == '0') ? 'selected="selected"' : ''}} value="0">
                                                            انتخاب ستاره
                                                        </option>
                                                        <option {{ ($value->star == '1') ? 'selected="selected"' : ''}} value="1">
                                                            یک ستاره
                                                        </option>
                                                        <option {{ ($value->star == '2') ? 'selected="selected"' : ''}} value="2">
                                                            دو ستاره
                                                        </option>
                                                        <option {{ ($value->star == '3') ? 'selected="selected"' : ''}} value="3">
                                                            سه ستاره
                                                        </option>
                                                        <option {{ ($value->star == '4') ? 'selected="selected"' : ''}} value="4">
                                                            چهار ستاره
                                                        </option>
                                                        <option {{ ($value->star == '5') ? 'selected="selected"' : ''}} value="5">
                                                            پنج ستاره
                                                        </option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <span style="color: #888585;font-size: 11px;">  هر نفر (استاندارد) (تومان)  :</span>
                                                    <input value="{{ $value->price }}" name="amount_price_package[]"
                                                           class="form-control amount_price_packages"
                                                           style="width:160px;display: inline-block;margin-right: 31px;"
                                                           type="number" min="1">
                                                </div>

                                                <div>
                                                    <span style="color: #888585;font-size: 11px;">  قیمت هر نوزاد  (تومان):</span>
                                                    <input value="{{ $value->baby }}" name="amount_price_baby[]"
                                                           class="form-control amount_price_packages"
                                                           style="width:160px;display: inline-block;margin-right: 31px;"
                                                           type="number" min="1">
                                                </div>

                                                <div>
                                                    <span style="color: #888585;font-size: 11px;">  قیمت زیر 5 سال  (تومان) :</span>
                                                    <input value="{{ $value->LTF }}" name="amount_price_LTF[]"
                                                           class="form-control amount_price_packages"
                                                           style="width:160px;display: inline-block;margin-right: 31px;"
                                                           type="number" min="1">
                                                </div>

                                                <div>
                                                    <span style="color: #888585;font-size: 11px;">  قیمت 6 تا 14 سال (تومان) :</span>
                                                    <input value="{{ $value->BSF }}" name="amount_price_BSF[]"
                                                           class="form-control amount_price_packages"
                                                           style="width:160px;display: inline-block;margin-right: 31px;"
                                                           type="number" min="1">
                                                </div>

                                                <div style="text-align: center;padding: 12px 0px 0 0"><span><i
                                                            style="font-size: 21px;color: #3f51b5;"
                                                            class="icon-plus-circle2"></i> </span></div>
                                                <div>
                                                    <span style="color: #888585;font-size: 11px;"> مقدار (ارز خارجی ) :</span>
                                                    <input value="{{ $value->price_dollar }}"
                                                           name="amount_price_dollar_package[]" class="form-control"
                                                           style="width:160px;display: inline-block;margin-right: 43px;"
                                                           type="number" min="1">
                                                </div>

                                                <div>
                                                    <select class="form-control" name="currency_price_package[]">
                                                        <?php foreach(config('defines.currency') as $rowCu=>$valCu) { ?>
                                                        <option <?php echo ($rowCu==$value->currency) ? "SELECTED" : ""; ?> value='<?php echo $rowCu ?>'><?php echo $valCu; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                            </div>
                                        @endforeach
                                    @else
                                        {{--@if(!empty(old('fieldsArray')))--}}
                                        {{--@foreach(old('fieldsArray') as $key=>$value)--}}
                                        {{--<div id="field_{{$key+1}}"  class="form-group col-md-6 field">--}}
                                        {{--<label for="name"> <span> {{ __('admin.Field') }} </span><span>{{$key+1}}</span> </label>--}}
                                        {{--<input name="fieldsArray[]"  value="{{ $value }}"  type="text" class="form-control" placeholder="{{  __('validation.required',['attribute'=>__('admin.Field')]) }}">--}}
                                        {{--</div>--}}
                                        {{--@endforeach--}}
                                        {{--@endif--}}
                                    @endif
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
                                {{ Form::textarea('documents',null,['class'=>'width100','']) }}
                                {!! getError($errors,'documents') !!}
                            </div>
                        </div>
                        <div class="row w-100">
                            <div class="form-group col-md-12">
                                <label class="d-block" for="name">قوانین</label>
                                {{ Form::textarea('rules',null,['class'=>'width100','']) }}
                                {!! getError($errors,'rules') !!}
                            </div>
                        </div>
                        <div class="row w-100">
                            <div class="form-group col-md-12">
                                <label class="d-block" for="name"> توضیحات تکمیلی تور </label>
                                {{ Form::textarea('description',null,['class'=>'width100 ','']) }}
                                {!! getError($errors,'description') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('isSuperAdmin',App\User::Class)
            <div style='margin: 0 auto; display: block; width: 100px;'>
                <div class="form-group col-md-3" >
                    <label for="name" style="display: inline-block">وضعیت</label>
                    {!! form::checkbox('status',1,$model->status ?? 0,['class'=>'form-check-input-switchery']) !!}
                    {!! getError($errors,'status') !!}
                </div>
            </div>
        @endcan
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 text-center">
                    <button style="width: 300px;height: 60px;font-size: 20px;" type="submit" class="btn btn-primary">
                        ویرایش تور <i class="icon-arrow-left13 position-right"></i></button>
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

            if ($('#isOnline').prop('checked') == true) {
                if ($(".amount_price_packages").length < 1) {
                    hasError = true;
                    $(".priceIsOnline").show();

                } else {
                    $(".priceIsOnline").hide();

                    var allEmpty = 'y';
                    $(".amount_price_packages").each(function(index, value) {
                        console.log(value.value);
                        if (value.value) {
                            allEmpty = 'n';
                        }
                    });

                    if(allEmpty=='y'){
                        hasError = true;
                        $(".priceIsOnline").show();
                    }else{
                        $(".priceIsOnline").hide();
                    }

                }
            } else {
                $(".priceIsOnline").hide();

            }



            if(hasError){

                $(".list-icons-item").removeClass('rotate-180');
                $('.card').find('.card-body').slideDown(150);

                alert('فیلد های دارای ستاره را پر نمایید');
                e.preventDefault();
            }


        })


        $(".card-header").click(function () {
            $(this).closest('.card').toggleClass('card-collapsed');
            $(this).closest('.card').find('.card-body').slideToggle(150);
            $(this).closest('.card').find('.list-icons-item').toggleClass('rotate-180');
        });


        $(".list-icons-item").click(function (e) {
            e.preventDefault();
            return false;
        });


        $('#iconPicker').find('img').click(function () {
            let address = $(this).data('image');
            let newAddress = "{{ url('/') }}" + "/" + address;
            $("#btnExistFile").find("i").html(" <img src=" + newAddress + " width=40 />");
            $('#existFile').val(address);
            $(".modal-footer .btn").click();
        });
    </script>
    <script>
        $("div#demoupload").dropzone({
            url: "<?=url('admin/MainUploadImg') . '/' . $model->id?>",
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
        removeimg = function (id) {
            $('#demoupload .delay').css('display', 'block');
            $('#id_' + id).remove();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '<?= url('admin/MainDeleteImg')  ?>',
                type: "POST",
                data: 'id=' + id + '&type=IMG',
                success: function (result) {
                    if (result == 'ok') {
                        $('#demoupload .delay').css('display', 'none');
                        let count = document.getElementsByClassName('dz-preview').length;
                        if (count > 0) {
                            $('#demoupload .dz-message').css('display', 'none');
                        } else {
                            $('#demoupload .dz-message').css('display', 'block');
                        }
                    }
                }
            });

        };
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
                url: '<?= url('admin/MainDeleteImg')  ?>',
                type: "POST",
                data: 'id=' + id + '&type=TMP',
                success: function (result) {
                    if (result == 'ok') {
                        $('#demoupload .delay').css('display', 'none');
                        let count = document.getElementsByClassName('dz-preview').length;
                        if (count > 0) {
                            $('#demoupload .dz-message').css('display', 'none');
                        } else {
                            $('#demoupload .dz-message').css('display', 'block');
                        }
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
                '<input name="name_price_package[]"   class="form-control" style="width:160px;display: inline-block;margin-right: 92px;margin-bottom: 9px;" type="text" min="0">' +
                ' </div> ' +
                '<div> <span style="color: #888585;font-size: 11px;"> نوع  :</span>' +
                '<select name="type_price_package[]"    class="form-control" style="width:160px;margin-bottom: 11px;display: inline-block;margin-right: 89px;"><option value="1">هتل</option><option value="2">هتل آپارتمان</option><option value="3">مهمانپذیر</option><option value="4">خانه مسافر</option><option value="5">اقامتگاه</option></select>' +
                ' </div> ' +
                '<div> <span style="color: #888585;font-size: 11px;"> انتخاب ستاره :</span>' +
                '<select name="star_price_package[]"    class="   form-control" style="width:160px;margin-bottom: 11px;display: inline-block;margin-right: 42px;"><option value="0">انتخاب ستاره</option> <option value="1">یک ستاره</option><option value="2">دو ستاره</option><option value="3">سه ستاره</option><option value="4">چهار ستاره</option><option value="5">پنج ستاره</option></select>' +
                ' </div> ' +
                '<div> <span style="color: #888585;font-size: 11px;"> هر نفر (استاندارد) :</span> <input name="amount_price_package[]"   class="form-control amount_price_packages" style="width:160px;display: inline-block;margin-right: 31px;" type="number" min="1"> </div>' +
                '<div> <span style="color: #888585;font-size: 11px;"> قیمت هر نوزاد :</span> <input name="amount_price_baby[]"   class="form-control amount_price_packages" style="width:160px;display: inline-block;margin-right: 31px;" type="number" min="1"> </div>' +
                '<div> <span style="color: #888585;font-size: 11px;"> قیمت زیر 5 سال : </span> <input name="amount_price_LTF[]"   class="form-control amount_price_packages" style="width:160px;display: inline-block;margin-right: 31px;" type="number" min="1"> </div>' +
                '<div> <span style="color: #888585;font-size: 11px;"> قیمت 6 تا 14 سال : </span> <input name="amount_price_BSF[]"   class="form-control amount_price_packages" style="width:160px;display: inline-block;margin-right: 31px;" type="number" min="1"> </div>' +
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
        // add_level = function () {
        //     var count = document.getElementsByClassName('level').length + 1;
        //     var html = '<div id="level_' + count + '"   class="level  "  style="direction:rtl; margin-right:30px;margin-top:13px;">' +
        //         '<label style="margin-bottom: 6px;color: #2196f3;border: 1px solid #2196f3;border-radius: 2px;padding: 2px 4px 1px 5px;"> <span>مرحله</span> <span>' + count + '</span> </label>' +
        //         '<input type="hidden" name="number_level[]" value="' + count + '"> ' +
        //         '<div> <span style="color: #707070;font-size: 12px;"> عنوان :</span><input name="title_level[]"   type="text" class="form-control" style="width:300px;margin-bottom: 11px;display: inline-block;margin-right: 42px;"> </div> ' +
        //         '<div style="display: flex;"> <span style="color: #707070;font-size: 12px;"> توضیحات :</span> <textarea name="description_level[]"  class="form-control" style="width:500px;display: inline-block;margin-right: 20px;"></textarea> </div>' +
        //         '</div>';
        //     $("#level_list").append(html);
        // };



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
    <script src="{{url('js/admin/mapsed.js?version=22')}}"></script>
    <script>



        $("#add-places").mapsed({


            showOnLoad:
                [
                        @foreach($model->maps as $key=>$value)
                    {
                        lat: {{ $value->lat }},
                        lng: {{ $value->lon }},
                        canEdit: false,
                        visible: true,
                        draggable: true,

                    },
                    @endforeach

                ],

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

    </script>
    <script>
        $(".udatemap").remove();
        let count = document.getElementsByClassName('dz-preview').length;
        if (count > 0) {
            $('#demoupload .dz-message').css('display', 'none');
        }


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
                $(this).closest('.form-group').find('.hiddenInputs').val(' ');
            });

            $(".isOnlineBtn").change(function() {
                if ($(this).prop('checked') == true) {
                    $(".capacity").addClass('hiddenInputs');
                } else {
                    $(".capacity").removeClass('hiddenInputs');
                    $(".capacity").closest('.form-group').find('.d-block').removeClass('borderRed');
                    $(".priceIsOnline").hide();
                }

            });

        });


    </script>
@endsection
