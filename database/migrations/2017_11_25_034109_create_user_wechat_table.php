<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWechatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wechat', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();

            /*----微信----*/
            $table->string('openid')->nullable()->comment('微信OPENID');
            $table->string('nickname')->nullable()->commnet('昵称');
//            $table->json('wechat_info')->nullable()->comment('微信详情');
            $table->text('avatar')->nullable()->comment('头像');
            $table->string('qrcode')->nullable()->commment('个人二维码');
//            $table->string('wechat_username')->nullable()->comment('微信名');
            $table->tinyInteger('sex')->nullable()->comment('姓名');
            $table->string('country')->nullable()->comment('国家');
            $table->string('province')->nullable()->comment('省份');
            $table->string('city')->nullable()->comment('城市');
            $table->timestamp('subscribe_time')->nullable()->comment('用户关注公众号时间');
            $table->text('wechat_remark')->nullable()->comment('用户备注');
            $table->tinyInteger('groupid')->nullable()->comment('用户所在的分组ID');
            $table->string('tagid_list')->nullable()->comment('用户被打上的标签ID列表');
            /*-----------*/

            /*--项目特殊需求字段--*/
            /*------------------*/
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_wechat');
    }
}
