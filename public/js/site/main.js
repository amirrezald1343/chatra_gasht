'use strict';

/*------------------------------*/
/*-- JS Guide ------------------*/
/*------------------------------*/
/*-- 01. LOADER ----------------*/
/*-- 02. NAVIGATION ------------*/
/*-- 03. SLIDER ----------------*/
/*-- 04. ACCORDION ELEMENT -----*/
/*-- 05. FORM VALIDATION -------*/
/*-- 06. ANIMATION ELEMENTS ----*/
/*-- 07. DATEPICKER ------------*/
/*-- 08  COUNTER ---------------*/
/*-- 09. GALLERY VIEWBOX -------*/
/*-- 10. MASONRY GALLERY -------*/
/*-- 11.SCROLL TOP -------------*/
/*-- 12.SCROLL MENU ------------*/
/*-- 13.MENU STICKY ------------*/
/*-- 14.SIDEBAR STICKY ---------*/
/*------------------------------*/



// 1. LOADER
//================================================================

window.addEventListener('load', function(){
  $('#loader').fadeOut('1500');
})


// 2. NAVIGATION
//================================================================

$("#navigation").navigation({
  mobileBreakpoint: 1030,
  submenuIndicator: false,
  effect: "slide"
});

$("#contact-menu").navigation({
    hidden: true //the navigation bar is hidden
});


$('.btn-show').on('click', function(e) {
  $("#contact-menu").data("navigation").toggleOffcanvas();
});



// 3. SLIDER
//================================================================

// fullscreen-slider
var sliderAutoplay  = jQuery('#sliderAutoplay').val();

var fullscreenOwl = jQuery("#fullscreen-slider");
  fullscreenOwl.owlCarousel({
    loop:true,
    margin:0,
    items:1,
    autoplay: true,
    autoplayHoverPause:true,
    autoplayTimeout: sliderAutoplay,
    nav: true,
    dots: false,
    navSpeed: 500,

    singleItem: true,
    navText: [
    "<i class='ti-angle-left'></i>",
    "<i class='ti-angle-right'></i>"
    ],
    animateIn: 'pulse'
  });


  fullscreenOwl.on('changed.owl.carousel', function(event) {

    var $currentItem = jQuery('.owl-item', fullscreenOwl).eq(event.item.index);
    var $elemsToanim = $currentItem.find("[data-animation]");

    

    setAnimation ($elemsToanim);
    setEmpty ($elemsToanim);
  })

  function setAnimation ( _elem ) {
    var animationEndEvent = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';

    _elem.each ( function () {
      var $elem = jQuery(this);
      $elem.removeClass('animated');
      $elem.removeClass($elem.data( 'animation' ));

      var $animationType = 'animated ' + $elem.data( 'animation' );
      var $animationTimeOut = $elem.data( 'timeout' );

      if ($animationTimeOut) {
        window.setTimeout(function(){
          $elem.addClass($animationType);
        }, parseInt($animationTimeOut,10));
      } else {

        $elem.addClass($animationType);
      }
    });
  }

  function setEmpty ( _elem ) {
    var animationEndEvent = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';

    _elem.each ( function () {
      var $elem = jQuery(this);
      
      $elem.addClass('animate');
      $elem.removeClass('animated');
    });
  }

// coming-soon-carousel

var owl4 = jQuery("#coming-soon-carousel");
owl4.owlCarousel({
  loop:true,
  margin: 0,
  items:1,
  autoplay: true,
  autoplayTimeout: 6000,
  nav: false,
  dots: false,
  navSpeed: 1400,
  singleItem: true
});



// 4. ACCORDION ELEMENT
//================================================================


$('.toggle').on('click', function(e) {
  e.preventDefault();

  var $this = $(this);
  if ($this.next().hasClass('show')) {
    $('.toggle').removeClass('current');
    $(this).toggleClass('current');
    $this.next().removeClass('show');
    $this.next().slideUp(350);
  } else {
    $('.toggle').removeClass('current');
    $(this).toggleClass('current');
    $this.parent().parent().find('li .inner').removeClass('show');
    $this.parent().parent().find('li .inner').slideUp(350);
    $this.next().toggleClass('show');
    $this.next().slideToggle(350);
  }
});



// 5. FORM VALIDATION
//================================================================

$("form#cta-form").validate({
  rules: {
    name: "required",
    phone: "required"
  },
  messages: {
    name: "Your name is required",
    phone: "Your phone is required"
  },
  submitHandler: function(form) {

    var name    = $("input[name=name]").val();
    var phone   = $("input[name=phone]").val();

    $.ajax({
      url: "./php/form_calltoaction.php",
      type: "POST",
      data: {name: name, phone: phone},
      cache: false,
      success: function() {
        $('.form-block').prepend( "<p class='success-message'>Thank You! Your message has been sent.</p><br>" );             
        $('.form-block').trigger("reset");
      },
      error: function() {
      },
    })

  }
});

$("form#contact-form").validate({
  rules: {
    subject: "required",
    email: "required"
  },
  messages: {
    subject: "Subject is required",
    email: "Email is required"
  },
  submitHandler: function(form) {

    var subject = $("input[name=subject]").val();
    var email   = $("input[name=email]").val();
    var message = $("input[name=message]").val();

    $.ajax({
      url: "./php/form_contact.php",
      type: "POST",
      data: {subject: subject, email:email, message:message},
      cache: false,
      success: function() {
        $('.form-block').prepend( "<p class='success-message'>Thank You! Your message has been sent.</p><br>" );             
        $('.form-block').trigger("reset");
      },
      error: function() {
      },
    })

  }
});

$("form#subscribe-form").validate({
  rules: {
    email: "required"
  },
  messages: {
    email: "Your email is required"
  },
  submitHandler: function(form) {

    var email   = $("input[name=email]").val();

    $.ajax({
      url: "./php/form_subscribe.php",
      type: "POST",
      data: {email:email},
      cache: false,
      success: function() {
        $('.form-block').prepend( "<p class='success-message'>Thank You! Your message has been sent.</p><br>" );             
        $('.form-block').trigger("reset");
      },
      error: function() {
      },
    })

  }
});

$("form#modal-book").validate({
  rules: {
    name: "required",
    email: "required",
    person: "required",
    depart: "required"
  },
  messages: {
    name: "Your name is required",
    email: "Your email is required",
    person: "Your person(s) is required",
    depart: "Your depart date is required"
  },
  submitHandler: function(form) {

    var name    = $("input[name=name]").val();
    var email   = $("input[name=email]").val();
    var person = $("input[name=person]").val();
    var depart = $("input[name=depart]").val();

    $.ajax({
      url: "./php/form_booking.php",
      type: "POST",
      data: {name: name, email: email, person:person, depart:depart},
      cache: false,
      success: function() {
        $('.form-block').prepend( "<p class='success-message'>Thank You! Your message has been sent.</p><br>" );             
        $('.form-block').trigger("reset");
      },
      error: function() {
      },
    })

  }
});



// 6. ANIMATION ELEMENTS
//================================================================

window.addEventListener('load', function(){

  var $window           = $(window),
      win_height_padded = $window.height() * 1.1,
      isTouch           = Modernizr.touch;

  if (isTouch) { $('.animate').addClass('animated'); }

  $window.on('scroll',animateScroll);

  function animateScroll() {
    var scrolled = $window.scrollTop(),
    win_height_padded = $window.height() * 1.1;

    $(".animate:not(.animated)").each(function () {
      var $elem = jQuery(this);
      var offsetTop = $elem.offset().top;

      $elem.removeClass('animated');
      $elem.removeClass($elem.data( 'animation' ));

      if (scrolled + win_height_padded > offsetTop) {

        var $animationType = 'animated ' + $elem.data( 'animation' );
        var $animationTimeOut = $elem.data( 'timeout' );

        if ($animationTimeOut) {
          window.setTimeout(function(){
            $elem.addClass($animationType);
          }, parseInt($animationTimeOut,10));
        } else {
          
        }
      }
    });

  }

  animateScroll();
});



// 7. DATEPICKER
//================================================================

if (jQuery("#daterangepicker").length) {
  jQuery('#daterangepicker').dateRangePicker({
    autoClose: false,
    format: 'YYYY-MM-DD',
    separator: ' - ',
    singleMonth: true
  });
}


// 8. COUNTER
//================================================================

var a = 0;
$(window).scroll(function() {

  if($("#counter").length > 0)
  {
    var oTop = $('#counter').offset().top - window.innerHeight;
    if (a == 0 && $(window).scrollTop() > oTop) {
      $('.counter-value').each(function() {
        var $this = $(this),
          countTo = $this.attr('data-count');
        $({
          countNum: $this.text()
        }).animate({
            countNum: countTo
          },
          {
            duration: 2000,
            easing: 'swing',
            step: function() {
              $this.text(Math.floor(this.countNum));
            },
            complete: function() {
              $this.text(this.countNum);
            }
          });
      });
      a = 1;
    }
  }

});

jQuery("#duration-input").slider();
jQuery("#duration-input").on("slide", function(slideEvt) {
  jQuery("#duration-1").text(slideEvt.value[0]);
  jQuery("#duration-2").text(slideEvt.value[1]);
});

jQuery("#budget-input").slider();
jQuery("#budget-input").on("slide", function(slideEvt) {
  jQuery("#budget-1").text(slideEvt.value[0]);
  jQuery("#budget-2").text(slideEvt.value[1]);
});


// 9. GALLERY VIEWBOX
//================================================================


$('.image-link').viewbox({
  nextOnContentClick: false
});

// 10. MASONRY GALLERY
//================================================================

var $grid = $('.masonry-4');

  // trigger after images loaded
  $grid.imagesLoaded( function() {
    $grid.masonry({
    itemSelector: '.col-md-4',
    columnWidth: '.grid-sizer-4',
    percentPosition: true
  });
  });



// 11. SCROLL TOP
//================================================================

$(window).scroll(function () {
  if ($(this).scrollTop() > 1300) {
    $('.scrollup').slideDown(300);
  } else {
    $('.scrollup').slideUp(300);
  }
});

$(document).on('click', '.scrollup',  function(){
  $("html, body").animate({
    scrollTop: 0
  }, 200);
  return false;
});

// 12. SCROLL MENU
//================================================================

function scrollToDiv(element,navheight){
  var offset = element.offset();
  var offsetTop = offset.top;
  var totalScroll = offsetTop-navheight;
  $('body, html').animate({scrollTop: totalScroll}, 300);
}

$('li.to-section a').on('click', function(e) {
  e.preventDefault(); 
  var el = $(this).attr('href');
  var elWrapped = $(el);
  scrollToDiv(elWrapped,0);

  $('li.to-section a').removeClass('active');
  $(this).addClass('active');

});

$('.section').waypoint(function(direction) {
    var $active = $(this);
    if (direction === "up") {
      $active = $active.prev();
    }
    if (!$active.length) {
      $active.end();
    }
  }, { offset: '30%' }
);

// 13. MENU STICKY
//================================================================

var  hdr = 550;

jQuery(window).scroll(function() {
  if( jQuery(this).scrollTop() > hdr ) {
    jQuery( "body" ).addClass("menu-sticky");
  } else {
   jQuery( "body" ).removeClass("menu-sticky");
  }
});


var  hdr = jQuery(window).height() - 1;
var  hm  = jQuery("ul.section-to-block-menu");
jQuery(window).scroll(function() {
  if( jQuery(this).scrollTop() > hdr ) {
    hm.addClass("nav-menu-sticky");
  } else {
    hm.removeClass("nav-menu-sticky");
  }
});


// Hide Header on on scroll down
var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = jQuery('.main-header').outerHeight();

jQuery(window).scroll(function(event){
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 250);

function hasScrolled() {
    var st = jQuery(this).scrollTop();
    
    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta)
        return;
    
    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
    if (st > lastScrollTop && st > navbarHeight){
  
        jQuery(".main-header").removeClass("main-header-sticky");
        jQuery( "body" ).removeClass( "header-bg-sticky");
    } else {

        if(st + jQuery(window).height() < jQuery(document).height()) {
            jQuery(".main-header").addClass("main-header-sticky");
            jQuery( "body" ).addClass( "header-bg-sticky");
        }
    }
    
    lastScrollTop = st;
}

// 14. SIDEBAR STICKY
//================================================================

$(".tour-single-sidebar-main").stick_in_parent({
});


// 15. COOKIE MESSAGE
//================================================================

var  hdr = 550;

jQuery(window).scroll(function() {
  if( jQuery(this).scrollTop() > hdr ) {
    jQuery( ".alert-fixed" ).addClass("visible-message");
  }
});


