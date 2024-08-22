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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();                       // название оффера
            $table->smallInteger('cpc');                             // cost per click
            $table->string('url_')->unique();                        // url оффера
            $table->boolean('is_actived')->default(true);           // отключение оффера рекламодателем
            // $table->unsignedBigInteger('topic_id')->nullable();
            // $table->foreign('topic_id')                             // тема оффера
            // ->references('id')
            // ->on('topics')                                         // ->cascadeOnDelete()??
            // ->onDelete('cascade');

            $table->foreignId('topic_id')                           // тема offera
            ->references('id')
            ->on('topics')                                         // ->cascadeOnDelete()??
            ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
