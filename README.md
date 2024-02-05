# Tasker App

Tasker is a simple & tiny project and task management system built with Laravel Version 10. It has following features:

-   Authentication System.
-   Project Management System.
-   Task Management System.
-

### Authentication System

User need to log in to use tasker app. When user register, he/she needs to verify his account.

### Project Management System

When user logs/registers into an account, user will be redirected to projects page. User can create & delete his own projects.

### Task Management System

User can click on a project and redirected to task page. One project may have multiple tasks. A task can be created, edited or deleted. Tasked can be sorted based on priority. User can toggle between projects to manage tasks of a project.

## Setup instruction

As this one is a zipped version, some of the files & folders are missing to decrease size. First download & extract the folder.

-   create a new file named .env and update the credentials specially
    -   APP_URL
    -   Database credentials
    -   SMTP mail credentials

As this project is using laravel version 10 & latest packages of npm, please use latest server configuration to run. For more details follow [server configuration section](https://laravel.com/docs/10.x/deployment#server-requirements) of laravel doc.

Finally follow the below instructions.

```
cd task-management

# install npm packages
npm install

# For development server run
npm run dev

# For production server run
npm run build

# install composer packages
composer install

# Generate app key
php artisan key:generate

# From terminal run the command to migrate database
php artisan migrate

# To seed user run the following command to avoid manually user registration
php artisan tinker
# Then copy/paste the following command
App\Models\User::factory(5)->create();

# Optionally may need to clear view, cache & route
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:cache
```

Now visit the code in server url ex: task-management.test and make a tour of the project.
