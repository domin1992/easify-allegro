$(document).ready(function(){
  var blogs = [];
  var pageCounter = 1;
  var newContent = '';
  var paginationContent = '';
  var currentPage = 1;
  var blogPerPage = 10;

  if($('.blog').length > blogPerPage){
    $('.blog').each(function(){
      blogs.push($(this).html());
    });

    $('.blog-wrapper').html('');

    newContent += '<div id="page-0">';
    for(var i = 0; i < blogs.length; i++){
      if(i%blogPerPage == 0 && i != 0){
        newContent += '</div>';
        newContent += '<div id="page-' + pageCounter + '">';
        pageCounter++;
      }
      newContent += '<div class="blog">';
      newContent += blogs[i];
      newContent += '</div>';
    }
    newContent += '</div>';

    $('.blog-wrapper').html(newContent);

    pageCounter--;
    for(var i = 1; i <= pageCounter; i++){
      var selector = '#page-' + i;
      $(selector).hide();
    }

    paginationContent += '<li><a href="javascript:void(0)" aria-label="Previous" data-page="prev"><span aria-hidden="true">&laquo;</span></a></li>';
    for(var i = 0; i <= pageCounter; i++){
      if(i==0){
        paginationContent += '<li class="active"><a href="javascript:void(0)" data-page="' + (i + 1) + '">' + (i + 1) + '</a></li>';
      }
      else{
        paginationContent += '<li><a href="javascript:void(0)" data-page="' + (i + 1) + '">' + (i + 1) + '</a></li>';
      }
    }
    paginationContent += '<li><a href="javascript:void(0)" aria-label="Next" data-page="next"><span aria-hidden="true">&raquo;</span></a></li>';

    $('.pagination').html(paginationContent);
    $('.pagination').delegate('a', 'click', function(){
      var request = $(this).data('page');
      $('.pagination').find('[data-page="' + currentPage + '"]').closest('li').removeClass('active');
      if(request != 'prev' && request != 'next'){
        openPage(request);
      }
      else if(request == 'prev' && currentPage > 1){
        openPage(currentPage - 1);
      }
      else if(request == 'next' && currentPage <= pageCounter){
        openPage(currentPage + 1);
      }
      $('.pagination').find('[data-page="' + currentPage + '"]').closest('li').addClass('active');
    });
  }

  function openPage(page){
    var selector = '';
    page = parseInt(page);
    for(var i = 0; i <= pageCounter; i++){
      selector = '#page-' + i;
      if($(selector).css('display') != 'none'){
        $(selector).fadeOut(300);
      }
    }
    translatedPageNo = page - 1;
    $('#page-' + translatedPageNo).delay(300).fadeIn();
    currentPage = page;
  }
});
