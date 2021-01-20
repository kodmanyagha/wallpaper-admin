## Form Manager

Create and update forms, share it and export answers to excel.

### Features
- ~~Create form.~~ (Form designer not finished yet, you must add forms to database)
- Export answers to Excel.
- Select date when exporting.
- Send e-mail to admin when a form filled.

<div align="center"><strong>Admin panel screen</strong></div>

![](https://image.nixarsoft.com/di/KNE9/Screen_Shot_2021-01-15_at_10.png)

<div align="center"><strong>Example forms</strong></div>

![](https://image.nixarsoft.com/di/RKRJ/Screen_Shot_2021-01-15_at_10.png)
![](https://image.nixarsoft.com/di/DJRM/Screen_Shot_2021-01-15_at_10.png)

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



