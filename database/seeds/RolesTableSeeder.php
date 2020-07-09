<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['user', 'premium', 'moderator', 'admin'];

        foreach ($roles as $val) {
            DB::table('roles')->insert([
                'name' => $val,
            ]);
        }
    }
}
