<footer class="dark-footer">
    <div class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h5>" درباره کلیک سفر "</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p class="aboutus">هدف اصلی کلیک سفر در همکاری با آژانس های مسافرتی معتبر , ایجاد یک اکوسیستم و مرجع کامل , مطمئن و به روز از اطلاعات تورها میباشد.

                        بازدید کنندگان سایت کلیک سفر میتوانند با استفاده از فیلتر ها و منوی سایت به اطلاعات کامل تور مسافرتی مد نظر خود دست پیدا کنند و به طور مستقیم و بدون واسطه با آژانس ارائه دهنده تور ارتباط برقرار نمایند.

                        لازم به ذکر است هیچ گونه تراکنش یا خریدی در سایت صورت نمی گیرد و مسافران در صورت تمایل به خرید تور فقط می بایست با آژانس مسافرتی ارائه دهنده تور تماس حاصل نمایند.</p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-12 text-right">
                    <div class="footer-item">
                        <div class="row">

                            <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                <ul class="footer_ul">
                                    <li><h5>کلیک سفر</h5></li>
                                    <li><a href="{{url('/administrator')}}">ورود آژانس</a></li>
                                    <li><a href="{{url('/searchAgency')}}">جستجوی آژانس</a></li>
                                    <li><a href="{{url('/RegisterAgency')}}">عضویت آژانس</a></li>
                                    <li><a href="{{url('/contact')}}">تماس با ما</a></li>
                                </ul>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                <ul class="footer_ul">
                                    <li><h5>دسترسی سریع</h5></li>
                                    <li><a href="{{url('/Tours/internal')}}">تورهای داخلی</a></li>
                                    <li><a href="{{url('/Tours/foreign')}}">تورهای خارجی</a></li>
                                    <li><a href="{{url('/Tours/moment')}}">تورهای لحظه آخری</a></li>
                                    <li><a href="{{url('/blog')}}">بلاگ</a></li>
                                </ul>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-6">
                                <ul class="footer_ul">
                                    <li><h5>قوانین کلیک سفر</h5></li>
                                    <li><a href="{{url('/rules')}}">قوانین</a></li>
                                    <li><a href="{{url('/contact')}}">ثبت شکایات</a></li>
                                    <li><a href="{{url('/about')}}">درباره ی ما</a></li>
                                    <li><a download="" href="{{url('/AnyDesk.5.2.2.exe')}}">دانلود AnyDesk</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" style="z-index: 99999;">
                    <div class="footer-item">
                      <img src="/img/header-logo.png" alt="Logo" style="width: 200px;" class="lazy">

                        <ul class="mb-20">
                            <li class="mt-10"><a href="mailto:info@clicksafar.com"><i class="fa fa-envelope"
                                                                                      style="font-size: 14px;"></i>
                                    info@clicksafar.com</a></li>
                            <li class="mt-10"><a href="tel:05131600"><i class="fa fa-phone"
                                                                        style="font-size: 18px;"></i>
                                    <span>دفتر مشهد : </span> <span style="direction: ltr !important;">31600-051</span></a>
                            </li>
                            <li class="mt-10"><a href="tel:02122387527"><i class="fa fa-phone"
                                                                           style="font-size: 18px;"></i> <span> دفتر تهران : </span>
                                    <span style="direction: ltr !important;">22387527-021</span></a></li>
                        </ul>

                    </div>


                    <ul class="footer-social mt-20">
                        <li><a target="_blank" href="https://instagram.com/clicksafar/"><i
                                        class="fa fa-instagram"></i></a></li>
                        <li><a target="_blank" href="http://t.me/clicksafar"><i class="fa fa-telegram"></i></a></li>
                        <li><a target="_blank" href="https://wa.me/+989364931600"><i
                                        class="fa fa-whatsapp"></i></a></li>
                        <li><a target="_blank" href="https://twitter.com/clicksafar"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li><a target="_blank" href="#"><i class="fa fa-youtube-play"></i></a>
                        </li>
                        <li><a target="_blank" href="https://www.aparat.com/clicksafar/"><img src="{{ url('img/aparat.png') }}" width="30" height="30px" class="fa "></a>
                        </li>
                    </ul>
                    <a download="" href="{{ url('https://play.google.com/store/apps/details?id=com.it.mahab.clicksafar') }}" style="visibility: hidden;">androidApp</a>
                </div>
            </div>
            <div class="row">
                {{--<div class="col-lg-5 pull-right "><p class="mt-30  mb-0 font-size-lg">تورهای گردشگری و لحظه آخری</p>--}}
                    {{--<p class="mt-10">شما می توانید تور مورد نظر خود را بر اساس مقصد مورد نظر جستجو کرده و یافته های خود--}}
                        {{--را براساس قیمت٬ مبداء حرکت٬ تعداد شب های اقامت٬ درجه هتل و ایرلاین فیلتر نمایید. <span><a--}}
                                    {{--href="http://127.0.0.1:8000/about" class="blue">بیشتر..</a></span></p></div>--}}
                <div class=" col-lg-12 " style="text-align: center;">
                    <div style="width: 100px; background-color: white; border-radius: 5px; display: inline-block;">
                        <img
                                src="https://trustseal.enamad.ir/logo.aspx?id=38051&amp;p=5F1ftZ3Tzsosng2K" alt=""
                                onclick="window.open('https://trustseal.enamad.ir/Verify.aspx?id=38051&amp;p=5F1ftZ3Tzsosng2K', 'Popup','toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30')"
                                id="5F1ftZ3Tzsosng2K" style="width: 100%; height: 100%;" class="lazy"></div>
                    <div style="width: 107px; background-color: white; border-radius: 5px; display: inline-block;">
                        <img
                                id="jzpejzpergvjjzpeoeuk"
                                onclick="window.open(&quot;https://logo.samandehi.ir/Verify.aspx?id=77378&amp;p=jyoejyoexlaojyoemcsi&quot;, &quot;Popup&quot;,&quot;toolbar=no, scrollbars=no, location=no, statusbar=no, menubar=no, resizable=0, width=450, height=630, top=30&quot;)"
                                alt="logo-samandehi"
                                src="https://logo.samandehi.ir/logo.aspx?id=77378&amp;p=yndtyndtqftiyndtaqgw"
                                style="height: 109px; cursor: pointer;" class="lazy"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center"><p>Copyright © 2019 کلیک سفر</p></div>
            </div>
        </div>
    </div>
</footer>
<!-- SCROLL UP -->
<a class="scrollup">
    <i class="ti-angle-up"></i>
</a>
