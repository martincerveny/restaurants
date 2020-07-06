<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

## Restaurants
This app allows to import attached restaurants-1.csv and restaurants-2.csv. Shows opened restaurants based on opening hours and allows to search among all restaurants.
### How to run
1. Clone repository
2. Make a .env file from .env.example
3. In .env fill credentials (database name to DB_DATABASE key) to empty database
4. Run php artisan key:generate
5. Run php artisan migrate


### How to use
1. Prepare your CSV to project folder
2. Run php artisan import:data
3. Enter name of your CSV without .csv extension

