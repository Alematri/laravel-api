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
        Schema::table('projects', function (Blueprint $table) {
            // creo la colonna della FK
            $table->unsignedBigInteger('technology_id')->nullable()->after('id');

            // assegno la FK alla colonna creata
            $table->foreign('technology_id')
                ->references('id')
                ->on('technologies')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // elimino la FK (metto il nome della colonna in un array)
            $table->dropForeign(['technology_id']);

            // elimino la colonna della FK
            $table->dropColumn('technology_id');
        });
    }
};
