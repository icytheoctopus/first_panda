<p align="center">
<br><br>
    <img src="https://cdn.bitpanda.com/media/redesign/bitpanda-logo.svg" width="200">
</p>

# First PHP Technical test
### Task description
Create a new Laravel project using composer
Attached you will find a DB dump. Create a DB connection in laravel using the .env file.
Seed the DB based on the dump
In the resulted DB you will have these 3 tables: `users`, `countries` and `user_details`.
```
* users: id, email, active
* countries: id, name, iso2, iso3 
* user_details: id, user_id, citizenship_country_id, first_name, last_name, phone_number
```

 1. Create a call which will return all the users which are `active` (users table) and have an Austrian citizenship.
 2. Create a call which will allow you to edit user details just if the user details are there already.
 3. Create a call which will allow you to delete a user just if no user details exist yet.
 4. Write a feature test for 3. with valid and invalid data

Tips:
- you can use Eloquent to simplify (eg: model binding)

## Instructions
#### Clone the project
```
git clone https://github.com/icytheoctopus/first_panda.git
```

#### Create .env file
Navigate into project
```
cd first_panda
```
Create .env from .env.example
```
cp .env.example .env
```

#### Install dependencies
```
composer install
```

#### Build sail (docker) network
Configure sail alias
```
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

without alias, you can run sail directly from vendor folder
```
./vendor/bin/sail
```

Build sail network
```
sail up
```
App uses ports 80 and 3306

#### Migrate and seed the database
```
sail artisan migrate:fresh --seed
```

#### Run tests with
```
sail artisan test
```

## Making requests
You can find Postman collection with all requests in app root directory
