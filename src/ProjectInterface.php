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
    const VERSION       = '1.0.12';
    const LAST_MODIFIED = '2020-02-17';
    const AUTHOR_NAME   = 'Hung Nguyen';
    const AUTHOR_EMAIL  = 'dev@nguyenanhung.com';
    const PROJECT_NAME  = 'Monitor Connector';
    const TIMEZONE      = 'Asia/Ho_Chi_Minh';

    /**
     * Function getVersion
     *
     * @return mixed
     * @author   : 713uk13m <dev@nguyenanhung.com>
     * @copyright: 713uk13m <dev@nguyenanhung.com>
     * @time     : 2/12/20 13:40
     */
    public function getVersion();
}
