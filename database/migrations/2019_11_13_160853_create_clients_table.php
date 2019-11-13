<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password');
			$table->string('phone')->nullable();
			$table->string('address')->nullable();
			$table->string('city')->nullable();
			$table->string('country')->nullable();
			$table->string('zipcode')->nullable();
			$table->string('branch')->nullable();
			$table->string('profile')->nullable();
			$table->integer('branch_id')->nullable();
			$table->integer('country_id')->nullable();
			$table->string('start_day')->nullable();
			$table->string('end_day')->nullable();
			$table->string('show_on')->nullable();
			$table->boolean('status')->nullable();
			$table->boolean('active')->nullable();
			$table->string('verifyToken')->nullable();
			$table->string('activation_token')->nullable();
			$table->rememberToken();
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
