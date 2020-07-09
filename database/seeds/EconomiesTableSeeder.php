<?php

use Illuminate\Database\Seeder;

class EconomiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $economies = ['kapitalizm', 'socjalizm'];

        foreach ($economies as $val) {
            DB::table('economies')->insert([
                'name' => $val,
            ]);
        }
    }
}
