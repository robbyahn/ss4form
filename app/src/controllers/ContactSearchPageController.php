<?php

namespace SS4form\App\Controllers;

use PageController;

use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\FormAction;
use SilverStripe\ORM\ArrayLib;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\Control\HTTP;

use SilverStripe\Control\Director;

use SS4form\App\Model\Contact;


class ContactSearchPageController extends PageController
{
    private static $allowed_actions = [
        'ContactSearchForm','editcontact'
    ];

    public function index(HTTPRequest $request)
    {
        $contacts = Contact::get();
        
        if ($search = $request->getVar('Keywords')) {
            $contacts = $contacts->filter(array(
                'Name:PartialMatch' => $search
            ));
        }

        $paginatedContacts = PaginatedList::create(
            $contacts,
            $request
        );
        
        $data = [
            'Results' => $paginatedContacts
        ];

        //if ($request->isAjax()) {
            if($contacts){
                return $this->customise($data)
                    ->renderWith(['Layout/ContactSearchPage','Page']);
            }
        //}

        return [
            'Results' => $paginatedContacts
        ];
    }

    public function ContactSearchForm()
    {  
        $form = Form::create(
            $this,
            'ContactSearchForm',
            FieldList::create(
                TextField::create('Keywords')
                    ->setAttribute('placeholder', 'Name')
            ),
            FieldList::create(
                FormAction::create('doContactSearch','Search')
            )
        );

        $form->setFormMethod('GET')
            ->setFormAction($this->Link())
            ->disableSecurityToken()
            ->loadDataFrom($this->request->getVars());

        return $form;
    }
}