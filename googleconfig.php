<?php
    $gClient = new Google_Client();
    $gClient->setClientId('653244596797-8ferkuudml3t15emfkthf3agf817sl6a.apps.googleusercontent.com');
    $gClient->setClientSecret('c2_cGP1Zf4FIQCmumc0K0C2C');
    $gClient->setApplicationName('CPI Login');
    $gClient->setRedirectUri('http://milovanovic.moj-test2.si/GoogleLogin/g-callback.php');
    $gClient->addScope( 'https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email');