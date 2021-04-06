<?php

namespace App\Console\Commands;


use App\Http\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Console\Command;
use App\Linkedin\Api;

class LinkedinApiLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LinkedinApiLogin';

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
     * Execute the console command.
     *
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {

        (new UserRepository())->getLinkedinCredentialsFilledUsers()->map(function ($user) {
            return Api::auth($user->linkedin_login,$user->linkedin_password)->login();
        });

        return 1;
    }

}
