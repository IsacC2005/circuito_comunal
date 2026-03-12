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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('community_id')->constrained()->onDelete('cascade');
            $table->foreignId('family_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('second_name')->nullable();
            $table->string('first_surname');
            $table->string('second_surname')->nullable();
            $table->integer('cedula')->unique();
            $table->enum('gender', ['masculino', 'femenino', 'otro']);
            $table->date('birth_date');
            $table->enum('relationship', ['jefe de familia', 'conyuge', 'hijo(a)', 'nieto(a)', 'otro']);
            $table->enum('nationality', ['venezolano', 'extranjero']);
            $table->enum('academic_level', ['ninguno', 'primaria', 'secundaria', 'universitaria', 'postgrado']);
            $table->timestamps();
        });

        Schema::table('streets', function (Blueprint $table) {
            $table->foreign('leader_id')->references('id')->on('people')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('streets', function (Blueprint $table) {
            $table->dropForeign(['leader_id']);
        });
        Schema::dropIfExists('people');
    }
};
