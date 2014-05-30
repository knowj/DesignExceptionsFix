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
     * @return Enterprise_PageCache_Model_Observer
     */
    protected function _saveDesignException()
    {
        if (!$this->isCacheEnabled()) {
            return $this;
        }

        Varien_Profiler::start('FPC DESIGN EXCEPTIONS FIX:'.__METHOD__);

        $cacheId = Enterprise_PageCache_Model_Processor::DESIGN_EXCEPTION_KEY;
        if (!Enterprise_PageCache_Model_Cache::getCacheInstance()->getFrontend()->test($cacheId)) {
            $exception = array(
                'package' => @unserialize(Mage::getStoreConfig(parent::XML_PATH_DESIGN_EXCEPTION)),
                'skin' => @unserialize(Mage::getStoreConfig(self::XML_PATH_DESIGN_SKIN_EXCEPTION)),
                'template' => @unserialize(Mage::getStoreConfig(self::XML_PATH_DESIGN_TEMPLATE_EXCEPTION)),
                'layout' => @unserialize(Mage::getStoreConfig(self::XML_PATH_DESIGN_LAYOUT_EXCEPTION))
            );
            $exception = serialize($exception);
            Enterprise_PageCache_Model_Cache::getCacheInstance()
                ->save($exception, $cacheId, array(Enterprise_PageCache_Model_Processor::CACHE_TAG));
            $this->_processor->refreshRequestIds();

        }

        Varien_Profiler::stop('FPC DESIGN EXCEPTIONS FIX:'.__METHOD__);

        return $this;
    }
}