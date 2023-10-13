<?php

namespace Database\Seeders;

use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsLetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = [1,2,3,4,5];

        foreach ($arr as $key => $value) {
            $user = User::all()->random();

            if(Newsletter::where('email', $user->email)->first()){
                Newsletter::factory()->create();
            }else{
                Newsletter::factory()->set('email', $user->email)->create();
            }

        }
    }
}
