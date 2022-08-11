<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('box_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('box_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('qty');
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
        Schema::dropIfExists('box_products');
    }
}
