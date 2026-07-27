<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE entrepreneurs MODIFY category ENUM('sobremesa','salgado','ambos','salgados_doces','servicos')");
        }

        DB::table('entrepreneurs')
            ->where('category', 'ambos')
            ->update(['category' => 'salgados_doces']);

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE entrepreneurs MODIFY category ENUM('sobremesa','salgado','salgados_doces','servicos')");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE entrepreneurs MODIFY category ENUM('sobremesa','salgado','ambos','salgados_doces','servicos')");
        }

        DB::table('entrepreneurs')
            ->where('category', 'salgados_doces')
            ->update(['category' => 'ambos']);

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE entrepreneurs MODIFY category ENUM('sobremesa','salgado','ambos','servicos')");
        }
    }
};
