<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['siswa', 'guru'])->default('siswa');
            $table->enum('kelas', ['X', 'XI', 'XII'])->nullable();
            $table->enum('jurusan', ['AKL', 'TKJ', 'BiD', 'OTKP', 'RPL', 'MM'])->nullable();
            $table->string('nisn', 20)->nullable();
            $table->string('phone', 15)->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 
                'kelas', 
                'jurusan', 
                'nisn', 
                'phone', 
                'bio', 
                'avatar'
            ]);
        });
    }
};