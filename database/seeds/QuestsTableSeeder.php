<?php

use Illuminate\Database\Seeder;

class QuestsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quests = [
            [
                'name' => "Pierwszy komentarz",
                'key' => 'first_comment',
                'points' => 1
            ],
            [
                'name' => "Setny komentarz",
                'key' => 'hundredth_comment',
                'points' => 100
            ],
            [
                'name' => "Tysięczny komentarz",
                'key' => 'thousandth_comment',
                'points' => 1000
            ],
        ];

        foreach ($quests as $quest) {
            DB::table('quests')->insert($quest);
        }
    }
}
