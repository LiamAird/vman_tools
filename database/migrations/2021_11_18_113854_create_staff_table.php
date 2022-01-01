<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff', static function (Blueprint $table) {
            $table->id();
			$table->integer('staff_id')->unique();
			$table->string('name');
			$table->integer('age');
	        $table->integer('club_id')->nullable();
	        $table->string('club')->nullable();
	        $table->string('job');
	        $table->string('price');
			$table->string('speciality');
			$table->integer('youth');
			$table->integer('keeper');
			$table->integer('mark');
			$table->integer('discipline');
			$table->integer('potential');
			$table->integer('management');
			$table->integer('ability');
			$table->integer('motivation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
}
