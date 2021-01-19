<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToApiKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_keys', function (Blueprint $table) {
            $table->boolean('blocked')->default(false);
            $table->boolean('enabled')->default(true);
            $table->boolean('logs_enabled')->default(true);
            $table->string('allowed_origin')->default('*');
            $table->boolean('can_read')->default(true);
            $table->boolean('can_write')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_keys', function (Blueprint $table) {
            //
        });
    }
}
