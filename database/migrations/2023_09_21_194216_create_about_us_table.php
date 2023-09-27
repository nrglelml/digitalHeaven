<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();

            $table->text('text_1_icon')->nullable();
            $table->string('text_1_title')->nullable();
            $table->text('text_1_content')->nullable();

            $table->text('text_2_icon')->nullable();
            $table->string('text_2_title')->nullable();
            $table->text('text_2_content')->nullable();

            $table->text('text_3_icon')->nullable();
            $table->string('text_3_title')->nullable();
            $table->text('text_3_content')->nullable();
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
        Schema::dropIfExists('about_us');
    }
};
