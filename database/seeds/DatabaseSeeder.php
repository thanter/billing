<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $tables = [
        'users',
        'plans',
        'subscriptions',
    ];


    protected $seeders = [
        UsersTableSeeder::class,
        PlansTableSeeder::class,
    ];

    public function run()
    {
        Eloquent::unguard();

        $this->cleanDatabase();

        foreach($this->seeders as $seedClass)
        {
            $this->call($seedClass);
        }
    }


    /*
    * Truncate all rows in db
    */
    public function cleanDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach($this->tables as $table)
        {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
