DesignExceptionsFix
===================

Resolves issue with Magento Enterprise Full Page Cache (FPC) and  Design Exceptions.

Currently Magento doesn't take design exceptions into consideration within the FPC module. To append the theme name
onto the FPC write requestId isn't a complicated task however you can easily end up in a position where the write
and read requestId are 2 different values resulting in a 100% FPC miss.

The complexity lies in the read requestId when Magento isn't init we need to make sure we
have enough data available to ensure the correct device is served the correct cached page. To
do this we cache the design exceptions with a common key to allow the rules to be retrieved
without Magento being init.

- Observer.php - Save the design exceptions to cache
- PageCache/Processor.php - Append the request id with the design exception theme (if applicable)

The following will need adding to the global node of your /app/etc/local.xml because enterprise.xml
statically defines the Enterprise_PageCache_Model_Processor the read and write request key
 would use different classes to generate with just the rewrite in place.
```
<cache>
    <request_processors>
        <ee>Jh_DesignExceptionsFix_Model_PageCache_Processor</ee>
    </request_processors>
</cache>
```

Adds FPC compatibility with
- System > Configuration > Design > Themes:
    - Templates > Add Exception
    - Skin > Add Exception
    - Layout > Add Exception

Each exception is taken into consideration individually to allow for more advanced configurations.
