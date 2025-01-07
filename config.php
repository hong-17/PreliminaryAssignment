<?php

require_once __DIR__ . '/vendor/autoload.php';

$client = new Google\Client();

$client->setClientId("372813192316-kc7d4ff9hd3niqrrphb11iti7br0rr0l.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/PreliminaryAssignment/index.php");

if (! isset($_GET["code"])) {

    exit("Login failed");

}

$token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);

$client->setAccessToken($token["access_token"]);

$oauth = new Google\Service\Oauth2($client);

$userinfo = $oauth->userinfo->get();

var_dump(
    $userinfo->email,
    $userinfo->firstName,
    $userinfo->lastName,
    $userinfo->name
);
if (isset($token['error'])) {
    var_dump($token['error']);
}
header('Location: periodic.html');
exit;
?>