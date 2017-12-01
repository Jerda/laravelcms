<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*
|--------------------------------------------------------------------------
| 获取验证码
|--------------------------------------------------------------------------
*/
Route::get('captcha/{config?}', function(\Mews\Captcha\Captcha $captcha, $config = 'default') {
    return $captcha->create($config);
});

Route::any('wechat/serve', 'Admin\Wechat\WechatController@actionServer');

Route::any('test', function() {
    $res = \Carbon\Carbon::createFromFormat('Y-m-d', '2017-11-10')->modify('-1 days')->toDateString();
    dd($res);
});

/*
|--------------------------------------------------------------------------
| 后台管理系统路由
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login');
    Route::get('/register', 'Auth\RegisterController@showRegistrationForm');
    Route::post('/register', 'Auth\RegisterController@register');
    /**
     * 登录后，后台管理系统路由
     */
    Route::group(['middleware' => 'admin'], function() {
        Route::get('/logout', 'Auth\LogoutController@logout');
        Route::get('index', 'IndexController@index');
        /**
         * 微信路由
         */
        Route::group(['prefix' => 'wechat'], function() {
            Route::get('/config', 'Wechat\ConfigController@index');
            Route::post('/config/set', 'Wechat\ConfigController@set');
            Route::post('/config/get', 'Wechat\ConfigController@get');
            Route::get('/menu', 'Wechat\MenuController@index');
            Route::get('/menu/add', 'Wechat\MenuController@showAdd');
            Route::post('/menu/add', 'Wechat\MenuController@actionAdd');
            Route::post('/menu/getMenus', 'Wechat\MenuController@getMenus');
            Route::post('/menu/modifySortId', 'Wechat\MenuController@actionModifySortId');
            Route::get('/menu/showModify/{id}', 'Wechat\MenuController@showAdd');
            Route::post('/menu/del', 'Wechat\MenuController@actionDel');
            Route::post('/menu/issue', 'Wechat\MenuController@issueMenus');
            Route::post('/menu/getLevelOnes', 'Wechat\MenuController@getLevelOnes');
        });
        /**
         * 用户管理
         */
        Route::group(['prefix' => 'user'], function() {
            Route::get('/index', 'User\WechatUserController@index');
            Route::post('/getUsers', 'User\WechatUserController@getUsers');
            /**
             * 微信用户
             */
            Route::group(['prefix' => 'user_wechat'], function() {
                Route::post('/synchronize_user', 'User\WechatUserController@synchronizeUsers');
                Route::get('/group', 'User\WechatUserController@showGroup');
                Route::post('/synchronize_user_group', 'User\WechatUserController@synchronizeUserGroups');
                Route::post('/add_user_group', 'User\WechatUserController@addUserGroup');
                Route::post('/modify_user_group', 'User\WechatUserController@modifyUserGroup');
                Route::get('/detail', 'User\WechatUserController@showUserDetail');
            });
        });
        /**
         * 系统设置
         */
        Route::group(['prefix' => 'system'], function() {
            /**
             * 权限管理
             */
            Route::group(['prefix' => 'permission'], function() {
                Route::get('/index', 'System\PermissionController@index');
                Route::get('/add', 'System\PermissionController@showAdd');
                Route::post('/add', 'System\PermissionController@actionAdd');
                Route::post('/getAll', 'System\PermissionController@getPermissions');
                Route::post('/getPermissions', 'System\PermissionController@getPermissionByParentId');
                Route::post('/del', 'System\PermissionController@del');
            });
            /**
             * 角色管理
             */
            Route::group(['prefix' => 'role'], function() {
                Route::get('/index', 'System\RoleController@index');
                Route::get('/add', 'System\RoleController@showAdd');
                Route::post('/add', 'System\RoleController@actionAdd');
                Route::post('/getAll', 'System\RoleController@getRoles');
            });
            Route::group(['prefix' => 'admin'], function() {
                Route::get('/index', 'System\AdminController@index');
                Route::post('/getAll', 'System\AdminController@getAll');
            });
        });
    });
});

