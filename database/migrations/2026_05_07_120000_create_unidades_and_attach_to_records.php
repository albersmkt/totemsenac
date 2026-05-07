<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150)->unique();
            $table->string('cidade', 120);
            $table->timestamps();
        });

        DB::table('unidades')->insert([
            [
                'nome' => 'Senac Registro',
                'cidade' => 'Registro',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Senac Sorocaba',
                'cidade' => 'Sorocaba',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Senac Lapa Tito',
                'cidade' => 'São Paulo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $registroId = (int) DB::table('unidades')
            ->where('nome', 'Senac Registro')
            ->value('id');

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('unidade_id')
                ->nullable()
                ->after('photo')
                ->constrained('unidades')
                ->nullOnDelete();
        });

        Schema::table('actions', function (Blueprint $table) {
            $table->foreignId('unidade_id')
                ->nullable()
                ->after('created_by')
                ->constrained('unidades')
                ->nullOnDelete();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('unidade_id')
                ->nullable()
                ->after('created_by')
                ->constrained('unidades')
                ->nullOnDelete();
        });

        Schema::table('integrator_projects', function (Blueprint $table) {
            $table->foreignId('unidade_id')
                ->nullable()
                ->after('created_by')
                ->constrained('unidades')
                ->nullOnDelete();
        });

        Schema::table('entrepreneurs', function (Blueprint $table) {
            $table->foreignId('unidade_id')
                ->nullable()
                ->after('created_by')
                ->constrained('unidades')
                ->nullOnDelete();
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->foreignId('unidade_id')
                ->nullable()
                ->after('slug')
                ->constrained('unidades')
                ->nullOnDelete();
        });

        DB::table('users')->whereNull('unidade_id')->update(['unidade_id' => $registroId]);
        DB::table('actions')->whereNull('unidade_id')->update(['unidade_id' => $registroId]);
        DB::table('events')->whereNull('unidade_id')->update(['unidade_id' => $registroId]);
        DB::table('integrator_projects')->whereNull('unidade_id')->update(['unidade_id' => $registroId]);
        DB::table('entrepreneurs')->whereNull('unidade_id')->update(['unidade_id' => $registroId]);
        DB::table('areas')->whereNull('unidade_id')->update(['unidade_id' => $registroId]);

        Schema::table('areas', function (Blueprint $table) {
            $table->dropUnique('areas_name_unique');
            $table->dropUnique('areas_slug_unique');
            $table->unique(['unidade_id', 'name'], 'areas_unidade_name_unique');
            $table->unique(['unidade_id', 'slug'], 'areas_unidade_slug_unique');
        });

        $baseAreas = DB::table('areas')
            ->where('unidade_id', $registroId)
            ->select(['name', 'slug', 'created_at', 'updated_at'])
            ->get();

        $otherUnitIds = DB::table('unidades')
            ->where('id', '!=', $registroId)
            ->pluck('id');

        foreach ($otherUnitIds as $unitId) {
            foreach ($baseAreas as $area) {
                DB::table('areas')->updateOrInsert(
                    ['unidade_id' => $unitId, 'slug' => $area->slug],
                    [
                        'name' => $area->name,
                        'created_at' => $area->created_at ?? now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->dropUnique('areas_unidade_name_unique');
            $table->dropUnique('areas_unidade_slug_unique');
        });

        DB::statement('DELETE a1 FROM areas a1 INNER JOIN areas a2 WHERE a1.id > a2.id AND a1.slug = a2.slug');

        Schema::table('areas', function (Blueprint $table) {
            $table->unique('name', 'areas_name_unique');
            $table->unique('slug', 'areas_slug_unique');
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('unidade_id');
        });

        Schema::table('entrepreneurs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('unidade_id');
        });

        Schema::table('integrator_projects', function (Blueprint $table) {
            $table->dropConstrainedForeignId('unidade_id');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropConstrainedForeignId('unidade_id');
        });

        Schema::table('actions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('unidade_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('unidade_id');
        });

        Schema::dropIfExists('unidades');
    }
};
