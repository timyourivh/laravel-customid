# laravel-customid

> **Note**
>
> laravel now supports using UUID's and custom ID's by default. Check out [their documentation](https://laravel.com/docs/9.x/eloquent#uuid-and-ulid-keys) to see if it fits your needs.

Eloquent custom ID generation trait for Laravel 6 and above.

<!-- [![Github Actions](https://img.shields.io/github/workflow/status/JamesHemery/laravel-uuid/Continuous%20Integration.svg?style=for-the-badge)](https://github.com/JamesHemery/laravel-uuid/actions?query=workflow%3A%22Continuous+Integration%22) -->
[![Total Downloads](https://img.shields.io/packagist/dt/timyouri/laravel-customid.svg?style=for-the-badge)](https://packagist.org/packages/timyouri/laravel-customid)
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg?style=for-the-badge)](https://raw.githubusercontent.com/JamesHemery/laravel-uuid/master/LICENSE)

A simple trait that allows you to generate and lock a (unique) custom generated id.

## Installation

	composer require timyouri/laravel-customid

## Usage

### In your migrations

Prepare your migration(s) where you would like to use random ID's. It would be best when creating the table, because updating a table may not work for you as it will most likely require you to use `->default()` or `->nullable()`.

```diff
// Example of 2014_10_12_000000_create_users_table.php:

Schema::create('users', function (Blueprint $table) {
-   $table->id();
+   $table->string('id')->primary()->unique();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});
```
### In your models

#### Basic usage

The basic usage is just using the trait and and setting the keytype and it will automatically generate random ID's for you.

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TimYouri\CustomId\Traits\GeneratesCustomId;

class User extends Model
{
    use GeneratesCustomId;
    
    protected $keyType = 'string';
}
```

By default it will generate a 12 character long random id (Example: `p0GWJskcTqUX`). The length of the default id generation can be configured by setting `$customIdLength`:

```diff
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TimYouri\CustomId\Traits\GeneratesCustomId;

class User extends Model
{
    use GeneratesCustomId;
    
    protected $keyType = 'string';

    // Sets default id lenght to 24, output example: 0BENc3Cvj5A9g3WCMPVCJLOK
+   protected $customIdLength = 24;
}
```

#### Advanced usage

All props to configure the beavior of the trait are listed below along with a description and its default value.

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TimYouri\CustomId\Traits\GeneratesCustomId;

class User extends Model
{
    use GeneratesCustomId;
    
    // This is a default Laravel prop.
    // Required if using a string as ID.
    protected $keyType = 'string';
    
    // Determines if the generated id should be unique.
    protected $uniqueCustomId = true; 

    // If `$uniqueCustomId` is true, this prop defines the maximum amount of attemts for validating uniqueness before inserting.
    // When exceeded, it will throw an exception.
    protected $customIdAttempts = 10; 

    // Determines if you are allowed to change the id. If true it will revert to the previous value when trying to update the id.
    protected $lockCustomId = true; 

    // Config parameter for defining the length of the id in the default id generation method.
    protected $customIdLength = 12; 

    // Overwrite the default id generation method
    protected function generateId(int $attempts)
    {
        // `$attempts` is passed to write your own logic based on tried attempts. The default method does not make use of this param.

        // Default:
        return (string) Str::random($this->customIdLength);

        // Example random number:
        return (int) random_int(100000, 999999);        
    }
}
```

## Unit tests

To run the tests, just run `composer install` and `composer test`.

