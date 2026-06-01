<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Users Table
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('nim');
            $table->string('study_program')->nullable()->after('phone_number');
            $table->text('address')->nullable()->after('study_program');
        });

        // 2. Books Table
        Schema::table('books', function (Blueprint $table) {
            $table->integer('publish_year')->nullable()->after('isbn');
            $table->string('shelf_location')->nullable()->after('publish_year');
        });

        // 3. Loans Table
        Schema::table('loans', function (Blueprint $table) {
            $table->foreignId('processed_by')->nullable()->after('status')->constrained('users')->onDelete('set null');
            $table->text('condition_notes')->nullable()->after('processed_by');
        });

        // 4. Fines Table
        Schema::table('fines', function (Blueprint $table) {
            $table->integer('days_late')->default(0)->after('amount');
            $table->string('payment_method')->nullable()->after('payment_status');
            $table->date('payment_date')->nullable()->after('payment_method');
        });
    }

    public function down(): void
    {
        // 1. Fines Table
        Schema::table('fines', function (Blueprint $table) {
            $table->dropColumn(['days_late', 'payment_method', 'payment_date']);
        });

        // 2. Loans Table
        Schema::table('loans', function (Blueprint $table) {
            $table->dropForeign(['processed_by']);
            $table->dropColumn(['processed_by', 'condition_notes']);
        });

        // 3. Books Table
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['publish_year', 'shelf_location']);
        });

        // 4. Users Table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'study_program', 'address']);
        });
    }
};
