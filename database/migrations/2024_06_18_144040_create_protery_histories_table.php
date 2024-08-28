<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProteryHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protery_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('scheme_id');
            $table->bigInteger('property_id');
            $table->bigInteger('action_by');
            $table->text('action')->nullable();
            $table->timestamps();
            $table->foreign('scheme_id')->references('id')->on('tbl_scheme')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('tbl_property')->onDelete('cascade');
            $table->foreign('action_by')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('protery_histories');
    }
}
