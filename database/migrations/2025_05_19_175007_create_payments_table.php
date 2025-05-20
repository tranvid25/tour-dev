<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('order_code');//vnp_TxnRef
            $table->integer('amount');//tnp_Amount(đơn vị:Vnd)
            $table->string('bank_code')->nullable();
            $table->String('transaction_no')->nullable();
            $table->string('response_code');//vnResponse_code
            $table->string('transaction_status');//vnp_transactionStatus
            $table->string('order_info')->nullable();//vnpOrderInfo
            $table->string('pay_date')->nullable();//vnp_PAYdATE;
            $table->ipAddress('ip_address')->nullable();//vnp_IPadrr
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
