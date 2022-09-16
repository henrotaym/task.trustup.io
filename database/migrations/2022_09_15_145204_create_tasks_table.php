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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('title');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->string('app_key')->nullable();
            $table->dateTime('done_at')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->boolean('having_due_date_time')->default(false);
            $table->json('user_ids')->nullable();
            $table->json('options')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
