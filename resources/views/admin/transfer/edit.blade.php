@extends('admin.layout.admin')
@section('style')
<link href="<?= url('css/admin/user.css') ?>" rel="stylesheet" type="text/css" />
<style type="text/css">
    .remove-item-div {
        background-color: #ff7777;
        color: white;
        padding: 3px;
        float: left;
        display: inline-block;
        cursor: pointer;
        font-size: 11px;
        border-radius: 4px;
    }

    .row-item-div input,
    .row-item-div textarea,
    .row-item-div select {
        font-size: 13px !important;
    }
</style>
@endsection
@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">

        <div class="card">



            @isset($errorForm)
            <div style="padding:5px">
                <p class='label label-danger'>{{$errorForm}}</p>
            </div>
            <hr>
            @endisset

            <div style="padding: 5px; width: 100%">


                <form method="post" action="{{route('admin.updateTransfer',['id'=>$transfer->id])}}" style=" width: 100%">
                    {{ csrf_field()  }}
                    <!-- <input type="hidden" value="sendFilter" name="sendFilter"> -->

                    <div class="row">
                        <div class="form-group col-md-5  col-6 col-sm-6">
                            <label class="d-block" for="name"> شهر
                            </label>
                            <v-select :options="options" @search="onSearch" dir="rtl" label="title_fa" v-model="value_cities_tour_origin" v-init:value_cities_tour_origin="{ id: '{{  $transfer->city->id }}', title_fa: '{{ $transfer->city->title_fa  }}' }">
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
                            <input name="city" type="hidden" v-model="valueCitiesTourOrigin">
                            {!! getError($errors,'cities') !!}
                        </div>

                        <div class="form-group col-md-6  col-6 col-sm-6">
                            <label for="name">تاریخ
                                <small>(dd/mm/yyyy)</small>
                            </label>
                            <date-picker value="{{ Carbon\Carbon::createFromFormat('Y-m-d',($transfer->date)  ) }}" initial-value="{{ Carbon\Carbon::createFromFormat('Y-m-d',($transfer->date)  ) }}" display-format="jYYYY/jMM/jDD" format="YYYY-MM-DD HH:mm:ss" :auto-submit="true" :clearable="true" locale="fa" name="date" placeholder="تاریخ شروع را وارد کنید"></date-picker>
                            {!! getError($errors,'start_in') !!}
                        </div>

                    </div>




                    <div class="row-item-container">
                        @foreach($transfer->titems as $rowItem)


                        <div class="row-item-div" style="width: 100%; background-color: #f5f5f5;padding:7px;    border-radius: 4px; margin-top:5px;">
                            <div style="width:30%; display:inline-block;vertical-align: top"><input value="{{$rowItem->title}}" style="width: 99%;padding: 4px" type="text" required="" autocomplete="off" name="title[]" placeholder="عنوان"></div>
                            <div style="width:40%; display:inline-block; vertical-align: top;"><textarea required="" rows="1" style="min-height: 32px;width: 99%; padding: 4px" name="desc[]" placeholder="توضیحات">{{$rowItem->desc}}</textarea></div>
                            <div style="width:13%; display:inline-block; vertical-align: top;"><input value="{{$rowItem->price}}" required="" style="width: 99%;padding: 4px" type="text" autocomplete="off" name="price[]" placeholder="قیمت"></div>
                            <div style="width:7%; display:inline-block; vertical-align: top;"><input value="{{$rowItem->capacity}}" required="" style="width: 99%;padding: 4px" type="number" autocomplete="off" name="capacity[]" placeholder="ظرفیت"></div><span class="remove-item-div">حذف</span>
                            <div>
                                <div style="width:30%; display:inline-block;vertical-align: top"><select name="accompanimentType[]" style="width:98%">
                                        <option value=""> نوع همراهی </option>
                                        <option <?php echo ($rowItem->accompanimentType == 'welcome') ? "SELECTED" : ""; ?> value="welcome"> استقبال </option>
                                        <option <?php echo ($rowItem->accompanimentType == 'convoy') ? "SELECTED" : ""; ?> value="convoy"> بدرقه </option>
                                        <option <?php echo ($rowItem->accompanimentType == 'welcome&convoy') ? "SELECTED" : ""; ?> value="welcome&convoy"> استقبال و بدرقه </option>
                                    </select></div>
                                <div style="width:40%; display:inline-block;vertical-align: top"><select name="vehicleType[]" style="width:98%">
                                        <option value=""> نوع خودرو </option>
                                        <option <?php echo ($rowItem->vehicleType == 'car') ? "SELECTED" : ""; ?> value="car"> سواری </option>
                                        <option <?php echo ($rowItem->vehicleType == 'van') ? "SELECTED" : ""; ?> value="van"> ون </option>
                                        <option <?php echo ($rowItem->vehicleType == 'minibus') ? "SELECTED" : ""; ?> value="minibus"> مینی بوس </option>
                                        <option <?php echo ($rowItem->vehicleType == 'bus') ? "SELECTED" : ""; ?> value="bus"> اتوبوس </option>
                                        <option <?php echo ($rowItem->vehicleType == 'floating') ? "SELECTED" : ""; ?> value="floating"> شناور </option>
                                    </select></div>
                                <div style="width:20%; display:inline-block;vertical-align: top"><select name="locationType[]" style="width:98%">
                                        <option value=""> محل ترانسفر </option>
                                        <option <?php echo ($rowItem->locationType == 'floating') ? "SELECTED" : ""; ?> value="airport"> فرودگاه </option>
                                        <option <?php echo ($rowItem->locationType == 'terminal') ? "SELECTED" : ""; ?> value="terminal"> ترمینال </option>
                                        <option <?php echo ($rowItem->locationType == 'rail') ? "SELECTED" : ""; ?> value="rail"> راه آهن </option>
                                        <option <?php echo ($rowItem->locationType == 'seaport') ? "SELECTED" : ""; ?> value="seaport"> بندر </option>
                                    </select></div>
                            </div>
                        </div>


                        @endforeach
                    </div>


                    <span class=' new-row-item-btn' style="cursor:pointer; float:left; background-color: #f5f5f5;padding:4px;font-size:12px; margin-top:2px;border: 1px solid #d4d4d4;">
                        ردیف جدید
                    </span>

                    <br>

                    <div>

                        <input type="submit" class='btn btn-success' value="ویرایش گشت">


                        @can('isSuperAdmin',App\User::Class)

                        <label style="margin-right:15px; background-color:#ebebeb;padding:3px 7px; border-radius:2px" for="status">
                            <input style="vertical-align: middle" type='checkbox' class="form-check-input-switchery" id="status" name="status" <?php echo ($transfer->status == "1") ? "checked" : ""; ?> />
                            وضعیت
                        </label>
                        @endcan

                    </div>

                </form>
            </div>

            <div class="card-body overflow-auto">

            </div>
        </div>

    </div>
</div>
@endsection
@section('scripts')
<script src="<?= url('js/adminVue.js?version2') ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?= url('global_assets/js/plugins/media/fancybox.min.js') ?>"></script>
<script type="text/javascript" src="<?= url('global_assets/js/demo_pages/blog_single.js') ?>"></script>


<script>
    //
    $(".new-row-item-btn").click(function() {
        $(".row-item-container").append(
            "<div class='row-item-div' style='width: 100%; background-color: #f5f5f5;padding:7px;    border-radius: 4px; margin-top:5px;'>" +
            "<div style='width:30%; display:inline-block;vertical-align: top'>" +
            "<input style='width: 99%;padding: 4px' type='text' required autocomplete='off' name='title[]' placeholder='عنوان' />" +
            "</div>" +
            "<div style='width:40%; display:inline-block; vertical-align: top;'>" +
            "<textarea required rows='1' style='min-height: 32px;width: 99%; padding: 4px' name='desc[]' placeholder='توضیحات'></textarea>" +
            "</div>" +
            "<div style='width:13%; display:inline-block; vertical-align: top;'>" +
            "<input required style='width: 99%;padding: 4px' type='text' autocomplete='off' name='price[]' placeholder='قیمت' />" +
            "</div>" +
            "<div style='width:7%; display:inline-block; vertical-align: top;'>" +
            "<input required style='width: 99%;padding: 4px' type='text' autocomplete='off' name='capacity[]' placeholder='ظرفیت' />" +
            "</div>" +
            "<span class='remove-item-div'>حذف</span>" +
            "<div>" +
            "<div style='width:30%; display:inline-block;vertical-align: top'>" +
            "<select name='accompanimentType[]' style='width:98%' >" +
            "<option value='' >" + ' نوع همراهی ' + "</option>" +
            "<option value='welcome' >" + ' استقبال ' + "</option>" +
            "<option value='convoy' >" + ' بدرقه ' + "</option>" +
            "<option value='welcome&convoy' >" + ' استقبال و بدرقه ' + "</option>" +
            "</select>" +
            "</div>" +
            "<div style='width:40%; display:inline-block;vertical-align: top'>" +
            "<select name='vehicleType[]' style='width:98%' >" +
            "<option value='' >" + ' نوع خودرو ' + "</option>" +
            "<option value='car' >" + ' سواری ' + "</option>" +
            "<option value='van' >" + ' ون ' + "</option>" +
            "<option value='minibus' >" + ' مینی بوس ' + "</option>" +
            "<option value='bus' >" + ' اتوبوس ' + "</option>" +
            "<option value='floating' >" + ' شناور ' + "</option>" +
            "</select>" +
            "</div>" +
            "<div style='width:20%; display:inline-block;vertical-align: top'>" +
            "<select name='locationType[]' style='width:98%' >" +
            "<option value='' >" + ' محل ترانسفر ' + "</option>" +
            "<option value='airport' >" + ' فرودگاه ' + "</option>" +
            "<option value='terminal' >" + ' ترمینال ' + "</option>" +
            "<option value='rail' >" + ' راه آهن ' + "</option>" +
            "<option value='seaport' >" + ' بندر ' + "</option>" +
            "</select>" +
            "</div>" +
            "</div>" +
            "</div>"
        );
    });


    $(document).ready(function(e) {

        $(document).on('click', '.remove-item-div', function() {
            if (confirm('حذف شود ؟')) {
                $(this).closest('.row-item-div').remove();
            }
        });

    });
</script>

@endsection