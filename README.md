# ImgurAPI
This is an object-oriented php project to connect to the Imgur API. 
It is meant to be a learning experience for me, but the goal is that this software will be usable by anyone for what ever purpose.

## Current Version

Current version: 0.1.0

## Documentation

In order to make this work, you need to register an application with Imgur. To do that you can check out this URL [Imgur API Documentation](https://api.imgur.com/). After getting your hands on the Client ID and Client Secret of your application you need to configure. *Work work*

Autoload.php

```php 
  // These three settings are the ones you're going to need to change and exchange for the ones in your application.
  Settings::setCredential('client_id', 'YOUR-CLIENT-ID');
  Settings::setCredential('client_secret', 'YOUR-CLIENT-SECRET');
  Settings::setPublic('auth_state', 'YOUR-AUTH-STATE'); 
```

After configuring these settings then you should be able to Rock 'N' Roll, my friend.

example index.php

```php
  // Since this program is using sessions, you need to start them sessions.
  session_start();

  // Load all the classes and your ready to go!
  require_once('vendor/autoload.php');

  // Get a new instance of the Authorize class
  $auth = new Authorize();

  // Now you can check if everything is loaded correctly and we have access
  if ($auth->checkAccess()) {
    $request = new Request();
    
    // Use the Request class and get information about the logged in users account
    $account = $request->get('account/me');

    var_dump($account);
  } else {
    print '<a href="<?php Settings::getPublic('auth_url'); ?>">Log in</a>';
  }
```

And that's as simple as it gets. If you want to learn more about the different Imgur Endpoints, then you can hit up the [Imgur API Documentation](https://api.imgur.com/) and read up!