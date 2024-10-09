<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('url'); // Link do WhatsApp
            $table->text('descricao'); // Descrição ou título do link
            $table->foreignId('categoria_id')->constrained()->onDelete('cascade'); // Referência à categoria
            $table->foreignId('cidade_id')->constrained()->onDelete('cascade'); // Referência à cidade
            $table->foreignId('bairro_id')->constrained()->onDelete('cascade'); // Referência ao bairro
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
};

