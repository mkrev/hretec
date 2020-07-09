<?php

use Illuminate\Database\Seeder;

class PartiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parties = ['Prawo i Sprawiedliwość' => 'PiS', 'Platforma Obywatelska' => 'PO', 'Polskie Stronnictwo Ludowe' => 'PSL', 'Sojusz Lewicy Demokretycznej' => 'SLD', 'Konfederacja Wolność i Niepodległość' => 'Konfederacja', 'Wiosna' => '', 'Porozumienie' => '', 'Solidarna Polska' => 'SP', 'Nowoczesna' => '.N', 'Lewica Razem' => 'Razem', 'Partia Zieloni' => 'Zieloni', 'Ruch Narodowy' => 'RN', 'Koalicja Odnowy Rzeczypospolitej Wolność i Nadzieja' => 'KORWiN',];

        foreach ($parties as $key => $val) {
            DB::table('parties')->insert([
                'name' => $key,
                'short_name' => $val,
            ]);
        }
    }
}
