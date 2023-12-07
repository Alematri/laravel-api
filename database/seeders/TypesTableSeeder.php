<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;
use Illuminate\Support\Str;

class typesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['Front End', 'Back End', 'Design', 'UX', 'Laravel',  'VueJs', 'AngularJs', 'ReactJs'];
        foreach($data as $type){
            $new_type =  new type();
            $new_type->name = $type;
            $new_type->slug = Str::slug($type, '-');
            $new_type->save();
        }
    }
}
