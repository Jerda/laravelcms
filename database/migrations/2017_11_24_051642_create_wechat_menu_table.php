<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('菜单名');
            $table->tinyInteger('parent_id')->comment('父菜单ID');
            $table->string('key')->nullable()->comment('微信KEY');
            $table->string('url')->nullable()->comment('URL');
            $table->string('key_word')->nullable()->comment('关键字');
            $table->string('type')->comment('类型');
            $table->string('sort_id')->comment('排序号');
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
        Schema::dropIfExists('wechat_menu');
    }
}
