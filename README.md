# laravel-customid
Eloquent Custom ID Generation Trait for Laravel 5.7 and above.

<!-- [![Github Actions](https://img.shields.io/github/workflow/status/JamesHemery/laravel-uuid/Continuous%20Integration.svg?style=for-the-badge)](https://github.com/JamesHemery/laravel-uuid/actions?query=workflow%3A%22Continuous+Integration%22)
[![Total Downloads](https://img.shields.io/packagist/dt/jamesh/laravel-uuid.svg?style=for-the-badge)](https://packagist.org/packages/jamesh/laravel-uuid) -->
[![MIT licensed](https://img.shields.io/badge/license-MIT-blue.svg?style=for-the-badge)](https://raw.githubusercontent.com/JamesHemery/laravel-uuid/master/LICENSE)

A simple trait that allows you to generate and lock a unique custom generated id.

## Installation

	composer require timyouri/laravel-customid

## Usage

### In your migrations

```php
Schema::create('users', function (Blueprint $table) {
    $table->string('id')->primary()->unique();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});
```

### In your models

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

### Advanced usage

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TimYouri\CustomId\Traits\GeneratesCustomId;

class User extends Model
{
    use GeneratesCustomId;
    
    protected $keyType = 'string';
    
    // Determines if the generated id should be unique
    protected $uniqueCustomId = true; 

    // Defines the maximum amount of attemts for validating uniqueness.
    protected $customIdAttempts = 10; 

    // Determines if you are allowed to change the id.
    protected $lockCustomId = true; 

    // Config parameter for defining the length of the id in the default id generation method.
    protected $customIdLength = 12; 

    // Overwtire the default id generation method
    protected function generateId($attempts)
    {
        // Default:
        return (string) Str::random($this->customIdLength);

        // Example uuid:
        return (string) Str::uuid();

        // Example random number:
        return (int) random_int(100000, 999999);
    }
}
```

## Unit tests

To run the tests, just run `composer install` and `composer test`.

