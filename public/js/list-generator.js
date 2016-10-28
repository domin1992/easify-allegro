$(document).ready(function(){
  var rowCounter = 0;
  var collection = [];
  var currentTextarea = '';

  $('.insert-list-btn').click(function(){
    clearModal();
    $('.insert-list').modal('show');
    currentTextarea = $(this).data('anchor');
  });

  $('#list-add-row').click(function(){
    rowCounter++;
    $('#list-values').append('<div class="form-group"><div class="col-sm-11"><input type="text" class="form-control" id="list-row-' + rowCounter + '"></div><div class="col-sm-1"><a href="javascript:void(0)" class="remove-row" data-row="' + rowCounter + '"><i class="fa fa-times remove"></i></a></div></div>');
  });

  $('#list-values').delegate('.remove-row', 'click', function(){
    var content = '';
    var row = $(this).data('row');
    collectAllExcept(row);
    rowCounter--;
    for(var i = 1; i <= rowCounter; i++){
      content += '<div class="form-group"><div class="col-sm-11"><input type="text" class="form-control" id="list-row-' + i + '" value="' + collection[i-1] + '"></div><div class="col-sm-1"><a href="javascript:void(0)" class="remove-row" data-row="' + i + '"><i class="fa fa-times remove"></i></a></div></div>';
    }
    $('#list-values').html(content);
  });

  $('#list-save').click(function(){
    collectAllList();
    if($(".list-type input[name=list_type]:checked").val() == 'list_type_points'){
      var newContent = convertToHtml('points');
      console.log(newContent);
      var oldContent = $('#' + currentTextarea).val();
      console.log(oldContent);
      $('#' + currentTextarea).val(oldContent + newContent);
      $('.insert-list').modal('hide');
    }
    else if($(".list-type input[name=list_type]:checked").val() == 'list_type_numbers'){
      var newContent = convertToHtml('numbers');
      var oldContent = $('#' + currentTextarea).val();
      $('#' + currentTextarea).val(oldContent + newContent);
      $('.insert-list').modal('hide');
    }
    else{
      var newContent = convertToHtml('points');
      var oldContent = $('#' + currentTextarea).val();
      $('#' + currentTextarea).val(oldContent + newContent);
      $('.insert-list').modal('hide');
    }
  });

  function collectAllList(){
    collection = [];
    var selector = '';
    for(var i = 0; i <= rowCounter; i++){
      selector = '#list-row-' + i;
      collection.push($(selector).val());
    }
  }

  function collectAllExcept(except){
    collection = [];
    $('#list-values input').each(function(index){
      if(index != except - 1){
        collection.push($(this).val());
      }
    });
  }

  function convertToHtml(option){
    var content = '';
    if(option == 'numbers'){
      content += '<ol>';
    }
    else if(option == 'points'){
      content += '<ul>';
    }
    for(var i = 0; i <= rowCounter; i++){
      content += '<li>' + collection[i] + '</li>';
    }
    if(option == 'numbers'){
      content += '</ol>';
    }
    else if(option == 'points'){
      content += '</ul>';
    }
    return content;
  }

  function clearModal(){
    $('#list-values').empty();
    $('#list-row-0').val('');
  }
});
