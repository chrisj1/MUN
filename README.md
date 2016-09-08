Welcome to the SJP MUN XI portal for this year!
This website uses the laravel framework.

============================================
How to run locally:
1. Create mysql database
2. create a blank schema called mun
2. open the .env file(yes it is called .env)
3a. Either create a mysql user for the database
3b. Change the following lines in the .env to match:
DB_HOST=127.0.0.1 //default
DB_PORT=3306 //default
DB_DATABASE=mun
DB_USERNAME=lar
DB_PASSWORD=password

4. open terminal
5. cd into mun directory
6. run command php artisan migrate
7. run command php artisan serve
8. open browser and goto localhost:8000