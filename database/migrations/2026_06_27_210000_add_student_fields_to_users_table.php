<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('enrollment_number')->nullable()->unique()->after('is_admin');
            $table->string('class_name')->nullable()->after('enrollment_number');
            $table->enum('enrollment_status', ['active', 'inactive', 'transferred', 'graduated'])->nullable()->after('class_name');
            $table->date('enrollment_started_at')->nullable()->after('enrollment_status');

            $table->index(['is_admin', 'enrollment_status']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['is_admin', 'enrollment_status']);
            $table->dropColumn([
                'phone',
                'enrollment_number',
                'class_name',
                'enrollment_status',
                'enrollment_started_at',
            ]);
        });
    }
};
