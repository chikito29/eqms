<?php

use Illuminate\Database\Seeder;
use App\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectionsData = [
            ['name' => 'Quality Procedures', 'created_by' => 'Daniel Bajana'],
            ['name' => 'QWI Manual', 'created_by' => 'Daniel Bajana'],
            ['name' => 'Position Description', 'created_by' => 'Daniel Bajana'],
            ['name' => 'QM Procedures', 'created_by' => 'Daniel Bajana']
        ];

        foreach ($sectionsData as $section) {
            App\Section::create($section);
        }
    }
}
