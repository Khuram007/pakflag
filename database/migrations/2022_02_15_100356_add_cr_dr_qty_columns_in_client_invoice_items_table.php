<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCrDrQtyColumnsInClientInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_invoice_items', function (Blueprint $table) {
            $table->integer('qty')->nullable();
            $table->double('credit')->nullable();
            $table->double('debit')->nullable();
            $table->double('balance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_invoice_items', function (Blueprint $table) {
            $table->dropColumn(['qty','credit','debit','balance']);
        });
    }
}
