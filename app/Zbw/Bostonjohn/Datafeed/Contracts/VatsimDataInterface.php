<?php
namespace Zbw\Bostonjohn\Datafeed\Contracts;

/**
 * @since 2.0.9b
 * @package Bostonjohn
 */
interface VatsimDataInterface
{
    /**
     * @name updateStatus
     *  updates the vatsim datafeeds
     * @return bool
     */
    public function updateStatus();
}
