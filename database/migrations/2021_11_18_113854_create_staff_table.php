<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
			$table->integer('staff_id');
			$table->string('name');
			$table->integer('age');
	        $table->string('club');
	        $table->string('job');
			$table->string('speciality');
			$table->integer('youth');
			$table->integer('keeper');
			$table->integer('mark');
			$table->integer('discipline');
			$table->integer('potential');
			$table->integer('management');
			$table->integer('ability');
			$table->integer('motivation');
			$table->float('employee_potential');
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
        Schema::dropIfExists('staff');
    }
}
