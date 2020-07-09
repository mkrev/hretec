<?php

use Illuminate\Database\Seeder;

class IdeologiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ideologies = ['konserwatyzm', 'liberalizm'];

        foreach ($ideologies as $val) {
            DB::table('ideologies')->insert([
                'name' => $val,
            ]);
        }
    }
}
