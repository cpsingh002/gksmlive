<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaitingListCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waiting_list_customers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('scheme_id');
            $table->bigInteger('plot_no');
            $table->string('user_id');
            $table->bigInteger('waiting_member_id');
            $table->bigInteger('payment_mode')->comment('1-RTGS/IMPS,2-Bank Transfer,3-Cheque');
            $table->string('adhar_card');
            $table->string('adhar_card_number'); 
            $table->string('pan_card');
            $table->string('pan_card_image');
            $table->string('cheque_photo');
            $table->string('attachment');
            $table->string('owner_name');
            $table->bigInteger('booking_status')->comment('2-Booked,3-Hold');
            $table->string('contact_no');
            $table->string('address');
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
        Schema::dropIfExists('waiting_list_customers');
    }
}
