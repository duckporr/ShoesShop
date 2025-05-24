<?php
// include ('C:/xampp/htdocs/Group11_PHP/common/Facebook/autoload.php');
// include ('C:/xampp/htdocs/Group11_PHP/common/fbconfig.php');
include ('../../common/Facebook/autoload.php');
include ('../../common/fbconfig.php');
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://localhost/Group11_PHP/common/fb-callback.php', $permissions);
?>