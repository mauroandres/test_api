<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */

     public function run() 
     {
         DB::table('users')->insert([
            'name'  => 'user_1',
            'email' => 'user_1@email.com',
            'image' => 'http://someurl.com/images',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
         ]);
         DB::table('users')->insert([
            'name'  => 'user_2',
            'email' => 'user_2@email.com',
            'image' => 'http://someurl.com/images',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
         ]);
    }
}