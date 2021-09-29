@extends('admin.layout.admin')
@section('style')
    <link href="<?= url('css/admin/user.css') ?>" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                {{--@can('isSuperAdmin',App\User::Class)--}}
                <div style="padding: 5px; width: 100%">
                    <form method="get" action="/admin/listGashtSells" style=" width: 100%">
                        {{ csrf_field()  }}
                        <input type="hidden" value="sendFilter" name="sendFilter">

                        <div class="row">

                            <div class="form-group col-md-5  col-12 col-sm-12">
                                <label class="d-block" for="title">عنوان گشت</label>
                                <input name="title" class="form-control select-fixed-single ">
                            </div>


                            <div class="form-group col-md-5  col-12 col-sm-12">
                                <label class="d-block" for="customer_name">نام مشتری </label>
                                <input name="customer_name" class="form-control select-fixed-single ">
                            </div>

                            <div class="form-group col-md-5 col-12 col-sm-12">
                                <label class="d-block" for="name">شناسه پیگیری</label>
                                <input name="reserve_id" class="form-control select-fixed-single ">
                            </div>

                            <div class="form-group col-md-5  col-12 col-sm-12">
                                <label class="d-block" for="date">تاریخ گشت</label>
                                <date-picker min="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',(\Carbon\Carbon::now())  ) }}" initial-value="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',(\Carbon\Carbon::now())  ) }}" display-format="jYYYY/jMM/jDD" format="YYYY-MM-DD HH:mm:ss" :auto-submit="true" :clearable="true" locale="fa" name="date" placeholder="تاریخ شروع را وارد کنید"></date-picker>
                                {!! getError($errors,'date') !!}
                            </div>
                            <div class="form-group col-md-5  col-12 col-sm-12">
                                <label class="d-block" for="title">از تاریخ رزرو</label>
                                <date-picker min="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',(\Carbon\Carbon::now())  ) }}" initial-value="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',(\Carbon\Carbon::now())  ) }}" display-format="jYYYY/jMM/jDD" format="YYYY-MM-DD HH:mm:ss" :auto-submit="true" :clearable="true" locale="fa"  name="created_at" placeholder="تاریخ رزرو را وارد کنید"></date-picker>
                                {!! getError($errors,'created_at') !!}
                            </div>
                            <div class="form-group col-md-5  col-12 col-sm-12">
                                <label class="d-block" for="title">به تاریخ رزرو</label>
                                <date-picker
                                    {{--                                        min="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',(\Carbon\Carbon::now())  ) }}"--}}
                                    {{--                                        initial-value="{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',(\Carbon\Carbon::now())  ) }}" --}}
                                    {{--display-format="jYYYY/jMM/jDD"--}}
                                    {{--format="YYYY-MM-DD HH:mm:ss"--}}
                                    {{--:auto-submit="true"--}}
                                    :clearable="true"
                                    {{--locale="fa"--}}
                                    {{--name="created_at2"--}}
                                    {{--placeholder="تاریخ رزرو را وارد کنید"--}}
                                ></date-picker>
                                {!! getError($errors,'created_at') !!}
                            </div>

                            <div class="form-group col-md-5  col-12 col-sm-12">
                                <label class="d-block" for="title"> شماره موبایل</label>
                                <input name="customer_mobile" class="form-control select-fixed-single ">
                            </div>


                        </div>


                        <div class="form-group col-md-6 col-12 col-sm-12">
                            <label class="d-block" for="name"></label>
                            <input type="submit" value="جستجو" style="background-color: #1dad1d; color:white; border: none; padding: 6px 12px;
                                        margin-top: 30px; width: 30%; cursor: pointer;">


                            <a href="/admin/listGashtSells" style="background-color: #4961bb; color:white; border: none; padding: 5px 12px;
                                        margin-top: 30px; width: 30%; cursor: pointer; margin-right: 15px">حذف فیلتر
                                ها</a>
                        </div>


                    </form>
                </div>
                {{--@endcan--}}


                <div class="card-body overflow-auto">
                    <table class="table table-striped" style="min-width: 765px;">
                        <thead>
                        <tr>
                            <th> عنوان</th>
                            <th>شهر</th>
                            @can('isSuperAdmin',App\User::Class)
                                <th>آژانس</th>
                            @endcan
                            <th> نام خریدار</th>
                            <th> شماره موبایل</th>
                            <th> تاریخ گشت</th>
                            <th> تاریخ رزرو</th>
                            <th> تعداد رزرو</th>
                            <th> بزرگسال</th>
                            <th> کودک</th>
                            {{--<th>تعدادروزهای برگزاری </th>--}}
                            <th> قیمت</th>
                            <th> شناسه پیگیری</th>

                            <!-- <th class="text-center">عملیات</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $key=>$item)
                            <tr>
                                <td>{{ $item->gasht->title }}</td>
                                <td>{{ $item->gasht->city->title_fa }}</td>
                                @can('isSuperAdmin',App\User::Class)
                                    <td>{{ $item->gasht->agency->company }}</td>
                                @endcan
                                <td>{{ $item->customer_name }}</td>
                                <td>{{ $item->customer_mobile }}</td>
                                <td>{{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($item->gasht->date))  }}</td>
                                {{--<td>{{ $wordCount }} </td>--}}
                                <td>{{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($item->created_at))  }}</td>
                                <td>{{ $item->total_count }}</td>
                                <td>{{ $item->adult_count }}</td>
                                <td>{{ $item->child_count }}</td>
                                <td>{{ number_format($item->price) }}</td>
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
