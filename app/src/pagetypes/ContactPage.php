<?php

namespace SS4form\App\PageTypes;

use SS4form\App\Controllers\ContactPageController;
use Page;

class ContactPage extends Page 
{
    /**
     * @return string
     */
    public function getControllerName()
    {
        return ContactPageController::class;
    }
}