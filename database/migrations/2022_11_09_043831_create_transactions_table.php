<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id')->nullable();
            $table->string('title');
            $table->date('date');
            $table->string('reference')->nullable();
            $table->text('note')->nullable();
            $table->integer('method')->comment('1 = Cash / 2 = Bank');
            $table->tinyInteger('transaction_type')->comment('0 = Initial Balance , 1 = Withdraw / 2 = Deposit / 3 = Income / 4 = Given Payment / 5 = Expense / 6 =  Fund-Transfer (Cash-In) / 7 =  Fund-Transfer (Cash-Out) / 8 = Cash-In');
            $table->string('cheque_number')->nullable();
            $table->tinyInteger('type')->comment('1= Debit / 2= Credit');
            $table->double('amount');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
