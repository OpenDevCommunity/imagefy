<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_log', function (Blueprint $table) {
            $table->id();
            $table->integer('api_key_id');
            $table->text('origin')->nullable();
            $table->string('method')->nullable();
            $table->text('endpoint')->nullable();
            $table->text('status')->nullable();
            $table->longText('headers')->nullable();
            $table->longText('body')->nullable();
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
        Schema::dropIfExists('api_log');
    }
}
