$(document).ready(function(){
  var currentTextarea = '';
  $('.insert-header-btn').click(function(){
    clearModal();
    currentTextarea = $(this).data('anchor');
    $('.insert-header').modal('show');
  });

  $('#header-save').click(function(){
    var oldContent = $('#' + currentTextarea).val();
    var newContent = '<h' + $('#header-type').val() + '>' + $('#header-text').val() + '</h' + $('#header-type').val() + '>';
    $('#' + currentTextarea).val(oldContent + newContent);
    $('.insert-header').modal('hide');
  });

  function clearModal(){
    $('#header-type').val(1);
    $('#header-text').val('');
  }
});
