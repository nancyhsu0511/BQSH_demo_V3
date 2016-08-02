<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->integer('sequence')->after('description');
            $table->integer('score')->after('sequence');
        });
        // Schema::table('lessons', function (Blueprint $table) {
			// DB::statement('ALTER TABLE `lessons` CHANGE `teacher_id` `course_id` INT(10) UNSIGNED NOT NULL;');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            //
        });
    }
}
