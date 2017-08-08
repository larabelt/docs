## Installation

```
# create .env file
cp .env.example .env

# install composer dependencies
composer install

# create app key
php artisan key:generate

# install assets & migrate
php artisan belt publish
composer dumpautoload

# migrate & seed
php artisan migrate
php artisan belt seed
```

## Asset Installation

```
# install node dependencies
yarn install

# compile assets
npm run dev
npm run watch
```

## Clear App & PHP Cache

```
composer run-script clear; 
sudo service php7.0-fpm restart;
```

## Misc

```
# run belt publish cmds
php artisan belt publish

# run belt seeds
php artisan seed

# refresh belt migrations with seeds
php artisan belt refresh
```

## Acknowledgments / Credits

* [AdminLTE] (https://github.com/almasaeed2010/AdminLTE)