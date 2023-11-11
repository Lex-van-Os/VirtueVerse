# VirtueVerse
VirtueVerse: A platform for exploring and studying Christian literature

## About
VirtueVerse is an application that allows users to browse through Christian literature by famous Christian authors throughout history. VirtueVerse contains a role based account system. With this, it is possible to register as a user and create a 'study trajectory' for a given book. Through a study trajectory, one can track progress and use tools and goals to help with studying the given content. 

VirtueVerse was created as a part of a school project for my current Bachelor education. For my program, it is required to create a MVC application in Laravel (unless one already has worked with Laravel previously, which I haven't, sadly.).

### Assessor clarification
Extra clarification on the application functionality regarding the requirements for the course 'Web Application Frameworks', can be found inside of the **AssessorClarification.md** file.

### Open Library API
The application makes use of the `Open Library API` to help with the retrieval of book and author records. The functionality for invoking the API, is done through back-end controller methods.

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

### VirtueVerse Insights API
For extra functionality through machine learning actions (recommendations, trends, expected data), VirtueVerse makes use of the VirtueVerse Insights API. VirtueVerse Insights is a seperate Python project, that uses necessary data from VirtueVerse to perform machine learning actions. The functionality provided is not necessary for the functioning of the VirtueVerse application itself, but serves as an added layer of personalisation.

#### Examples
*Retrieval of expected completion time of a study trajectory*
http://127.0.0.1:5000/insightsApi/expectedCompletionTime

*Retrieval of popular books*
http://127.0.0.1:5000/insightsApi/popularBooks

*Retrieval of book recommendations*
http://127.0.0.1:5000/insightsApi/bookRecommendations

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

#### Viewing trajectories
Trajectories can be viewed by navigating to the profile page of your account. Here you can find a button for the study trajectory catalogue, which will display all your created study trajectories. This page is also accessible through the footer once logged in

### Study entries

#### Description
Through study trajectories, a user can create study entries for the book edition he's created study trajectory for. Through study entries, it's possible to give information on the studying progress of a book (read pages, spent minutes, notes, glossaries etc.). Through this data, it's possible to gain insights provided by VirtueVerse.

## Authorization

### Description
Through project authorization, realised through user roles, certain actions are made available or prohibited. This is depending on the given role of the user.

### Admin functionality
- Full CRUD for authors
- Full CRUD for books
- Full CRUD for book editions
- Full CRUD for users
- Full CRUD for study trajectories
- Full CRUD for study entries

### Editor functionality
- Full CRUD for authors
- Full CRUD for books
- Full CRUD for book editions
- Full CRUD for own study trajectories
- Full CRUD for own study entries

### 'User' functionality
- CR for books, UD for self made books
- CR for book editions, UD for self made book editions
- Full CRUD for own study trajectories
- Full CRUD for own study entries

## Project structure
![virtueverse-erd drawio](https://github.com/Lex-van-Os/VirtueVerse/assets/44748283/0e5b6736-a1e4-47da-8e1c-55d95342eca8)

## Installation

### Connecting to a local database
VirtueVerse makes use of a local `postgres` database for storing and transforming data.

#### Prerequisites
Making use of a database, has the following prerequisites:
- PostgreSQL installed
- PHP installed
- PHP configuration to make use of the PostgreSQL extension
- pgAdmin for database UI (recommended)

#### Database configuration
To connect to a locally defined database, you first have to create a PostgreSQL database, locally. This can be done with a tool like `pgAdmin` (comes with an installation of PostgreSQL when selected).

When having created a local database, the project `.env` file has to be modified to refer to your local database. The variables that have to be changed, are all the variables starting with `'DB_'.` For example:

```php
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE={example_database}
DB_USERNAME={example_user}
DB_PASSWORD={example_password}
```

Make sure that the database, username and password match the database name and the defined database username and passwords respectively.

### Correct folder
When executing the following commands, and also all other commands regarding terminal actions, make sure that you have firstly navigated to the **VirtueVerse** project folder. For example:

```markdown
C:\CMGT\CMI\Virtue Verse\VirtueVerse
```

### Running migrations
After having successfully created the database, you can automatically add the corresponding tables with the following command:
```bash
php artisan migrate
```

### Running seeders
Having added the tables, test data is to be inserted using the following command:
```bash
php artisan db:seed
```

## Starting the application
To run the application, two processes have to be started in two seperate terminals. Both are to be executed in the project root folder (**/VirtueVerse**):

### Running the development server
The following command starts the development server:
```bash
php artisan serve
```

### Running Vite
The following command runs the project application builder; Vite:
```bash
npm run dev
```

## Validating a correct database connection
A correct database connection can be validated by navigating to the following url:
'<http://127.0.0.1:8000/test-database>'

## Deploying a Laravel Application Locally with Docker

This guide will walk you through deploying your Laravel application using Docker on your local machine. Docker allows you to containerize your application, making it easy to manage and deploy.

### Prerequisites

Before you begin, ensure that you have the following prerequisites installed:

1. **Docker**: Install Docker on your machine. You can download and install Docker Desktop from [Docker's official website](https://www.docker.com/products/docker-desktop).

### Step 1: Prepare Your Laravel Application

Make sure your Laravel application is ready for deployment. Ensure you have set up your database configuration, environment variables, and dependencies.

### Step 2: Create a Docker Compose File

Create a `docker-compose.yml` file at the root of your Laravel project. This file defines how your application and its dependencies will run in containers.

### Step 3: Build and Run the Containers

Open your terminal, navigate to the root directory of this project, and run the following command to build and run your Docker containers:

```bash
docker-compose up -d
```

This command will create the necessary containers and start them in the background.

### Step 4: Access Your Laravel Application

Once the containers are up and running, you can access VirtueVerse in your web browser by navigating to [http://localhost](http://localhost). With this, VirtueVerse is accessible locally

### Step 5: Stopping and Removing Containers

To stop and remove the containers, you can use the following command:

```bash
docker-compose down
```

This command will stop and remove the Docker containers.