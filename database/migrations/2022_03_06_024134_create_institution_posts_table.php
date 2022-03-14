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
        Schema::create('institution_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type');
            $table->string('woreda')->nullable();
            $table->string('kebele')->nullable();
            $table->text('description');
            $table->foreignId('zone_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('posted_by')->constrained('admins','id')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('institution_posts');
    }
};
