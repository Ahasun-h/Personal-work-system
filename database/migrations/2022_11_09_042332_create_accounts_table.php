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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_number');
            $table->string('account_holder_name');
            $table->text('note')->nullable();
            $table->integer('branch_id');
            $table->tinyInteger('is_default')->default(0)->comment('1 = Active / 0 = Deactive');
            $table->tinyInteger('status')->default(1)->comment('1 = Publish / 0 = Unpublish');
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
        Schema::dropIfExists('accounts');
    }
};
