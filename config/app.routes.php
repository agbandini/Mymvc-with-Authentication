<?php
return array(
    'routes' => [
        'GET' => [
            '' => 'App\Controllers\MainController@mainPage',
            'login' => 'App\Controllers\AuthController@login',
            'lostpassword' => 'App\Controllers\AuthController@lostPassword',
            'logout' => 'App\Controllers\AuthController@logout',
            'users' => 'App\Controllers\UsersController@users',
            'users/new' => 'App\Controllers\UsersController@newUser',
            'users/:userid/edit' => 'App\Controllers\UsersController@editUser',
            'groups' => 'App\Controllers\UsersController@groups',
            'groups/new' => 'App\Controllers\UsersController@newGroup',
            'groups/:groupid/edit' => 'App\Controllers\UsersController@editGroup',
            'lostpassword' => 'App\Controllers\AuthController@lostPassword',
            //'posts' => 'App\Controllers\PostController@getPosts',
            //'post/create' => 'App\Controllers\PostController@create',
            //'post/:id' => 'App\Controllers\PostController@show',
            //'post/:postid/edit' => 'App\Controllers\PostController@edit',

        ],
        'POST' => [
            'login/dologin' => 'App\Controllers\AuthController@dologin',
            'login/pwdremind' => 'App\Controllers\AuthController@passwordRemind',
            'users/save' => 'App\Controllers\UsersController@save',
            'groups/save' => 'App\Controllers\UsersController@saveGroup',
            //'post/:id/store' => 'App\Controllers\PostController@store',
            'users/:id/store' => 'App\Controllers\UsersController@store',
            'groups/:id/store' => 'App\Controllers\UsersController@storeGroup',
            //'post/:id/delete' => 'App\Controllers\PostController@delete',
            //'post/:id/comment' => 'App\Controllers\PostController@saveComment',
            
            // chiamate ajax
            'users/all' => 'App\Controllers\AjaxController@allUsers',   
            'users/:id/delete' => 'App\Controllers\AjaxController@userDelete',
            'groups/all' => 'App\Controllers\AjaxController@allGroups',   
        ]
    ]
);
