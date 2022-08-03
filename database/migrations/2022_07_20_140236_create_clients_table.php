<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // profile_pic
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('fullname');  //fullname
            $table->string('username');  //username
            $table->string('email')->unique()->nullable();
            $table->string('phone_no',15)->unique()->nullable();
            $table->string('password');
            $table->text('address')->nullable();
            $table->unsignedInteger('region_id')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('profile_pic')->nullable();
            $table->boolean('verified')->nullable()->comment('null = non-verified and 1 = verified'); 
            $table->string('temp_code',15)->nullable()->comment('for reset password');
            $table->boolean('forgot')->nullable()->comment('null = not forgot and 1 = forgot'); 
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
        Schema::dropIfExists('clients');
    }
}
