<?php
/**
 * Project monitor.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 2019-08-04
 * Time: 02:23
 */

namespace nguyenanhung\Monitor;

/**
 * Trait Version
 *
 * @package   nguyenanhung\Monitor
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
trait Version
{
    /**
     * Function getVersion
     *
     * @return mixed|string
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 11/26/18 00:48
     *
     */
    public function getVersion()
    {
        return self::VERSION;
    }
}
