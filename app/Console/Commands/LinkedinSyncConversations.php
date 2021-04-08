<?php

namespace App\Console\Commands;


use App\Http\Repositories\LinkedinConversationRepository;
use App\Http\Repositories\UserRepository;
use App\Linkedin\Responses\Response;
use Illuminate\Console\Command;
use App\Linkedin\Api;

class LinkedinSyncConversations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LinkedinSyncConversations';

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
     * @return int
     */
    public function handle()
    {
        foreach ((new UserRepository())->getLinkedinCredentialsFilledUsers() as $user) {

            try {

                $response = Api::conversation($user->linkedin_login, $user->linkedin_password)->getConversations();

                if ($response['success']) {
                    (new LinkedinConversationRepository())->updateOrCreateCollection(Response::conversations($response, $user->linkedin_entityUrn), $user->id);
                }

            }catch (\Exception $exception){
                $this->error($exception->getMessage());
                continue;
            }
        }

        return 1;
    }
}
