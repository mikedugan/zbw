<?php
namespace Zbw\Bostonjohn\Datafeed\Contracts;

interface VatsimDataInterface
{
    /**
     * @name updateStatus
     * @description updates the vatsim datafeeds
     * @return bool
     */
    public function updateStatus();
}
