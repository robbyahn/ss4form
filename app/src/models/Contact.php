<?php

namespace SS4form\App\Model;

use SilverStripe\ORM\DataObject;

class Contact extends DataObject
{
    /**
     * @var string
     */
    private static $singular_name = 'Contact';

    /**
     * @var string
     */
    private static $plural_name = 'Contacts';

    /**
     * @var string
     */
    private static $table_name = 'Contact';

    /**
     * @var array
     */
    private static $db = [
        'ContactID' => 'Varchar(255)',
        'Name' => 'Varchar(255)',
        'Address' => 'Varchar(255)',
        'Email' => 'Varchar(255)',
        'Phone' => 'Varchar(255)'
    ];

}
