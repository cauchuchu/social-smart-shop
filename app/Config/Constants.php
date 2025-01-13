<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);


define('ROLE_ADMIN', 1);
define('ROLE_USER', 2);

define('STATUS_ACTIVE_PRODUCT', 1);
define('STATUS_INACTIVE_PRODUCT', 0);
define('STATUS_ACTIVE_EMPLOYEE', 1);
define('STATUS_INACTIVE_EMPLOYEE', 0);

define('ORDER_STATUS_PROCESSING', 0);
define('ORDER_STATUS_DELIVERING', 1);
define('ORDER_STATUS_DONE', 2);
define('ORDER_STATUS_REFUND', 3);
define('ORDER_STATUS_CANCEL', 4);

define('ORDER_STATUS_PROCESSING_VALUE', 'Đang xử lý');
define('ORDER_STATUS_DELIVERING_VALUE', 'Đang giao');
define('ORDER_STATUS_DONE_VALUE', 'Thành công');
define('ORDER_STATUS_REFUND_VALUE', 'Hoàn hàng');
define('ORDER_STATUS_CANCEL_VALUE', 'Hủy');

define('ORDER_STATUS_PAYMENT_NONE', 0); // khong xu ly
define('ORDER_STATUS_PAYMENT_NO', 1); // khong tra
define('ORDER_STATUS_PAYMENT_NOTYET', 2); // chua thanh toan
define('ORDER_STATUS_PAYMENT_DONE', 3); // da thanh toan 

define('ORDER_STATUS_PAYMENT_NONE_VALUE', 'Đơn hủy'); // khong xu ly
define('ORDER_STATUS_PAYMENT_NO_VALUE', 'Không trả'); // khong tra
define('ORDER_STATUS_PAYMENT_NOTYET_VALUE', 'Chưa T.Toán'); // chua thanh toan
define('ORDER_STATUS_PAYMENT_DONE_VALUE', 'Đã T.Toán'); // da thanh toan 

define('CUSTOMER_BLACK', 1);

define('ORDER_ACTIVE_STATUS', 1);

function getOrderStatusDeliveryValue($status_code) {
    switch ($status_code) {
        case ORDER_STATUS_PROCESSING:
            return ORDER_STATUS_PROCESSING_VALUE;
        case ORDER_STATUS_DELIVERING:
            return ORDER_STATUS_DELIVERING_VALUE;
        case ORDER_STATUS_DONE:
            return ORDER_STATUS_DONE_VALUE;
        case ORDER_STATUS_REFUND:
            return ORDER_STATUS_REFUND_VALUE;
        case ORDER_STATUS_CANCEL:
            return ORDER_STATUS_CANCEL_VALUE;
        default:
            return 'Trạng thái không hợp lệ';
    }
}

function getOrderStatusPaymentValue($status_code) {
    switch ($status_code) {
        case ORDER_STATUS_PAYMENT_NONE:
            return ORDER_STATUS_PAYMENT_NONE_VALUE;
        case ORDER_STATUS_PAYMENT_NO:
            return ORDER_STATUS_PAYMENT_NO_VALUE;
        case ORDER_STATUS_PAYMENT_NOTYET:
            return ORDER_STATUS_PAYMENT_NOTYET_VALUE;
        case ORDER_STATUS_PAYMENT_DONE:
            return ORDER_STATUS_PAYMENT_DONE_VALUE;
        default:
            return 'Trạng thái không hợp lệ';
    }
}