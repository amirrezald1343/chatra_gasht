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
        {{ Form::open(['route'=>['admin.adminContactUpdate'],'files'=>true,'method'=>'post','class'=>'form-horizontal w-100']) }}


        <div class="col-md-12">
            <div class="card">
                <div class="card-header mb-3">
                </div>
                <div class="card-body">

                    <div class="row w-100">
                        <div class="form-group col-md-12">
                            <label class="d-block" for="name"> ارتباط با ما <span
                                        class="required-input">*</span></label>
                            {{ Form::textarea('description',$model['body'],['class'=>'summernote','']) }}
                            {!! getError($errors,'description') !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12 mt-3">
                            <input type="submit" class="btn btn-primary"
                                   value="{{ 'ویرایش'  }}  "/>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{ Form::close() }}

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


    <script type="text/javascript"
            src="<?= url('global_assets/js/plugins/editors/summernote/summernote.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/uniform.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/demo_pages/editor_summernote.js') ?>"></script>

@endsection