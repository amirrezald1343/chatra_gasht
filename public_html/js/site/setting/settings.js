$(document).on('click', '#setting-button',  function(){
  if (jQuery("#setting-button i").hasClass("ti-settings")){
    jQuery("#options-setting").addClass("move-right");
    jQuery("#setting-button i").removeClass("ti-settings");
    jQuery("#setting-button i").addClass("ti-close");
  }
  else
  {
    jQuery("#options-setting").removeClass("move-right");
    jQuery("#setting-button i").removeClass("ti-close");
    jQuery("#setting-button i").addClass("ti-settings");
  }
});


// HEADER

$('select#setting-header-bg').on('change', function() {
  var header_bg = this.value;
  if(header_bg) {
    jQuery(".main-header").attr('class','main-header');
    jQuery(".main-header").addClass(header_bg);
    
  }
})


$('select#setting-header-width').on('change', function() {
  var header_width = this.value;
  if(header_width) {
    jQuery(".header-width").attr('class','header-width');
    jQuery(".header-width").addClass(header_width);
    
  }
})



$('select#setting-page-align').on('change', function() {
  var page_align = this.value;
  if(page_align) {
    jQuery(".display-r").attr('class','display-r');
    jQuery(".display-r").addClass(page_align);
  }
})

$('#setting-first-color').on('change', function() {
  var first_color = this.value;
  if(first_color) {
    document.documentElement.style.setProperty('--first_color', '#'+first_color);
  }
})

$('#setting-second-color').on('change', function() {
  var second_color = this.value;
  if(second_color) {
    document.documentElement.style.setProperty('--second_color', '#'+second_color);
  }
})

$('#setting-third-color').on('change', function() {
  var third_color = this.value;
  if(third_color) {
    document.documentElement.style.setProperty('--third_color', '#'+third_color);
  }
})

$('#setting-background-color').on('change', function() {
  var bg_color = this.value;
  if(bg_color) {
    document.documentElement.style.setProperty('--bg_color', '#'+bg_color);
  }
})


$(document).on('click', '#scheme-1',  function(){
  var first  = 'ffd903';
  var second = 'ef3822';
  var third  = 'fffce9';

  document.documentElement.style.setProperty('--first_color', '#'+first);
  document.documentElement.style.setProperty('--second_color', '#'+second);
  document.documentElement.style.setProperty('--third_color', '#'+third);
});

$(document).on('click', '#scheme-2',  function(){
  var first  = 'f5ac20';
  var second = 'f57d20';
  var third  = 'ffcf75';

  document.documentElement.style.setProperty('--first_color', '#'+first);
  document.documentElement.style.setProperty('--second_color', '#'+second);
  document.documentElement.style.setProperty('--third_color', '#'+third);
});

$(document).on('click', '#scheme-3',  function(){
  var first  = '12C998';
  var second = 'F070A1';
  var third  = '16FFBD';

  document.documentElement.style.setProperty('--first_color', '#'+first);
  document.documentElement.style.setProperty('--second_color', '#'+second);
  document.documentElement.style.setProperty('--third_color', '#'+third);
});

$(document).on('click', '#scheme-4',  function(){
  var first  = '77A6F7';
  var second = '00887A';
  var third  = 'D3E3FC';

  document.documentElement.style.setProperty('--first_color', '#'+first);
  document.documentElement.style.setProperty('--second_color', '#'+second);
  document.documentElement.style.setProperty('--third_color', '#'+third);
});

$(document).on('click', '#scheme-5',  function(){
  var first  = '9E5A63';
  var second = '97AABD';
  var third  = 'C96567';

  document.documentElement.style.setProperty('--first_color', '#'+first);
  document.documentElement.style.setProperty('--second_color', '#'+second);
  document.documentElement.style.setProperty('--third_color', '#'+third);
});

$(document).on('click', '#scheme-6',  function(){
  var first  = '955eb5';
  var second = '564F6F';
  var third  = 'D1D7E0';

  document.documentElement.style.setProperty('--first_color', '#'+first);
  document.documentElement.style.setProperty('--second_color', '#'+second);
  document.documentElement.style.setProperty('--third_color', '#'+third);
});

$(document).on('click', '#scheme-7',  function(){
  var first  = 'FCE181';
  var second = '026670';
  var third  = 'FEF9C7';

  document.documentElement.style.setProperty('--first_color', '#'+first);
  document.documentElement.style.setProperty('--second_color', '#'+second);
  document.documentElement.style.setProperty('--third_color', '#'+third);
});

$(document).on('click', '#scheme-8',  function(){
  var first  = '53900F';
  var second = '1F6521';
  var third  = 'A4A71E';

  document.documentElement.style.setProperty('--first_color', '#'+first);
  document.documentElement.style.setProperty('--second_color', '#'+second);
  document.documentElement.style.setProperty('--third_color', '#'+third);
});

$(document).on('click', '#scheme-9',  function(){
  var first  = 'D9B08C';
  var second = '116466';
  var third  = 'FFCB9A';

  document.documentElement.style.setProperty('--first_color', '#'+first);
  document.documentElement.style.setProperty('--second_color', '#'+second);
  document.documentElement.style.setProperty('--third_color', '#'+third);
});

