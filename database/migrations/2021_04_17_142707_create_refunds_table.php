<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');

            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();

            $table->integer('amount');

            $table->bigInteger('refID');

            $table->longText('card_number');
            $table->longText('iban');

            $table->text('description')->nullable();

            $table->boolean('seen')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refunds');
    }
}
