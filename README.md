
## About Calorie

Calorie is a simple calorie tracking web application that allows users to enter their food entries along with the number of calories for each food entry.

Then they can check if they reached the daily threshold limit of calorie or monthly threshold limit of money spent for food easily.

Users can also filter food entries by date range and they can update / delete their own food entries.

Admin users can see all food entries entered by other users as well as themselves, and manage them (create / update / delete food entries).

### Technical details
#### Backend
The backend API was built with Laravel and MySql.  
On the local environment, you can run the API by running:
```
php artisan serve
```
In order to import some test data to the database, you can execute the following command:
```
php artisan migrate:fresh --seed
```
#### Frontend
The Frontend Web app was built with Vue and BootstrapVue.  
Argon BootstrapVue theme was used for simple and decent UI.  

On the local environment, you can run the web app by running:
```
yarn watch
```
or
```
npm run watch
```

Two short project video files were included for simple explanation for functionalities.