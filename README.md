### **Activity log**

This is an open source laravel project that you can use to monitor whatever post activity a user create on your project <br>
it saves the user
* device
* platform
* browser
* IP address
* user auth id
* user auth email
* user activity

in your laravel project run:
`php artisan make:model ActivityLog -m` <br>
this will create 2 files
1. ActivityLog.php in your app folder 
2. activity log migration file in your database/migration folder
