<style>
    .notify_main_div {
        position: absolute;
        display: none;
        width: 350px !important;
        height: auto;
        left: 82px;
        max-height: 500px;
        z-index: 1000 !important;
        background-color: white;
        padding: 5px;
        border-radius: 2px;
        margin-top: -5px;
        box-shadow: 1px 1px 5px 1px #bcbcbc;
    }

    #triangle-up {
        width: 10px;
        height: 10px;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
        border-bottom: 10px solid white;
        float: left;
        margin-top: -15px;
    }

    .notify_details_div {
        color: black;
        background-color: #ededed;
        margin-top: 7px;
        padding: 5px;
        border-radius: 2px;
    }
    .notify_details_div a{
        color:black;
    }
</style>

<?php $isoCode = session()->get('isoCode') ?>
<div class="navbar-brand" style="font-size: 16px">
    <a target="_blank" href="{{ url('/') }}" class="d-inline-block">{{ $myAgency->company ?? '' }}</a>
</div>

<div class="d-md-none">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
        <i class="icon-tree5"></i>
    </button>
    <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
        <i class="icon-paragraph-justify3"></i>
    </button>
</div>
<div class="collapse navbar-collapse" id="navbar-mobile">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                <i class="icon-paragraph-justify3"></i>
            </a>
        </li>
    </ul>

    <!-- <span class="navbar-text ml-md-3">
        <span class="badge badge-mark border-orange-300 mr-2"></span>
        آدمی هرچیز مبهم و تیره‌ای را مهم‌تر از چیزی آشکار و روشن می‌پندارد.
    </span> -->

    <ul class="navbar-nav ml-md-auto">
        <?php if (auth()->user()) {  ?>

        <?php
        
        $getNotifies = DB::table('notifications')
                ->leftJoin('packages', 'notifications.package_id', '=', 'packages.id')
                ->leftJoin('users', 'notifications.user_id', '=', 'users.id')
                ->where('notifications.status','unread')
                ->where('notifications.agency_id', auth()->user())->orderBy('notifications.id', 'DESC')->get();
         
         ?>

        <li class="nav-item">
            <a href="{{Route('admin.showNotificationList')}}" class="navbar-nav-link toggle_notify_btn">
                <i class="  icon-volume-medium"></i>
                <span id="notify_count">{{count($getNotifies)}}</span> اعلان خوانده نشده
            </a>
 
        </li>

        <?php } ?>

        <li class="nav-item">
            <a href="{{ url('/logout') }}" class="navbar-nav-link">
                <i class="icon-switch2"></i>
                <span class="d-md-none ml-2">خروج</span>
            </a>
        </li>
    </ul>
</div>