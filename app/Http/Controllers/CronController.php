<?php

namespace EasifyAllegro\Http\Controllers;

use Illuminate\Http\Request;

use DateTime;
use DateInterval;

use EasifyAllegro\User;

use EasifyAllegro\Http\Requests;
use EasifyAllegro\Http\Controllers\Controller;

class CronController extends Controller{
    public function main(){
      $response = array();
      $users = User::all();
      foreach($users as $user){
        $now = new DateTime('NOW');
        if($user->premium_until != NULL){
          $premiumUntil = new DateTime($user->premium_until);
          if($premiumUntil < $now && $user->premium != 0){
            $user->premium = 0;
          }
        }

        if($user->premium_limit != 0 && $user->premium_limit_used >= $user->premium_limit){
          $premiumFinished = new DateTime($user->premium_limit_finished);
          $premiumFinishedDiff = $premiumFinished->diff($now);
          $premiumInterval = new DateInterval('P7D');
          if($premiumFinished < $now && (array)$premiumFinishedDiff > (array)$premiumInterval){
            $user->premium_limit = 0;
            $user->premium_limit_used = 0;
          }
        }

        $userCreated = new DateTime($user->created_at);
        $userCreatedDiff = $userCreated->diff($now);
        $baseLimitReset = new DateTime($user->base_limit_reset);
        $baseLimitResetDiff = $baseLimitReset->diff($now);
        $baseLimitResetInterval = new DateInterval('P29D');

        if($userCreatedDiff->days % 30 == 0 && $user->base_limit_used != 0 && (array)$baseLimitResetDiff >= (array)$baseLimitResetInterval){
          $user->base_limit_reset = date('Y-m-d H:i:s');
          $user->base_limit_used = 0;
        }

        $user->save();
      }

      $response['success'] = 1;
      echo json_encode($response);
    }
}
