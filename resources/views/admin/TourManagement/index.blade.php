@extends('admin.layout.admin')
@section('style')
    <link href="<?= url('css/admin/user.css')?>" rel="stylesheet" type="text/css"/>
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
                            <th>نام آژانس</th>
                            <th>عنوان</th>
                            <th>تاریخ شروع</th>
                            <th>تعداد شب</th>
                            <th>مبدا</th>
                            {{-- <th>نوع تور</th>
                            <th>لحظه آخری</th>
                            <th>بوم گردی</th> --}}
                            <th>وضعیت</th>
                            <th>جزئیات</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $key=>$item)
                            <tr>
                                <td>{{ ($items->currentPage() - 1) * $items->perPage() + $key + 1 }}</td>
                                <td>
                                    <button type="button" class="btn bg-indigo-400" data-toggle="modal"
                                            data-target="#permissionShow{{$item->agency['id']}}">{{ $item->agency['company'] }}</button>
                                    <div id="permissionShow{{$item->agency['id']}}" class="modal fade"
                                         tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"></h5>
                                                    <button type="button" class="close"
                                                            data-dismiss="modal">&times;
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered table-hover bg-white">
                                                            <tr>
                                                                <td>نام مدیر عامل</td>
                                                                <td>{{ $item->agency['name'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>کد ملی</td>
                                                                <td>{{ $item->agency['nationalNumber'] }}  </td>
                                                            </tr>
                                                            <tr>
                                                                <td>سایت</td>
                                                                <td>{{ $item->agency['domain'] }}  </td>
                                                            </tr>
                                                            <tr>
                                                                <td>شماره همراه</td>
                                                                <td>{{ $item->agency['tellPhone'] }}  </td>
                                                            </tr>
                                                            <tr>
                                                                <td>شماره ثابت</td>
                                                                <td>{{ $item->agency['cellPhone'] }}  </td>
                                                            </tr>
                                                            <tr>
                                                                <td>ایمیل</td>
                                                                <td>{{ $item->agency['email'] }}  </td>

                                                            </tr>
                                                            <tr>
                                                                <td>آدرس</td>
                                                                <td>{{ $item->agency['address'] }}  </td>

                                                            </tr>
                                                            <tr>
                                                                <td>وضعیت</td>
                                                                <td>{!! $item->agency['status'] == '1' ? '<span class="badge badge-flat border-success text-success-600"> فعال </span>' : '<span class="badge badge-flat border-danger text-danger-600">غیرفعال</span>' !!} </td>

                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn bg-primary"
                                                            data-dismiss="modal"> {{ __('admin.close') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->title }}</td>
                                <td> {{  \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($item->start_in))  }}</td>
                                <td>{{ $item->number_nights }} شب</td>
                                <td>{{ $item->city->title_fa }}</td>
                               
                                
                                <td>{!! $item->status == '1' ? '<span class="badge badge-flat border-success text-success-600"> فعال </span>' : '<span class="badge badge-flat border-danger text-danger-600">غیرفعال</span>' !!}</td>
                                <td>
                                    @can('show', [\App\User::class,$NAME])
                                        <a class="list-icons-item" href="" title="more details" data-toggle="modal"
                                           data-target="#detailsAgency{{$item->id}}"><i
                                                    class="icon-list ml-2"></i></a>
                                        <div id="detailsAgency{{$item->id}}" class="modal fade"
                                             tabindex="-1">
                                            <div class="modal-dialog " style="max-width: 90%">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close"
                                                                data-dismiss="modal">&times;
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered table-hover">
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
                                                                            @if($value->pivot->type == 'country') <span><span
                                                                                        class="icon-pin-alt text-danger-800"></span> {{ $value->title_fa }}</span>@endif
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
                                                                            <span class="m-1"><span> <img width="22px"
                                                                                                          src="{{ url($value->icon) }}"></span> {{ $value->title }}</span>
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
                                                                        <td>نوع تور</td>
                                                                            <td>
                                                                                @if($item->tourType == 'foreign')
                                                                                    <span>خارجی</span>@elseif($item->tourType == 'internal')<span>داخلی</span>@endif
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
                                                                    <td>مراحل تور</td>
                                                                    <td class="text-small">
                                                                        @foreach($item->levels ?? [] as $keylevel=>$valuelevel)
                                                                            <div class="card-group-control card-group-control-right">
                                                                                <div class="card mb-2">
                                                                                    <div class="card-header">
                                                                                        <h6 class="card-title">
                                                                                            <a style="color: #025f97;"
                                                                                               class="  text-blue-800 {{ ($keylevel>0) ?'collapsed':'' }} "
                                                                                               data-toggle="collapse"
                                                                                               href="#question{{ $valuelevel->id }}"
                                                                                               aria-expanded=" {{ ($keylevel>0) ?'false':'true' }}  ">
                                                                                                <i class="  font-size-sm  mr-1 icon-tree5"></i> {{ $valuelevel->title }}
                                                                                            </a>
                                                                                        </h6>
                                                                                    </div>
                                                                                    <div id="question{{ $valuelevel->id }}"
                                                                                         class="collapse {{ ($keylevel>0) ?'':'show' }} "
                                                                                         style="">
                                                                                        <div class="card-body"> {{ $valuelevel->description }} </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>نمایش در سایت</td>
                                                                    <td style="direction: ltr"><a target="_black"  style="direction: ltr" href="https://clicksafar.com/Tour/{{$item->id}}/{{$item->title}}">https://clicksafar.com/Tour/{{$item->id}}/{{$item->title}}</a></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>تصاویر</td>
                                                                    <td class="text-small">
                                                                        <div class="card ">
                                                                            <div class="card-header bg-transparent header-elements-inline">
                                                                                <span style="color: #025f97;"
                                                                                      class="card-title font-weight-semibold">نمایش</span>
                                                                                <div class="header-elements">
                                                                                    <div class="list-icons">
                                                                                        <a class="list-icons-item"
                                                                                           data-action="collapse"></a>
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
                                                                                                        <a href="{{ url($value->media->path) }}"
                                                                                                           data-popup="lightbox">
                                                                                                            <img class="card-img img-fluid"
                                                                                                                 src="{{ url($value->media->path) }}"
                                                                                                                 alt="">
                                                                                                            <span class="card-img-actions-overlay card-img"><i
                                                                                                                        class="icon-plus3"></i></span>
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
                                                                            <table style="text-align: center;"
                                                                                   class="table">
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
                                                                        <td><a href="{{ url($item->media->path) }}"
                                                                               target="_blank"
                                                                               title="{{ $item->media->name }}"
                                                                               type="button"
                                                                               class="btn bg-indigo-400 legitRipple">{{__('admin.download')}}
                                                                                <i class="icon-link"></i></a></td>
                                                                    </tr>
                                                                @endisset
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn bg-primary"
                                                                data-dismiss="modal">باشه!
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                </td>
                                <td class="text-center">
                                    {!! Form::model($item,['method'=>'put','route'=>['admin.TourManagement.update',$item->id],'class'=>'form-horizontal']) !!}
                                    @if( $item->status == '1' )
                                        <button type="submit" name="submit" value="disable" class="btn btn-danger">
                                            غیرفعال <i class="icon-arrow-left13 position-right"></i></button>
                                    @else
                                        <button type="submit" name="submit" value="enable" class="btn btn-info">فعال <i
                                                    class="icon-arrow-left13 position-right"></i></button>
                                    @endif
                                    {!! Form::close() !!}
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
    <script type="text/javascript" src="<?= url('global_assets/js/plugins/media/fancybox.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/demo_pages/blog_single.js') ?>"></script>
@endsection