<?php
/**
 * Class Jh_DesignExceptionsFix_Model_PageCache_Processor
 * @author John Knowles <john@wearejh.com>
 */
class Jh_DesignExceptionsFix_Model_PageCache_Processor extends Enterprise_PageCache_Model_Processor
{

    /**
     * Skin design exception cache key
     */
    const DESIGN_SKIN_EXCEPTION_KEY = 'FPC_DESIGN_SKIN_EXCEPTION_CACHE';

    /**
     * Template design exception cache key
     */
    const DESIGN_TEMPLATE_EXCEPTION_KEY = 'FPC_DESIGN_TEMPLATE_EXCEPTION_CACHE';

    /**
     * Layout design exception cache key
     */
    const DESIGN_LAYOUT_EXCEPTION_KEY = 'FPC_DESIGN_LAYOUT_EXCEPTION_CACHE';

    /**
     *  FPC_THEME_COOKIE
     */
    const FPC_THEME_COOKIE = 'FPC_THEME';

    /**
     * Override of the _getDesignPackage() method to accommodate for design exceptions
     * @todo Condense the cache request to a single file
     * @return string
     */
    protected function _getDesignPackage()
    {
        /** @todo implement a cookie to reduce the amount of load required currently the getPath within
         * the cookie model is preventing the cookie from being saved without Magento init  */
        /*if ($theme = $this->_getCookie()->get(self::FPC_THEME_COOKIE)) {
            return $theme;
        }*/

        $packageArray = array();

        $cacheInstance = Enterprise_PageCache_Model_Cache::getCacheInstance();

        $exceptionKeys = array(
            $this::DESIGN_EXCEPTION_KEY,
            self::DESIGN_SKIN_EXCEPTION_KEY,
            self::DESIGN_TEMPLATE_EXCEPTION_KEY,
            self::DESIGN_LAYOUT_EXCEPTION_KEY
        );

        foreach ($exceptionKeys as $key) {
            $test = $cacheInstance->getFrontend()->test($key);
            if ($test!=false) {
                $this->_designExceptionExistsInCache = $test;
                break;
            }
        }

        //Package
        $exceptions = $cacheInstance->load($this::DESIGN_EXCEPTION_KEY);
        if ($exceptions) {
            $rules = @unserialize($exceptions);
            if (!empty($rules)) {
                $packageArray['package'] = Mage_Core_Model_Design_Package::getPackageByUserAgent($rules);
            }
        }

        //Skin
        $exceptions = $cacheInstance->load($this::DESIGN_SKIN_EXCEPTION_KEY);
        if ($exceptions) {
            $rules = @unserialize($exceptions);
            if (!empty($rules)) {
                $packageArray['skin'] = Mage_Core_Model_Design_Package::getPackageByUserAgent($rules);
            }
        }

        //Templates
        $exceptions = $cacheInstance->load($this::DESIGN_TEMPLATE_EXCEPTION_KEY);
        if ($exceptions) {
            $rules = @unserialize($exceptions);
            if (!empty($rules)) {
                $packageArray['template'] = Mage_Core_Model_Design_Package::getPackageByUserAgent($rules);
            }
        }

        //Layout
        $exceptions = $cacheInstance->load($this::DESIGN_LAYOUT_EXCEPTION_KEY);
        if ($exceptions) {
            $rules = @unserialize($exceptions);
            if (!empty($rules)) {
                $packageArray['layout'] = Mage_Core_Model_Design_Package::getPackageByUserAgent($rules);
            }
        }


        $packageExceptions = implode('', $packageArray);
        if ($packageExceptions) {
            /** @todo implement a cookie to reduce the amount of load required currently the getPath within
             * the cookie model is preventing the cookie from being saved without Magento init  */
            //$this->_getCookie()->set(self::FPC_THEME_COOKIE, $packageExceptions, time()+604800);
            return $packageExceptions;
        }
        return '';
    }
}
