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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('sale_type', ['online', 'pos'])->default('online')->after('user_id');
            $table->string('customer_name')->nullable()->after('sale_type');
            $table->decimal('amount_paid', 15, 2)->nullable()->after('total');
            $table->decimal('change_amount', 15, 2)->nullable()->after('amount_paid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['sale_type', 'customer_name', 'amount_paid', 'change_amount']);
        });
    }
};
