<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('wallet_id');
            $table->unsignedBigInteger('category_id');

            $table->unsignedBigInteger('invoice_of')->nullable();
            $table->string('description');
            $table->string('type');
            $table->decimal('value',10,2);
            $table->string('currency')->nullable();
            $table->date('due_at');
            $table->string('repeat_when');
            $table->string('period');
            $table->unsignedInteger('enrollments')->nullable();
            $table->unsignedInteger('enrollment_of')->nullable();
            $table->string('status')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
