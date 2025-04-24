<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customerlists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('scheme_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('owner_name');
            $table->string('contact_no')->nullable();
            $table->integer('booking_status')->default(2);
            $table->string('adhar_card_number'); 
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->foreign('scheme_id')->references('id')->on('tbl_scheme')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customerlists');
    }
}
