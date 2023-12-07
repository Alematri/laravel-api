<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\project;
use App\Models\type;

class projecttypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ad ogni ciclo estraggo random un project e un type e li metto in relazione
        for($i = 0; $i < 50; $i++) {

            // estraggo un project random
            $project = project::inRandomOrder()->first();

            // estraggo l'id del type random
            $type_id = type::inRandomOrder()->first()->id;

            $project->types()->attach($type_id,['vote' => rand(0,10)]);
        }
    }

}
