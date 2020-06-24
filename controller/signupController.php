<?php

require_once( 'model/user.php' );

/****************************
* ----- LOAD SIGNUP PAGE -----
****************************/

function signupPage() {

  $user     = new stdClass();
  $user->id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false;

  if( !$user->id ):
    require('view/auth/signupView.php');
  else:
    require('view/homeView.php');
  endif;

}

/***************************
* ----- SIGNUP FUNCTION -----
***************************/

function signup() {
    $user = new User();
    try {
        $user->setEmail($_POST["email"]);
        $user->setPassword(hash('sha256',$_POST["password"]), hash('sha256', $_POST["password_confirm"]));
        $user->createUser();
        $error_msg = "Compte crée avec succès";
    }
    catch (Exception $e) {
        $error_msg = $e->getMessage();
    } 
        return $error_msg;
}