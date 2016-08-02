<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('teacher_id')->unsigned()->index();
            $table->integer('subject_id')->unsigned()->index();
			$table->string('course_code', 6);
            $table->enum('category', ['觀念', '練習', '批次上傳練習題']);
            $table->string('course_name', 255);
            $table->text('description');
            $table->string('video_embed', 255);
            $table->string('attached_doc', 150);
            $table->string('attached_pdf', 150);
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
        Schema::drop('courses');
    }
}
