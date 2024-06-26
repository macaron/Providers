# Orcid

```bash
composer require socialiteproviders/orcid
```

## Installation & Basic Usage

Please see the [Base Installation Guide](https://socialiteproviders.com/usage/), then follow the provider specific instructions below.

### Add configuration to `config/services.php`

**Please note, the latest version of this package requires you to use `services` config file. Previously enviroment variables were read directly, which is no longer supported**

```php
'orcid' => [    
  'client_id' => env('ORCID_CLIENT_ID'),  
  'client_secret' => env('ORCID_CLIENT_SECRET'),  
  'redirect' => env('ORCID_REDIRECT_URI') ,
  'environment' => env('ORCID_ENVIRONMENT'), // Optional
  'uid_fieldname' => env('ORCID_UID_FIELDNAME'), // Optional
],
```

### Add provider event listener

#### Laravel 11+

In Laravel 11, the default `EventServiceProvider` provider was removed. Instead, add the listener using the `listen` method on the `Event` facade, in your `AppServiceProvider` `boot` method.

* Note: You do not need to add anything for the built-in socialite providers unless you override them with your own providers.

```php
Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
    $event->extendSocialite('orcid', \SocialiteProviders\Orcid\Provider::class);
});
```
<details>
<summary>
Laravel 10 or below
</summary>
Configure the package's listener to listen for `SocialiteWasCalled` events.

Add the event to your `listen[]` array in `app/Providers/EventServiceProvider`. See the [Base Installation Guide](https://socialiteproviders.com/usage/) for detailed instructions.

```php
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        // ... other providers
        \SocialiteProviders\Orcid\OrcidExtendSocialite::class.'@handle',
    ],
];
```
</details>

### Usage

You should now be able to use the provider like you would regularly use Socialite (assuming you have the facade installed):

```php
return Socialite::driver('orcid')->redirect();
```
