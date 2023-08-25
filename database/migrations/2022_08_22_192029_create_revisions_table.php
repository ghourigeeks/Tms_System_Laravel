<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revisions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('order_id')->unique();
            $table->enum('revisions',array('1 Revision', '2 Revision', '3 Revision', '4 Revision', '5 Revision', '6 Revision', '7 Revision','8 Revision','9 Revision','10 Revision'))->nullable();
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->enum('complete',array('Completed','Incompleted'))->nullable()->default('Incompleted');
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
        Schema::dropIfExists('revisions');
    }
}
