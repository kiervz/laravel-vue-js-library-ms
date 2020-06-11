<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();

        $adminRole = Role::where('name', 'Admin')->first();

        $admin = User::create([
            'firstname' => 'Kiervey',
            'middlename' => 'Pogi',
            'lastname' => 'Maghanoy',
            'contact_no' => '09888899999',
            'username' => 'kiervs',
            'gender' => 'Male',
            'birthday' => '1998-10-24',
            'email' => 'kierveymaghanoy24@gmail.com',
            'password' => Hash::make('password'),
            'status' => '1',
            'user_image' => 'profile.jpg',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $admin->roles()->attach($adminRole);
    }
}
