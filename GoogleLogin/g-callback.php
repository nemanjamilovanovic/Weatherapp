<?php
include '../bootstrap.php';
include '../googleconfig.php';

$code = $_GET['code'];

$accessToken = $gClient->fetchAccessTokenWithAuthCode($code);

$oAuth = new Google_Service_Oauth2($gClient);
$userInfo = $oAuth->userinfo->get();

$userManager->handleGoogleUser(
    $userInfo->getId(),
    $accessToken['access_token'],
    $userInfo->getGivenName(),
    $userInfo->getFamilyName(),
    $userInfo->getEmail(),
    $userInfo->getLink(),
    $userInfo->getPicture()
);

$_SESSION['user'] = $userManager->getByGoogleId($userInfo->getId());



header('Location: /weather.view.php');
