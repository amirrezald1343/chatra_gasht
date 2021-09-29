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

                </div>
                <div class="card-body">

                    {{ Form::open(['route'=>['admin.FavoriteTours.store'],'files'=>true,'method'=>'post','class'=>'form-horizontal']) }}

                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-12">
                            <label for="name">عنوان :</label>
                            {{ Form::text('title',null,['class'=>'form-control','placeholder'=> __('validation.required',['attribute'=>'عنوان'])]) }}
                            {!! getError($errors,'title') !!}
                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-12">
                            <label class="d-block" for="name">کشور</label>
                            {!! Form::select('country',[$countries],null  ,['class'=>'form-control select-fixed-single','','data-placeholder'=>'انتخاب کنید..']) !!}
                            {!! getError($errors,'country') !!}
                        </div>

                        <div class="form-group col-md-12 col-sm-12 col-12">
                            <label class="d-block" for="name">توضیحات مختصر</label>
                            {{ Form::textarea('details',null,['class'=>'summernote','']) }}
                            {!! getError($errors,'details') !!}
                        </div>

                        <div class="form-group col-md-12 col-sm-12 col-12">
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


                        <div class="form-group  col-md-6 col-sm-6 col-12 mt-3">
                            <input type="submit" class="btn btn-primary"
                                   value="{{ isCreate() ? 'ایجاد' : 'ایجاد'  }} {{ $FANAME }} "/>
                        </div>
                    </div>
                    {{ Form::close() }}
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

    <script type="text/javascript"
            src="<?= url('global_assets/js/plugins/editors/summernote/summernote.min.js') ?>"></script>

    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/uniform.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/demo_pages/editor_summernote.js') ?>"></script>

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