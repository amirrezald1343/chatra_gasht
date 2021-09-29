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

    .status_read {
        color: green;
    }

    .status_unread {
        color: orange;
    }
</style>
@endsection
@section('content')




<div class="row justify-content-center">


    <div class="col-md-12">
        <div class="card">
            <div class="card-body overflow-auto">
                <table class="table table-striped" style="min-width: 765px;">
                    <thead>
                        <tr>

                            <th>تور</th>
                            <th>نام و نام خانوادگی</th>
                            <th>ایمیل</th>
                            <td>شماره تماس</td>
                            <td>تاریخ ثبت</td>
                            <!-- <th>وضعیت تور</th> -->

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($model as $rows)

                        <tr>

                            <td>{{ $rows->title }}</td>
                            <td>{{ $rows->name }}</td>
                            <td>{{ $rows->email }}</td>
                            <td>{{ $rows->cellphone }}</td>
                            <td>{{ Morilog\Jalali\Jalalian::forge($rows->created_at)->format('H:i @ Y/m/d') }}</td>
                            <!-- <td class="status_{{$rows->status}}">{{ config('defines.read-status')[$rows->status] }}</td> -->


                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {!! $model->links() !!}
    </div>

</div>






@endsection
@section('scripts')
<script src="<?= url('js/adminVue.js') ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/selects/select2.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_select2.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_inputs.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/switchery.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/switch.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/demo_pages/form_checkboxes_radios.js') ?>"></script>


<script type="text/javascript" src="<?= url('global_assets/js/plugins/editors/summernote/summernote.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/uniform.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/demo_pages/editor_summernote.js') ?>"></script>

@endsection