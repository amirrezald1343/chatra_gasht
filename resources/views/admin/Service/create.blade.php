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
                        <div class="form-group col-md-6 col-sm-6 col-12">
                            <label for="name">عنوان :</label>
                            {{ Form::text('title',null,['class'=>'form-control','placeholder'=> __('validation.required',['attribute'=>'عنوان'])]) }}
                            {!! getError($errors,'title') !!}
                        </div>
                        <div class="form-group  col-md-6 col-sm-6 col-12">
                            <label for="name" class="d-block">آیکون :</label>
                            {{ Form::hidden('icon',null,['required','id'=>'existFile']) }}
                            <button id="btnExistFile" type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#selectIcon">
                                <i class="position-right">انتخاب آیکون
                                    @if(isset($model['icon']))
                                        <img src={{ url('/'.$model['icon']) }} width="40"/>
                                    @endif
                                </i>
                            </button>
                            {!! getError($errors,'icon') !!}
                        </div>
                        <div class="form-group  col-md-6 col-sm-6 col-12 my-3">
                            <div class="form-check form-check-switchery form-check-inline form-check-right">
                                <label class="form-check-label">
                                    {!! form::checkbox('status',1,$model->status ?? 1,['class'=>'form-check-input-switchery']) !!}
                                    {{ __('admin.status') }}:
                                </label>
                                {!! getError($errors,'status') !!}
                            </div>
                        </div>

                        <div class="form-group  col-md-6 col-sm-6 col-12 mt-3">
                            <input type="submit" class="btn btn-primary"
                                   value="{{ isCreate() ? 'ایجاد' : 'ویرایش'  }} {{ $FANAME }} "/>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    <div id="selectIcon" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;
                    </button>
                </div>
                <div class="modal-body" id="iconPicker">
                    <h6 class="font-weight-semibold mb-4">  لطفا ایکون خدمات مورد نظر را انتخاب نمایید.</h6>
                    <hr>
                    @foreach($storage as $item=>$value)
                        <img src="{{ url(str_replace('\\','/',$value->getPathname())) }}" data-image="{{ str_replace('\\','/',$value->getPathname()) }}" width="40">
                    @endforeach
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn bg-slate"
                            data-dismiss="modal">{{ __('admin.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/uniform.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_inputs.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/switchery.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/switch.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_checkboxes_radios.js') ?>"></script>
    <script>
        $('#iconPicker').find('img').click(function () {
            let address = $(this).data('image');
            let newAddress = "{{ url('/') }}" + "/" + address;
            $("#btnExistFile").find("i").html(" <img src=" + newAddress + " width=40 />");
            $('#existFile').val(address);
            $(".modal-footer .btn").click();
        });
    </script>
@endsection