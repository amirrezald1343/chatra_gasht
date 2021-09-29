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
                <div class="card-body overflow-auto">
                    <table class="table table-striped" style="min-width: 765px;">
                        <thead>
                        <tr>

                            <th>موضوع</th>
                            <th>نام و نام خانوادگی</th>
                            <th>ایمیل</th>
                            <td>شماره تماس</td>
                            <td>تاریخ ثبت</td>
                            <th>متن تیکت</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($model as $rows)

                            <tr>

                                <td>{{ $rows->subject }}</td>
                                <td>{{ $rows->name }}</td>
                                <td>{{ $rows->mail }}</td>
                                <td>{{ $rows->phone_number }}</td>
                                <td>{{ Morilog\Jalali\Jalalian::forge($rows->created_at)->format('H:i @ Y/m/d') }}</td>
                                <td class="help-tour" title="{{$rows->message}}">{{mb_substr($rows->message,0,15)}} . . . </td>
                                {{--<td>{{ config('defines.active_status')[$rows->status] }}</td>--}}


                                <td class="text-center">

                                    {{--                                    @can('destroy', [\App\User::class,$NAME])
                                                                            <a href="#" @click.prevent="" class="list-icons-item" data-toggle="modal" data-target="#delete-{{ $favs->id }}"><i class="icon-trash"></i></a>
                                                                        @endcan
                                                                        <div id="delete-{{ $favs->id }}" class="modal fade" tabindex="-1">
                                                                            <div class="modal-dialog modal-sm">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <h6 class="font-weight-semibold mb-4"> {{ __('admin.Delete') .' '. $FANAME }}</h6>
                                                                                        <p>{{ __('admin.Are you sure you want to delete this information?') }}</p>
                                                                                        <hr>
                                                                                    </div>
                                                                                    <div class="modal-footer justify-content-center">
                                                                                        <button type="button" class="btn bg-slate"
                                                                                                data-dismiss="modal">{{ __('admin.No') }}</button>
                                                                                        <form action="{{ route('admin.FavoriteTours.destroy', ['id' => $favs->id]) }}"
                                                                                              method="POST">
                                                                                            @csrf
                                                                                            {{ method_field('DELETE') }}
                                                                                            <button type="submit"
                                                                                                    class="btn bg-danger">{{ __('admin.Yes') }} !
                                                                                            </button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>--}}


                                </td>


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