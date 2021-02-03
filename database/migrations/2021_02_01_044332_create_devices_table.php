<?php

use Domain\OS;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('u_id', 100);
            $table->string('app_id', 100);
            $table->string('lang', 2);
            $table->enum('os', [OS::GOOGLE_PLATFORM, OS::APPLE_PLATFORM]);
            $table->softDeletes();
            $table->timestamps();
            $table->index(['u_id','app_id', 'os', 'lang']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
