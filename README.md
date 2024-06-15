My simple project of bank app made that use CRUD in Laravel for completing university course.

## Features

- Users system
- Verification link on e-mail to activate an account
- 3 roles in the system (Client, Support, Admin)
- Transactions system
- List of transaction of logged in user
- CRUD to manage users as an admin
- Light/Dark mode based on a system theme

## Requirements
- PHP 8.2+
- Composer

## Installation

- Clone repo
- Install all PHP dependencies via composer
```
composer install
```
- Set up the new configuration file
``` 
cp env.example .env 
```
- Change database values in new created .env file
- Run migrations
```
php artisan migrate
```
- Serve website
```
php artisan serve
```

### Adding new admin
- Register normal account by register form on site
- Open tinker (console programming environment)
```
php artisan tinker
```
- Assign role "admin" to newly created user
```bash
use App\Models\User;
use Spatie\Permission\Models\Role;
$user = User::find(1); # or any other ID (change 1 in that case)
$user->assignRole('admin');
exit();
```