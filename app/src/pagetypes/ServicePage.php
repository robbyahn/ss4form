<?php

namespace SS4form\App\PageTypes;

use SS4form\App\Controllers\ServicePageController;

use Page;

class ServicePage extends Page
{
    /**
     * Used for determining the ID of a randomly selected 'pinned' news/article
     * page - displayed on the feature story panel
     *
     * @var int
     */
    private $_randomPinnedID;

    /**
     * @var string
     */
    private static $singular_name = 'Service Page';

    /**
     * @var string
     */
    private static $plural_name = 'Service Pages';

    /**
     * @var string
     */
    private static $table_name = 'ServicePage';

   
    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        
        return $fields;
    }
    /**
     * @return string
     */
    public function getControllerName()
    {
        return ServicePageController::class;
    }
}
