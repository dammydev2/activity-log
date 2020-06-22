### **Activity log**

This is an open source laravel project that you can use to monitor whatever post activity a user create on your project (The most reputable Laravel package provided for detecting user agent is Agent developed by Jens Segers and its the one I will use. All the information you need to know about user are accessible by using [Agent](https://github.com/jenssegers/agent)) <br>
it saves the user
* device
* platform
* browser
* IP address
* user auth id
* user auth email
* user activity

in your laravel project run:<br>
`composer require jenssegers/agent`<br><br>
Then find the config/app.php and then find **providers array** add:<br><br>
`Jenssegers\Agent\AgentServiceProvider::class,`<br><br>
In the same config/app.php file find the **aliases array** and add:<br>
`'Agent' => Jenssegers\Agent\Facades\Agent::class,`<br>
then run:
<br>
`php artisan make:model ActivityLog -m` <br>
this will create 2 files
1. ActivityLog.php in your app folder 
2. activity log migration file in your database/migration folder (something like `2020_06_21_151755_create_activity_logs_table`)<br><br>
open your **ActivityLog.php** and add the following codes inside the class {...}
`protected $fillable = [
        'device',
        'platform',
        'browser',
        'ip_address',
        'user_id',
        'user_email',
        'user_activity'
    ];`<br><br>
open your migration file in **2 above** and add the following lines inside the schema function after **$table->id();**<br>
            `$table->string('device');`<br>
            `$table->string('platform');`<br>
            `$table->string('browser');`<br>
            `$table->string('ip_address');`<br>
            `$table->string('user_id')->nullable();`<br>
            `$table->string('user_email');`<br>
            `$table->string('user_activity');`<br><br>
if you don't have an authentication scaffold already in your project run: <br>
 `php artisan make:auth` for laravel 5.8 and below<br>
for laravel 6.0 and above run:
`composer require laravel/ui`<br>
`php artisan ui vue --auth`<br><br>
create a folder called "Services" in your app folder and create a file called ActivityService.php (app\services\ActivityServices.php), open your ActivityService.php file and add the following code: <br> <br>

`<?php`<br>

`namespace App\Services;` <br>
`use App\ActivityLog;`<br>
`use Jenssegers\Agent\Agent;`<br>

` class ActivityService`<br>
{<br>
    `protected $activityLog;`<br>
    `public function __construct(`<br>
        `ActivityLog $activityLog`<br>
    ) {<br>
        `$this->activityLog = $activityLog;`<br>
    }

    public function enterActivity($user_activity,$email)
    {
        $agent = new Agent();
        $platform = $agent->platform();
        // Ubuntu, Windows, OS X, ...
        $browser = $agent->browser();
        // Chrome, IE, Safari, Firefox, ...
        $this->activityLog->create([
            'platform' => $agent->version($platform),
            'browser' => $agent->version($browser),
            'device' => $agent->device(),
            'ip_address' => \Request::ip(),
            'user_id' => null,
            'user_email' => $email,
            'user_activity' => $user_activity
        ]);
    }`
`}`<br><br>

run migration in order to create the activity log table in your DB<br><br>
open RegisterController.php and call the Activity service:<br> `use App\Services\ActivityService;`<br>
in your **RegisterController class** add `protected $activityService;`<br>
in your __construct() method add `ActivityService $activityService` and in the __construct() function add `$this->activityService = $activityService;`<br> your __construct() method code should look like<br><br>
`protected $activityService;`<br>
    `public function __construct(ActivityService $activityService)`<br>
    {<br>
        `$this->activityService = $activityService;`<br>
        `$this->middleware('guest');`<br>
    }<br><br>
then add the below code in your create function<br>
        `$user_activity = 'user attempted to login'`;<br>
        `$email = $data['email'];`<br>
        `$this->activityService->enterActivity($user_activity,$email);`<br>
try to register, once you have registered, check the activity log table you will see all the details of the person 
including his IP address, the **$user_activity** can be changed to whatever you like depending on the user activity, The service can be called anywhere in your controller, just remember to include the **$user_activity and $email**

**hope this helps**, I can be reached via damilola.yakubu@yahoo.com<br>
twitter: [https://twitter.com/dammydev](https://twitter.com/dammydev)

Thanks
