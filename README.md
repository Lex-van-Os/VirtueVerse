# VirtueVerse
VirtueVerse: A platform for exploring and studying Christian literature

## About
VirtueVerse is an application that allows users to browse through Christian literature by famous Christian authors throughout history. VirtueVerse contains a role based account system. With this, it is possible to register as a user and create a 'study trajectory' for a given book. Through a study trajectory, one can track progress and use tools and goals to help with studying the given content. 

VirtueVerse was created as a part of a school project for my current Bachelor education. For my program, it is required to create a MVC application in Laravel (unless one already has worked with Laravel previously, which I haven't, sadly.).

### Open Library API

#### Examples
*Retrieval of a book*
https://openlibrary.org/api/books?bibkeys=OLID:OL22589662M&format=json&jscmd=data

*Searching through book records*
https://openlibrary.org/search.json?q=screwtape%20letters&fields=title,first_publish_year,author_name,edition_key&limit=10&mode=everything

*Searching through the works of a book*
https://openlibrary.org/works/OL71072W/editions.json

*Retrieval of an author*
https://openlibrary.org/authors/OL31574A.json

*Searching through author records*
https://openlibrary.org/search/authors.json?q=C.S.Lewis&limit=10

### Books

#### Description
The book table serves as the base of this application. With the use of this application, users can create new books and have the possibility to create corresponding book editions. Books can both be created with manual input and through the Open Library API. Upon using the Open Library API to search through books and adding them, additional Open Library information is stored for easy creation of corresponding book editions.

#### Catalogue
Through the book catalogue, users have the ability to quickly look through book information. Through filtering and text search, you can easily find your desired book.

### Book editions

#### Description
To make it possible to store different types of editions / publications of a single book, the 'book editions' table is included in this project. This makes it easier for a user to start a study trajectory for his owned book. One book can have multiple different kinds of book editions, with different ISBN numbers, languages etc.

#### Catalogue
Like the book table, the book editions table also includes a catalogue in the functionality. This makes it easier for users to find their desired edition to start a study trajectory.

### User accounts

#### Description
In the application, users have the ability to create a user account. The ability to create and manage user accounts, is realised through the Laravel Breeze starter kit, with added user roles on top. Through the creation of an account, you have the possibility to create records inside of the application. These actions are authorized through user accounts

#### User roles, authentication and authorization
Through added user roles, extra authorization is added to the application. Admins have the ability to monitor all content and perform all actions, editors have the ability to create new records for (most) of the included entities, while users are mainly tied to functionality for creating book editions and studying trajectories.

### Study trajectories

#### Description
Study trajectories create the possibility for a user to use tools for support when studying a book. Through creating a book and book edition inside of VirtueVerse, users can start their own study trajectories for this given edition. Through this, users can set goals, retrieve automated to-do tasks for the given book and track their progress in certain tasks.

## Authorization

### Description
Through project authorization, realised through user roles, certain actions are made available or prohibited. This is depending on the given role of the user.

### Admin functionality
- Full CRUD for authors
- Full CRUD for books
- Full CRUD for book editions
- Full CRUD for users
- Full CRUD for study trajectories

### Editor functionality
- Full CRUD for authors
- Full CRUD for books
- Full CRUD for book editions
- Full CRUD for own study trajectories

### 'User' functionality
- CR for books, UD for self made books
- CR for book editions, UD for self made book editions
- Full CRUD for own study trajectories


## Project structure
![virtueverse-erd drawio](https://github.com/Lex-van-Os/VirtueVerse/assets/44748283/0e5b6736-a1e4-47da-8e1c-55d95342eca8)

## Installation

### Connecting to a local database
VirtueVerse makes use of a local postgres database for storing and transforming data.

#### Prerequisites
Making use of a database, has the following prerequisites:
- PostgreSQL installed
- PHP installed
- PHP installed configuration to make use of the PostgreSQL extension

#### Database configuration
To connect to a locally defined database, you first have to create a PostgreSQL database, locally. This can be done with a tool like pgAdmin (comes with an installation of PostgreSQL when selected).

When having created a local database, the .env file has to be modified to refer to your local database. The variables that have to be changed, are all the variables starting with 'DB_'. For example:

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE={example_database}
DB_USERNAME={example_user}
DB_PASSWORD={example_password}

### Running migrations
After having successfully created the database, you can automatically add the corresponding tables with the following command:
php artisan migrate

### Running seeders
Having added the tables, test data is to be inserted using the following command:
php artisan db:seed

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