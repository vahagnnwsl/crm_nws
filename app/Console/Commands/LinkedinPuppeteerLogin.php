<?php

namespace App\Console\Commands;


use App\Http\Repositories\UserRepository;
use App\Linkedin\Helper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Nesk\Puphpeteer\Puppeteer;

class LinkedinPuppeteerLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LinkedinPuppeteerLogin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @var string
     */
    protected string $username_selector = 'username';

    /**
     * @var string
     */
    protected string $password_selector = 'password';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $users =  (new UserRepository())->getLinkedinCredentialsFilledUsers();

        foreach ($users as $user) {
            try {

                $browser = (new Puppeteer)->launch();

                $page = $browser->newPage();

                $page->goto('https://www.linkedin.com/login', [
                    'timeout' => 90000
                ]);

                $email = $page->querySelector('[id="' . $this->username_selector . '"]');

                $email->type($user->linkedin_login);

                $password = $page->querySelector('[id="' . $this->password_selector . '"]');

                $password->type($user->linkedin_password);

                $page->querySelector('button[type=submit')->click();

                $page->waitForNavigation();

                $cookies = $page->cookies();

                $filtered = [];

                foreach ($cookies as $item){
                    $filtered[$item['name']]=str_replace('"', '', $item['value']);
                }

                $cookie = [
                    'str' =>  Helper::cookieToString(collect($filtered)),
                    'crfToken'=> $filtered['JSESSIONID']
                ];

                File::put(storage_path('linkedin/cookies/' . $user->linkedin_login . '.json'), json_encode($cookie));

                $page->screenshot(['path' => public_path($user->linkedin_login . '.png')]);

                $browser->close();
            }catch (\Exception $exception){
                 $this->error($exception->getMessage().'   '.$user->linkedin_login);
            }
        }


        return 1;
    }

}
