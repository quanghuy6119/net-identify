<?php

namespace App\Validation;

class Action{
    public const GET = 'get';
    public const CREATE = 'create';
    public const CREATE_MANY = 'create_many';
    public const CREATE_EACH = 'create_each';
    public const UPDATE = 'update';
    public const UPDATE_MANY = 'update_many';
    public const SEARCH = 'search';
    public const ADD = 'add';
    public const DELETE = 'delete';
    public const FILE_UPLOAD = 'file_upload';
}