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
  $formData->global = array('<div>Your email address appears to be invalid.</div>');
}


$phoneNum = (int) preg_replace('/\D/', '', $formData->phone);

if(empty($phoneNum)){
  $formCSS['phone'] = 'error';
  $formData->phone = 'Phone Number w/ Area Code';
}elseif(preg_match('/[0-9]{10,11}/', $phoneNum)){
  $formData->global = array('<div>Your phone number appears to be invalid.</div>');
}


if(empty($formData->hear)){
  $formCSS['hear'] = 'error';
  $formData->hear = 'error';
}
if(empty($formData->first)){
  $formCSS['first'] = 'error';
  $formData->first = 'error';
}
if(empty($formData->kind)){
  $formCSS['kind'] = 'error';
  $formData->kind = 'error';
}


//echo "<pre>";
//print_r($_POST);
//echo "</pre>";
echo "<pre>";
print_r($formData);
echo "</pre>";
//exit;

?>
