<?php

namespace App\Services;

class StatusCode
{
    /**
     *  Status Code 9xxx
     */

    /**
     * Standard response for successful HTTP requests.
     */
    public const OK = 9000;
    /**
     * The request was successful and as a result a new resource was created.
     */
    public const CREATED = 9001;
    /**
     * The request was successful and as a result a new resource was updated.
     */
    public const UPDATED = 9002;
    /**
     * The request was successful and as a result a resource specified was deleted.
     */
    public const DELETED = 9003;
    /**
     * The request was successful and as a result a notifications specified was marked.
     */
    public const MARKED = 9004;
    /**
     * The request was successful and as a result a resource specified was added in entity specified.
     */
    public const ADDED = 9005;
    /**
     * The request was successful and a result a resource specified was sended email successfully.
     */
    public const SENDED = 9006;
    /**
     * The request was successful and logout in program , terminate token access.
     */
    public const LOGGED_OUT = 9007;



    /**
     *  Status Code 10xx
     */

    /**
     * Invalid input.
     */
    public const INVALID_INPUT = 1000;



    /**
     *  Status Code 11xx
     */

    /**
     * Invalid token.
     */
    public const INVALID_TOKEN = 1100;
    /**
     * Token is expired.
     */
    public const TOKEN_EXPIRED = 1101;
    /**
     * User is not authenticated.
     */
    public const UNAUTHENTICATED = 1102;
    /**
     * Unauthorized Access.
     */
    public const UNAUTHORIZED = 1103;
    /**
     * Email Does Not Match Email of The Token
     */
    public const INVALID_EMAIL_TOKEN = 1104;
    /**
     * Account is banned
     */
    public const ACCOUNT_IS_BANNED = 1105;

    /**
     *  Status Code 12xx
     */

    /**
     * Record is already existed in program
     */
    public const ALREADY_EXISTED = 1200;


    /**
     *  Status Code 2xxx
     */

    /**
     * No data - Data request is not existed
     */
    public const NOT_FOUND_DATA = 2000;
    /**
     * Route is not existed
     */
    public const NOT_FOUND_ROUTE = 2001;
    /**
     * Null argument - Argument must be set
     */
    public const ARGUMENT_NULL = 2002;




    /**
     *  Status Code 21xx
     */

    /**
     * Internal server error.
     */
    public const INTERNAL_SERVER_ERROR = 2100;
    /**
     * Exception error.
     */
    public const EXCEPTION_ERROR = 2101;
    /**
     * Logic exception error.
     */
    public const LOGIC_EXCEPTION_ERROR = 2102;
    /**
     * Database exception error.
     */
    public const DATABASE_EXCEPTION_ERROR = 2103;
    /**
     * Serializer Exception error.
     */
    public const SERIALIZER_EXCEPTION_ERROR = 2104;
    /**
     * Delete record failed.
     */
    public const FAILED_TO_DELETE = 2105;
    /**
     * Update record failed.
     */
    public const FAILED_TO_UPDATE = 2106;
    /**
     * Update record failed.
     */
    public const FAILED_TO_UPLOAD = 2107;

    /**
     * Delete purpose failed.
     */
    public const FAILED_DELETE_PURPOSE = 3006;
    /**
     * Delete scale failed.
     */
    public const FAILED_DELETE_SCALE = 3007;
    /**
     * Delete structure type failed.
     */
    public const FAILED_DELETE_STRUCTURE_TYPES = 3008;
    /**
     * Delete method failed.
     */
    public const FAILED_DELETE_METHOD = 3009;
    /**
     * Delete system architecture failed.
     */
    public const FAILED_DELETE_SYSTEM_ARCHITECTURE = 3010;
    /**
     * Delete role.
     */
    public const FAILED_DELETE_ROLE = 3011;
}
