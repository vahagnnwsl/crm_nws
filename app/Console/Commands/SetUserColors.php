<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class SetUserColors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SetUserColors';

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

    protected static $COLORS = [
        'red',
        'blue',
        'green',
        'grey',
        'yellow',
        'orange',
        'brown',
        'pink',
        'purple',

    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $index => $user) {
            $user->color = $this->colors[$index];
            $user->save();
        }

        return 0;
    }
}
