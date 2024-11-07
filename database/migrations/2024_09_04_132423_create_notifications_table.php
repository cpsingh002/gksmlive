<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('scheme_id');
            $table->bigInteger('property_id');
            $table->bigInteger('action_by');
            $table->bigInteger('msg_to');
            $table->string('action');
            $table->text('msg')->nullable();
            $table->timestamps();
            $table->foreign('scheme_id')->references('id')->on('tbl_scheme')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('tbl_property')->onDelete('cascade');
            $table->foreign('action_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('msg_to')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
