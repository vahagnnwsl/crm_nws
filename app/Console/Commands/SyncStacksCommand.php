<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Developer;
use App\Models\Stack;
use App\Models\Order;
use Illuminate\Support\Arr;

class SyncStacksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SyncStacksCommand';

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
     */
    public function handle()
    {

        $stacks = Stack::all();

        Developer::all()->each(function ($developer) use ($stacks) {
            $developer->stacks()->sync(
                $stacks->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        Order::all()->each(function ($order) use ($stacks) {
            $order->stacks()->sync(
                $stacks->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        return 0;
    }
}
