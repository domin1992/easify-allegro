<?php

namespace EasifyAllegro\Library;

class HtmlToPdfConverter{
  private $url = 'http://freehtmltopdf.com';
  private $baseUrl = '';
  private $pathToHtmlFiles = '';

  function __construct(){
    $this->baseUrl = getenv('APP_URL');
    $this->pathToHtmlFiles = getenv('UPLOAD_PATH');
  }

  public function convertFromFile($htmlFilename, $pdfFilename){
  	$data = array(  'convert' => '',
  			'html' => $this->validate(file_get_contents($this->pathToHtmlFiles.$htmlFilename)),
  			'baseurl' => $this->baseUrl);

  	$options = array(
  		'http' => array(
  			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
  			'method'  => 'POST',
  			'content' => http_build_query($data),
  		),
  	);

  	$context  = stream_context_create($options);
    $result = file_get_contents($this->url, false, $context);
    file_put_contents(getenv('ROOT_DIR')."public/visualization/".$pdfFilename, $result);

    return true;
  }

  public function convertFromHtml($content, $pdfFilename){
    $data = array(  'convert' => '',
  			'html' => $this->validate($content),
  			'baseurl' => $this->baseUrl);

  	$options = array(
  		'http' => array(
  			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
  			'method'  => 'POST',
  			'content' => http_build_query($data),
  		),
  	);

  	$context  = stream_context_create($options);
    $result = file_get_contents($this->url, false, $context);
    file_put_contents(getenv('ROOT_DIR')."public/visualization/".$pdfFilename.".pdf", $result);

    return true;
  }

  public function validate($content){
    if(!preg_match('/<body>/', $content) && !preg_match('/<\/body>/', $content) && !preg_match('/<head>/', $content) && !preg_match('/<\/head>/', $content) && !preg_match('/<html>/', $content) && !preg_match('/<\/html>/', $content)){
      $content = '<html><head><title>Untitled</title><meta charset="UTF-8"></head><body>'.$content.'</html>';
      return $content;
    }
    else{
      return $content;
    }
  }
}


?>
