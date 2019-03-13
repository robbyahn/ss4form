<?php
namespace SS4form\App;
use SilverStripe\Admin\ModelAdmin;

use SS4form\App\Model\Contact;

class ContactAdmin extends ModelAdmin
{
    private static $menu_title = 'contacts admin';
    private static $url_segment = 'contactsadmin';
    private static $managed_models = [
        Contact::class
    ];
    
}