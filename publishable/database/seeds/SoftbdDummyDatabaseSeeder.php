<?php

use Illuminate\Database\Seeder;
use SBD\Softbd\Traits\Seedable;

class SoftbdDummyDatabaseSeeder extends Seeder
{
    use Seedable;

    protected $seedersPath = __DIR__.'/';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seed('CategoriesTableSeeder');
        $this->seed('UsersTableSeeder');
        $this->seed('PostsTableSeeder');
        $this->seed('PagesTableSeeder');
        $this->seed('SettingsTableSeeder');
        $this->seed('TranslationsTableSeeder');
    }
}
