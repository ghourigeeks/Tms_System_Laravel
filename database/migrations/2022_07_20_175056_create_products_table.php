<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id');
            $table->string('name');
            $table->unsignedInteger('price');
            $table->string('color',25)->nullable()->comment('color code');
            $table->unsignedInteger('qty')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('category_id')->comment('categories table');
            $table->unsignedInteger('sub_category_id')->comment('sub-categories table');
            $table->string('qrcode',25)->nullable();
            $table->string('barcode',25)->nullable();
            $table->string('lat',25)->nullable();
            $table->string('lng',25)->nullable();
            $table->boolean('added_to_mp')->nullable()->default(0)->comment('mp = marketplace null = false and 1 = true'); 
            $table->boolean('active')->nullable()->default(1)->comment('null = inactive and 1 = active'); 
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
