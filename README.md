# ImgurAPI
This is an object-oriented php project to connect to the Imgur API. 
It is meant to be a learning experience for me, but the goal is that this software will be usable by anyone for what ever purpose.

## Current Version

Current version: 0.3.0

### Dependencies

PHP >= 5.2.0

### Current Features

* Connect to the Imgur API via OAuth2.0.
* Support for connecting using either authorization code or pin.
    * _(Since the token authorization type responds with a hash query im gonna leave it out)_
* Send GET, POST, PUT, DELETE requests.
* Error handling for requests.
* Output the response data from requests to JSON.
* Model-specific classes that has methods to use as shorthand, such as:
    * Image has find, upload, delete, edit, favorite, publish/unpublish.
    * More coming.

### Future Plans

* Easy way to upload images, galleries and other things.

* A general method to get viral, hot or a specific sorting for the following
    * Images
    * Galleries
    * Comments

* And more.....

### Known Issues

At the moment there are no known issues. If you are experiencing any issues then submit an issue, please!

## Documentation

In order to make this work, you need to register an application with Imgur. To do that you can check out the [Imgur API Documentation](https://api.imgur.com/). After getting your hands on the Client ID and Client Secret of your application you need to configure the settings. *Work work*

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
    
    /** 
    * Use the Request class and get information about the logged in users account.
    * If the request would fail, then a ImgurException would be thrown with the 
    * message and code from Imgur.
    *
    * It is also possible to output the response object to JSON or stdClass using the output() method.
    */
    try {
      $account = $request->get('account/me');

      print $account->output('json');
    } catch(ImgurException $e) {
      print $e->getMessage();
    }
  } else {

    // If you want a simple login link you can use the auth url setting
    ?>
    <a href="<?php Settings::getPublic('auth_url'); ?>">Log in</a>
    <?php

    // Or if you are connecting by pin code, just make a simple form with these two fields
    if (Settings::getCredential('grant_type') == 'pin'): 
    ?>
      <form method="GET" action="<?php $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="state" value="<?php print Settings::getPublic('auth_state'); ?>">
        <input type="text" name="code">
        <input type="submit">
      </form>
    <?php
    endif;
  }
```

And that's as simple as it gets. If you want to learn more about the different Imgur Endpoints, then you can hit up the [Imgur API Documentation](https://api.imgur.com/) and read up!

If you want to contact me, you can look me up on twitter [@jzasnake](http://twitter.com/jzasnake)!