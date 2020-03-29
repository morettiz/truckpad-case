<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArrivalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrivals', function (Blueprint $table) {
            $table->id();
            $table->string('drivers_name');
            $table->date('birth_date');
            $table->char('gender', 1);
            $table->boolean('is_vehicle_owner')->default(false);
            $table->boolean('is_truck_loaded');
            $table->char('drivers_license_category', 2);
            $table->unsignedInteger('truck_id');
            $table->float('origin_lat', 9, 6);
            $table->float('origin_lng', 9, 6);
            $table->float('destination_lat', 11, 7);
            $table->float('destination_lng', 11, 7);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('truck_id')->references('code')->on('trucks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arrivals');
    }
}
