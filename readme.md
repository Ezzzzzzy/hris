# Human Resources Information System

## File Structure

The following shows the file structure of the project at a glance, so you know where to go and where to put your codes.

```
peopleserve-hris
├── app/			#contains Classes, Controllers, Middlewares
│
├── bootstrap/		
│
├── config/			#laravel configurations
│
├── database/		
│   ├── factories/      #for building the faker models
│   ├── migrations/     #all db structure changes
│   └── seeds         	#seeding the db with fakers
│
├── public/    		#where bundles and final assets are generated
│
├── resources/    	#front-end codes
│   │
│   ├── assets/js/		#boilerplate repos and frameworks ready for cloning
│   │    ├── common/        
│   │    ├── components/    #react components
│   │    ├── constants/     #variables used throughout including action types
│   │    ├── middleware/    #redux's middleware
│   │    ├── pages/         #page composed of components
│   │    └── reducers/      #redux's actions and reducers
│   │    
│   ├── assets/sass/	#sass files
│   │    
│   ├── lang/en/       
│   └── views/			#laravel's html files
│
├── routes/    		#laravel's routers
│
├── storage/    	#check logs here
│
├── tests/    		#client's webtasks / lambda codebases
│   ├── Features/      	#boilerplate repos and frameworks ready for cloning
│   └── Unit/         	#unit test cases
```

## Cloning the Repository

1. Beside the repository name, click and copy the clone URL (HTTPS).
2. Open your terminal.
3. Change the current working directory to the location where you want the cloned directory to be made.
4. Type `git clone`, and then paste the URL you copied in Step 2.
5. Press Enter. Your local clone will be created.

## Installing Dependencies

1. Run the following commands on Git CMD or Other Command Shells (Run within the project's folder):
    - `composer install` - To install required composer dependencies
    - `npm install` - To install the default Laravel packages
    - `npm run dev` - To run all Laravel Mix tasks
2. Access XAMPP or other cross-platform web servers (WAMP, MAMP, EasyPHP etc).
3. Start your local server's Apache and MySQL services.

## Getting Started

### Environment
1. Run `php -r "file_exists('.env') || copy('.env.example', '.env')";` on the command shell to copy the existing `.env.example` file within the project folder. Fill in the fresh `.env` copy with your own configurations.
2. Generate a new APP_KEY via `php artisan key:generate` artisan command.

### Database

1. Create a new database with `phpMyAdmin`. Use `hris` for your database name.
2. Open the command shell
3. Type `php artisan migrate --seed` and hit enter to activate the artisan command.
4. This will migrate the database tables and it will make the database accessible through `localhost/phpMyAdmin`.

### Usage

1. After *migrating*, execute a separate command shell within the project folder.
2. Generate a new APP_KEY via `php artisan key:generate` artisan command.
3. Run `php artisan serve` on your command shell, just make sure you're within the directory of your local repository.
4. Open any modern browsers (Chrome, Firefox, Edge etc) and access the application by typing `http://localhost:8000` on your address bar.

### Note to Contributors

#### General

* If you're new to Git or just in need of a reference for this project, please see our official standard [documentation](https://bitbucket.org/botbrosai/brocode/src/master/version-control/).
* In addition, you can navigate to the General section of version-control to check for Git naming conventions.
* Always pull the latest commit from the remote repository before pushing your own changes to avoid merge conflicts.
* For Laravel standards and conventions. Please see [*Development Rules and Guidelines (Laravel)*](https://drive.google.com/file/d/1Ddxsk8CoMSmheWcdhYEfzLEWi3OFue7j/view) and [Laravel Practices Presentation](https://drive.google.com/file/d/1HyJO-bPpzMiObCJpTLd4syhzQCNnbzbk/view).
* Check for `[NPM]` and `[COMP]` tags. If a commit has one or both of these tags, execute `npm run dev` and/or `composer install` commands on your shell to install and/or compile assets.

#### Pull Request and Code Review

* Before attempting to merge a feature to a live branch. Please see our documentation about [`Pull Requests`](https://bitbucket.org/botbrosai/brocode/src/master/version-control/pull-requests.md).
* For code review standards, check [this](https://bitbucket.org/botbrosai/brocode/src/master/version-control/code-review.md) before diving into action.