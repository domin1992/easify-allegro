<?php

namespace EasifyAllegro\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use EasifyAllegro\Http\Requests;
use EasifyAllegro\Http\Controllers\Controller;

use Input;
use Mail;
use Redirect;
use DB;

use EasifyAllegro\User;
use EasifyAllegro\Blog;

use EasifyAllegro\Library\Functions;

class FrontController extends Controller{
  public function index(){
    $blogs = DB::table('blog')->orderBy('created_at', 'desc')->take(2)->get();
    return view('front.index', ['blogs' => $blogs, 'adsense' => Functions::getAdSense('horizontal')]);
  }

  public function blog(){
    $blogs = Blog::all();
    $blogs = $blogs->sortByDesc('created_at');
    return view('front.blog', ['blogs' => $blogs, 'adsense' => Functions::getAdSense('vertical')]);
  }

  public function blogSingle($index){
    $blog = Blog::where('id', $index)->first();
    return view('front.single', ['blog' => $blog, 'adsense' => Functions::getAdSense('horizontal')]);
  }

  public function howWorks(){
    return view('front.how-works');
  }

  public function getContact(){
    $recaptchaPublicKey = getenv('RECAPTCHA_PUBLIC_KEY');
    return view('front.contact', ['recaptchaPublicKey' => $recaptchaPublicKey]);
  }

  public function postContact(){
    $recaptchaPublicKey = getenv('RECAPTCHA_PUBLIC_KEY');
    $success = false;
    $error = '';
    $input = Input::all();
    if(Input::has('name') && $input['name'] != ''){
      if(Input::has('email') && $input['email'] != ''){
        if(Input::has('email') && filter_var($input['email'], FILTER_VALIDATE_EMAIL)){
          if(Input::has('content') && $input['content'] != ''){
            if(Input::has('g-recaptcha-response') && $this->checkRecaptcha($input['g-recaptcha-response'])){
              $name = $input['name'];
              $email = $input['email'];
              $content = $input['content'];
              $data = array('name' => $name, 'email' => $email, 'content' => $content);
              Mail::send('emails.contact', $data, function($message) use($name, $email, $content){
                  $message->to(getenv('EMAIL_ADDRESS_SUPPORT'), 'Dominik Nowak')->subject('Wiadomość z serwisu Easify Allegro');
              });
              $success = true;
            }
            else{
              $success = false;
              $error = 'Czy na pewno jesteś człowiekiem?';
            }
          }
          else{
            $success = false;
            $error = 'Musisz wpisać treść swojej wiadomości';
          }
        }
        else{
          $success = false;
          $error = 'Nieprawidłowy format adresu e-mail';
        }
      }
      else{
        $success = false;
        $error = 'Musisz wpisać swój adres e-mail';
      }
    }
    else{
      $success = false;
      $error = 'Musisz wpisać swoje imię i nazwisko';
    }
    return view('front.contact', ['recaptchaPublicKey' => $recaptchaPublicKey, 'success' => $success, 'error' => $error, 'input' => $input]);
  }

  public static function checkRecaptcha($recaptchaResponse){
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array('secret' => getenv('RECAPTCHA_PRIVATE_KEY'),
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

  public function phpInfo(){
    if(getenv('APP_ENV') == 'local' || getenv('APP_ENV') == 'dev'){
      echo phpinfo();
    }
    else{
      Redirect::to('/');
    }
  }

  public function privacyPolicy(){
    return view('front.privacy-policy');
  }

  public function activateUser(){
    if(Input::has('activate')){
      $user = User::where('activation', Input::get('activate'))->first();
      if($user != null){
        $user->activated = 1;
        $user->save();

        return view('auth.activate', ['activated' => true]);
      }
      else{
        return Redirect::to('/');
      }
    }
    else{
      return Redirect::to('/');
    }
  }

  public function sendActivationalLink(){
    if(Input::has('email')){
      $user = User::where('email', Input::get('email'))->first();
      if($user != null){
        Mail::send('emails.register', ['user' => $user], function ($mailMsg) use ($user){
            $mailMsg->to($user->email)->subject('Aktywuj konto w Easify Allegro');
        });
        return view('auth.login', ['activation_sent' => true]);
      }
      else{
        return Redirect::to('/rejestracja');
      }
    }
    else{
      return Redirect::to('/');
    }
  }
}
