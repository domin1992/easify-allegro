<?php
namespace EasifyAllegro\Library;

use Auth;
use EasifyAllegro\Template;

class Functions{
  public static function checkRecaptcha($recaptchaResponse){
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array('secret' => recaptcha_private_key,
                  'response' => $recaptchaResponse
                );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ),
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $resultJson = json_decode($result);

    if($resultJson->success === true){
      return true;
    }
    else{
      return false;
    }
  }

  public static function generateRandomString($length = 10){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  public static function cutCode($content){
    //repleaces whole [img] tag to variable
    /*if(preg_match_all("/<img\s[^>]*?src\s*=\s*['\"]([^'\"]*?)['\"][^>]*?>/", $content, $matches)){
      foreach($matches[1] as $index => $match){
        if(preg_match('/\$\$(.*)\$\$/', $match)){
          $content = str_replace($matches[0][$index], $match, $content);
        }
      }
    }*/

    //remove scripts
    if(preg_match("~<script[^>]*>\K[^<]*(?=</script>)~i", $content)){
      $content = preg_replace('~<script[^>]*>\K[^<]*(?=</script>)~i', '', $content);
    }

    return $content;
  }

  public static function getAdSense($type = 'responsive'){
    if($type == 'responsive'){
      return '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><!-- Responsive --><ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-2180140997733350" data-ad-slot="7738437624" data-ad-format="auto"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';
    }
    elseif($type == 'horizontal'){
      return '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><!-- Horizontal --><ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-2180140997733350" data-ad-slot="4784971229"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';
    }
    elseif($type == 'vertical'){
      return '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><!-- Vertical --><ins class="adsbygoogle" style="display:inline-block;width:300px;height:600px" data-ad-client="ca-pub-2180140997733350" data-ad-slot="6261704428"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';
    }
    elseif($type == 'thin'){
      return '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script><!-- Thin --><ins class="adsbygoogle" style="display:inline-block;width:190px;height:700px" data-ad-client="ca-pub-2180140997733350" data-ad-slot="9215170829"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script>';
    }
  }

  public static function userHasPermissionToDocument($userId, $templateId){
    $template = Template::where('id', $templateId)->first();
    if($template->permission != ''){
      $shared = unserialize($template->permission);
      foreach($shared as $s){
        if($s == $userId){
          return true;
        }
      }
      return false;
    }
    else{
      return false;
    }
  }
}
?>
