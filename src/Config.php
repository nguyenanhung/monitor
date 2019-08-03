<?php
/**
 * Project monitor.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 2019-08-04
 * Time: 02:24
 */

namespace nguyenanhung\Monitor;

/**
 * Trait Config
 *
 * @package   nguyenanhung\Monitor
 * @author    713uk13m <dev@nguyenanhung.com>
 * @copyright 713uk13m <dev@nguyenanhung.com>
 */
trait Config
{
    /**
     * Function setSdkConfig
     *
     * @param array $sdkConfig
     *
     * @return $this
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-08-04 02:24
     *
     */
    public function setSdkConfig($sdkConfig = array())
    {
        $this->sdkConfig = $sdkConfig;

        return $this;
    }

    /**
     * Function getSdkConfig
     *
     * @return array|null
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 2019-08-04 02:24
     *
     */
    public function getSdkConfig()
    {
        return $this->sdkConfig;
    }
}
