# Assessor clarification
To give an indication on the added functionality regarding the project for the course 'Web Application Frameworks', this document has been made to clarify different requirements for this given application.

## Application requirements
In the following part of this document, i will explain different parts of the application in regards to the given requirements for the assignment. Parts will be explained in functionality, and where to find them inside of the application, assuming the user is on the home page.

### Security

#### Login
Security is done through the login & register functionality which is found in the top right of the navbar. Once having logged in, the user can access his own profile page and find more settings and navigation here.

#### Form validation
Form validation can be found inside of the create and edit pages for all of the supported entities. Form validation is done through both front-end and back-end. In the front-end checks are done through 'required' fields and front-end handling of forms. In the back-end fields are again checked through deeper validation. If this validation fails, the user will be redirected back to the form create / edit page, with necessary validation errors.

### Roles
Roles are realised through the registration of a user. Although it is not best practice for a live application, a user can select his preferred role when registering, enabling or disabling certain functionality.

#### Role authentication
Authentication for roles is done through custom middleware. Middleware is registered in the Kernel, after which it is implemented in the web.php file. Through this implementation, users will automatically be redirected in case the user is not authorised to visit a certain URL. Certain navigation is also disabled inside of the front-end, depending on the user role.

### Search & filtering
Search and filtering functionality is currently implemented in the book edition catalogue page. Here it is possible to filter on author, book, and search through the book edition table based on input and 'where like' SQL functionality. 

### Validation
Validation through the ability to perform certain functionality after a certain amount of actions, is implemented inside of the user profile page. In case the logged in user is a user and has created 5 book / book edition records, the user has the ability to apply for the editor role. With this, a boolean value is set to 'true', indicating that the user has signed up. Currently there is no further implementation of functionality regarding this value

### OWASP Top 10
There are a couple of ways in which the framework / application complies with the OWASP Top 10 defined in 2021:

#### A01:2021-Broken Access Control
Through the added middleware, the application tackles the problem of access control. Certain users are automatically redirected when attempting to navigate to certain URL's. Adding or modifying crucial application information, like authors, on which the rest is built, is shielded against. The same is the case for private information, like user study trajectories

#### A02:2021-Cryptographic Failures
A part of this category is realised through the hashing of passwords when users register an account inside of the application

#### A03:2021-Injection
Through Eloquent ORM, Laravel shields against SQL injection by automatically escaping user input, preventing any possibility for attack. The same is also realised through the use of form input validation inside of controller methods.

#### A04:2021-Insecure Design
Through Laravel, there are a number of secure design patterns that prevent th

#### A05:2021-Security Misconfiguration
Although security misconfiguration is a broad spectrum, Laravel does have its ways in which it prevents this. For example the out of the box authentication and authorisation functionality included with Laravel. The Eloquent ORM also serves as a out of the box way of securing the application.

#### A06:2021-Vulnerable and Outdated Components
Through the use of artisan and npm, outdated libraries and components can be updated to minimate security risks. Warnings regarding insecure libraries or versions are also given through the terminal when using these managers.

#### A07:2021-Identification and Authentication Failures
Similar to broken access control, this category is tackled through the use of middleware. By specifying authorisation rules inside of the middleware, you create a seperation of concern and a general centralised control for your entire application. With this, you also handle authorisation before harmful requests can be made in the application lifecycle.

#### A08:2021-Software and Data Integrity Failures
This category of the OWASP Top 10 has less to do with code infrastructure and more with validation of application design by the developer himself. In this project, this is realised through source control protocols, like: branches with corresponding issues, and pull requests with informative descriptions. With this, made assumptions by the developer are validated for the developer himself and (possibly) the rest of the team.

#### A09:2021-Security Logging and Monitoring Failures
Inside of VirtueVerse, there is an active attempt at retrieving exception information by wrapping code around try / catch blocks, and logging stack traces inside of the internal Laravel logging folder. In this way, the application can be monitored effectively

#### A10:2021-Server-Side Request Forgery
Although there isn't much custom code implemented to tackle this category, the subject of external HTTP(S) calls is tackled through the use of the Laravel HTTP library, which has some built-in features for securely handling requests. When rolling out an application for production, further measures can also be taken to whitelist certain requests and to make sure not all remotes are allowed. This can be done through CORS.

## Deploying the application
If the application would have to be deployed to a live development server, the following actions would have to be taken:


### Configuration

#### 1. Environment File

Ensure your `.env` file is correctly configured for the production environment. Update the following settings:

- `APP_ENV`: Set to `production`.
- `APP_DEBUG`: Set to `false` to disable debugging.
- `APP_KEY`: Generate a new application key using `php artisan key:generate`.

#### 2. Database Configuration

Update the database settings in the `.env` file with your production database credentials:

- `DB_CONNECTION`: Use the appropriate database connection (e.g., `mysql` or `pgsql).
- `DB_HOST`: Set the database host.
- `DB_PORT`: Specify the database port.
- `DB_DATABASE`: Name of your production database.
- `DB_USERNAME`: Production database username.
- `DB_PASSWORD`: Production database password.

#### 3. Folder Permissions

Make sure the `storage` and `bootstrap/cache` folders have proper write permissions:

```shell
chmod -R 775 storage bootstrap/cache
```

### Deployment

#### 1. Clone Repository

Clone your Laravel project's codebase from your Git repository onto the production server.

```shell
git clone your_project_repository.git
```

#### 2. Install Composer Dependencies

Install Composer dependencies:

```shell
composer install --no-dev --optimize-autoloader
```

#### 3. Set Up Web Server

Configure your web server (e.g., Apache, Nginx) to point to the `public` directory of your Laravel project.

#### 4. Run Database Migrations

Run Laravel database migrations to set up your database tables:

```shell
php artisan migrate --force
```

#### 5. Domain Setup

Ensure your domain or subdomain points to your server's IP address.

#### 6. Secure Your Application

- Implement HTTPS using SSL certificates.
- Set up a firewall or security measures to protect your application.

#### 7. Monitor and Maintain

Regularly monitor your application's performance and security. Ensure you keep Laravel and server software up-to-date.

---
