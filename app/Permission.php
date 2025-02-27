<?php

namespace App;

class Permission extends \Spatie\Permission\Models\Permission
{

    public static function defaultPermissions()
    {
        return [
            'view_users',
            'add_users',
            'edit_users',
            'delete_users',

            'view_roles',
            'add_roles',
            'edit_roles',
            'delete_roles',

            'view_holidays',
            'add_holidays',
            'edit_holidays',
            'delete_holidays',

            'view_working_hours',
            'add_working_hours',
            'edit_working_hours',
            'delete_working_hours',

            'view_reports',
            'add_reports',
            'edit_reports',
            'delete_reports',

            'view_forget_login',
            'add_forget_login',
            'edit_forget_login',
            'delete_forget_login',

            'view_request_time_off',
            'add_request_time_off',
            'edit_request_time_off',
            'delete_request_time_off',

            'view_departments',
            'add_departments',
            'edit_departments',
            'delete_departments',
        ];
    }
}
