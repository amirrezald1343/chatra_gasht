<script src="{{ url('js/app-min.js') }}"></script>
<script src="{{ url('js/site/vendor/jquery.min.js') }}"></script>
<script src="{{ url('js/site/carousel.js') }}"></script>
<script src="{{ url('js/site/vendor/moment_min.js') }}"></script>
<script src="{{ url('js/site/vendor/bootstrap.min.js') }}"></script>
<script src="{{ url('js/site/vendor/bootstrap-slider.min.js') }}"></script>
<script src="{{ url('js/site/vendor/cookies.js') }}"></script>
<script src="{{ url('js/site/vendor/jquery.daterangepicker.min.js') }}"></script>
<script src="{{ url('js/site/vendor/navigation.js') }}"></script>
<script src="{{ url('js/site/vendor/modernizr.js') }}"></script>
<script src="{{ url('js/site/vendor/jqueryvalidation.js') }}"></script>
<script src="{{ url('js/site/vendor/jquery.viewbox.min.js') }}"></script>
<script src="{{ url('js/site/vendor/masonry.min.js') }}"></script>
<script src="{{ url('js/site/vendor/imagesloaded.js') }}"></script>
<script src="{{ url('js/site/vendor/jquery.waypoints.min.js') }}"></script>
<script src="{{ url('js/site/vendor/jquery.sticky-kit.min.js') }}"></script>
<script src="{{ url('js/site/main.js') }}"></script>
<script src="{{ url('js/site/setting/jscolor.js') }}"></script>
<script src="{{ url('js/site/setting/settings.js') }}"></script>
<script src="{{ url('js/jquery.lazy.min.js') }}"></script>
<script src="{{ url('js/wNumb.js') }}"></script>
<script src="{{ url('js/nouislider.min.js') }}"></script>
<script src="{{ url('js/umd/popper.min.js') }}"></script>




<script type="text/javascript">window.$crisp = [];
    window.CRISP_WEBSITE_ID = "3027182d-5039-46db-b3c0-dbd68badbcd6";
    (function () {
        d = document;
        s = d.createElement("script");
        s.src = "https://client.crisp.chat/l.js";
        s.async = 1;
        d.getElementsByTagName("head")[0].appendChild(s);
    })();</script>

<script type="text/javascript">

    $(window).scroll(function () {
        var href= window.location.href;
        var dotes=href.indexOf(":");
        var mainhref=href.substring(dotes+3);
        var slash=mainhref.indexOf("/");
        var rot=mainhref.substring(slash+1);


        var scrollWin = $(window).scrollTop();

        if (scrollWin > 170) {

            $(".main-header").addClass('headerFixTop');
            $(".main-header-logo a img").attr("src", "/icons/logo11.jpg");
        } else if (scrollWin < 170) {
            $(".main-header").removeClass('headerFixTop');

            if((rot!="about")&& (rot!="contact")&& (rot!="compare")&& (rot!="createAgency")&& (rot!="rules")&& (rot!="single")&& (rot!="blog")&& (rot!="favTourList")&& (rot!="searchAgency")&& (rot!="RegisterAgency")&& (rot!="blog/{id}/{title?}"))

            {
                $(".main-header-logo a img").attr("src", "/img/header-logo-white.png");

            }
            else
            {
                $(".main-header-logo a img").attr("src", "/img/header-logo.png");

            }

        }
    });

    $('.headerFixTop .nav-submenu').hover(function () {
        $(this).closest('li').find('a').first().css({"color": "black"});
    });


</script>
