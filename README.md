Google API Bundle
=================

A symfony2 bundle to communicate to Google API. This bundle is a Symfony2 wrapper for the [google apiclient][1].
There are some services not yet implemented. Please submit a PR and I'm happy to merge.



Installation
------------

### Step 1: Using Composer

Install it with Composer!

```js
// composer.json
{
    // ...
    require: {
        // ...
        "happyr/google-api-bundle": "dev-master",
        "google/apiclient": "@beta",
    }
}
```

Then, you can install the new dependencies by running Composer's ``update``
command from the directory where your ``composer.json`` file is located:

```bash
$ php composer.phar update
```

### Step 2: Register the bundle

To register the bundles with your kernel:

```php
<?php

// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new HappyR\Google\ApiBundle\HappyRGoogleApiBundle(),
    // ...
);
```

### Step 3: Configure the bundle

``` yaml
# app/config/config.yml
# you will get these parameters form https://code.google.com/apis/console/"
happy_r_google_api:
    auth_type: all
    # Set up the auth system that you want to use. "all" if your application needs to use different types of auth.
    # e.g auth_type: service_account_auth
    web_server_auth:
        application_name: AppName
        oauth2_client_id: clientId
        oauth2_client_secret: clientSecret
        oauth2_redirect_uri: redirectUri
        developer_key: developerKey
        site_name: mysite.com

    service_account_auth:
        application_name: AppName
        oauth2_client_id: clientId
        service_account_name: something@developer.gserviceaccount.com
        key_file_location: /path/to/your/file.p12 
        # If you need to spectify a user who you are acting on behalf of, then set the 'sub' parameter.
        # e.g. sub: emailaddress@yourdomain.com
        scopes:
            directory:
                - "https://www.googleapis.com/auth/admin.directory.user"
```


[1]: https://github.com/google/google-api-php-client