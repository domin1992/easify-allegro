$(document).ready(function(){
  $('#upload-file').click(function(){
    runPreloader();
  });
});

$(document).ready(function() {
  $('#filer_input').filer();
});

//sets height of div's
$(window).load(function(){
  var maxHeight = 0;
  var templateCounter = 0;
  $('.template').each(function(){
    templateCounter++;
    if(maxHeight < $(this).height())
      maxHeight = $(this).height();
  });

  $('.template').each(function(){
    $(this).height(maxHeight);
  });

  if(templateCounter > 1){
    var paddingTop = (maxHeight - 1 - $('.template-new h1').height() - $('.template-new h3').height()) / 3;
    $('.template-new .new-holder').css('padding-top', paddingTop);
  }
});

$(document).ready(function(){
  var cookieAccepted = '';
  cookieAccepted = $.cookie('cookie-accepted');
  if(cookieAccepted != 'yes'){
    $('.cookie-info').show();
  }

  $('#cookie-accept').click(function(){
    $('.cookie-info').hide();
    $.cookie('cookie-accepted', 'yes');
  });
});
