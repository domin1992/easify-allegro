<?php

namespace EasifyAllegro\Http\Controllers;

use Illuminate\Http\Request;

use EasifyAllegro\Http\Requests;
use EasifyAllegro\Http\Controllers\Controller;

use Input;
use Mail;
use Auth;
use Redirect;
use DB;
use Hash;
use EasifyAllegro\Template;
use EasifyAllegro\User;
use EasifyAllegro\Document;
use EasifyAllegro\Pricing;
use EasifyAllegro\UserWallet;
use EasifyAllegro\UserOrderDeclaration;

use EasifyAllegro\Library\Uploader;
use EasifyAllegro\Library\Functions;
use EasifyAllegro\Library\HtmlToPdfConverter;
use EasifyAllegro\Library\Limit;

class PanelController extends Controller{
  public function template(){
    if(Auth::User()){
      $templateId = Input::get('id');
      $template = Template::where('id', $templateId)->first();
      if($template->owner == Auth::User()->id){
        $sharedIds = array();
        $sharedEmails = array();
        if($template->permission != ''){
          $sharedIds = unserialize($template->permission);
          foreach($sharedIds as $id){
            array_push($sharedEmails, User::find($id)->email);
          }
        }

        $error = '';
        if(Input::has('err')){
          if(Input::get('err') == 1){
            $error = 'Musisz najpierw określić symbole rozpoczynające i kończące zmienne w szablonie';
          }
        }

        return view('panel.template', ['template' => $template, 'sharedIds' => $sharedIds, 'sharedEmails' => $sharedEmails, 'owner' => true, 'error' => $error]);
      }
      else{
        if($template->permission != ''){
          $shared = unserialize($template->permission);
          foreach($shared as $s){
            if($s == Auth::User()->id){
              $user = User::where('id', $template->owner)->first();
              return view('panel.template', ['template' => $template, 'owner' => false, 'realOwner' => $user->email]);
            }
          }
          return Redirect::to('/moje-szablony');
        }
        else{
          return Redirect::to('/moje-szablony');
        }
      }
    }
    else{
      return Redirect::to('/zaloguj');
    }
  }

  public function myTemplates(){
    if(Auth::User()){
      $limit = new Limit(Auth::User());
      $templates = array();

      $templatesArr = Template::all();
      foreach($templatesArr as $t){
        if($t->owner == Auth::User()->id){
          array_push($templates, $t);
        }
        else{
          if($t->permission != ''){
            $shared = unserialize($t->permission);
            foreach($shared as $s){
              if($s == Auth::User()->id){
                array_push($templates, $t);
              }
            }
          }
        }
      }

      return view('panel.my-templates', ['templates' => $templates, 'limit' => $limit]);
    }
    else{
      return Redirect::to('/zaloguj');
    }
  }

  public function newTemplate(){
    if(Auth::User()){
      return view('panel.new-template');
    }
    else{
      return Redirect::to('/zaloguj');
    }
  }

  public function postNewTemplate(){
    if(Auth::User()){
      $uploader = new Uploader;
      $data = $uploader->upload($_FILES['files'], array(
          'limit' => 1, //Maximum Limit of files. {null, Number}
          'maxSize' => 10, //Maximum Size of files {null, Number(in MB's)}
          'extensions' => array('html', 'htm'), //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
          'required' => true, //Minimum one file is required for upload {Boolean}
          'uploadDir' => 'upload/', //Upload directory {String}
          'title' => array('name'), //New file name {null, String, Array} *please read documentation in README.md
          'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
          'perms' => null, //Uploaded file permisions {null, Number}
          'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
          'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
          'onSuccess' => null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
          'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
          'onComplete' => null, //A callback function name to be called when upload is complete | ($file) | Callback
          'onRemove' => 'onFilesRemoveCallback' //A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
      ));

      if($data['isComplete']){
          $files = $data['data'];
      }

      if($data['hasErrors']){
          $errors = $data['errors'];
          return view('panel.new-template', ['errors' => $errors]);
      }
      else{
        $content = '';
        foreach($files['files'] as $file){
          $content = file_get_contents($file);
        }

        $content = Functions::cutCode($content);

        $hash = '';

        do{
          $hash = Functions::generateRandomString();
          $templateTmp = Template::where('hash', $hash)->first();
          if($templateTmp == null){
            $closeLoop = false;
          }
        }while($closeLoop);

        $template = new Template;
        $template->name = 'Nowy szablon';
        $template->hash = $hash;
        $template->owner = Auth::User()->id;
        $template->content = $content;
        $template->version = '1.0';

        $template->save();

        $converter = new HtmlToPdfConverter;
        $converter->convertFromHtml($content, $template->hash);

        return Redirect::to('/moje-szablony');
      }
    }
    else{
      return Redirect::to('/zaloguj');
    }
  }

  public function myDocuments(){
    if(Auth::User()){
      $limit = new Limit(Auth::User());
      $documents = Document::where('owner', Auth::User()->id)->where('generated', 1)->get();
      $templateNames = array();
      foreach($documents as $key => $document){
        $template = Template::where('id', $document->template)->first();
        if($template != null){
          $templateNames[$key] = $template->name;
        }
        else{
          $templateNames[$key] = 'Bez nazwy';
        }
      }
      return view('panel.my-documents', ['documents' => $documents, 'templateNames' => $templateNames, 'limit' => $limit]);
    }
    else{
      return Redirect::to('/zaloguj');
    }
  }

  public function newDocument(){
    if(Auth::User()){
      $limit = new Limit(Auth::User());
      $templates = array();

      $templatesArr = Template::all();
      foreach($templatesArr as $t){
        if($t->owner == Auth::User()->id){
          array_push($templates, $t);
        }
        else{
          if($t->permission != ''){
            $shared = unserialize($t->permission);
            foreach($shared as $s){
              if($s == Auth::User()->id){
                array_push($templates, $t);
              }
            }
          }
        }
      }

      return view('panel.new-document', ['templates' => $templates, 'limit' => $limit]);
    }
    else{
      return Redirect::to('/zaloguj');
    }
  }

  public function createDocument(){
    if(Auth::User()){
      $template = Template::where('id', Input::get('id'))->first();
      if(intval($template->owner) == Auth::User()->id || Functions::userHasPermissionToDocument(Auth::User()->id, $template->id)){
        if($template->var_start != '' && $template->var_end != ''){
          $varStart = str_split($template->var_start);
          $varStartNew = array();
          foreach($varStart as $v){
            array_push($varStartNew, '\\');
            array_push($varStartNew, $v);
          }
          $varStartNew = implode('', $varStartNew);
          $varEnd = str_split($template->var_end);
          $varEndNew = array();
          foreach($varEnd as $v){
            array_push($varEndNew, '\\');
            array_push($varEndNew, $v);
          }
          $varEndNew = implode('', $varEndNew);
          preg_match_all('/'.$varStartNew.'(.*?)'.$varEndNew.'/', $template->content, $matching);
          return view('panel.create-document', ['template' => $template, 'matching' => $matching]);
        }
        else{
          return Redirect::to('/szablon?id='.$template->id.'&err=1');
        }
      }
      else{
        return Redirect::to('/moje-szablony');
      }
    }
    else{
      return Redirect::to('/zaloguj');
    }
  }

  public function generateDocument(){
    if(Auth::User()){
      $document = Document::where('id', Input::get('id'))->first();
      if($document->owner == Auth::User()->id && $document->generated == 1){
        return view('panel.generate-document', ['document' => $document]);
      }
      else{
        return Redirect::to('/moje-dokumenty');
      }
    }
    else{
      return Redirect::to('/zaloguj');
    }
  }

  public function riseLimit(){
    if(Auth::User()){
      return view('panel.rise-limit');
    }
    else{
      return Redirect::to('/zaloguj');
    }
  }

  public function pay(){
    if(Auth::User()){
      $paymentMethod = Input::get('method');
      $pricing = Pricing::all();
      $userWallet = UserWallet::where('user', Auth::User()->id)->first();

      return view('panel.pay', ['method' => $paymentMethod, 'pricing' => $pricing, 'userWallet' => $userWallet, 'realization' => Input::get('realization')]);
    }
    else{
      return Redirect::to('/zaloguj');
    }
  }

  public function accountSettings(){
    if(Auth::User()){
      $user = User::where('id', Auth::User()->id)->first();
      return view('panel.settings', ['user' => $user]);
    }
    else{
      return Redirect::to('/zaloguj');
    }
  }

  public function postRemoveTemplate(){
    if(Auth::User()){
      if(Input::has('template_id')){
        $template = Template::where('id', Input::get('template_id'))->first();
        if($template != null){
          if($template->owner == Auth::User()->id){
            $template->forceDelete();
            return Redirect::to('/moje-szablony');
          }
          else{
            return Redirect::to('/');
          }
        }
        else{
          return Redirect::to('/moje-szablony');
        }
      }
      else{
        return Redirect::to('/');
      }
    }
    else{
      return Redirect::to('/');
    }
  }

  public function postRemoveDocument(){
    if(Auth::User()){
      if(Input::has('document_id')){
        $document = Document::where('id', Input::get('document_id'))->first();
        if($document != null){
          if($document->owner == Auth::User()->id){
            $document->forceDelete();
            return Redirect::to('/moje-dokumenty');
          }
          else{
            return Redirect::to('/');
          }
        }
        else{
          return Redirect::to('/moje-dokumenty');
        }
      }
      else{
        return Redirect::to('/');
      }
    }
    else{
      return Redirect::to('/');
    }
  }

  public function postUpdateTemplate(){
    if(Auth::User()){
      if(Input::has('template')){
        $template = Template::where('id', Input::get('template'))->first();
        if($template->owner == Auth::User()->id){
          $uploader = new Uploader;
          $data = $uploader->upload($_FILES['files'], array(
              'limit' => 1, //Maximum Limit of files. {null, Number}
              'maxSize' => 10, //Maximum Size of files {null, Number(in MB's)}
              'extensions' => array('html', 'htm'), //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
              'required' => true, //Minimum one file is required for upload {Boolean}
              'uploadDir' => 'upload/', //Upload directory {String}
              'title' => array('name'), //New file name {null, String, Array} *please read documentation in README.md
              'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
              'perms' => null, //Uploaded file permisions {null, Number}
              'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
              'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
              'onSuccess' => null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
              'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
              'onComplete' => null, //A callback function name to be called when upload is complete | ($file) | Callback
              'onRemove' => 'onFilesRemoveCallback' //A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
          ));

          if($data['isComplete']){
              $files = $data['data'];
          }

          if($data['hasErrors']){
              $errors = $data['errors'];
              return Redirect::to('/szablon?id='.Input::get('template').'&updateerror='.$errors[0][0]);
          }
          else{
            $content = '';
            foreach($files['files'] as $file){
              $content = file_get_contents($file);
            }

            $content = Functions::cutCode($content);

            $template->content = $content;

            $template->save();

            $converter = new HtmlToPdfConverter;
            $converter->convertFromHtml($content, $template->hash);
            return Redirect::to('/szablon?id='.Input::get('template'));
          }
        }
        else{
          return Redirect::to('/moje-szablony');
        }
      }
      else{
        return Redirect::to('/moje-szablony');
      }
    }
    else{
      return Redirect::to('/');
    }
  }

  public function postChangePassword(){
    if(Auth::User() && Input::has('old_password') && Input::has('password') && Input::has('password_confirmation')){
      $user = User::where('id', Auth::User()->id)->first();
      if($user != null){
        if(Input::get('password') === Input::get('password_confirmation')){
          if(strlen(Input::get('password')) > 8){
            if(Hash::check(Input::get('old_password'), $user->password)){
              $user->password = Hash::make(Input::get('password'));
              $user->save();

              Auth::logout();
              Auth::attempt(['email' => $user->email, 'password' => $user->password]);

              return view('auth.login', ['newPasswordSet' => true]);
            }
            else{
              return view('panel.settings', ['error' => 'Aktualne hasło jest niepoprawne']);
            }
          }
          else{
            return view('panel.settings', ['error' => 'Nowe hasło musi zawierać co najmniej 8 znaków']);
          }
        }
        else{
          return view('panel.settings', ['error' => 'Potwierdź nowe hasło musi być taki sam jak nowe hasło']);
        }
      }
      else{
        return view('panel.settings', ['error' => 'Wystąpił błąd wewnętrzny']);
      }
    }
    else{
      return view('panel.settings', ['error' => 'Wystąpił błąd wewnętrzny']);
    }
  }

  //REST
  public function restSetTemplate(){
    $input = Input::all();

    $response = array();

    if(Auth::User()){
      $template = Template::where('id', $input['template_id'])->first();
      if($template != null){
        if(Auth::User()->id == $template->owner){
          $response['success'] = 1;
          if($input['name'] != ''){
            $template->name = $input['name'];
          }
          if($input['content'] != ''){
            $template->content = $input['content'];
          }
          if($input['version'] != ''){
            $template->version = $input['version'];
          }
          if($input['var_start'] != ''){
            if(preg_match('/[a-z]|[A-Z]/', $input['var_start']) || preg_match('/[0-9]/', $input['var_start'])){
              $response['error'] = 'Symbole rozpoczynające zmienne w szablonie nie mogą zawierać liczb, ani cyfr, sugerujemy użyć <strong>$$</strong>';
              $response['success'] = 0;
            }
            else{
              $template->var_start = $input['var_start'];
            }
          }
          if($input['var_end'] != ''){
            if(preg_match('/[a-z]|[A-Z]/', $input['var_end']) || preg_match('/[0-9]/', $input['var_end'])){
              $response['error'] = 'Symbole kończące zmienne w szablonie nie mogą zawierać liczb, ani cyfr, sugerujemy użyć <strong>$$</strong>';
              $response['success'] = 0;
            }
            else{
              $template->var_end = $input['var_end'];
            }
          }

          $template->save();

          echo json_encode($response);
        }
        else{
          $response['success'] = 0;
          $response['error'] = 'Nie masz uprawnien do wykonania tej operacji';
          echo json_encode($response);
        }
      }
      else{
        $response['success'] = 0;
        $response['error'] = 'Taki szablon nie istnieje';
        echo json_encode($response);
      }
    }
    else{
      $response['success'] = 0;
      $response['error'] = 'Nie masz uprawnien do wykonania tej operacji';
      echo json_encode($response);
    }
  }

  public function restAddShare(){
    $input = Input::all();

    $response = array();

    if(Auth::User() && Input::has('email') && Input::has('template_id')){
      if(Input::has('email') && Auth::User()->email != $input['email']){
        $template = Template::where('id', $input['template_id'])->first();
        if($template != null){
          if(Auth::User()->id == $template->owner){
            $sharing = $template->permission;
            $user = User::where('email', $input['email'])->first();
            if($user != null){
              $receiverId = $user->id;

              if($sharing != ''){
                $sharingDecoded = unserialize($sharing);
                if(!in_array(intval($receiverId), $sharingDecoded)){
                  array_push($sharingDecoded, intval($receiverId));
                  $sharing = serialize($sharingDecoded);
                  $template->permission = $sharing;
                  $template->save();

                  $response['user_id'] = $receiverId;
                  $response['success'] = 1;
                  echo json_encode($response);
                }
                else{
                  $response['success'] = 0;
                  $response['error'] = 'Podany adres e-mail już istnieje na liscie tego szablonu';
                  echo json_encode($response);
                }
              }
              else{
                $sharingDecoded = array();
                array_push($sharingDecoded, intval($receiverId));
                $sharing = serialize($sharingDecoded);
                $template->permission = $sharing;
                $template->save();

                $response['success'] = 1;
                echo json_encode($response);
              }
            }
            else{
              $response['success'] = 0;
              $response['error'] = 'Podany użytkownik nie posiada konta w naszym serwisie';
              echo json_encode($response);
            }
          }
          else{
            $response['success'] = 0;
            $response['error'] = 'Nie masz uprawnień do wykonania tej operacji';
            echo json_encode($response);
          }
        }
        else{
          $response['success'] = 0;
          $response['error'] = 'Nie ma takiego szablonu';
          echo json_encode($response);
        }
      }
      else{
        $response['success'] = 0;
        $response['error'] = 'Nie możesz dodać swojego adresu e-mail';
        echo json_encode($response);
      }
    }
    else{
      $response['success'] = 0;
      $response['error'] = 'Brak wymaganych danych';
      echo json_encode($response);
    }
  }

  public function restDelShare(){
    $input = Input::all();

    $response = array();

    if(Auth::User() && Input::has('template_id') && Input::has('user_id')){
      $template = Template::where('id', $input['template_id'])->first();
      if($template != null){
        if(Auth::User()->id == $template->owner){
          $sharing = $template->permission;
          if($sharing != ''){
            $sharingDecoded = unserialize($sharing);
            if(in_array(intval($input['user_id']), $sharingDecoded)){
              $keyToDelete = array_search($input['user_id'], $sharingDecoded);
              unset($sharingDecoded[$keyToDelete]);
              $sharingDecoded = array_values($sharingDecoded);
              $sharing = serialize($sharingDecoded);
              $template->permission = $sharing;
              $template->save();

              $response['success'] = 1;
              echo json_encode($response);
            }
            else{
              $response['success'] = 0;
              $response['error'] = 'Podany użytkownik nie był dopisany do szablonu';
              echo json_encode($response);
            }
          }
          else{
            $response['success'] = 0;
            $response['error'] = 'Nie ma nic do usunięcia';
            echo json_encode($response);
          }
        }
        else{
          $response['success'] = 0;
          $response['error'] = 'Nie masz uprawnien do wykonania tej operacji';
          echo json_encode($response);
        }
      }
      else{
        $response['success'] = 0;
        $response['error'] = 'Nie ma takiego szablonu';
        echo json_encode($response);
      }
    }
    else{
      $response['success'] = 0;
      $response['error'] = 'Brak wymaganych danych';
      echo json_encode($response);
    }
  }

  public function restGenerateDocument(){
    $input = Input::all();

    $response = array();

    if(Auth::User() && Input::has('document_id')){
      $document = Document::where('id', $input['document_id'])->first();
      if($document != null){
        if(Auth::User()->id == $document->owner){
          $document->generated = 1;

          $user = User::where('id', Auth::User()->id)->first();
          if($user != null){
            if(intval($user->premium) == 1){
              $document->save();
              $response['success'] = 1;
              echo json_encode($response);
            }
            elseif(intval($user->base_limit_used) < intval(getenv('BASE_LIMIT'))){
              $user->base_limit_used += 1;
              $user->save();
              $document->save();

              $response['success'] = 1;
              echo json_encode($response);
            }
            elseif(intval($user->premium_limit) > 0 && intval($user->premium_limit_used) < intval($user->premium_limit)){
              $user->premium_limit_used += 1;
              if($user->premium_limit_used == $user->premium_limit){
                $user->premium_limit_finished = date('Y-m-d H:i:s');
              }
              $user->save();
              $document->save();

              $response['success'] = 1;
              echo json_encode($response);
            }
            else{
              $response['success'] = 0;
              $response['error'] = 'Nie możesz utworzyć więcej dokumentów, zwiększ limit';
              echo json_encode($response);
            }
          }
          else{
            $response['success'] = 0;
            $response['error'] = 'Coś poszło nie tak';
            echo json_encode($response);
          }
        }
        else{
          $response['success'] = 0;
          $response['error'] = 'Nie posiadasz uprawnień do wykonania tej operacji';
          echo json_encode($response);
        }
      }
      else{
        $response['success'] = 0;
        $response['error'] = 'Nie ma takiego dokumentu';
        echo json_encode($response);
      }
    }
    else{
      $response['success'] = 0;
      $response['error'] = 'Brak wymaganych danych';
      echo json_encode($response);
    }
  }

  public function restAddDocument(){
    $input = Input::all();

    $response = array();

    if(Auth::User() && Input::has('template_id') && Input::has('document_name') && Input::has('data')){
      $template = Template::where('id', $input['template_id'])->first();
      if($template != null){
        if(Auth::User()->id == $template->owner || Functions::userHasPermissionToDocument(Auth::User()->id, $template->id)){
          $gotData = json_decode($input['data']);
          $newContent = $template->content;
          foreach($gotData->data as $data){
            $newContent = str_replace($template->var_start.$data->name.$template->var_end, $data->value, $newContent);
          }

          $hash = '';
          do{
            $hash = Functions::generateRandomString();
            $templateTmp = Template::where('hash', $hash)->first();
            if($templateTmp == null){
              $closeLoop = false;
            }
          }while($closeLoop);

          $document = new Document;
          $document->owner = Auth::User()->id;
          $document->name = $input['document_name'];
          $document->hash = $hash;
          $document->content = $newContent;
          $document->template = $template->id;

          $document->save();

          $converter = new HtmlToPdfConverter;
          $converter->convertFromHtml($newContent, $document->hash);

          $response['success'] = 1;
          $response['document_id'] = $document->id;
          $response['document_hash'] = $document->hash;
          echo json_encode($response);
        }
        else{
          $response['success'] = 0;
          $response['error'] = 'Nie masz uprawnień do wykonania tej operacji';
          echo json_encode($response);
        }
      }
      else{
        $response['success'] = 0;
        $response['error'] = 'Nie ma takiego szablonu';
        echo json_encode($response);
      }
    }
    else{
      $response['success'] = 0;
      $response['error'] = 'Brak wymaganych danych';
      echo json_encode($response);
    }
  }

  public function restSetDocument(){
    $input = Input::all();

    $response = array();

    if(Auth::User() && Input::has('document_id') && Input::has('data')){
      $document = Document::where('id', $input['document_id'])->first();
      if($document != null){
        if($document->owner == Auth::User()->id){
          $template = Template::where('id', $document->template)->first();
          if($template != null){
            if($template->owner == Auth::User()->id || Functions::userHasPermissionToDocument(Auth::User()->id, $template->id)){
              $gotData = json_decode($input['data']);
              $newContent = $template->content;
              foreach($gotData->data as $data){
                $newContent = str_replace($template->var_start.$data->name.$template->var_end, $data->value, $newContent);
              }

              $document->content = $newContent;
              $document->save();

              $converter = new HtmlToPdfConverter;
              $converter->convertFromHtml($newContent, $document->hash);

              $response['success'] = 1;
              echo json_encode($response);
            }
            else{
              $response['success'] = 0;
              $response['error'] = 'Nie masz uprawnień do wykonania tej operacji';
              echo json_encode($response);
            }
          }
          else{
            $response['success'] = 0;
            $response['error'] = 'Nie ma takiego szablonu';
            echo json_encode($response);
          }
        }
        else{
          $response['success'] = 0;
          $response['error'] = 'Nie masz uprawnień do wykonania tej operacji';
          echo json_encode($response);
        }
      }
      else{
        $response['success'] = 0;
        $response['error'] = 'Nie ma takiego dokumentu';
        echo json_encode($response);
      }
    }
    else{
      $response['success'] = 0;
      $response['error'] = 'Brak wymaganych danych';
      echo json_encode($response);
    }
  }

  public function restGetCurrentBitcoin(){
    echo file_get_contents('https://www.bitmarket.pl/json/BTCPLN/ticker.json');
  }

  public function restGetCurrentPrice(){
    if(Auth::User()){
      $response = array();
      $pricing = Pricing::where('id', Input::get('package'))->first();
      if($pricing != null){
        $response['success'] = 1;
        $response['price'] = $pricing->price;
        $response['currency'] = $pricing->currency;
        echo json_encode($response);
      }
      else{
        $response['success'] = 0;
        $response['error'] = 'Taki pakiet nie istnieje';
        echo json_encode($response);
      }
    }
  }

  public function restSetBitcoinAddress(){
    if(Auth::User()){
      $response = array();
      $userWallet = UserWallet::where('user', Auth::User()->id)->first();
      if($userWallet != null){
        $userWallet->bitcoin = Input::get('address');
        $userWallet->save();

        $response['success'] = 1;
        echo json_encode($response);
      }
      else{
        $userWallet = new UserWallet;
        $userWallet->user = Auth::User()->id;
        $userWallet->bitcoin = Input::get('address');
        $userWallet->save();

        $response['success'] = 1;
        echo json_encode($response);
      }
    }
  }

  public function restIsBitcoinAddress(){
    if(Auth::User()){
      $response = array();
      $userWallet = UserWallet::where('user', Auth::User()->id)->first();
      if($userWallet != null){
        if($userWallet->bitcoin != ''){
          $response['success'] = 1;
          $response['exists'] = 1;
          echo json_encode($response);
        }
        else{
          $response['success'] = 1;
          $response['exists'] = 0;
          echo json_encode($response);
        }
      }
      else{
        $response['success'] = 1;
        $response['exists'] = 0;
        echo json_encode($response);
      }
    }
  }

  public function restSetPayPalAddress(){
    if(Auth::User()){
      $response = array();
      $userWallet = UserWallet::where('user', Auth::User()->id)->first();
      if($userWallet != null){
        $userWallet->paypal = Input::get('address');
        $userWallet->save();

        $response['success'] = 1;
        echo json_encode($response);
      }
      else{
        $userWallet = new UserWallet;
        $userWallet->user = Auth::User()->id;
        $userWallet->paypal = Input::get('address');
        $userWallet->save();

        $response['success'] = 1;
        echo json_encode($response);
      }
    }
  }

  public function restIsPayPalAddress(){
    if(Auth::User()){
      $response = array();
      $userWallet = UserWallet::where('user', Auth::User()->id)->first();
      if($userWallet != null){
        if($userWallet->paypal != ''){
          $response['success'] = 1;
          $response['exists'] = 1;
          echo json_encode($response);
        }
        else{
          $response['success'] = 1;
          $response['exists'] = 0;
          echo json_encode($response);
        }
      }
      else{
        $response['success'] = 1;
        $response['exists'] = 0;
        echo json_encode($response);
      }
    }
  }

  public function restDeclarePayment(){
    if(Auth::User() && Input::has('method') && Input::has('package')){
      $declaration = new UserOrderDeclaration;
      $declaration->method = Input::get('method');
      $declaration->user = Auth::User()->id;
      if(Input::get('method') == 'bitcoin'){
        $declaration->package = Input::get('package');
      }
      elseif(Input::get('method') == 'paypal'){
        $pricing = Pricing::where('package_without_accented', Input::get('package'))->first();
        if($pricing != null){
          $declaration->package = $pricing->id;
        }
      }
      if(Input::get('method') == 'bitcoin' && Input::has('price')){
        $declaration->price = Input::get('price');
      }
      elseif(Input::get('method') == 'paypal'){
        $pricing = Pricing::where('package_without_accented', Input::get('package'))->first();
        if($pricing != null){
          $declaration->price = $pricing->price;
        }
      }
      $declaration->save();
    }
  }

  public function restDeleteUser(){
    if(Auth::User() && Input::has('pass')){
      $user = User::where('id', Auth::User()->id)->first();
      if($user != null){
        if(Hash::check(Input::get('pass'), $user->password)){

          $documents = Document::where('owner', Auth::User()->id)->get();
          if($documents != null){
            foreach($documents as $document){
              rename(getenv('ROOT_DIR')."public/visualization/".$document->hash.'.pdf', getenv('ROOT_DIR')."public/visualization/_deleted_".$document->hash.'.pdf');
              $document->forceDelete();
            }
          }

          $templates = Template::where('owner', Auth::User()->id)->get();
          if($templates != null){
            foreach($templates as $template){
              rename(getenv('ROOT_DIR')."public/visualization/".$template->hash.'.pdf', getenv('ROOT_DIR')."public/visualization/_deleted_".$template->hash.'.pdf');
              $template->forceDelete();
            }
          }

          $templatesAll = Template::all();
          if($templatesAll != null){
            foreach($templatesAll as $template){
              $sharing = $template->permission;
              if($sharing != ''){
                $sharingDecoded = unserialize($sharing);
                if(in_array(intval(Auth::User()->id), $sharingDecoded)){
                  $keyToDelete = array_search(Auth::User()->id, $sharingDecoded);
                  unset($sharingDecoded[$keyToDelete]);
                  $sharingDecoded = array_values($sharingDecoded);
                  $sharing = serialize($sharingDecoded);
                  $template->permission = $sharing;
                  $template->save();
                }
              }
            }
          }

          $userWallet = UserWallet::where('user', Auth::User()->id)->first();
          if($userWallet != null){
            $userWallet->forceDelete();
          }

          $user->forceDelete();

          $response['success'] = 1;
          echo json_encode($response);
        }
        else{
          $response['success'] = 0;
          $response['error'] = 'Błędne hasło';
          echo json_encode($response);
        }
      }
      else{
        $response['success'] = 0;
        $response['error'] = 'Wystąpił błąd, spróbuj ponownie później';
        echo json_encode($response);
      }
    }
    else{
      $response['success'] = 0;
      $response['error'] = 'Wystąpił błąd, spróbuj ponownie później';
      echo json_encode($response);
    }
  }
}
