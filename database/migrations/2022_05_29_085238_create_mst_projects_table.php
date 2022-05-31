<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMstProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_projects', function (Blueprint $table) {
            $table->uuid('idproject')->primary();
            $table->string('projectname', 32);
            $table->string('description', 225)->nullable;
            $table->float('rateperhour')->nullable;
            $table->dateTime('since_at')->nullable;
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
        Schema::dropIfExists('mst_projects');
    }
}
