csharp

# Symfony App

This is a Symfony application built with Yarn, Webpack Encore, and Doctrine.

## Installation

1. Clone the repository:

   ``````bash
   git clone https://github.com/radhwanben/football-team-management.git
   
Navigate to the project directory:

```bash

cd football-team-management

```
Install Composer dependencies:

```bash

composer install
```
Install Yarn dependencies:

```bash

yarn install
```
Build the frontend assets with Webpack Encore:

```bash

yarn encore dev
```
Database Setup
Configure the database connection in the .env file.

Create the database:

```bash

php bin/console doctrine:database:create
```
Run database migrations:

```bash

php bin/console doctrine:migrations:migrate
```
Load Data Fixtures
Load data fixtures:

```bash

php bin/console doctrine:fixtures:load
```
Follow the prompts to confirm the data fixture loading process.

Usage
Start the Symfony development server:

```bash

symfony serve
```
Open your web browser and visit http://localhost:8000 to access the application.

Contributing
Contributions are welcome! Please fork the repository and submit a pull request with your changes.

License
This project is licensed under the MIT License.
