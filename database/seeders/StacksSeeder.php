<?php

namespace Database\Seeders;

use App\Http\Repositories\RoleRepository;
use App\Models\Stack;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class StacksSeeder extends Seeder
{

    /**
     * @var string[]
     */
    protected $stacks = [
        "PHP",
        "Javascript",
        "Java",
        "Python",
        "Css",
        "Html",
        "Bootstrap",
        "MaterialCSS",
        "ReactJS",
        "VueJS",
        "Angular",
        "AngularJS",
        "JQuery",
        "Laravel",
        "Yii2",
        "CodeIgniter",
        "NodeJS",
        "Django",
        "Flask",
        "Spring"
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        foreach ($this->stacks as $stack) {
            Stack::create([
                'name' => $stack
            ]);
        }

    }
}

