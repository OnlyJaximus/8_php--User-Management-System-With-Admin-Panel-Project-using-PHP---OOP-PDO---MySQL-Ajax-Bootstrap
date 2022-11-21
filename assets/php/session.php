<?php

session_start();
require_once 'auth.php';

// cuser = current user
$cuser = new Auth();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    die;
}

//cemail = current email
$cemail = $_SESSION['user'];

$data = $cuser->currentUser($cemail);

// current id
$cid = $data['id'];
$cname = $data['name'];
$cpass = $data['password'];
$cphone = $data['phone'];
$cgender = $data['gender'];
$cdob = $data['dob'];   // Date of Birth
$cphoto = $data['photo']; // If any photo is already uploaded previously then we will store the path in this cphoto variable

$created = $data['created_at'];
$reg_on = date('d M Y', strtotime($created));


$verified = $data['verified'];

$fname = strtok($cname, " ",);

if ($verified == 0) {
    $verified = 'Not Verified!';
} else {
    $verified = "Verified!";
}
