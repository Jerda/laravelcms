<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatUserGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_user_group', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('group_id')->comment('分组ID');
            $table->string('name')->comment('分组名称');
            $table->tinyInteger('count')->default(0)->comment('用户总数');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_user_group');
    }
}
