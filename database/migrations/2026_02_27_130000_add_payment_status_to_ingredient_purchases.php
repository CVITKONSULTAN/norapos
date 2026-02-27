<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaymentStatusToIngredientPurchases extends Migration
{
    public function up()
    {
        Schema::table('ingredient_purchases', function (Blueprint $table) {
            $table->enum('payment_status', ['paid', 'partial', 'unpaid'])->default('unpaid')->after('status');
            $table->decimal('total_amount', 22, 4)->default(0)->after('payment_status');
            $table->decimal('paid_amount', 22, 4)->default(0)->after('total_amount');
        });
    }

    public function down()
    {
        Schema::table('ingredient_purchases', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'total_amount', 'paid_amount']);
        });
    }
}
