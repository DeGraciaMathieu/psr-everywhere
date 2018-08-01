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
            $table->increments('id');
            $table->string('username')->nullable();
            $table->string('repository')->nullable();
            $table->string('url');
            $table->string('hash')->nullable();
            $table->string('default_branch')->nullable();
            $table->timestamp('prepared_at')->nullable();
            $table->timestamp('standardised_at')->nullable();
            $table->timestamp('suggested_at')->nullable();
            $table->timestamp('cleaned_at')->nullable();
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
