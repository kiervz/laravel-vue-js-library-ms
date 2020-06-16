<?php

use App\RoleBorrower;
use Illuminate\Database\Seeder;

class RolesBorrowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoleBorrower::truncate();

        RoleBorrower::create(['name' => 'Student']);
        RoleBorrower::create(['name' => 'Faculty']);
    }
}
