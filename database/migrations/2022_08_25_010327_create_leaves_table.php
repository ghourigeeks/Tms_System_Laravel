<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('user_email')->nullable();
            $table->unsignedInteger('user_contact')->nullable();
            $table->string('subject')->nullable();
            $table->text('reason')->nullable();
            $table->date('leave_start')->nullable();
            $table->date('leave_end')->nullable();
            $table->enum('pending',array('Approve','Cancel'))->nullable();
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
        Schema::dropIfExists('leaves');
    }
}
