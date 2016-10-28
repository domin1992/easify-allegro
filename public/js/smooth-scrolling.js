$(document).ready(function(){
  $('a').click(function(){
    $('html, body').animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top
    }, 500);
    return false;
  });

  if($(window).width() > 767){
    var headerBottomLine = $('header').position().top + $('header').outerHeight(true);
    var windowTopLine = 0;
    $(window).scroll(function(){
      windowTopLine = $(window).scrollTop();
      if(windowTopLine >= headerBottomLine){
        $('.fixed').css('top', '0');
      }
      else{
        $('.fixed').css('top', 'auto');
      }
    });
  }
});
