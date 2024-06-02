<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreeningsTable extends Migration
{
    public function up()
    {
        Schema::create('screenings', function (Blueprint $table) {
            $table->id();
            $table->boolean('agreement')->default(false);

            // Identitas Diri
            $table->string('full_name');
            $table->string('nik', 16)->unique();
            $table->string('contact'); 
            $table->string('gender', 10); 
            $table->unsignedSmallInteger('age'); 
            $table->string('address', 100);
            $table->string('district', 50); 
            $table->date('screening_date');

            // Screening Awal
            $table->boolean('cough')->default(false);
            $table->enum('tb_diagnosed', ['a', 'b', 'c']);
            $table->boolean('home_contact')->default(false);
            $table->boolean('close_contact')->default(false);

            // Gejala Lain
            $table->boolean('weight_loss')->default(false);
            $table->boolean('fever')->default(false);
            $table->boolean('breath')->default(false);
            $table->boolean('smoking')->default(false);
            $table->boolean('sluggish')->default(false);
            $table->boolean('sweat')->default(false); 

            // Faktor Risiko
            $table->boolean('ever_treatment')->default(false);
            $table->boolean('elderly')->default(false);
            $table->boolean('pregnant')->default(false);
            $table->boolean('diabetes')->default(false);

            // Kontak
            $table->string('contact1_name', 100); 
            $table->string('contact1_number', 20); 
            $table->string('contact2_name', 100); 
            $table->string('contact2_number', 20);
            $table->string('contact3_name', 100); 
            $table->string('contact3_number', 20); 
            $table->boolean('is_positive')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('screenings');
    }
}

