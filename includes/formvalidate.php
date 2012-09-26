<?php
require_once './emailverification.php';

$formData = json_decode($_POST['data']);
$formCSS = array();

if(empty($formData->name)){
  $formCSS['name'] = 'error';
  $formData->name = 'Your Name';
}

if(empty($formData->email)){
  $formCSS['email'] = 'error';
  $formData->email = 'Email Address';
}elseif(!validEmail($formData->email)){
  $formCSS['email'] = 'error';
  $formData->global->e = '<div>Your email address appears to be invalid.</div>';
}


$phoneNum = (int) preg_replace('/\D/', '', $formData->phone);

//var_dump(strlen($phoneNum));

if(empty($phoneNum)){
  $formCSS['phone'] = 'error';
  $formData->phone = 'Phone Number w/ Area Code';
}elseif(strlen($phoneNum) < 10 || strlen($phoneNum) > 11){
  $formCSS['phone'] = 'error';
  $formData->global->p = '<div>Your phone number appears to be invalid.</div>';
}


if(empty($formData->hear) || $formData->hear === '0'){
  $formCSS['hear'] = 'error';
}
if(empty($formData->first) || $formData->first === '0'){
  $formCSS['first'] = 'error';
}
if(empty($formData->kind) || $formData->kind === '0'){
  $formCSS['kind'] = 'error';
}

if(empty($formCSS)){
  $success = true;
  require_once './sendEmail.php';
}
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
//echo "<pre>";
//print_r($formData);
//echo "</pre>";
//exit;

?>
