<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    private $table = 'users';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table($this->table)->delete();
        DB::table($this->table)->insert([
                [
                    'name' => 'Bharat Bhushan',
                    'email' => 'to.bharatbhushan@gmail.com',
                    'password' => bcrypt('secret'),
                ],
                [
                    'name' => 'Ahmet Salt',
                    'email' => 'ahmet.salt@useinsider.com',
                    'password' => bcrypt('secret'),
                ]
            ]
        );
    }
}
