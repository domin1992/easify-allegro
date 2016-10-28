<?php

namespace EasifyAllegro\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Redirect;
use Input;
use Mail;
use DateTime;
use DateInterval;

use EasifyAllegro\Blog;
use EasifyAllegro\User;
use EasifyAllegro\UserOrderDeclaration;
use EasifyAllegro\Pricing;

use EasifyAllegro\Http\Requests;
use EasifyAllegro\Http\Controllers\Controller;

use EasifyAllegro\Library\ActivatePackage;

class AdminController extends Controller{
  public function index(){
    if(Auth::User()){
      if(Auth::User()->admin == 1){
        return view('admin.index');
      }
      else{
        return Redirect::to('/moje-szablony');
      }
    }
    else{
      return Redirect::to('/');
    }
  }

  public function blogList(){
    if(Auth::User()){
      if(Auth::User()->admin == 1){
        $blogs = Blog::all();
        $blogs = $blogs->sortByDesc('created_at');
        return view('admin.blog-list', ['blogs' => $blogs]);
      }
      else{
        return Redirect::to('/moje-szablony');
      }
    }
    else{
      return Redirect::to('/');
    }
  }

  public function blog($id = null){
    if(Auth::User()){
      if(Auth::User()->admin == 1){
        if($id != null){
          $blog = Blog::where('id', $id)->first();
          if($blog != null){
            return view('admin.blog', ['blog' => $blog]);
          }
          else{
            return view('admin.blog');
          }
        }
        else{
          return view('admin.blog');
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

  public function postBlog(){
    if(Auth::User()){
      if(Auth::User()->admin == 1){
        if(Input::has('title') && Input::has('content')){
          if(Input::has('blog_id')){
            $blog = Blog::where('id', Input::get('blog_id'))->first();
            $blog->author = 'Admin';
            $blog->title = Input::get('title');
            $blog->text = Input::get('content');
            if(Input::has('priority')){
              $blog->priority = Input::get('priority');
            }
            else{
              $blog->priority = 0;
            }
            $blog->save();
          }
          else{
            $blog = new Blog;
            $blog->author = 'Admin';
            $blog->title = Input::get('title');
            $blog->text = Input::get('content');
            if(Input::has('priority')){
              $blog->priority = Input::get('priority');
            }
            else{
              $blog->priority = 0;
            }
            $blog->save();
          }
          return view('admin.blog', ['blog' => $blog]);
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

  public function deleteBlog($id){
    if(Auth::User()){
      if(Auth::User()->admin == 1){
        $blog = Blog::where('id', $id)->first();
        if($blog != null){
          $blog->forceDelete();
        }
        $blogs = Blog::all();
        $blogs = $blogs->sortByDesc('created_at');
        return view('admin.blog-list', ['blogs' => $blogs]);
      }
      else{
        return Redirect::to('/moje-szablony');
      }
    }
    else{
      return Redirect::to('/');
    }
  }

  public function stats(){
    if(Auth::User()){
      if(Auth::User()->admin == 1){
        return view('admin.stats');
      }
      else{
        return Redirect::to('/moje-szablony');
      }
    }
    else{
      return Redirect::to('/');
    }
  }

  public function users(){
    if(Auth::User()){
      if(Auth::User()->admin == 1){
        $users = User::all();
        return view('admin.users', ['users' => $users]);
      }
      else{
        return Redirect::to('/moje-szablony');
      }
    }
    else{
      return Redirect::to('/');
    }
  }

  public function activatePackage(){
    if(Auth::User()){
      if(Auth::User()->admin == 1){
        $error = '';
        if(Input::has('err')){
          switch(Input::get('err')){
            case '1':
              $error = 'Taki pakiet nie istnieje';
              break;
            case '2':
              $error = 'Taki użytkownik nie istnieje';
              break;
            case '3':
              $error = 'Taka deklaracja nie istnieje';
              break;
            case '4':
              $error = 'Błąd id';
              break;
          }
        }
        $declarations = UserOrderDeclaration::all();
        $activatePackages = array();
        foreach($declarations as $d){
          $activatePackage = new ActivatePackage($d);
          array_push($activatePackages, $activatePackage);
        }
        return view('admin.activate-package', ['declarations' => $activatePackages, 'error' => $error]);
      }
      else{
        return Redirect::to('/moje-szablony');
      }
    }
    else{
      return Redirect::to('/');
    }
  }

  public function doActivatePackage($id){
    if(Auth::User()){
      if(Auth::User()->admin == 1){
        if($id != null){
          $declaration = UserOrderDeclaration::where('id', $id)->first();
          if($declaration != null){
            $user = User::where('id', $declaration->user)->first();
            if($user != null){
              $package = Pricing::where('id', $declaration->package)->first();
              if($package != null){
                if($user->premium_limit_used >= $user->premium_limit && $user->premium_limit != 0){
                  $user->premium_limit_used = 0;
                  $user->premium_limit = 0;
                  if($package->count == 0){
                    $user->premium = 1;
                    $premiumUntil = new DateTime('NOW');
                    $interval = new DateInterval('P30D');
                    $user->premium_until = $premiumUntil->add($interval);
                    $user->save();
                    $declaration->confirmation = 1;
                    $declaration->save();

                    return Redirect::to('/ea-admin/aktywuj-pakiet');
                  }
                  else{
                    $user->premium_limit = $package->count;
                    $user->save();
                    $declaration->confirmation = 1;
                    $declaration->save();

                    return Redirect::to('/ea-admin/aktywuj-pakiet');
                  }
                }
                else{
                  if($package->count == 0){
                    $user->premium = 1;
                    $premiumUntil = new DateTime('NOW');
                    $interval = new DateInterval('P30D');
                    $user->premium_until = $premiumUntil->add($interval);
                    $user->save();
                    $declaration->confirmation = 1;
                    $declaration->save();

                    return Redirect::to('/ea-admin/aktywuj-pakiet');
                  }
                  else{
                    $user->premium_limit += $package->count;
                    $user->save();
                    $declaration->confirmation = 1;
                    $declaration->save();

                    return Redirect::to('/ea-admin/aktywuj-pakiet');
                  }
                }
              }
              else{
                return Redirect::to('/ea-admin/aktywuj-pakiet?err=1');
              }
            }
            else{
              return Redirect::to('/ea-admin/aktywuj-pakiet?err=2');
            }
          }
          else{
            return Redirect::to('/ea-admin/aktywuj-pakiet?err=3');
          }
        }
        else{
          return Redirect::to('/ea-admin/aktywuj-pakiet?err=4');
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

  public function settings(){
    if(Auth::User()){
      if(Auth::User()->admin == 1){
        return view('admin.settings');
      }
      else{
        return Redirect::to('/moje-szablony');
      }
    }
    else{
      return Redirect::to('/');
    }
  }

  public function mails(){
    if(Auth::User()){
      if(Auth::User()->admin == 1){
        if(Input::has('error')){
          return view('admin.mails', ['error' => 'Nieprawidłowy post']);
        }
        else{
          return view('admin.mails');
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

  public function postMails(){
    if(Auth::User()){
      if(Auth::User()->admin == 1){
        if(Input::has('email')){
          Mail::send('emails.test', [], function ($mailMsg){
              $mailMsg->to(Input::get('email'))->subject('Testowa wiadomość');
          });
          return Redirect::to('/ea-admin/poczta');
        }
        else{
          return Redirect::to('/ea-admin/poczta')->with('error', 'true');
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
}
