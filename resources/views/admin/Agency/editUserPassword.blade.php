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
          
                        {{ Form::open(['route'=>['admin.updateUserPasswords'],'files'=>true,'method'=>'post','class'=>'form-horizontal']) }}
                  
                    <div class="row">
                        <div class="form-group col-md-12 col-sm-12 col-12">
                            <label for="name">رمز عبور :</label>
                            {{ Form::text('password',null,['class'=>'form-control','autocomplete'=>'off']) }}
                            {!! getError($errors,'password') !!}
                        </div>

                        <div class="form-group col-md-12 col-sm-12 col-12">
                            <label for="name">تکرار رمز عبور :</label>
                            {{ Form::text('password_confirmation',null,['class'=>'form-control','autocomplete'=>'off']) }}
                            
                        </div>
   

                        <div class="form-group  col-md-6 col-sm-6 col-12 mt-3">
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