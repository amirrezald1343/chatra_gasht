<div class="sidebar sidebar-light sidebar-main sidebar-expand-md" xmlns="http://www.w3.org/1999/html">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-right8"></i>
        </a>
        <span class="font-weight-semibold"></span>
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">
        <!-- User menu -->
        <div class="sidebar-user-material">
            <div class="sidebar-user-material-body">
                <div class="card-body text-center">
                    <a href="#">
                        <img src="{{  '../../../../global_assets/images/placeholders/placeholder.jpg' }}" class="img-fluid rounded-circle shadow-1 mb-3" width="80" height="80" alt="">
                    </a>
                    @if(auth()->user()->role=='superAdmin')
                    <h6 class="mb-0 text-white text-shadow-dark">{{ auth()->user()->name }}</h6>
                    <span class="font-size-sm text-white text-shadow-dark">مدیر سیستم</span>
                    @elseif(auth()->user()->role=='admin')
                    <?php $agencyUserId = auth()->user()->id;
                    $agencyNames = \App\Agency::where('user_id', $agencyUserId)->first();
                    ?>
                    @if(@$agencyNames)
                    <h6 class="mb-0 text-white text-shadow-dark">{{ $agencyNames->company }}
                    </h6>
                    @endif
                    <span class="font-size-sm text-white text-shadow-dark">مدیر آژانس</span>
                    @endif
                </div>

                <div class="sidebar-user-material-footer">
                    <a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>حساب من</span></a>
                </div>
            </div>

            <div class="collapse" id="user-nav">
                <ul class="nav nav-sidebar">
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="icon-user-plus"></i>
                            <span>پروفایل من</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/logout') }}" class="nav-link">
                            <i class="icon-switch2"></i>
                            <span>خروج</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item-header">
                    <div class="text-uppercase  line-height-xs">مدیریت تورها</div>
                    <i class="icon-menu" title="Main"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin') }}" class="nav-link active">
                        <i class="icon-home4"></i>
                        <span>داشبورد</span>
                    </a>
                </li>

                @if (Auth::user()->can('create', [\App\User::class,'Permission']) || Auth::user()->can('index', [\App\User::class,'Permission']))
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-circle-small"></i>
                        <span>سطح دسترسی</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        @can('create', [\App\User::class,'Permission'])
                        <li class="nav-item">
                            <a href="{{ route('admin.Permission.create') }}" class="nav-link">تعریف</a>
                        </li>
                        @endcan
                        @can('index', [\App\User::class,'Permission'])
                        <li class="nav-item">
                            <a href="{{ route('admin.Permission.index') }}" class="nav-link">لیست</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                @if (Auth::user()->can('create', [\App\User::class,'Agency']) || Auth::user()->can('index', [\App\User::class,'Agency']))
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-circle-small"></i>
                        <span>آژانس ها</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        @can('create', [\App\User::class,'Agency'])
                        <li class="nav-item">
                            <a href="{{  route('admin.Agency.create') }}" class="nav-link">تعریف</a>
                        </li>
                        @endcan
                        @can('index', [\App\User::class,'Agency'])
                        <li class="nav-item">
                            <a href="{{ route('admin.Agency.index') }}" class="nav-link">لیست</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if (Auth::user()->can('create', [\App\User::class,'Package']) || Auth::user()->can('index', [\App\User::class,'Package']))
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-circle-small"></i>
                        <span>تور</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        @can('create', [\App\User::class,'Package'])
                        <li class="nav-item">
                            <a href="{{ route('admin.Package.create') }}" class="nav-link">تعریف</a>
                        </li>
                        @endcan
                        @can('index', [\App\User::class,'Package'])
                        <li class="nav-item">
                            <a href="{{ route('admin.Package.index') }}" class="nav-link">لیست</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif


                @if (Auth::user()->can('create', [\App\User::class,'Gasht']) )
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-circle-small"></i>
                        <span>گشت و گذار</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        @can('create', [\App\User::class,'Gasht'])
                        <li class="nav-item">
                            <a href="{{ route('admin.createGasht') }}" class="nav-link">تعریف</a>
                        </li>
                        @endcan
                        @can('index', [\App\User::class,'Gasht'])
                        <li class="nav-item">
                            <a href="{{ route('admin.listGasht') }}" class="nav-link">لیست</a>
                        </li>
                        @endcan
                        @can('index', [\App\User::class,'Gasht'])
                        <li class="nav-item">
                            <a href="{{ route('admin.listGashtSell') }}" class="nav-link">لیست فروش ها</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if (Auth::user()->can('create', [\App\User::class,'Transfer']) )
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-circle-small"></i>
                        <span> ترانسفر </span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        @can('create', [\App\User::class,'Transfer'])
                        <li class="nav-item">
                            <a href="{{ route('admin.createTransfer') }}" class="nav-link">تعریف</a>
                        </li>
                        @endcan
                        @can('index', [\App\User::class,'Transfer'])
                        <li class="nav-item">
                            <a href="{{ route('admin.listTransfer') }}" class="nav-link">لیست</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @if (Auth::user()->can('create', [\App\User::class,'Service']) || Auth::user()->can('index', [\App\User::class,'Service']))
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-circle-small"></i>
                        <span>خدمات</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        @can('create', [\App\User::class,'Service'])
                        <li class="nav-item">
                            <a href="{{ route('admin.Service.create') }}" class="nav-link">تعریف</a>
                        </li>
                        @endcan
                        @can('index', [\App\User::class,'Service'])
                        <li class="nav-item">
                            <a href="{{ route('admin.Service.index') }}" class="nav-link">لیست</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif
                @if (Auth::user()->can('create', [\App\User::class,'TourManagement']) || Auth::user()->can('index', [\App\User::class,'TourManagement']))
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-circle-small"></i>
                        <span>مدیریت تور</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        @can('index', [\App\User::class,'TourManagement'])
                        <li class="nav-item">
                            <a href="{{ route('admin.TourManagement.index') }}" class="nav-link">لیست تور ها</a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endif

                @can('isSuperAdmin',App\User::Class)

                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-circle-small"></i>
                        <span>داده های پویا</span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">

                        <li class="nav-item">
                            <a href="{{ route('admin.editCurrencies') }}" class="nav-link">فرم ویرایش ارز</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.locationRelates') }}" class="nav-link">فرم ارتباط شهر / کشور</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.showCityForms') }}" class="nav-link"> فرم ثبت شهر جدید </a>
                        </li>

                    </ul>
                </li>

                @endcan


                <!-- Main -->
                @can('isSuperAdmin',App\User::Class)
                <li class="nav-item-header">
                    <div class="text-uppercase  line-height-xs" style="font-size:1.2em">مدیریت سایت</div>
                    <i class="icon-menu" title="Main"></i>
                </li>
                {{--@if (Auth::user()->can('create', [\App\User::class,'AboutUs']))--}}
                {{--<li class="nav-item nav-item-submenu">--}}
                {{-- <a href="{{ route('admin.AboutUs.create',['lang'=>$isoCode]) }}" class="nav-link"><i--}} {{--class="icon-circle-small"></i>--}} {{--<span>{{ __('admin.aboutUs') }}</span> </a>--}} {{--</li>--}} {{--@endif--}} <li class="nav-item nav-item-submenu">

                    <a href="#" class="nav-link"><i class="icon-circle-small"></i>
                        <span> اطلاعات صفحات سایت </span></a>
                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">

                        <li class="nav-item">
                            <a href="{{route('admin.adminAbout')}}" class="nav-link">درباره ما</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.adminContact')}}" class="nav-link">ارتباط با ما </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.adminRules')}}" class="nav-link">قوانین</a>
                        </li>

                    </ul>

                    </li>

                    <li class="nav-item nav-item-submenu">

                        <a href="#" class="nav-link"><i class="icon-circle-small"></i>
                            <span> تور های محبوب </span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            <li class="nav-item">
                                <a href="{{route('admin.FavoriteTours.index')}}" class="nav-link">لیست تور های محبوب</a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('admin.FavoriteTours.create')}}" class="nav-link">ثبت جدید</a>
                            </li>


                        </ul>

                    </li>

                    <li class="nav-item nav-item-submenu">

                        <a href="#" class="nav-link"><i class="icon-circle-small"></i>
                            <span> پشتیبانی </span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">

                            <li class="nav-item">
                                <a href="{{route('admin.showsTicket')}}" class="nav-link">تیکت ها</a>
                            </li>

                        </ul>

                    </li>

                    <li class="nav-item nav-item-submenu">

                        <a href="#" class="nav-link"><i class="icon-circle-small"></i>
                            <span> وبلاگ </span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">

                            <li class="nav-item">
                                <a href="{{route('admin.createPost')}}" class="nav-link">مطلب جدید</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.listPost')}}" class="nav-link">لیست مطالب</a>
                            </li>

                        </ul>

                    </li>

                    <li class="nav-item nav-item-submenu">

                        <a href="#" class="nav-link"><i class="icon-circle-small"></i>
                            <span> ویدیو </span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">

                            <li class="nav-item">
                                <a href="{{route('admin.createVideo')}}" class="nav-link"> ویدیو جدید </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.listVideo')}}" class="nav-link">  لیست ویدیو ها </a>
                            </li>

                        </ul>

                    </li>


                    @endcan


                    <li class="nav-item-header">
                        <div class="text-uppercase  line-height-xs" style="font-size:1.2em">تنظیمات</div>
                        <i class="icon-menu" title="Main"></i>
                    </li>

                    <li class="nav-item nav-item-submenu">

                        <a href="#" class="nav-link"><i class="icon-circle-small"></i>
                            <span> پروفایل </span></a>
                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">

                            <li class="nav-item">
                                <a href="{{route('admin.editPassword')}}" class="nav-link">ویرایش رمزعبور</a>
                            </li>

                        </ul>

                    </li>

            </ul>
        </div>
        <!-- /main navigation -->
    </div>
    <!-- /sidebar content -->
</div>
<!-- /main sidebar -->