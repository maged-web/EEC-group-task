# EEC-group-task


## Installation

Follow these steps to set up the project on your local machine:

1-Clone the repository:

git clone https://github.com/maged-web/EEC-group-task.git


2-Navigate to the project directory:

cd EEC-group-task


3-Install dependencies:

Run the following command to install all required dependencies via Composer:

composer install


Create a .env file:

Copy the example environment file and create your own .env file:

cp .env.example .env


Generate the application key:

This command will generate a unique application key for your project:

php artisan key:generate


Configure your database:

Open the .env file and set your database connection details:


DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password


Apply the database migrations:

php artisan migrate


Seed the database (optional):

Note: You have 50,000 seeders for products, 20,000 seeders for pharmacies, and 100,000 seeders for product-pharmacy relationships. 

This process may take a long time; you can decrease the number of seeders to speed it up.

php artisan db:seed


Launch the Laravel development server:

php artisan serve


Run tests: To run your tests, execute:

php artisan test

