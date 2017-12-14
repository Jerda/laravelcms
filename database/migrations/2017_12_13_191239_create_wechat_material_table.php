<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_material', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->comment('类型');
            $table->string('desc')->nullable()->comment('描述');
            $table->string('path')->nullable()->comment('路径');
            $table->string('media_id');
            $table->string('url')->nullable();
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
        Schema::dropIfExists('wechat_material');
    }
}
