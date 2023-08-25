<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('name')->unique();
            $table->enum('concepts',array('1 Concept', '2 Concept', '3 Concept', '4 Concept', '5 Concept', '6 Concept', '7 Concept','8 Concept','9 Concept','10 Concept'))->nullable();
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('client_id')->nullable();
            $table->enum('logo_type',array('IconBased', 'TextBased', 'Mascot', 'Illustration', 'SemiMascot'))->nullable();
            $table->string('payment')->nullable();
            $table->string('total_payment')->nullable();
            $table->enum('complete',array('Completed','Incompleted'))->nullable()->default('Incompleted');
            $table->enum('final',array('Final','Cancel'))->nullable()->default('Cancel');
            $table->enum('work_from',array('Home','Office'))->nullable();
            $table->boolean('active')->nullable()->default(1)->comment('null = inactive and 1 = active');   
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
