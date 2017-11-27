<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            /**
             * 该表只保留基本字段，其他字段，请填写在user_detail表中
             * '其他字段'不包括特殊的关联字段
             */
            $table->increments('id');
            $table->string('username')->unique()->nullable()->comment('用户名');
            $table->string('email')->unique()->nullable()->comment('邮箱');
            $table->string('mobile')->nullable()->comment('手机号');
            $table->string('password')->nullable();
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->string('name')->nullable()->comment('姓名');

            /*--可选字段--*/
            $table->string('user_num')->nullable()->comment('会员编号');
            $table->tinyInteger('type')->default(0)->comment('用户类型');
            $table->string('idcard_num')->nullable()->comment('身份证号码');
            $table->text('idcard_img')->nullable()->comment('身份证照片');
            $table->string('QQ')->nullable()->comment('QQ号');
            $table->string('remark')->nullable()->comment('备注');
            /*-----------*/

            /*-- 特殊关联字段 --*/

            /*----------------*/
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
