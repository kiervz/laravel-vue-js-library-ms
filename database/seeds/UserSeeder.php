<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'user_type_id' => '1',
            'firstname' => 'Kiervey',
            'middlename' => 'Pogi',
            'lastname' => 'Maghanoy',
            'contact_no' => '09888899999',
            'username' => 'kiervs',
            'gender' => 'Male',
            'birthday' => '1998-10-24',
            'email' => 'kierveymaghanoy24@gmail.com',
            'password' => '$2y$10$iA7.jLQZWtfgj1.kebQncujzdQ0cb9cOiDqpAdWDOSd27ikN2t57q',
            'status' => '1',
            'user_image' => 'profile.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
