@extends('admin.layout.admin')
@section('style')
<link href="<?= url('css/admin/user.css') ?>" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">

            <div class="card-body overflow-auto">
                <table class="table table-striped" style="min-width: 765px;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>شهر</th>
                            <th>تاریخ</th>
                            <th>آژانس</th>
                            <th>وضعیت</th>
                            <th>آیتم ها</th>

                            <th class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $key=>$item)
                        <tr>
                            <td>{{ ($items->currentPage() - 1) * $items->perPage() + $key + 1 }}</td>
                            <td>{{ $item->city->title_fa }}</td>
                            <td> {{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($item->date))  }}</td>
                            <td>{{ $item['agency']['company'] }}</td>
                            <td>{!! $item->status == '1' ? '<span class="badge badge-flat border-success text-success-600"> فعال </span>' : '<span class="badge badge-flat border-info text-info-600"> در انتظار تایید..</span>' !!}</td>
                            <td>
                                @can('show', [\App\User::class,$NAME])
                                <a class="list-icons-item" href="" title="more details" data-toggle="modal" data-target="#detailsAgency{{$item->id}}"><i class="icon-list ml-2"></i></a>
                                <div id="detailsAgency{{$item->id}}" class="modal fade" tabindex="-1">
                                    <div class="modal-dialog " style="max-width: 90%">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table class='table '>
                                                        <thead>
                                                            <th>عنوان</th>
                                                            <th>توضیحات</th>
                                                            <th>قیمت</th>
                                                            <th>ظرفیت</th>
                                                            <th>نوع همراهی</th>
                                                            <th>نوع خودرو</th>
                                                            <th>محل ترانسفر</th>

                                                        </thead>
                                                        <tbody>
                                                            @foreach($item->titems as $rowI)
                                                            <tr>
                                                                <td>{{$rowI->title}}</td>
                                                                <td>{{$rowI->desc}}</td>
                                                                <td>{{number_format($rowI->price)}} ریال</td>
                                                                <td>{{$rowI->capacity}}</td>

                                                                <td>
                                                                    @if($rowI->accompanimentType)
                                                                    {{config('defines.accompanimentType')[$rowI->accompanimentType]}}
                                                                    @else
                                                                    ---
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($rowI->vehicleType)
                                                                    {{config('defines.vehicleType')[$rowI->vehicleType]}}
                                                                    @else
                                                                    ---
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($rowI->locationType)
                                                                    {{config('defines.locationType')[$rowI->locationType]}}
                                                                    @else
                                                                    ---
                                                                    @endif
                                                                </td>

                                                            <tr>

                                                                @endforeach
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn bg-primary" data-dismiss="modal">باشه!
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endcan
                            </td>

                            <td>
                                <a style="display: inline-block" href="{{ route('admin.editTransfer', ['transfer' => $item->id]) }}" class="list-icons-item" title="edit">
                                    <i class="icon-quill4"></i>
                                </a>

                                @can('destroy', [\App\User::class,'Transfer'])
                                <!-- <a href="#" @click.prevent="" class="list-icons-item" data-toggle="modal" data-target="#delete-{{ $item->id }}"><i class="icon-trash"></i></a> -->
                                @endcan
                                <div id="delete-{{ $item->id }}" class="modal fade" tabindex="-1">
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
                                                <button type="button" class="btn bg-slate" data-dismiss="modal">{{ __('admin.No') }}</button>
                                                <form action="{{ route('admin.deleteGasth', ['id' => $item->id]) }}" method="POST">
                                                    @csrf
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn bg-danger">{{ __('admin.Yes') }} !
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>



                        </tr>
                        @empty
                        <tr>
                            <td colspan="11">
                                <div class="alert alert-warning border-0 alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span>
                                    </button>
                                    <span class="font-weight-semibold">{{ __('admin.not found anything') }}</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {!! $items->links() !!}
    </div>
</div>
@endsection
@section('scripts')
<script src="<?= url('js/adminVue.js?version2') ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?= url('global_assets/js/plugins/media/fancybox.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/demo_pages/blog_single.js') ?>"></script>
@endsection