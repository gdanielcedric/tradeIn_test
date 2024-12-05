## Technical Guide
## A.	Repository :
https://github.com/gdanielcedric/tradeIn_test.git 

## B.	Project architecture :
t_api : laravel backend project
t_frontend : vueJs frontend project

## C.	Running :
0-	Prerequis
-	To have phpmyadmin install on your device
-	To have nodeJs install on your device

1-	Running databse
Create database

2-	Running backend
From base project :
a-	cd t_api
b-	update .env file with created database information
c-	php artisan migrate
d-	php artisan app:import-json-feed
e-	php artisan serve --host=0.0.0.0 --port=8000

3-	Running frontend
From base project :
a-	cd t_frontend
b-	npm install
c-	npm run serve
