<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->unique();
            $table->enum('tb_health_facility', ['RSD DR. SOEBANDI JEMBER', 'RS PARU JEMBER']);
            $table->foreignId('satellite_health_facility_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignId('user_id') 
                ->nullable()
                ->constrained() 
                ->nullOnDelete();
            $table->string('no_regis', 16)->unique();
            $table->foreignId('patient_status_id')
                ->default(2)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('age');
            $table->integer('weight');
            $table->integer('height');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_details');
    }
};
