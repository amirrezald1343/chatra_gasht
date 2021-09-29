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

                            <th>عنوان</th>
                            <th>شهر</th>
                            <th> تاریخ فروش</th>
                            <th> قیمت </th>
                            <th> تعداد رزرو </th>
                            <th> بزرگسال </th>
                            <th> کودک </th>
                            <th> شناسه پیگیری </th>
                            <!-- <th class="text-center">عملیات</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $key=>$item)
                        <tr>
                            <td>{{ $item->gasht->title }}</td>
                            <td>{{ $item->gasht->city->title_fa }}</td>
                            <td>{{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($item->created_at))  }}</td>
                            <td>{{ number_format($item->price) }}</td>
                            <td>{{ $item->total_count }}</td>
                            <td>{{ $item->adult_count }}</td>
                            <td>{{ $item->child_count }}</td>
                            <td>{{ $item->reserve_id }}</td>
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

