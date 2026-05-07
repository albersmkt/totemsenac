<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE actions MODIFY status ENUM('pending','draft','published','archived') DEFAULT 'draft'");
        DB::statement("ALTER TABLE events MODIFY status ENUM('pending','draft','published','archived') DEFAULT 'draft'");
    }

    public function down(): void
    {
        DB::table('actions')->where('status', 'pending')->update(['status' => 'draft']);
        DB::table('events')->where('status', 'pending')->update(['status' => 'draft']);

        DB::statement("ALTER TABLE actions MODIFY status ENUM('draft','published','archived') DEFAULT 'draft'");
        DB::statement("ALTER TABLE events MODIFY status ENUM('draft','published','archived') DEFAULT 'draft'");
    }
};
