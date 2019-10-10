<?php
/**
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/4/18
 * Time: 14:55
 */

namespace nguyenanhung\Monitor;

/**
 * Interface ProjectInterface
 *
 * @package   nguyenanhung\Monitor
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
interface ProjectInterface
{
    const VERSION             = '1.0.10';
    const LAST_MODIFIED       = '2019-10-10';
    const AUTHOR_NAME         = 'Hung Nguyen';
    const AUTHOR_EMAIL        = 'dev@nguyenanhung.com';
    const PROJECT_NAME        = 'Monitor Connector';
    const TIMEZONE            = 'Asia/Ho_Chi_Minh';
    const REQUEST_TIMEOUT     = 60;
    const EXIT_SUCCESS        = 0; // no errors
    const EXIT_ERROR          = 1; // generic error
    const EXIT_CONFIG         = 3; // configuration error
    const EXIT_UNKNOWN_FILE   = 4; // file not found
    const EXIT_UNKNOWN_CLASS  = 5; // unknown class
    const EXIT_UNKNOWN_METHOD = 6; // unknown class member
    const EXIT_USER_INPUT     = 7; // invalid user input
    const EXIT_DATABASE       = 8; // database error
    const EXIT__AUTO_MIN      = 9; // lowest automatically-assigned error code
    const EXIT__AUTO_MAX      = 125; // highest automatically-assigned error code
    const USE_BENCHMARK       = FALSE;
    const USE_DEBUG           = FALSE;

    /**
     * Function getVersion
     *
     * @return mixed
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-08-04 03:03
     *
     */
    public function getVersion();
}
