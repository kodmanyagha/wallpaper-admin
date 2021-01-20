## Wallpaper Admin Panel adn API

This app requesting Pexels API and storing them to database. And it is
exposing these images via API.

### Features
- Built with Laravel 8, Mysql.
- There is a Job for requesting and storing Pexels API.
- There is API endpoint for mobile app.
- Admin panel can manage everything.

<div align="center"><strong>Admin panel screen</strong></div>

![](https://image.nixarsoft.com/di/KNE9/Screen_Shot_2021-01-15_at_10.png)

## Installation

```
git clone https://github.com/kodmanyagha/FormManager.git
composer install
cp .env.example .env
php artisan key:generate
nano .env 
```

Set database and e-mail settings in here and save it. After that you can login to admin panel, create forms, share forms and get reports. If you want to receive answers via e-mail you must execute the queue. And don't forget to add inform email to `forms.feedback_email` table column. 

```
php artisan queue:work
```

You can use the `startqueue.sh` file for automatically start at server restart.

## Customization

You can change logo in `storage/app/public/form/assets/img/logo.png` and `logo.gif` files. `logo.png` file is using in frontend, `logo.gif` file is usin in e-mail template.

Have a nice day.

