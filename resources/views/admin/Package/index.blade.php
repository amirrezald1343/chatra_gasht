@extends('admin.layout.admin')
@section('style')
<link href="

use App\User;

<?= url('css/admin/user.css') ?>" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            @can('isSuperAdmin',App\User::Class)
            <div style="padding: 5px; width: 100%">
                <form method="get" action="/admin/Package" style=" width: 100%">
                    {{ csrf_field()  }}
                    <input type="hidden" value="sendFilter" name="sendFilter">
                    <div class="row">
                        
                        <div class="form-group col-md-5  col-12 col-sm-12">
                            <label class="d-block" for="name"> آژانس</label>
                            <v-select :options="optionsAgencies" @search="onSearchAgency" dir="rtl" label="company" v-model="value_agencies" @if($filterParams['agency']) v-init:value_agencies="{id:{{$filterParams['agency']}},company:'{{$filterParams['agencyName']}}'}" @endif>
                                <template slot="no-options">هیچ موری یافت نشد.</template>
                                <template slot="option" slot-scope="option">
                                    <div class="d-center">
                                        @{{ option.company }}
                                    </div>
                                </template>
                                <template slot="selected-option" slot-scope="option">
                                    <div class="selected d-center">
                                        @{{ option.company }}
                                    </div>
                                </template>
                            </v-select>
                            <input name="agency" type="hidden" v-model="valueAgency">
                            {!! getError($errors,'agency') !!}
                        </div>
                        <div class="form-group col-md-6 col-12 col-sm-12">
                            <label class="d-block" for="name">نوع تور</label>
                            <?php $tourTypes = ['' => 'همه', 'internal' => 'داخلی', 'foreign' => 'خارجی']; ?>
                            <select name="tourType" class="form-control select-fixed-single ">
                                <?php foreach ($tourTypes as $tourKey => $tourValue) { ?>
                                    <option <?php if ($tourKey == $filterParams['tourType']) {
                                                    echo "selected";
                                                } else {
                                                    echo "";
                                                }  ?> value="<?php echo $tourKey; ?>"> <?php echo $tourValue ?> </option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-5  col-6 col-sm-6">
                            <label class="d-block" for="name"> مبدا
                            </label>
                            <v-select :options="options" @search="onSearch" dir="rtl" label="title_fa" v-model="value_cities_tour_origin" @if($filterParams['originId']) v-init:value_cities_tour_origin="{id:{{$filterParams['originId']}},title_fa:'{{$filterParams['originTitle']}}'}" @endif>
                                <template slot="no-options">هیچ موری یافت نشد.</template>
                                <template slot="option" slot-scope="option">
                                    <div class="d-center">
                                        @{{ option.title_fa }}
                                    </div>
                                </template>
                                <template slot="selected-option" slot-scope="option">
                                    <div class="selected d-center">
                                        @{{ option.title_fa }}
                                    </div>
                                </template>
                            </v-select>
                            <input name="origin" type="hidden" v-model="valueCitiesTourOrigin">
                            {!! getError($errors,'cities') !!}
                        </div>


                        <div class="form-group col-md-6  col-6 col-sm-6">
                            <label class="d-block" for="name"> مقصد
                            </label>
                            <v-select :options="options" @search="onSearch" dir="rtl" label="title_fa" v-model="value_cities_tour_destination" @if($filterParams['destinationId']) v-init:value_cities_tour_destination="{id:{{$filterParams['destinationId']}},title_fa:'{{$filterParams['destinationTitle']}}'}" @endif>
                                <template slot="no-options">هیچ موری یافت نشد.</template>
                                <template slot="option" slot-scope="option">
                                    <div class="d-center">
                                        @{{ option.title_fa }}
                                    </div>
                                </template>
                                <template slot="selected-option" slot-scope="option">
                                    <div class="selected d-center">
                                        @{{ option.title_fa }}
                                    </div>
                                </template>
                            </v-select>
                            <input name="destination" type="hidden" v-model="valueCitiesTourDestination">
                            {!! getError($errors,'cities') !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-5 col-12 col-sm-12">
                            <label class="d-block" for="name">وضعیت</label>
                            <?php $tourTypes = ['' => 'همه', 'n' => 'در انتظار تایید', 'y' => 'فعال']; ?>
                            <select name="tourStatus" class="form-control select-fixed-single ">
                                <?php foreach ($tourTypes as $tourKey => $tourValue) { ?>
                                    <option <?php if ($tourKey == $filterParams['tourStatus']) {
                                                    echo "selected";
                                                } else {
                                                    echo "";
                                                }  ?> value="<?php echo $tourKey; ?>"> <?php echo $tourValue ?> </option>
                                <?php } ?>
                            </select>
                        </div>


                        <div class="form-group col-md-6 col-12 col-sm-12">
                            <label class="d-block" for="hideExpires" style="vertical-align: middle;margin-top:25px; padding:12px; background-color:#fbfbfb">
                                <input style='vertical-align: middle;' id='hideExpires' value="1" type="checkbox" name="hideExpires" <?php echo ($filterParams['hideExpires']) ? "CHECKED" : "" ?>>
                                مخفی کردن تورهای تاریخ گذشته
                            </label>
                        </div>

                        <div class="form-group col-md-6 col-12 col-sm-12">
                            <label class="d-block" for="name"></label>
                            <input type="submit" value="جستجو" style="background-color: #1dad1d; color:white; border: none; padding: 6px 12px;
                                        margin-top: 30px; width: 30%; cursor: pointer;">
                            <a href="/admin/Package" style="background-color: #4961bb; color:white; border: none; padding: 5px 12px;
                                        margin-top: 30px; width: 30%; cursor: pointer; margin-right: 15px">حذف فیلتر
                                ها</a>
                        </div>

                    </div>

                </form>
            </div>
            @endcan

            <div class="card-body overflow-auto">
                <table class="table table-striped" style="min-width: 765px;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان</th>
                            <th>تاریخ شروع</th>
                            <th>آژانس مربوطه</th>
                            <th>مبدا</th>
                            <th>تاریخ ثبت</th>
                            @can('isSuperAdmin',App\User::Class)
                            <th>ویرایش کننده</th>
                            <th> بازدید </th>
                            @endcan

                            <th>وضعیت</th>
                            <th>جزئیات</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $key=>$item)
                        <tr>
                            <td>{{ ($items->currentPage() - 1) * $items->perPage() + $key + 1 }}</td>
                            <td>{{ $item->title }}</td>
                            <td> {{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($item->start_in))  }}</td>
                            <td>{{ $item['agency']['company'] }}</td>
                            <td>{{ $item->city->title_fa }}</td>
                            <td> {{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($item->created_at))  }}</td>
                            @can('isSuperAdmin',App\User::Class)
                            <td>
                                <?php
                                $lastUser=  \App\User::find($item->lastUserId);
                                
                                if(!is_null($lastUser)){
                                echo $lastUser->name;
                                    }
                                    else{
                                        echo 'نامثشخص';
                                    }
                                ?>
                            </td>
                            <td>{{$item->visitCount}}</td>
                            @endcan

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
                                                    <table class="table table-striped table-bordered table-hover">

                                                        <tr>
                                                            <td>تعداد شب</td>
                                                            <td>{{ $item->number_nights }}</td>
                                                        </tr>

                                                        <tr>
                                                            <td>روش سفر</td>
                                                            <td>{{ getTravelMethod($item->travel_method)  }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>نوع وسیله نقلیه</td>
                                                            <td>{{ $item->vehicle_type }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>مقاصد(قاره)</td>
                                                            <td class="text-small">
                                                                @foreach($item->cities ?? [] as $value)
                                                                @if($value->pivot->type == 'continent')
                                                                <span><span class="icon-pin-alt text-danger-800"></span> {{ $value->title_fa }}</span>@endif
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>مقاصد(کشور)</td>
                                                            <td class="text-small">
                                                                @foreach($item->cities ?? [] as $value)
                                                                @if($value->pivot->type == 'country') <span><span class="icon-pin-alt text-danger-800"></span> {{ $value->title_fa }}</span>@endif
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>مقاصد(شهر)</td>
                                                            <td class="text-small">
                                                                @foreach($item->cities ?? [] as $value)
                                                                @if($value->pivot->type == 'city')
                                                                <span><span class="icon-pin-alt text-danger-800"></span> {{ $value->title_fa }}</span>@endif
                                                                @endforeach
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>خدمات</td>
                                                            <td class="text-small">
                                                                @foreach($item->services ?? [] as $value)
                                                                <span class="m-1"><span> <img width="22px" src="{{ url($value->icon) }}"></span> {{ $value->title }}</span>
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>توضیحات</td>
                                                            <td class="text-small">
                                                                <p>
                                                                    {!! $item->description !!}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>خدمات تکمیلی</td>
                                                            <td class="text-small">
                                                                <p>
                                                                    {!! $item->additional_services !!}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>مدارک مورد نیاز</td>
                                                            <td class="text-small">
                                                                <p>
                                                                    {!! $item->documents !!}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>قوانین</td>
                                                            <td class="text-small">
                                                                <p>
                                                                    {!! $item->rules !!}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr>

                                                        <tr>
                                                            <td>نوع تور</td>
                                                            <td>@if($item->tourType == 'foreign')
                                                                <span>خارجی</span>@elseif($item->tourType == 'internal')
                                                                <span>داخلی</span>@endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>لحظه آخری</td>
                                                            <td class="text-center">{!! $item->moment == '1' ? '<i class="icon-checkmark3 text-success"></i>' : '<i class="icon-cross2 text-danger-400"></i>' !!}</td>
                                                        </tr>

                                                        <tr>
                                                            <td>بوم گردی</td>
                                                            <td class="text-center">{!! $item->indoors == '1' ? '<i class="icon-checkmark3 text-success"></i>' : '<i class="icon-cross2 text-danger-400"></i>' !!}</td>
                                                        </tr>
                                                        <td>مراحل تور</td>
                                                        <td class="text-small">
                                                            @foreach($item->levels ?? [] as $keylevel=>$valuelevel)
                                                            <div class="card-group-control card-group-control-right">
                                                                <div class="card mb-2">
                                                                    <div class="card-header">
                                                                        <h6 class="card-title">
                                                                            <a style="color: #025f97;" class="  text-blue-800 {{ ($keylevel>0) ?'collapsed':'' }} " data-toggle="collapse" href="#question{{ $valuelevel->id }}" aria-expanded=" {{ ($keylevel>0) ?'false':'true' }}  ">
                                                                                <i class="  font-size-sm  mr-1 icon-tree5"></i> {{ $valuelevel->title }}
                                                                            </a>
                                                                        </h6>
                                                                    </div>
                                                                    <div id="question{{ $valuelevel->id }}" class="collapse {{ ($keylevel>0) ?'':'show' }} " style="">
                                                                        <div class="card-body"> {{ $valuelevel->description }} </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </td>
                        </tr>
                        <tr>
                            <td>تصاویر</td>
                            <td class="text-small">
                                <div class="card ">
                                    <div class="card-header bg-transparent header-elements-inline">
                                        <span style="color: #025f97;" class="card-title font-weight-semibold">نمایش</span>
                                        <div class="header-elements">
                                            <div class="list-icons">
                                                <a class="list-icons-item" data-action="collapse"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach($item->images ?? [] as $key=>$value)
                                            @if(@$value->media->path)
                                            <div class="col-2">
                                                <div class="mb-2">
                                                    <label>{{ $value->title }}</label>
                                                    <div class="card-img-actions">
                                                        <a href="{{ url($value->media->path) }}" data-popup="lightbox">
                                                            <img class="card-img img-fluid" src="{{ url($value->media->path) }}" alt="">
                                                            <span class="card-img-actions-overlay card-img"><i class="icon-plus3"></i></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>قیمت</td>
                            <td class="text-small">
                                <div class="table-responsive">
                                    <table style="text-align: center;" class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>نام</th>
                                                <th>نوع</th>
                                                <th>ستاره</th>
                                                <th>قیمت تومان</th>
                                                <th>قیمت ارز</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($item->prices ?? [] as $key=>$value)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td class="">{{ $value->name }}</td>
                                                <td>{{ getResidenceType($value->type) }}</td>
                                                <td>
                                                    @for($i=0;$i < $value->star ;$i++)
                                                        <span class="icon-star-full2 text-small text-warning-800"></span>
                                                        @endfor
                                                </td>
                                                <td>{{ number_format($value->price) }}
                                                    تومان
                                                </td>
                                                <td>{{ number_format($value->price_dollar) }}
                                                    {{ config('defines.currency')[$value->currency] }}
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </td>
                        </tr>

                        @isset($item->media)
                        <tr>
                            <td>{{ __('admin.attach') }}</td>
                            <td><a href="{{ url($item->media->path) }}" target="_blank" title="{{ $item->media->name }}" type="button" class="btn bg-indigo-400 legitRipple">{{__('admin.download')}}
                                    <i class="icon-link"></i></a></td>
                        </tr>
                        @endisset
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
<td class="text-center">
    @can('edit', [\App\User::class,$NAME])
    <a href="{{ route('admin.'.$NAME.'.edit', ['id' => $item->id]) }}" class="list-icons-item" title="edit">
        <i class="icon-quill4"></i>
    </a>
    @endcan
    {{--@can('destroy', [\App\User::class,$NAME])--}}
    {{--<a href="#" @click.prevent="" class="list-icons-item" data-toggle="modal" data-target="#delete-{{ $item->id }}"><i class="icon-trash"></i></a>--}}
    {{--@endcan--}}
    <div id="delete-{{ $item->id }}" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="font-weight-semibold mb-4"> {{ __('admin.Delete') .' '. __('admin.'.$NAME) }}</h6>
                    <p>{{ __('admin.Are you sure you want to delete this information?') }}</p>
                    <hr>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn bg-slate" data-dismiss="modal">{{ __('admin.No') }}</button>
                    <form action="{{ route('admin.'.$NAME.'.destroy', ['id' => $item->id]) }}" method="POST">
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