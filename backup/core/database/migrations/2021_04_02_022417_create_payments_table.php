<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('references_code','75');
            $table->foreignId('id_invoice')->constrained('invoices');
            $table->string('method','125');
            $table->double('total_amount');
            $table->double('fee_merchant');
            $table->double('fee_customer');
            $table->double('total_fee');
            $table->double('amount_received');
            $table->string('status',15);
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
