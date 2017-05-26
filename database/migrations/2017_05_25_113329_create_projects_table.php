<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
  /**
  * Run the migrations.
  *
  * @return void
  */
  public function up()
  {
    Schema::create('projects', function (Blueprint $table) {
      $table->increments('projectid');
      $table->string('projectname');
      $table->string('projectrepo');
      $table->string('projectkey');
      $table->string('organization');
      $table->string('token');
      $table->integer('version');
      $table->string('encode');
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
    Schema::dropIfExists('projects');
  }
}
