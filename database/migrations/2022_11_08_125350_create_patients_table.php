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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->enum('sex', ['laki-laki', 'perempuan']);
            $table->foreignId('education_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('id_card_address');
            $table->string('id_number', 16)->unique();
            $table->foreignId('religion_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('residence_address');
            $table->foreignId('district_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('phone', 20);
            $table->enum('marital_status', ['menikah', 'belum menikah', 'janda/duda']);
            $table->boolean('has_job');
            $table->string('workplace')->nullable()->default(null);
            $table->string('work_address')->nullable()->default(null);
            $table->integer('dependent');
            $table->string('mother_name', 64);
            $table->string('father_name', 64);
            $table->string('guardian_phone', 20);
            $table->string('guardian_address');
            $table->foreignId('emergency_contact_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->unique();
            $table->timestamp('start_treatment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
