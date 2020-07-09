<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(EconomiesTableSeeder::class);
        $this->call(IdeologiesTableSeeder::class);
        $this->call(PartiesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(QuestsTableSeeder::class);
        
    }
}
