<?php 

namespace SS4form\App\Controllers;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\Form;

use PageController;

class ContactPageController extends PageController 
{
    private static $allowed_actions = ['Form'];

    public function Form() 
    { 
        $fields = new FieldList( 
            new TextField('Name'),
            new TextField('Address'),  
            new EmailField('Email'), 
            new TextField('Phone')
        );

        $actions = new FieldList( 
            new FormAction('submit', 'Submit') 
        );

        return new Form($this, 'Form', $fields, $actions); 
    }

    public function submit() 
    {
        
    }
}
