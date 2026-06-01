<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('user')->change();
        });

        DB::statement("UPDATE users SET role = 'admin' WHERE role IN ('admin', 'petugas')");
        DB::statement("UPDATE users SET role = 'user' WHERE role = 'mahasiswa'");
    }

    public function down(): void
    {
        DB::statement("UPDATE users SET role = 'mahasiswa' WHERE role = 'user'");
    }
};
