<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSanasaGeneralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanasa_generals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('slpost_ref');
            $table->string('vehicle_number',12);
            $table->string('vehicle_type');
            $table->string('chassis_no',35);
            $table->string('salutation',4);
            $table->string('name');
            $table->String('current_owner');
            $table->string('nic',12);
            $table->string('mobile_number',10);
            $table->text('address');
            $table->Date('valid_from');
            $table->Date('valid_to');
            $table->float('premium', 8, 2);
            $table->enum('status', ['PENDING', 'DOWNLOAD','CANCELLED']);
            $table->string('post_office',5);
            $table->bigInteger('download_id')->nullable();
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
        Schema::dropIfExists('sanasa_generals');
    }



}