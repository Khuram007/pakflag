<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->integer('client_invoice_id')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('rate')->nullable();
            $table->string('weight')->nullable();
            $table->string('delivered_form')->nullable();
            $table->string('type')->nullable();
            $table->integer('amount')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('client_invoice_items');
    }
}
