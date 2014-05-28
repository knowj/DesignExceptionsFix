<?php
/**
 * Class Jh_DesignExceptionsFix_Model_Observer
 * @author John Knowles <john@wearejh.com>
 */
class Jh_DesignExceptionsFix_Model_Observer extends Enterprise_PageCache_Model_Observer
{
    /**
     * Config xpath for skin exception
     */
    const XML_PATH_DESIGN_SKIN_EXCEPTION = 'design/theme/skin_ua_regexp';
    /**
     * Config xpath for template exception
     */
    const XML_PATH_DESIGN_TEMPLATE_EXCEPTION = 'design/theme/template_ua_regexp';
    /**
     * Config xpath for layout exception
     */
    const XML_PATH_DESIGN_LAYOUT_EXCEPTION = 'design/theme/layout_ua_regexp';

    /**
     * Checks whether exists design exception value in cache.
     * If not, gets it from config and puts into cache
     * @todo Condense the following into a single cache file
     * @return Enterprise_PageCache_Model_Observer
     */
    protected function _saveDesignException()
    {
        if (!$this->isCacheEnabled()) {
            return $this;
        }
        $cacheId = Enterprise_PageCache_Model_Processor::DESIGN_EXCEPTION_KEY;

        $exception = Enterprise_PageCache_Model_Cache::getCacheInstance()->load($cacheId);
        if (!$exception) {
            $exception = Mage::getStoreConfig(self::XML_PATH_DESIGN_EXCEPTION);
            Enterprise_PageCache_Model_Cache::getCacheInstance()->save($exception, $cacheId);
            $this->_processor->refreshRequestIds();
        }

        $cacheId = Jh_DesignExceptionsFix_Model_PageCache_Processor::DESIGN_SKIN_EXCEPTION_KEY;

        $exception = Enterprise_PageCache_Model_Cache::getCacheInstance()->load($cacheId);
        if (!$exception) {
            $exception = Mage::getStoreConfig(self::XML_PATH_DESIGN_SKIN_EXCEPTION);
            Enterprise_PageCache_Model_Cache::getCacheInstance()->save($exception, $cacheId);
            $this->_processor->refreshRequestIds();
        }

        $cacheId = Jh_DesignExceptionsFix_Model_PageCache_Processor::DESIGN_TEMPLATE_EXCEPTION_KEY;

        $exception = Enterprise_PageCache_Model_Cache::getCacheInstance()->load($cacheId);
        if (!$exception) {
            $exception = Mage::getStoreConfig(self::XML_PATH_DESIGN_TEMPLATE_EXCEPTION);
            Enterprise_PageCache_Model_Cache::getCacheInstance()->save($exception, $cacheId);
            $this->_processor->refreshRequestIds();
        }

        $cacheId = Jh_DesignExceptionsFix_Model_PageCache_Processor::DESIGN_LAYOUT_EXCEPTION_KEY;

        $exception = Enterprise_PageCache_Model_Cache::getCacheInstance()->load($cacheId);
        if (!$exception) {
            $exception = Mage::getStoreConfig(self::XML_PATH_DESIGN_LAYOUT_EXCEPTION);
            Enterprise_PageCache_Model_Cache::getCacheInstance()->save($exception, $cacheId);
            $this->_processor->refreshRequestIds();
        }
        return $this;
    }
}