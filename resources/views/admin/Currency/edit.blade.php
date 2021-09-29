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
          
                        {{ Form::open(['route'=>['admin.updateCurrencies'],'files'=>true,'method'=>'post','class'=>'form-horizontal']) }}
                  
                    <div class="row">



                            @foreach(config('defines.currency') as $key=>$val)
                                <div class="form-group col-md-12 col-sm-12 col-12">
                                    <label for="name">{{$val}} :</label>
                                    <input value="<?php echo (count(@$currencies)) ? @$currencies[$key]  : 0;  ?>"
                                     type='number' name="currency[<?=$key ?>]" class="form-control" required='required' style='min-width:250px; width:60% !important' placeholder='مبلغ را با تومان وارد کنید' >
                                    
                                </div>
                            @endforeach

                        <div class="form-group  col-md-12 col-sm-12 col-12 mt-3">
                            <input type="submit" class="btn btn-primary"
                                   value="{{ isCreate() ? 'ویرایش' : 'ویرایش'  }} "/>
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

@endsection