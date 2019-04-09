# Laravel Artisan Commands
[![Travis](https://img.shields.io/travis/novius/laravel-artisan-commands.svg?maxAge=1800&style=flat-square)](https://travis-ci.org/novius/laravel-artisan-commands)
[![Packagist Release](https://img.shields.io/packagist/v/novius/laravel-artisan-commands.svg?maxAge=1800&style=flat-square)](https://packagist.org/packages/novius/laravel-artisan-commands)
[![Licence](https://img.shields.io/packagist/l/novius/laravel-artisan-commands.svg?maxAge=1800&style=flat-square)](https://github.com/novius/laravel-artisan-commands#licence)

This package contains some useful Artisan commands.

## Requirements

This version is compatible with Laravel >=5.7.

For Laravel >=5.5.0 and <5.7 please use 0.3 version.


## Installation

In your terminal:

```sh
composer install novius/laravel-artisan-commands
```

Then, if you are on Laravel 5.4 (no need for Laravel 5.5 and higher), register the service provider to your `config/app.php` file:

```php
'providers' => [
    ...
    Novius\ArtisanCommands\ArtisanCommandsServiceProvider::class,
];
```



## Usage & Features

#### `db:configure`

This command replaces some variables into `.env` and `config/database.php` files, 
in order to configure database name, user and password when you create a new project.


```
php artisan db:configure
```


#### `db:create`

This command tries to create a database, for a given connection:

```
php artisan db:create --connection=[connection]
```

`[connection]` have to be a valid connection, defined into `config/database.php` configuration file.

For instance, `php artisan db:create --connection=mysql` will call `config('database.connections.mysql')` to get driver, host, database name, etc.


## Testing

Run the tests with:

```sh
./test.sh
```


## Lint

Run php-cs with:

```sh
./cs.sh
```

## Contributing

Contributions are welcome!
Leave an issue on Github, or create a Pull Request.


## Licence

This package is under [GNU Affero General Public License v3](http://www.gnu.org/licenses/agpl-3.0.html) or (at your option) any later version.
