<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('public_id');
            $table->string('plot_public_id');
            $table->integer('payment_mode');
            $table->string('adhar_card');
            $table->string('cheque_photo');
            $table->string('pan_card');
            $table->string('pan_card_image');
            $table->string('attachment');
            $table->string('owner_name');
            $table->string('contact_no');
            $table->integer('booking_status');
            $table->string('address');
            $table->string('description');
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
        Schema::dropIfExists('customers');
    }
}
