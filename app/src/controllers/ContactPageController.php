<?php 

namespace SS4form\App\Controllers;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\Form;

use SilverStripe\ORM\PaginatedList;

use SS4form\App\Model\Contact;

use PageController;

class ContactPageController extends PageController 
{
    private static $allowed_actions = ['Form','show','edit'];

    public function Form() 
    { 
        $cid = $this->getRequest()->getVar('id');

        if($cid){
            $contact = Contact::get()->filter('ID', $cid);
        }

        $contact       = ($cid)? $contact = Contact::get()->filter('ID', $cid) : false;
		$submitCaption = ($contact) ? 'Edit' : 'Submit';
		
        $fields = FieldList::create(
			TextField::create('Name', 'Name'),
            TextField::create('Address', 'Address'),
            EmailField::create('Email', 'Email'),
            TextField::create('Phone', 'Phone'),
			HiddenField::create('ID', 'ID')->setValue($cid)
		);

        $actions = new FieldList( 
            new FormAction('doSubmit', 'Submit') 
        );

        $form = Form::create($this, 'Form', $fields, $actions);
		
        if ($contact) $form->loadDataFrom($contact->first()); 
		
        return $form; 
    }

    public function doSubmit($data, $form) 
    {
        $contact = Contact::create();

        $contact->Name = $data['Name'];
        $contact->Address = $data['Address'];
        $contact->Email = $data['Email'];
        $contact->Phone = $data['Phone'];

        if($data['ID']){
            $contact->ID = $data['ID'];
        }

        $contact->write();

        // show success
		$form->sessionMessage("Contact has been created", 'success');

		return $this->redirectBack();
    }
}
