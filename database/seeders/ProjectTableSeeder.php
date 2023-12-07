<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\project;
use App\Models\technology;
use App\Functions\Helper;

class projectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 100; $i++){
            $new_project = new project();
            // associo randomicamente una categoria al project
            $new_project->technology_id = technology::inRandomOrder()->first()->id;
            $new_project->title = $faker->sentence();
            $new_project->slug = Helper::generateSlug($new_project->title, project::class);
            $new_project->text = $faker->paragraph();
            $new_project->date = $faker->date();
            $new_project->save();
        }
    }
}
