<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('integrator_projects', function (Blueprint $table) {
            $table->text('member_names')->nullable()->after('class_group');
        });
    }

    public function down(): void
    {
        Schema::table('integrator_projects', function (Blueprint $table) {
            $table->dropColumn('member_names');
        });
    }
};
