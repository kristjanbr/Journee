## How to install the web app

#####  Tested environment / prerequisites:
- PHP 8 (for web app)
- MariaDB (for database, along with phpMyAdmin for easier management)

##### Installation:

- Place the contents of ```/src/``` directory into the desired directory on your web server, such as ```/var/www/html/```.
- Run the SQL code, provided in ```/sql/``` directory on your database.
- In ```/src/static/``` directory you will need to modify file _config.php_, that contains your API key for uploading images to ImgBB, only by changing the field ```your_api_key```.
