<?php
use \FunctionalTester;
use Cartalyst\Sentry\Facades\Laravel\Sentry;

class BaseCest
{
    public function _before(FunctionalTester $I)
    {
        $I->haveEnabledFilters();
    }
    
    /**
     * Logs in the first user in the database
     */
    protected function login()
    {
        $user = Sentry::findUserById(1);
        Sentry::login($user);
    }
    
    /**
     * Logs out the current user
     */
    protected function logout()
    {
        Sentry::logout();
    }
    
    /**
     * Fills form fields specified in the extending classes property
     * 
     * @param FunctionalTester $I
     */
    protected function fillFields(FunctionalTester $I)
    {
        foreach($this->formFields as $type => $fields) {

            switch($type)
            {
                case 'text':
                    $this->fillTextFields($I, $fields);
                    break;
                
                case 'select':
                    $this->fillSelectFields($I, $fields);
                    break;
            }
            
        }
    }
    
    /**
     * Processes an array of fields and fills the current FunctionalTester select
     * fields with each field / value
     * 
     * @param FunctionalTester $I
     * @param array $fields
     */
    protected function fillSelectFields(FunctionalTester $I, $fields = array())
    {
        foreach($fields as $select => $option) {
            
            $field = sprintf('select[name=%s]', $select);
            
            $I->fillField($field, $option);
            
        }
    }
    
    /**
     * Processes an array of fields and fills the current FunctionalTester text
     * fields with each field / value
     * 
     * @param FunctionalTester $I
     * @param array $fields
     */
    protected function fillTextFields(FunctionalTester $I, $fields = array())
    {
        foreach($fields as $field => $value) {
            
            $I->fillField($field, $value);
            
        }
    }
}