<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('teacher_id')->unsigned()->index();
            $table->enum('category', ['觀念', '練習', '批次上傳練習題']);
            $table->string('topic_name', 255);
            $table->text('description');
            $table->string('video_embed', 255);
            $table->string('attached_doc', 150);
            $table->string('attached_pdf', 150);
            $table->enum('question_type', ['單選題', '填充題', '問答題']);
            $table->timestamps();

			// $table->foreign('teacher_id')
				// ->references('id')->on('users')
				// ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lessons');
    }
}
