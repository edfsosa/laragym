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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female'])->nullable()->after('password');
            $table->string('document_number')->unique()->nullable()->after('gender');
            $table->date('birth_date')->nullable()->after('document_number');
            $table->string('phone', 20)->nullable()->after('birth_date');
            $table->string('address')->nullable()->after('phone');
            $table->string('city')->nullable()->after('address');
            $table->string('avatar')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'document_number',
                'birth_date',
                'phone',
                'address',
                'city',
                'avatar'
            ]);
        });
    }
};
