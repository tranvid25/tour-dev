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
        Schema::table('tbl_users', function (Blueprint $table) {
            $table->string('otp', 6)->nullable()->after('password');
            $table->boolean('google_logged_in')->default(false)->after('otp');
            $table->tinyInteger('tinh_trang')->default(1)->after('google_logged_in');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_users', function (Blueprint $table) {
            $table->dropColumn(['otp', 'google_logged_in', 'tinh_trang']);
        });
    }
};
