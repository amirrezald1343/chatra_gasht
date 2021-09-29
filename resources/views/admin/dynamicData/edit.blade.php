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

                {{ Form::open(['route'=>['admin.locationRelatesUpdate'],'files'=>true,'method'=>'post','class'=>'form-horizontal']) }}

                <div class="row">

                    <div class="form-group col-md-6 col-sm-12 col-12">
                        <label>شهر :</label>
                        {{ Form::select('city',$cities,'',['class'=>'citySelect2','autocomplete'=>'on']) }}
                        {!! getError($errors,'password') !!}

                    </div>

                    <div class="form-group col-md-6 col-sm-12 col-12">
                        <label>کشور :</label>
                        {{ Form::select('country',$coutries,'',['class'=>'countrySelect2 ','autocomplete'=>'on']) }}
                        {!! getError($errors,'password') !!}
                    </div>

                    <div class="form-group  col-md-6 col-sm-6 col-12 mt-3">
                        <input type="submit" class="btn btn-primary" value="{{ isCreate() ? 'ویرایش' : 'ویرایش'  }} " />
                    </div>
                </div>
                {{ Form::close() }}

            </div>
            <hr>
       
            <div class="card-body">
                <h6 style="margin-right:5px;padding:9px; background-color:#f7f7f7;display:inline-block">   شهر های دارای ارتباط : </h6>

                <table class="table table-hover">
                    <thead>
                        <td>#</td>
                        <td> کشور </th>
                        <th> شهر </th>
                    </thead>

                    <tbody> 
                        @php $i=1; @endphp
                    @foreach($getRelateToCountry as $row=>$val)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{$val}}</td>
                        <td>{{$row}}</td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach

                    </tbody>
                    
                </table>

            </div>

        </div>
    </div>
</div>

@endsection
@section('scripts')

<script src="<?= url('js/adminVue.js') ?>" type="text/javascript"></script>

<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_inputs.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/switchery.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/switch.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_checkboxes_radios.js') ?>"></script>


<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/inputs/maxlength.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_controls_extended.js') ?>"></script>

{{-------------editor-------------}}
<script type="text/javascript" src="<?= url('global_assets/js/plugins/editors/summernote/summernote.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/demo_pages/editor_summernote.js') ?>"></script>

<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/selects/select2.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_select2.js') ?>"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.citySelect2').select2();
        $('.countrySelect2').select2();
    });
</script>


@endsection