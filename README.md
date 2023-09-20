# VirtueVerse
VirtueVerse: A platform for exploring and studying Christian literature

## About
VirtueVerse is an application that allows users to browse through Christian literature by famous Christian authors throughout history. VirtueVerse contains a role based account system. With this, it is possible to register as a user and create a 'study trajectory' for a given book. Through a study trajectory, one can track progress and use tools and goals to help with studying the given content. 

VirtueVerse was created as a part of a school project for my current Bachelor education. For my program, it is required to create a MVC application in Laravel (unless one already has worked with Laravel previously, which I haven't, sadly.).

## Project structure
![virtueverse-erd drawio](https://github.com/Lex-van-Os/VirtueVerse/assets/44748283/0e5b6736-a1e4-47da-8e1c-55d95342eca8)

## Installation
To be added

## Connecting to a local database
VirtueVerse makes use of a local postgres database for storing and transforming data.

### Prerequisites
Making use of a database, has the following prerequisites:
- PostgreSQL installed
- PHP installed
- PHP installed configuration to make use of the PostgreSQL extension

### Database configuration
To connect to a locally defined database, you first have to create a PostgreSQL database, locally. This can be done with a tool like pgAdmin (comes with an installation of PostgreSQL when selected).

When having created a local database, the .env file has to be modified to refer to your local database. The variables that have to be changed, are all the variables starting with 'DB_'. For example:

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE={example_database}
DB_USERNAME={example_user}
DB_PASSWORD={example_password}

## Starting the application
The application can be started using the command:
<pre>
```bash
php artisan serve
```
</pre>

## Validating a correct database connection
A correct database connection can be validated by navigating to the following url:
'<http://127.0.0.1:8000/test-database>'