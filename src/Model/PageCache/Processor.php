<?php
/**
 * Class Jh_DesignExceptionsFix_Model_PageCache_Processor
 * @author John Knowles <john@wearejh.com>
 */
class Jh_DesignExceptionsFix_Model_PageCache_Processor extends Enterprise_PageCache_Model_Processor
{
    /**
     * Override of the _getDesignPackage() method to accommodate for design exceptions
     * @return string
     */
    protected function _getDesignPackage()
    {
        Varien_Profiler::start('FPC DESIGN EXCEPTIONS FIX:'.__METHOD__);
        /** @todo implement a cookie to reduce the amount of load required currently the getPath within
         * the cookie model is preventing the cookie from being saved without Magento init  */

        $packageArray = array();

        $cacheInstance = Enterprise_PageCache_Model_Cache::getCacheInstance();
        $exceptions = $cacheInstance->load(Enterprise_PageCache_Model_Processor::DESIGN_EXCEPTION_KEY);
        $this->_designExceptionExistsInCache = $cacheInstance->getFrontend()->test(Enterprise_PageCache_Model_Processor::DESIGN_EXCEPTION_KEY);
        if ($exceptions) {
            $rules = @unserialize($exceptions);
            foreach ($rules as $key=>$value) {
                if (!empty($value)) {
                    $packageArray[$key] = Mage_Core_Model_Design_Package::getPackageByUserAgent($value);
                }
            }
        }

        $packageExceptions = implode('', $packageArray);

        Varien_Profiler::stop('FPC DESIGN EXCEPTIONS FIX:'.__METHOD__);
        return $packageExceptions;
    }
}
