$(window).load(function(){
  if($(window).outerHeight() > $('body').outerHeight()){
    var minHeight = $(window).outerHeight() - $('header').outerHeight() - $('footer').outerHeight() - $('.user-space').outerHeight();
    $('main').css('min-height', minHeight + 'px');
  }
});
