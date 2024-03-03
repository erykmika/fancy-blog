# fancy-blog

## Tech stack used

|             Type             |                            Technology used                           |
| ---------------------------- |----------------------------------------------------------------------|
| Core scripting language      | PHP                                                                  |
| MVC framework                | <a href="https://github.com/codeigniter4/framework">Codeigniter 4</a>|
| Database                     | MySQL                                                                |
| Testing database             | SQLite                                                               |
| Unit testing                 | PHPUnit/Codeigniter testing framework                                |
| View                         | HTML/CSS/Bootstrap 5 CSS library                                     |

## Setup

PHP >= 8.1 is recommended. You must have an instance of the MySQL database and composer installed in order to set up required dependencies.

### Clone the repository and navigate into it
```sh
git clone https://github.com/erykmika/fancy-blog.git
cd ./fancy-blog/
```

### Run 'composer' and install required packages
```sh
composer install
```
This assumes composer is installed **globally** on your machine. If not, refer to this manual <a href="https://getcomposer.org/doc/00-intro.md">https://getcomposer.org/doc/00-intro.md</a>.

### Prepare the database configuration
Prepare the **.env** file. You can create your own one by using the **env** template:
```sh
cp ./env ./.env
```
At least, modify the development database rows according to your MySQL instance setup.

### Run the database migration
Run the database migration script. This will create a proper schema of the database.
```sh
php spark migrate
```

### (Optional) Run the database seeder
Seeding the database will insert sample data into the tables.
```sh
php spark db:seed
> DatabaseSeeder
```

### Start a development server
```sh
php spark serve
```
Now that everything is set up, go to **localhost:8080** in your web browser.

## Accessing the admin dashboard

Go to **localhost:8080/admin/login**. Enter the password **123**. After that you should be able to edit the articles.
