<?php
/**
* This is a class autoloader, it also serves as a configuration file where you can 
* set the application's credentials and other settings.
* 
* Client ID and Client Secret are delegated to the application owner when registering
* a new application with Imgur. The administration panel where you have these credentials also
* contains the redirect URL (to which URL the user should be redirected after logging in) and
* the Auth state.
*/
function __autoload($class) {
  require('src/' . $class . '.php');
}

Settings::setCredential('client_id', 'YOUR-CLIENT-ID');
Settings::setCredential('client_secret', 'YOUR-CLIENT-SECRET');
Settings::setCredential('grant_type', 'code');

Settings::setPublic('api_url', 'https://api.imgur.com/3/');
Settings::setPublic('token_url', 'https://api.imgur.com/oauth2/token');
Settings::setPublic(
  'auth_url', 
  'https://api.imgur.com/oauth2/authorize?response_type=' . 
    Settings::getCredential('grant_type') . 
    '&client_id=' . Settings::getCredential('client_id') . 
    '&state=authorizing'
);
Settings::setPublic('auth_state', 'YOUR-AUTH-STATE');
?>