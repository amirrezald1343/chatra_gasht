@extends('admin.layout.admin')
@section('style')
    <link href="<?= url('css/admin/user.css') ?>" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                @can('isSuperAdmin',App\User::Class)
                    <div style="padding: 5px; width: 100%">
                        <form method="get" action="/admin/listGasht" style=" width: 100%">
                            {{ csrf_field()  }}
                            <input type="hidden" value="sendFilter" name="sendFilter">
                            <?php // dd($filterParams) ;
                            //?>
                            <div class="row">

                                <div class="form-group col-md-5  col-12 col-sm-12">
                                    <label class="d-block" for="name"> آژانس</label>
                                    <v-select :options="optionsAgencies" @search="onSearchAgency" dir="rtl"
                                              label="company" v-model="value_agencies"
                                              @if($filterParams['agency']) v-init:value_agencies="{id:{{$filterParams['agency']}},company:'{{$filterParams['agencyName']}}'}" @endif>
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

                                <div class="form-group col-md-5 col-12 col-sm-12">
                                    <label class="d-block" for="name">وضعیت</label>
                                    <?php $gashtTypes = ['' => 'همه', ' pendding' => 'در انتظار تایید', 'active' => 'فعال','unactive' => 'غیرفعال','expire' => 'منقضی']; ?>
                                    <select name="gashtstatus" class="form-control select-fixed-single ">
                                        <?php foreach ($gashtTypes as $tourKey => $tourValue) { ?>
                                        <option <?php if ($tourKey == $filterParams['gashtstatus']) {
                                            echo "selected";
                                        } else {
                                            echo "";
                                        }  ?> value="<?php echo $tourKey; ?>">  <?php echo $tourValue ?> </option>
                                        <?php } ?>
                                    </select>
                                </div>

                            </div>


                            <div class="form-group col-md-6 col-12 col-sm-12">
                                <label class="d-block" for="name"></label>
                                <input type="submit" value="جستجو" style="background-color: #1dad1d; color:white; border: none; padding: 6px 12px;
                                        margin-top: 30px; width: 30%; cursor: pointer;">
                                <a href="/admin/listGasht" style="background-color: #4961bb; color:white; border: none; padding: 5px 12px;
                                        margin-top: 30px; width: 30%; cursor: pointer; margin-right: 15px">حذف فیلتر
                                    ها</a>
                            </div>


                        </form>
                    </div>
                @endcan
                    @can('isSuperAdmin',App\User::Class)
                        <div class="row">
                            <div class="col-lg-3 pull-right" style="margin-right:41px;">
                                <input id="select_all" class="checkbox" type="checkbox" style="position: relative"> انتخاب
                                همه
                                موارد
                            </div>
                        </div>
                    @endcan

                <div class="card-body overflow-auto">
                    <form method="post" action="{{ route('admin.deletecheck') }}">
                        {{ csrf_field() }}
                        <table class="table table-striped" style="min-width: 765px;">
                            <thead>

                            <tr>
                                <th> #</th>
                                <th>عنوان</th>
                                <th>شهر</th>
                                <th>تاریخ</th>
                                {{--<th>نوع روز</th>--}}
                                <th>آژانس</th>
                                <th>وضعیت</th>
                                <th> جزئیات</th>

                                <th class="text-center">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--<button type="submit" class="btn"--}}
                                    {{--style="background: #1da1d5;color: white; border: none; padding: 5px 12px; margin-top: 30px; width: 11%; cursor: pointer; margin-right: 15px;border-radius: 3px"--}}
                                    {{--formaction="{{ route('admin.deletecheck') }}">حذف علامت دارها--}}
                            {{--</button>--}}

                            @can('isSuperAdmin',App\User::Class)
                                <button type="submit" formaction="{{ route('admin.activestatus') }}" class="btn"
                                        style="background: #50d554;color: white; border: none; padding: 5px 12px; margin-top: 30px; width: 13%; cursor: pointer; margin-right: 15px;border-radius: 3px">
                                    فعال کردن گشت
                                </button>

                                <button type="submit" formaction="{{ route('admin.unactivestatus') }}" class="btn"
                                        style="background: #d55251;color: white; border: none; padding: 5px 12px; margin-top: 30px; width: 13%; cursor: pointer; margin-right: 15px;border-radius: 3px">
                                    غیرفعال کردن گشت
                                </button>
                            @endcan


                            @forelse($items as $key=>$item)
                                <tr>
                                    <td>
                                        @can('isSuperAdmin',App\User::Class)
                                            <input title='انتخاب' type='checkbox' class='checkbox ' name='listGasht[]'
                                                   value='{{ $item->id  }}'>
                                        @endcan

                                        {{ ($items->currentPage() - 1) * $items->perPage() + $key + 1 }}
                                    </td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->city->title_fa }}</td>
                                    <td> {{ \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($item->date))  }}</td>
                                    {{--<td>{{ $item->typedate }}</td>--}}
                                    <td>{{ $item['agency']['company'] }}</td>
                                    <td>
                                     @if($item->status == 'unactive')
                                     <span class="badge badge-flat border-success text-success-600"> غیرفعال </span>
                                    @elseif($item->status == 'active')
                                      <span class="badge badge-flat border-success text-success-600"> فعال </span>
                                    @elseif($item->status == 'expire')
                                       <span class="badge badge-flat border-success text-success-600"> منقضی </span>
                                    @elseif($item->status == 'pendding')
                                      <span class="badge badge-flat border-info text-info-600"> درانتظار تایید..</span>
                                    @endif
                                    </td>
                                    <td>
                                        @can('show', [\App\User::class,$NAME])
                                            <a class="list-icons-item" href="" title="more details" data-toggle="modal"
                                               data-target="#detailsAgency{{$item->id}}"><i class="icon-list ml-2"></i></a>
                                            <div id="detailsAgency{{$item->id}}" class="modal fade" tabindex="-1">
                                                <div class="modal-dialog " style="max-width: 90%">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                &times;
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="table-responsive">
                                                                <table class='table '>
                                                                    <thead>
                                                                    <th>قیمت بزرگسال</th>
                                                                    <th>قیمت خردسال</th>
                                                                    <th>ظرفیت</th>
                                                                    </thead>
                                                                    <tbody>

                                                                    <tr>
                                                                        <td>
                                                                            @if($item->adult)
                                                                                {{number_format($item->adult)}} تومان
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            @if($item->child)
                                                                                {{number_format($item->child)}} تومان
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$item->capacity}}</td>
                                                                    <tr>

                                                                    </tbody>
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

                                    <form></form>

                                    <td>
                                        <a style="display: inline-block"
                                           href="{{ route('admin.editGasht', ['id' => $item->id]) }}"
                                           class="list-icons-item" title="edit">
                                            <i class="icon-quill4"></i>
                                        </a>


                                        {{--@can('destroy', [\App\User::class,'Gasht'])--}}
                                            {{--<a href="#" @click.prevent="" class="list-icons-item" data-toggle="modal"--}}
                                               {{--data-target="#delete-{{ $item->id }}"><i class="icon-trash"></i></a>--}}
                                        {{--@endcan--}}


                                        <div id="delete-{{ $item->id }}" class="modal fade" tabindex="-1">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            &times;
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h6 class="font-weight-semibold mb-4"> {{ __('admin.Delete') .' '. $FANAME }}</h6>
                                                        <p>{{ __('admin.Are you sure you want to delete this information?') }}</p>
                                                        <hr>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button" class="btn bg-slate"
                                                                data-dismiss="modal">{{ __('admin.No') }}</button>
                                                        <form
                                                            action="{{ route('admin.deleteGasth', ['id' => $item->id]) }}"
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
                                        </div>

                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11">
                                        <div class="alert alert-warning border-0 alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            <span
                                                class="font-weight-semibold">{{ __('admin.not found anything') }}</span>
                                        </div>
                                    </td>
                                </tr>


                            @endforelse
                            </tbody>
                        </table>
                    </form>
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

    <script>

        var select_all = document.getElementById("select_all"); //select all checkbox
        var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items

        //select all checkboxes
        select_all.addEventListener("change", function (e) {

            for (i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = select_all.checked;
            }

        });


        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].addEventListener('change', function (e) { //".checkbox" change
                //uncheck "select all", if one of the listed checkbox item is unchecked
                if (this.checked == false) {
                    select_all.checked = false;
                }
                //check "select all" if all checkbox items are checked
                if (document.querySelectorAll('.checkbox:checked').length == checkboxes.length) {

                    select_all.checked = true;
                }
            });

        }

    </script>

@endsection



