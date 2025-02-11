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
            //1 migration dans bd role et age
            $table->boolean('role')->default(0);
            $table->integer('age')->nullable();
            $table->after('email', function (Blueprint $table) {
                $table->string('email')->unique()->change();
            });
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //1
            $table->dropColumn(['role', 'age']);
        });
    }
};
