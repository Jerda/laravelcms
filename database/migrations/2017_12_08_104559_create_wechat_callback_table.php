<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatcallbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_callback', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->comment('消息类型');
            $table->string('key_word')->comment('关键字');
            $table->string('title')->comment('标题');
            $table->string('content')->comment('内容');
            $table->string('no_normal_content')->nullable()->comment('受限回复');
            $table->string('img')->nullable()->comment('图片');
            $table->string('link')->nullable()->comment('链接');
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
        Schema::dropIfExists('wechatcallback');
    }
}
