<?php
namespace EasifyAllegro\Library;

use EasifyAllegro\User;
use EasifyAllegro\Pricing;
use EasifyAllegro\UserWallet;

class ActivatePackage{
  public $id;
  public $user;
  public $userWalletAddress;
  public $method;
  public $package;
  public $price;
  public $confirmation;
  public $created_at;

  function __construct($declaration){
    $this->id = $declaration->id;
    $user = User::where('id', $declaration->user)->first();
    $this->user = $user->email;
    $this->method = $declaration->method;
    $userWallet = UserWallet::where('user', $declaration->user)->first();
    if($userWallet != null){
      if($this->method == 'bitcoin'){
        $this->userWalletAddress = $userWallet->bitcoin;
      }
      elseif($this->method == 'paypal'){
        $this->userWalletAddress = $userWallet->paypal;
      }
    }
    else{
      $this->userWalletAddress = 'brak';
    }
    $package = Pricing::where('id', $declaration->package)->first();
    $this->package = $package->package;
    $this->price = $declaration->price;
    $this->confirmation = $declaration->confirmation;
    $this->created_at = $declaration->created_at;
  }
}

?>
