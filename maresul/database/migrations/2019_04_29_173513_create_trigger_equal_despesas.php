<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTriggerEqualDespesas extends Migration //TRIGGER PARA IMPEDIR QUE DUAS RESERVAS IGUAIS SEJAM CRIADAS.
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE TRIGGER trg_equals_desp BEFORE INSERT ON despesas FOR EACH ROW
            BEGIN
                IF( EXISTS( SELECT *FROM despesas
                    WHERE DATE_FORMAT(reportdate, '%y-%m') = DATE_FORMAT(new.reportdate, '%y-%m'))) THEN
                    SIGNAL SQLSTATE '02000' SET MESSAGE_TEXT = 'erroo';
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
        DB::unprepared('DROP TRIGGER trg_equals_desp');
    }
}
