<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentTypeColumnToPaymentsTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_type', ['Pix', 'Cartão de Crédito', 'Cartão de Débito', 'Dinheiro'])
                ->nullable()
                ->after('description');
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payment_type');
        });
    }
}
