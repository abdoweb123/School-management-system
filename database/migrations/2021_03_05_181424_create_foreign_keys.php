<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('Classrooms', function(Blueprint $table) {
			$table->foreign('Grade_id')->references('id')->on('Grades')
						->onDelete('cascade');
		});

        Schema::table('sections', function(Blueprint $table) {
            $table->foreign('Grade_id')->references('id')->on('Grades')
                ->onDelete('cascade');
        });

//        Schema::table('sections', function(Blueprint $table) {
//            $table->foreign('Class_id')->references('id')->on('Classrooms')
//                ->onDelete('cascade');
//        });

        Schema::table('my__parents', function(Blueprint $table) {
            $table->foreign('Nationality_Father_id')->references('id')->on('nationalities')->onDelete('cascade');
            $table->foreign('Blood_Type_Father_id')->references('id')->on('type__bloods')->onDelete('cascade');
            $table->foreign('Religion_Father_id')->references('id')->on('religions')->onDelete('cascade');
            $table->foreign('Nationality_Mother_id')->references('id')->on('nationalities')->onDelete('cascade');
            $table->foreign('Blood_Type_Mother_id')->references('id')->on('type__bloods')->onDelete('cascade');
            $table->foreign('Religion_Mother_id')->references('id')->on('religions')->onDelete('cascade');
        });

        Schema::table('parent_attachments', function(Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('my__parents')->onDelete('cascade');
        });

	}

	public function down()
	{
		Schema::table('Classrooms', function(Blueprint $table) {
			$table->dropForeign('Classrooms_Grade_id_foreign');
		});
        Schema::table('sections', function(Blueprint $table) {
            $table->dropForeign('sections_Grade_id_foreign');
        });
        Schema::table('sections', function(Blueprint $table) {
            $table->dropForeign('sections_Class_id_foreign');
        });
	}
}
