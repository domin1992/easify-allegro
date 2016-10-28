<?php

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
          'email' => 'test@test.com',
          'password' => bcrypt('test123'),
          'activation' => 'Ds79VmlsuktjJcITAQv7qCGrRRLJ0FyE',
          'activated' => 1,
          'admin' => 1,
      ]);
    }
}
