<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrsRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trs_records', function (Blueprint $table) {
            $table->uuid('idrecord')->primary();
            $table->string('idproject', 64);
            $table->string('idduration', 64);
            $table->string('durationname', 10);
            $table->integer('duration');
            $table->bigInteger('iduser');
            $table->string('note', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trs_records');
    }
}
