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
        Schema::create('project_type', function (Blueprint $table) {

            // colonna in relazione con projects
            $table->unsignedBigInteger('project_id');
            // creazione FK della colonna project_id
            $table->foreign('project_id')
                    ->references('id')
                    ->on('projects')
                    ->cascadeOnDelete(); // se viene cancellato il project viene eliminata la relazione col type nella tabella posnte

            // colonna in relazione con types
            $table->unsignedBigInteger('type_id');
            // creazione FK della colonna type_id
            $table->foreign('type_id')
                    ->references('id')
                    ->on('types')
                    ->cascadeOnDelete(); // se viene cancellato il type viene eliminato la relazione col nella tabella ponte

            $table->integer('vote')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_type');
    }


};
