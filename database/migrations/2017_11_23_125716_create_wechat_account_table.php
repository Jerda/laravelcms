<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_account', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('公众号名称');
            $table->string('wechat_id')->default('')->comment('微信号');
            $table->string('init_wechat_id')->default('')->comment('微信号原始ID');
            $table->string('app_id')->default('')->comment('AppID');
            $table->string('app_secret')->default('')->comment('应用密匙');
            $table->string('api')->default('')->comment('API地址');
            $table->string('token')->default('')->comment('TOKEN');
            $table->string('encoding_aes_key')->default('')->comment('消息加解密密钥');
            $table->string('auth_file')->default('')->comment('授权文件');
            $table->string('qr_code')->default('')->comment('二维码');
            $table->string('attention')->default('')->comment('关注连接');
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
        Schema::dropIfExists('wechat_account');
    }
}
