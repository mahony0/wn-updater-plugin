# Remote updater plugin for WinterCMS

Plugin for updating WinterCMS via remote command

# Installation

To install from [the repository](https://github.com/mahony0/wn-updater-plugin), clone it into **plugins/mahony0/updater** and then run `composer update` from your project root in order to pull in the dependencies.

To install it with Composer, run `composer require mahony0/wn-updater-plugin` from your project root.

# env Options

## UPDATER_ENABLED

> Default: **true**

Either plugin active or disable


## UPDATER_HASH_CHECK

> Default: **true**

If enabled, updater will try to match current date (Y-m-d in UTC) with post "code" parameter. If did not match, then update will be aborted

## UPDATER_DELAY

> Default: **60**

Minimum required delay between update requests (in minutes)

## UPDATER_ROUTE

> Default: **wn-updater-plugin/update**

Updater route for post request to be sent

# Sample code

```php
$result = Http::post('https://domain.tld/wn-updater-plugin/update', function($http) {

    // Optional, can be disabled by UPDATER_HASH_CHECK=false
    date_default_timezone_set('UTC');
    $http->data(['code' => Hash::make(date('Y-m-d'))]);

});
```

# Successful Response

```json
{
    "status": true,
    "payload": "Loading composer repositories with package information\r\nUpdating dependencies\r\n........"
}
```

# Error Responses

```json
{
    "status": false,
    "payload": "Updater is disabled"
}

{
    "status": false,
    "payload": "Provided code did not match"
}

{
    "status": false,
    "payload": "Update cannot be started because not enough time has passed since the last update"
}
```
