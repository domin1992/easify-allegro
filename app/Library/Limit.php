<?php

namespace EasifyAllegro\Library;

use DateTime;
use DateInterval;

use EasifyAllegro\User;

class Limit{
  public $base_limit;
  public $base_limit_used;
  public $base_limit_used_percent;
  public $premium_limit;
  public $premium_limit_used;
  public $premium_limit_used_percent;
  public $premium_limit_finished;
  public $premium;
  public $premium_until;
  public $display_premium;

  function __construct($user){
    $this->base_limit = getenv('BASE_LIMIT');
    if($user != null){
      $this->base_limit_used = $user->base_limit_used;
      $this->premium_limit = $user->premium_limit;
      $this->premium_limit_used = $user->premium_limit_used;
      $this->premium_limit_finished = new DateTime($user->premium_limit_finished);
      $this->premium = $user->premium;
      if($this->premium == 1){
        $this->premium_until = new DateTime($user->premium_until);
      }

      $this->base_limit_used_percent = (intval($this->base_limit_used) / intval($this->base_limit)) * 100;

      if(intval($this->premium_limit) > 0){
        if($this->premium_limit_used >= $this->premium_limit){
          if((array)$this->premium_limit_finished->diff(new DateTime('now')) < (array)new DateInterval('P7D')){
            $this->display_premium = true;
            $this->premium_limit_used_percent = (intval($this->premium_limit_used) / intval($this->premium_limit)) * 100;
          }
          else{
            $this->display_premium = false;
          }
        }
        else{
          $this->display_premium = true;
          $this->premium_limit_used_percent = (intval($this->premium_limit_used) / intval($this->premium_limit)) * 100;
        }
      }
      else{
        $this->display_premium = false;
      }
    }
  }
}

?>
