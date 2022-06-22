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
        Schema::create('menu_menu_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('menu_id')->references('id')->on('menus')->cascadeOnDelete();
            $table->foreignId('menu_item_id')->references('id')->on('menu_items')->cascadeOnDelete();

            $table->foreignId('parent_id')->nullable()->references('id')->on('menu_menu_items')->cascadeOnDelete();
            $table->smallInteger('order');

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
        Schema::dropIfExists('menu_menu_items');
    }
};
