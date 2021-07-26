### Weather APP
## Requirement
* npm version 12
* php 7.3 and above

##Assumption things that are not scoped in this project
* This application assumes that this is a public api and therefore any authentication is not required.
* Rate limiting will not be handled and will not be considered as part of the scope of this project
* Frontend CDN is not required to host any of the frontend files
* HTTPS is not required for this project.
* All unit types are in metric
* Hardcoded cities
* I have hardcoded the api in the codebase. I know this is not correct and should be provided via SSM or .env file, or
generated when we build the codebase.

To start
-
Run the following commands to start the backend server
```shell script
composer install
php artisan serve
```

Run the following command to build the frontend
```shell script
npm install
npm run dev
```

Access the API via the following URL
```
http://localhost:8000/api/weather?city=brisbane

or

http://localhost:8000/api/weather?city=brisbane&useMock=true [optional use mock flag if you hit api limit]
```

To access the frontend
```
http://localhost:8000/weather.html
```

Run the following command to execute the bash script
```shell script
 php artisan weather:fetch accuweather brisbane
```
You can also pass in an option `--verbose` to show any errors if the command errors out.

If you have hit the API limit, you can always use the following option to use a mock version of the response.
```shell script
 php artisan weather:fetch accuweather brisbane --useMock
```

##Improvements
There are a few improvements that can be made to the frontend
- Adding Icons to show the different weather types
- Adding more cities to the drop down list and load it via ajax instead of populating it via a flat file / memory
- General styles

## Limitations
As I am using the free version of accuweather api, there is a limit of 50 calls per day
- It calls city api to fetch a key from accuweather
- The key will be used to fetch the 5 days forecast.


