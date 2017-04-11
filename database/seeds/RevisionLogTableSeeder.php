<?php

use App\RevisionLog;
use Illuminate\Database\Seeder;

class RevisionLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $document = \App\Document::find(3);

        RevisionLog::unguard();
        RevisionLog::create([
            'date' => '2016-01-27',
            'document_id' => $document->id,
            'manual_reference' => $document->title,
            'description' => 'Corrective and Preventive Action Form',
            'revision_number' => 'NSCPI-QM-001-8',
            'approved_by' => 'CEO',
            'encoded_by' => 'Esmeraldo de Guzman Jr'
        ]);
        RevisionLog::reguard();
    }
}
