<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImageTempurlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_tempurls', function (Blueprint $table) {
            $table->id();
            $table->integer('image_id');
            $table->text('share_url');
            $table->timestamp('expiries_at');
            $table->boolean('expiried')->default(false);
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
        Schema::dropIfExists('image_tempurls');
    }
}
