<?php

namespace SS4form\App\PageTypes;

use SS4form\App\Controllers\ContactSearchPageController;
use Page;

class ContactSearchPage extends Page {
     /**
     * @return string
     */
    public function getControllerName()
    {
        return ContactSearchPageController::class;
    }

}
