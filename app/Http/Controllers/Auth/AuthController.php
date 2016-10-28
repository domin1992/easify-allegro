<?php

namespace EasifyAllegro\Http\Controllers\Auth;

use EasifyAllegro\User;
use Validator;
use EasifyAllegro\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Input;
use Hash;
use Mail;
use Auth;
use Redirect;
use DateTime;
use DateInterval;

use EasifyAllegro\Library\Functions;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validatorRegister(array $data){
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);
    }

    protected function validatorLogin(array $data){
      return Validator::make($data, [
          'email' => 'required|email|max:255',
      ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getRegister(){
      if(Auth::User()){
        return Redirect::to('/moje-szablony');
      }
      else{
        $recaptchaPublicKey = getenv('RECAPTCHA_PUBLIC_KEY');
        return view('auth.register', ['recaptchaPublicKey' => $recaptchaPublicKey]);
      }
    }

    public function postRegister(){
      $recaptchaPublicKey = getenv('RECAPTCHA_PUBLIC_KEY');
      $success = false;
      $error = '';
      $input = Input::all();

      $validate = self::validatorRegister(Input::only('email', 'password', 'password_confirmation'));

      if(!$validate->fails()){
        if(Input::has('g-recaptcha-response') && $this->checkRecaptcha($input['g-recaptcha-response'])){
          $pass = Hash::make($input['password']);
  				$user = new User;
  				$user->email = $input['email'];
  				$user->password = $pass;
          $user->activation = Functions::generateRandomString(32);
  				$user->admin = 0;
          $user->premium = 0;
          $user->base_limit_reset = date('Y-m-d H:i:s');
          $now = new DateTime('NOW');
          $appStart = new DateTime(getenv('APP_START'));
          $interval = new DateInterval('P7D');

          if($now < $appStart && (array)$appStart->diff($now) < (array)$interval){
            $user->premium_limit = 10;
          }

  				$user->save();

  				Mail::send('emails.register', ['user' => $user, 'password' => $input['password']], function ($mailMsg) use ($user){
	            $mailMsg->to($user->email)->subject('Nowe konto w Easify Allegro');
	        });

          $success = true;
        }
        else{
          $error = 'Czy na pewno jesteś człowiekiem?';
          $success = false;
        }
      }
      else{
        //TODO: dorobic translacje bledow
        $error = 'Nieprawidłowe dane podane do rejestracji';
        $success = false;
      }
      //TODO: dorobic wysylanie linka aktywacyjnego na maila
      return view('auth.register', ['recaptchaPublicKey' => $recaptchaPublicKey, 'success' => $success, 'error' => $error]);
    }

    public static function checkRecaptcha($recaptchaResponse){
      $url = 'https://www.google.com/recaptcha/api/siteverify';
      $data = array('secret' => getenv('RECAPTCHA_PRIVATE_KEY'),
                    'response' => $recaptchaResponse
                  );

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

    public function getLogin(){
      if(Auth::User()){
        return Redirect::to('/moje-szablony');
      }
      else{
        return view('auth.login');
      }
    }

    public function postLogin(){
      $input = Input::all();

  		$validate = self::validatorLogin(Input::only('email'));

  		if(!$validate->fails()){
        if(Auth::attempt(['email' => $input['email'], 'password' => $input['password']], Input::has('remember'))){
          if(Auth::User()->activated == 1){
            return Redirect::to('/');
          }
  				else{
            Auth::logout();
            $success = false;
            $error = 'Konto nie zostało jeszcze aktywowane. Sprawdź SPAM, a jeżeli tam też nie ma wiadomości z linkiem aktywacyjnym to wyślij potwierdzenie jeszcze raz.';
            $activation = 'error';
            return view('auth.login', ['success' => $success, 'error' => $error, 'activation' => $activation, 'email' => $input['email']]);
          }
  			}
  			else{
          $success = false;
          $error = 'Nieprawidłowe dane logowania';
          return view('auth.login', ['success' => $success, 'error' => $error]);
  			}
  		}
  		else{
        //TODO: dorobic translacje bledow
        $success = false;
        $error = 'Nieprawidłowe dane logowania';
  			return view('auth.login', ['success' => $success, 'error' => $error]);
  		}
    }
}
