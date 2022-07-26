<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('amount')->default(0)->comment('package subcription amount');
            $table->unsignedInteger('box_limit')->default(0)->comment('limit to create box');
            $table->unsignedInteger('inventory_limit')->default(0)->comment('limit to create inventory');
            $table->boolean('add_to_mp')->comment('mp = marketplace null = false and 1 = true'); 
            $table->boolean('ibeacon')->comment('assign ibeacon null = false and 1 = true'); 
            $table->boolean('barcode')->comment('generate barcode null = false and 1 = true'); 
            $table->boolean('qrcode')->comment('generate qrcode null = false and 1 = true'); 
            $table->boolean('active')->default(1)->comment('null = inactive and 1 = active'); 
            $table->unsignedInteger('created_by');
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
        Schema::dropIfExists('packages');
    }
}
