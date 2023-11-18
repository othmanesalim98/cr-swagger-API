<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'post' => [
        'title' => 'Post',

        'actions' => [
            'index' => 'Post',
            'create' => 'New Post',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'blog' => [
        'title' => 'Blog',

        'actions' => [
            'index' => 'Blog',
            'create' => 'New Blog',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'teest' => [
        'title' => 'Teest',

        'actions' => [
            'index' => 'Teest',
            'create' => 'New Teest',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'uuid' => 'Uuid',
            'connection' => 'Connection',
            'queue' => 'Queue',
            'payload' => 'Payload',
            'exception' => 'Exception',
            'failed_at' => 'Failed at',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];