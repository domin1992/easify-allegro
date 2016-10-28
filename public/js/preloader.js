function runPreloader(){
  $('body').append('<div class="preloader"><i class="fa fa-spinner fa-pulse"></i></div>');
}

function stopPreloader(){
  $('.preloader').remove();
}
