<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTriggerEqualsReportDate extends Migration //TRIGGER PARA IMPEDIR QUE DUAS RESERVAS IGUAIS SEJAM CRIADAS.
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE TRIGGER trg_equals_reportdate BEFORE INSERT ON reservas FOR EACH ROW
            BEGIN
                IF( EXISTS( SELECT *FROM reservas WHERE reportdate = new.reportdate AND local_targ = new.local_targ)) 
                THEN
                SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = 'erro';
                END IF;
            END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER trg_equals_reportdate');
    }
}
