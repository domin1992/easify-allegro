$(document).ready(function(){
  var currentTextarea = '';
  $('.insert-image-btn').click(function(){
    clearModal();
    currentTextarea = $(this).data('anchor');
    $('.insert-image').modal('show');
  });

  $('#image-save').click(function(){
    var oldContent = $('#' + currentTextarea).val();
    var newContent = '<img src="' + $('#image-address').val() + '" alt="' + $('#image-alternative').val() + '" />';
    $('#' + currentTextarea).val(oldContent + newContent);
    $('.insert-image').modal('hide');
  });

  function clearModal(){
    $('#image-address').val('');
    $('#image-alternative').val('');
  }
});
