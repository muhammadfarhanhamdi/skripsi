<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('transactions', 'paid_amount')) {
                $table->decimal('paid_amount', 10, 2)->nullable()->after('payment_method');
            }
            if (! Schema::hasColumn('transactions', 'change_amount')) {
                $table->decimal('change_amount', 10, 2)->nullable()->after('paid_amount');
            }
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'change_amount')) {
                $table->dropColumn('change_amount');
            }
            if (Schema::hasColumn('transactions', 'paid_amount')) {
                $table->dropColumn('paid_amount');
            }
        });
    }
};
