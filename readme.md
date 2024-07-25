## Laravel license

Create licenses for your website

### Installation
````
composer require erjon/laravel_license
````

### Publish files
````
php artisan vendor:publish --tag=license
````

This will create two files in your project
- config/vendor/license/license.php
- views/vendor/license/activate.blade.php

### Migrate
You can migrate if your website uses database
````
php artisan migrate
````

### Add license
````
php artisan license:add ABCD-EFGH-IJKL
````

### Activate the license when you first install the project
### 1. <i>By command line</i>
````
php artisan license:activate ABCD-EFGH-IJKL
````

### 2. <i>Just straight up open the website and insert the license in the form provided.</i>


#### Things to consider
- If you activate the license before connecting to the database, you will be required to provide the license one more time.
- License should be 8 to 30 characters long.
- Someone with enough knowledge of php/laravel or just programming in general can easily copy the existing project.
- License characters allowed are ascii characters from 33 to 122. https://www.ascii-code.com