<?php

use Illuminate\Database\Seeder;

class PricingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('pricing')->insert([
          'package' => '3 Dokumenty',
          'package_without_accented' => '3 Dokumenty',
          'count' => 3,
          'price' => 2.4,
          'currency' => 'PLN',
      ]);

      DB::table('pricing')->insert([
          'package' => '5 Dokumentów',
          'package_without_accented' => '5 Dokumentow',
          'count' => 5,
          'price' => 3.9,
          'currency' => 'PLN',
      ]);

      DB::table('pricing')->insert([
          'package' => '10 Dokumentów',
          'package_without_accented' => '10 Dokumentow',
          'count' => 10,
          'price' => 7.8,
          'currency' => 'PLN',
      ]);

      DB::table('pricing')->insert([
          'package' => '15 Dokumentów',
          'package_without_accented' => '15 Dokumentow',
          'count' => 15,
          'price' => 11.7,
          'currency' => 'PLN',
      ]);

      DB::table('pricing')->insert([
          'package' => '25 Dokumentów',
          'package_without_accented' => '25 Dokumentow',
          'count' => 25,
          'price' => 19.6,
          'currency' => 'PLN',
      ]);

      DB::table('pricing')->insert([
          'package' => 'Nielimitowane na miesiąc',
          'package_without_accented' => 'Nielimitowane',
          'count' => 0,
          'price' => 29.9,
          'currency' => 'PLN',
      ]);
    }
}
