<?php

require_once __DIR__ . '/vendor/autoload.php';

$client = new Google_Client();

$client->setClientId("372813192316-kc7d4ff9hd3niqrrphb11iti7br0rr0l.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/PreliminaryAssignment/index.php");
$client->addScope('email');
$client->addScope('profile');

if (isset($_GET['code'])) {
    try {
        // Fetch the token using the authorization code
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
        // Set the token to the client
        $client->setAccessToken($token['access_token']);
        
        // Fetch user info using the Google Oauth2 service
        $oauth = new Google\Service\Oauth2($client);
        $userinfo = $oauth->userinfo->get();

        // Optionally, save user information in session or database
        session_start();
        $_SESSION['user'] = [
            'email' => $userinfo->email,
            'firstName' => $userinfo->givenName,
            'lastName' => $userinfo->familyName,
            'fullName' => $userinfo->name,
        ];

        // Redirect to periodic.html after login
        header('Location: http://localhost/PreliminaryAssignment/periodic.html');
        exit;
    } catch (Exception $e) {
        // Handle any errors during the authentication process
        echo 'Error: ' . $e->getMessage();
    }
}

$url = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Login with Google</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css"/>
</head>
<body>
<div class="container">
    <h2 style="margin-top:5px">Welcome Back</h2>
    <p style="color:gray; padding:20px">Lorem ipsum dolor sit amet, consectetuer</p>
    <div class="wrapper">
       <a href="<?= $url ?>" class="login-btn">
        <img src="image/google.png" alt="Google Icon" class="btn-icon">
       Sign in with Google</a>
    </div>
</div>
</body>
</html>