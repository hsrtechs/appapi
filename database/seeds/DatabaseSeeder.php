<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'Rishabh Jain',
            'username' => 'admin',
            'email' => 'testing@email.com',
            'password' => bcrypt('password')
        ]);

        $this->call('UsersTableSeeder');
        $this->call('OffersTableSeeder');
    }
}
