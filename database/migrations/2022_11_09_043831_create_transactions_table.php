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
            $table->string('transaction_title');
            $table->date('transaction_date');
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('transaction_purpose')->comment('0 = Initial Balance , 1 = Withdraw / 2 = Deposit / 3 = Revenue / 4 = Given Payment / 5 = Expense / 6 =  Fund-Transfer (Cash-In) / 7 =  Fund-Transfer (Cash-Out) / 8 = Cash-In');
            $table->string('cheque_number')->nullable();
            $table->tinyInteger('transaction_type')->comment('1= Debit / 2= Credit');
            $table->double('amount');
            $table->tinyInteger('status')->default(1)->comment('1 = Active / 0 = Deactivate');
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
