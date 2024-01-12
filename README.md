# Aine frontend example
Aine CMS frontend blog example

## Aine Backend

Aine backend installation can be found on the [Aine install](https://github.com/kothing/laravel-aine/).

## Installation Example

1. Clone or download the repository
1. Go to the project directory and run composer install
1. Create .env file by copying the .env.example. You may use the command to do that cp .env.example .env
1. Configure `AINE_API_URL` and `AINE_API_TOKEN` in .env
1. Update the database name and credentials in .env file
1. Run the command to generate application key php artisan key:generate
1. Run the command php artisan migrate --seed
1. Visit your site