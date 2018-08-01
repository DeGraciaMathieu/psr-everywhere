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
        $project = new \App\Project;
        $project->name = 'PsrBot/Test';
        $project->url = 'https://github.com/PsrBot/Test.git';
        $project->save();
    }
}
