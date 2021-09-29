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

                {{ Form::open(['route'=>['admin.post.update',$post->id],'files'=>true,'method'=>'post','class'=>'form-horizontal']) }}

                <div class="row">

                    <div class="form-group col-md-6 col-sm-6 col-12">
                        <label for="name">عنوان : <span class="required-input">*</span> </label>
                        {{ Form::text('title',$post->title,['class'=>'form-control','placeholder'=> __('validation.required',['attribute'=>'عنوان'])]) }}
                        {!! getError($errors,'title') !!}
                    </div>

                    <div class="form-group col-md-12 col-sm-12 col-12">
                        <label class="d-block" for="name">چکیده متن : <span class="required-input">*</span></label>
                        {{ Form::text('summary',$post->summary,['class'=>'form-control','placeholder'=> __('validation.required',['attribute'=>'چکیده متن'])]) }}
                        {!! getError($errors,'summary') !!}
                    </div>


                    <div class="form-group col-md-12 col-sm-12 col-12">
                        <label class="d-block" for="name">متن : <span class="required-input">*</span></label>
                        {{ Form::textarea('body',$post->body,['class'=>'ckEr','']) }}
                        {!! getError($errors,'body') !!}
                    </div>

                    <div class="form-group col-md-12 col-sm-12 col-12">
                        <label for="name">کلمات کلیدی : </label>
                        {{ Form::text('tags',$post->tags,['class'=>'form-control inputTagSelector','placeholder'=> __('validation.required',['attribute'=>'عنوان'])]) }}
                        {!! getError($errors,'tags') !!}
                    </div>

                    <div class="form-group col-md-6  col-6 col-sm-6">
                        <label class="d-block" for="name">تور مرتبط : </label>
                        <v-select multiple :options="options" @search="onSearchTour" dir="rtl" label="title" v-model="value_continents_tour" @if($post->packages)
                            v-init:value_continents_tour="[
                            @foreach($post->packages as $value)
                            { id: '{{ $value->id }}', title: '{{ $value->title  }}' },
                            @endforeach
                            ]"
                            @endif
                            >
                            <template slot="no-options">هیچ موردی یافت نشد.</template>
                            <template slot="option" slot-scope="option">
                                <div class="d-center">
                                    @{{ option.title }}
                                </div>
                            </template>
                            <template slot="selected-option" slot-scope="option">
                                <div class="selected d-center">
                                    @{{ option.title }}
                                </div>
                            </template>
                        </v-select>
                        <input name="tours" type="hidden" v-model="valueContinentsTour">

                    </div>

                    <div class="form-group col-md-12 col-sm-12 col-12">
                        <label for="attach">{{ 'تصویر بند انگشتی' }}: <span class="required-input">*</span> </label>
                        {{ Form::file('file',['class'=>'form-control-uniform-custom','placeholder'=> __('validation.required',['attribute'=>__('admin.attach')])]) }}
                        {!! getError($errors,'file') !!}


                        @if($post->image_thumb)
                        <img src='{{url("/$post->image_thumb")}}' style="width:300px;height:250px;" />
                        @endif


                    </div>

                    <br>

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
<script type="text/javascript" src="<?= url('js/jQuery.tagify.min.js') ?>"></script>
<script src="<?= url('js/adminVue.js') ?>" type="text/javascript"></script>


<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_inputs.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/switchery.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/switch.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_checkboxes_radios.js') ?>"></script>

<!-- <script type="text/javascript" src="<?= url('global_assets/js/plugins/editors/summernote/summernote.min.js') ?>"></script> -->

<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/uniform.min.js') ?>"></script>
<!-- <script type="text/javascript" src="<?= url('global_assets/js/demo_pages/editor_summernote.js') ?>"></script> -->
<script type="text/javascript" src="<?= url('ckeditor/ckeditor.js?v=12') ?>"> </script>
<script>
    $('.inputTagSelector').tagify({
        maxTags: 15,
    });

    $(document).ready(function(e) {

        setTimeout(function() {
            CKEDITOR.replace('body', {
            height: 480,
            filebrowserUploadUrl: "{{route('admin.post.uploadImage', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
        }, 1200);

    });
</script>
@endsection
