@extends('admin.layout.admin')
@section('style')
    <style>
        #iconPicker img {
            margin-bottom: 2px;
            margin-right: 2px;
            cursor: pointer;
        }

        .modal-footer {
            padding-top: 15px;
        }

        #iconPicker img:hover {
            transform: scale(1.5);
            transition: all 0.2s;
        }

        .text-small {
            font-size: 1em;
        }
    </style>
@endsection
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header mb-3">
                    <i class="icon-link"></i> <span>لینک های مرتبط : </span>
                    <a href="{{ route('admin.'.$NAME.'.index') }}"
                       class="btn bg-slate text-small">{{ ' لیست '.$FANAME }}</a>
                </div>
                <div class="card-body">
                    @if(isset($model))
                        {{ Form::model($model,['route'=>['admin.'.$NAME.'.update',$model->id],'files'=>true,'method'=>'put','class'=>'form-horizontal']) }}
                    @else
                        {{ Form::open(['route'=>['admin.'.$NAME.'.store'],'files'=>true,'method'=>'post','class'=>'form-horizontal']) }}
                    @endif
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">{{ __('admin.first and last name') }}:  <span class="required-input">*</span></label>
                            {{ Form::text('name',null,['class'=>'form-control','placeholder'=> __('validation.required',['attribute'=>__('admin.first and last name')])]) }}
                            {!! getError($errors,'name') !!}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nationalNumber">{{ __('admin.national number') }}: <span class="required-input">*</span></label>
                            {{ Form::text('nationalNumber',null,['class'=>'form-control','placeholder'=> __('validation.required',['attribute'=>__('admin.national number')])]) }}
                            {!! getError($errors,'nationalNumber') !!}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="domain">{{ __('admin.domain') }}: </label>
                            {{ Form::text('domain',null,['class'=>'form-control','placeholder'=> __('validation.required',['attribute'=>__('admin.domain')]).' : http://domain.com']) }}
                            {!! getError($errors,'domain') !!}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="company">{{ __('admin.company') }}: <span class="required-input">*</span></label>
                            {{ Form::text('company',null,['class'=>'form-control','placeholder'=> __('validation.required',['attribute'=>__('admin.company')])]) }}
                            {!! getError($errors,'company') !!}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tellPhone">{{ __('admin.telephone') }}: <span class="required-input">*</span></label>
                            {{ Form::text('tellPhone',null,['class'=>'form-control','placeholder'=> __('validation.required',['attribute'=>__('admin.telephone')])]) }}
                            {!! getError($errors,'tellPhone') !!}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cellPhone">{{ __('admin.cellphone number') }}: <span class="required-input">*</span></label>
                            {{ Form::text('cellPhone',null,['class'=>'form-control','placeholder'=> __('validation.required',['attribute'=>__('admin.cellphone')])]) }}
                            {!! getError($errors,'cellPhone') !!}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="internalCode">{{ 'کد داخلی' }}: </label>
                            {{ Form::text('internalCode',null,['class'=>'form-control','placeholder'=>'کد تلفن داخلی']) }}
                            {!! getError($errors,'internalCode') !!}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">{{ __('admin.email') }}: <span class="required-input">*</span></label>
                            {{ Form::email('email',null,['class'=>'form-control','placeholder'=> __('validation.required',['attribute'=>__('admin.email')])]) }}
                            {!! getError($errors,'email') !!}
                        </div>

                        <div class="form-group col-md-12">
                                <label for="password">{{ __('admin.password') }}: </label>
                                {{ Form::text('password',null,['class'=>'form-control','placeholder'=> 'رمز عبور' ]) }}
                                {!! getError($errors,'password') !!}
                        </div>

                        
                        <div class="form-group col-md-12" style="border-bottom:1px solid #d6d6d6">
                            <label for="agencyRules">قوانین آژانس:</label>
                            {!! Form::select('agencyRules[]',config('defines.agencyRules'), null, ['multiple'=>'multiple','class'=>'form-control select-fixed-single select2-hidden-accessible','id'=>'agencyRules']) !!}
                            {!! getError($errors,'agencyRules') !!}
                        </div>

                        @if(isset($onEdit) and $onEdit=='true')
                            @php
                                $generateDate=$model['expDate'];
                            @endphp
                        @else
                            @php
                                $generateDate=Carbon\Carbon::createFromFormat('Y-m-j H:i:s',(\Carbon\Carbon::now())  );
                            @endphp
                        @endif

                        <div class="form-group col-md-6">
                            <label for="name">تاریخ اعتبار
                                <small>(dd/mm/yyyy)</small>
                                <span class="required-input">*</span>
                            </label>
                            <date-picker
                                    value="{{ $generateDate }}"
                                    initial-value="{{ $generateDate }}"
                                    display-format="jYYYY/jMM/jDD"
                                    format="YYYY-MM-DD HH:mm:ss"
                                    :auto-submit="true"
                                    :clearable="true"
                                    locale="fa"
                                    name="expDate"
                                    placeholder="تاریخ اعتبار را وارد کنید"
                            ></date-picker>
                            {!! getError($errors,'expDate') !!}
                        </div>

                        <div class="form-group col-md-6">
                            <label for="agencyLicense">شماره مجوز</label>
                            {!! Form::text('agencyLicense',null, ['class'=>'form-control','id'=>'agencyLicense']) !!}
                            {!! getError($errors,'agencyLicense') !!}
                        </div>

                        <div class="form-group col-md-6">
                            <label for="address">{{ __('admin.address') }}: <span class="required-input">*</span></label>
                            {{ Form::text('address',null,['class'=>'form-control','placeholder'=> __('validation.required',['attribute'=>__('admin.address')])]) }}
                            {!! getError($errors,'address') !!}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="attach">{{ __('admin.attach') }}:</label>
                            {{ Form::file('file',['class'=>'form-control-uniform-custom','placeholder'=> __('validation.required',['attribute'=>__('admin.attach')])]) }}
                            @isset($model->media->path)
                                {{ __('admin.before file') }} : <a href="{{ url($model->media->path) }}" target="_blank"
                                                                   title="{{ $model->media->name }}" type="button"
                                                                   class="btn bg-indigo-400 legitRipple mt-2">{{__('admin.download')}}
                                    <i class="icon-link"></i></a>
                            @endisset
                            {!! getError($errors,'file') !!}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="permission">{{ __('admin.permission') }}:</label>
                            {!! Form::select('permission_id', $permissions, null, ['class'=>'form-control','id'=>'permission']) !!}
                            {!! getError($errors,'permission_id') !!}
                        </div>

                        <div class="form-group col-md-4 my-3">
                            <div class="form-check form-check-switchery form-check-inline form-check-right">
                                <label class="form-check-label">
                                    {!! form::checkbox('status',1,$model->status ?? 0,['class'=>'form-check-input-switchery']) !!}
                                    {{ __('admin.status') }}:
                                </label>
                                {!! getError($errors,'status') !!}
                            </div>
                        </div>



                        <div class="form-group col-md-4 my-3">
                            <div class="form-check form-check-switchery form-check-inline form-check-right">
                                <label class="form-check-label">
                                    {!! form::checkbox('sendSms',1,'',['class'=>'form-check-input-switchery']) !!}
                                    {{ 'ارسال پیامک مشخصات' }}:
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-md-12 mt-3">
                            <input type="submit" class="btn btn-primary"
                                   value="{{ isCreate() ? 'ایجاد' : 'ویرایش'  }} {{ $FANAME }} "/>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="<?= url('js/adminVue.js')?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/selects/select2.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_select2.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/uniform.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_inputs.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/switchery.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/switch.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_checkboxes_radios.js') ?>"></script>

@endsection