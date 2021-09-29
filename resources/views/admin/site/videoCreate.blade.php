@extends('admin.layout.admin')
@section('style')
<link href="{{url('css/tagify.css')}}" rel="stylesheet">
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

                {{ Form::open(['route'=>['admin.video.store'],'files'=>true,'method'=>'post','class'=>'form-horizontal']) }}

                <div class="row">

                    <div class="form-group col-md-6 col-sm-6 col-12">
                        <label for="name">عنوان : <span class="required-input">*</span> </label>
                        {{ Form::text('title',null,['class'=>'form-control','placeholder'=> __('validation.required',['attribute'=>'عنوان'])]) }}
                        {!! getError($errors,'title') !!}
                    </div>

                    <div class="form-group col-md-6 col-sm-6 col-12">
                        <label for="name">آدرس فایل : <span class="required-input">*</span> </label>
                        {{ Form::text('url',null,['class'=>'form-control','placeholder'=> __('validation.required',['attribute'=>'آدرس فایل'])]) }}
                        {!! getError($errors,'url') !!}
                    </div>

                    <div class="form-group col-md-12 col-sm-12 col-12">
                        <label class="d-block" for="name">متن : <span class="required-input">*</span></label>
                        {{ Form::textarea('body',null,['class'=>'body','']) }}
                        {!! getError($errors,'body') !!}
                    </div>

                    <div class="form-group col-md-12 col-sm-12 col-12">
                        <label for="attach">{{ 'تصویر پوستر' }}: <span class="required-input">*</span> </label>
                        {{ Form::file('file',['class'=>'form-control-uniform-custom','placeholder'=> __('validation.required',['attribute'=>__('admin.attach')])]) }}
                        {!! getError($errors,'file') !!}
                    </div>


                    <div class="form-group  col-md-6 col-sm-6 col-12 mt-3">
                        <input type="submit" class="btn btn-primary" value=" ثبت مطلب جدید " />
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="<?= url('js/adminVue.js') ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?= url('js/jQuery.tagify.min.js') ?>"></script>



<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_inputs.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/switchery.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/switch.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_checkboxes_radios.js') ?>"></script>

<!-- <script type="text/javascript" src="<?= url('global_assets/js/plugins/editors/summernote/summernote.min.js') ?>"></script> -->
<script type="text/javascript" src="<?= url('ckeditor/ckeditor.js') ?>"> </script>
<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/uniform.min.js') ?>"></script>
<!-- <script type="text/javascript" src="<?= url('global_assets/js/demo_pages/editor_summernote.js') ?>"></script> -->

<script>
    $('.inputTagSelector').tagify({
        maxTags: 15,
    });
    $(document).ready(function(e) {

        setTimeout(function() {
            CKEDITOR.replace('body', {
                contentsLangDirection: 'rtl',
            });
        }, 1200);


    });
</script>
@endsection