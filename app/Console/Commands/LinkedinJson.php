<?php

namespace App\Console\Commands;


use App\Http\Repositories\UserRepository;
use Illuminate\Console\Command;
use App\Linkedin\Api;
use Illuminate\Support\Facades\File;

class LinkedinJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LinkedinJson';

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

        $array = [];

        foreach ((new UserRepository())->getLinkedinCredentialsFilledUsers() as $user) {
            array_push($array, [
                'login' => $user->linkedin_login,
                'entityUrn' => $user->linkedin_entityUrn,
            ]);
        }

        File::put(storage_path('linkedin/linkedin_users.json'),json_encode($array));

        return 1;
    }

}
