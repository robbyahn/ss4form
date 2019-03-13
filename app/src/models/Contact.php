<?php

namespace SS4form\App\Model;

use SilverStripe\ORM\Filters\PartialMatchFilter;
use SilverStripe\ORM\Filters\GreaterThanFilter;
use SilverStripe\ORM\Search\SearchContext;
use SilverStripe\ORM\DataObject;

use SilverStripe\Forms\TextField;

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
        'Name' => 'Varchar(255)',
        'Address' => 'Varchar(255)',
        'Email' => 'Varchar(255)',
        'Phone' => 'Varchar(255)'
    ];

    private static $searchable_fields = [
        'Name',
        'Address'
     ];
    

    public function getDefaultSearchContext() 
    {
        $fields = $this->scaffoldSearchFields([
            'restrictFields' => ['Name','Address']
        ]);

        $filters = [
            'Name' => new PartialMatchFilter('Name')
        ];

        return new SearchContext(
            $this->class, 
            $fields, 
            $filters
        );
    }


}
