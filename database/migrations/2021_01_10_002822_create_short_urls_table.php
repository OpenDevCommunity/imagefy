<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShortUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_urls', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('image_id')->nullable();
            $table->text('original_url');
            $table->uuid('short_url_hash');
            $table->string('name', 50);
            $table->timestamp('expiries_at')->nullable();
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
        Schema::dropIfExists('short_urls');
    }
}
