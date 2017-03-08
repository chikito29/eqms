<?php

use Illuminate\Database\Seeder;
use App\RevisionLog;

class RevisionLogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $revision_logs = array(
          array('revision_number' => 'NSCPI-QM-001-8','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Corrective and Preventive Action Report Form','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2016-01-27 06:59:38','updated_at' => '2016-01-27 06:59:38','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-QM-002-2','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Assessment Letter to Suppliers','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:05:38','updated_at' => '2015-07-10 22:05:38','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-QM-003-2','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Quality Questionaire','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:06:30','updated_at' => '2015-07-10 22:06:30','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-QM-004-6','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Document Revision Log','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:07:18','updated_at' => '2015-07-10 22:07:18','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-QM-005-2','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Internal Quality Audit Plan','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:08:06','updated_at' => '2015-07-10 22:08:06','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-QM-006-7','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Revision Request Form','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:08:58','updated_at' => '2015-07-10 22:08:58','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-QM-007-3','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Internal Quality Checklist','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:09:53','updated_at' => '2015-07-10 22:09:53','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-QM-008-2','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'IQA Schedule','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:11:12','updated_at' => '2015-07-10 22:11:12','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-QM-009-2','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Internal Quality Audit Notice','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:12:05','updated_at' => '2015-07-10 22:12:05','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-QM-009-2','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Internal Quality Result','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:14:44','updated_at' => '2015-07-10 22:14:44','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-TRNG-011-0','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Trainee\'s Appeal Form','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2016-06-08 22:18:08','updated_at' => '2016-06-08 22:18:08','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-QM-012-2','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Notice of MR Meeting','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:19:03','updated_at' => '2015-07-10 22:19:03','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-QM-013-2','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'MR Attendance Sheet','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:20:07','updated_at' => '2015-07-10 22:20:07','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-QM-014-7','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Minutes of the MR Meeting','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:21:06','updated_at' => '2015-07-10 22:21:06','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-TRNG-015-1','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'NEWSIM Waiver','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:21:47','updated_at' => '2015-07-10 22:21:47','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-HR-016-1','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Teaching Demo Evaluation Form','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:02:50','updated_at' => '2015-07-10 22:02:50','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-FNA-017-03','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Official Receipt','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:03:51','updated_at' => '2015-07-10 22:03:51','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-FNA-019-0','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Petty Cash Voucher','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:04:24','updated_at' => '2015-07-10 22:04:24','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-FNA-020-2','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Issuance Slip','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:04:50','updated_at' => '2015-07-10 22:04:50','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-FNA-021-3','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Office Forms Inventory Report','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:06:08','updated_at' => '2015-07-10 22:06:08','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-FNA-022-5','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Purchase Order','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:07:07','updated_at' => '2015-07-10 22:07:07','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-FNA-023-5','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Invoice Billing Statement','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:07:39','updated_at' => '2015-07-10 22:07:39','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-HR-024-2','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Cash Advance Form','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:08:17','updated_at' => '2015-07-10 22:08:17','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-FNA-025-3','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Request For Payment','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 22:08:58','updated_at' => '2015-07-10 22:08:58','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-ACCTNG-026-1','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Mobile Phone Billing','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2014-04-12 22:09:47','updated_at' => '2014-04-12 22:09:47','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-MKTG-027-4','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Training Fees','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2016-05-10 22:10:38','updated_at' => '2016-05-10 22:10:38','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-HR-028-1','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Field Report Form','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2014-04-25 22:11:24','updated_at' => '2014-04-25 22:11:24','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-HR-029-4','manual_reference' => 'QUALITY PROCEDURES','description' => 'Application For Leave','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2017-01-27 22:53:46','updated_at' => '2017-01-27 22:53:46','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-HR-030-4','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Familiarization Checklist','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2016-10-12 22:56:05','updated_at' => '2016-10-12 22:56:05','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-HR-031-0','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Interview Evaluation Sheet','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2016-06-08 22:56:44','updated_at' => '2016-06-08 22:56:44','deleted_at' => NULL),
          array('revision_number' => 'NSCPI-FNA-032-5','manual_reference' => 'QP 02: CONTROL OF QUALITY RECORDS','description' => 'Maintenance Report(Standard)','approved_by' => 'CEO','encoded_by' => 'Esme de Guzman Jr','created_at' => '2015-07-10 23:02:21','updated_at' => '2015-07-10 23:02:21','deleted_at' => NULL)
        );

        foreach ($revision_logs as $revision_log) {
            RevisionLog::create($revision_log);
        }
    }
}
