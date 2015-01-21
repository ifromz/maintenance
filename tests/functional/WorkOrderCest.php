<?php

class WorkOrderCest extends BaseCest
{
    public $formFields = array(
        'text' => array(
            'work_order_category' => '1',
            'location' => '1',
            'subject' => 'Testing Create',
            'description' => 'Testing Work Order Creation',
        ),
        'select' => array(
            'status' => '1',
            'priority' => '1',
        ),
    );
    
    /**
     * @before login
     */
    public function testIndex(FunctionalTester $I)
    {
        $I->wantTo('Make sure the work order index is available');
        $I->amOnRoute('maintenance.work-orders.index');
        $I->see('Work Orders', 'h1');
        $I->see('New Work Order', 'a');
        $I->see('Search', 'a');
    }
    
    /**
     * @before logout
     */
    public function testIndexAuthFailure(FunctionalTester $I)
    {
        $I->wantTo('Make sure I am redirected to login page');
        $I->amOnRoute('maintenance.work-orders.index');
        $I->see('Sign In', 'div');
    }
    
    /**
     * @before login
     */
    public function testCreate(FunctionalTester $I)
    {
        $I->wantTo('Make sure the work order creation page is available');
        $I->amOnRoute('maintenance.work-orders.create');
        $I->see('Create a Work Order', 'h1');
    }
    
    /**
     * @before login
     * @depends testCreate
     */
    public function testStore(FunctionalTester $I)
    {
        $I->wantTo('Make sure storing a new work order works');
        $this->testCreate($I);
        $this->fillFields($I);
        $I->click('Save');
        $I->see('Successfully created work order');
    }
    
    /**
     * @before login
     */
    public function testEdit(FunctionalTester $I)
    {
        $I->wantTo('Make sure the work order editing page is available');
        $I->amOnRoute('maintenance.work-orders.edit', array(1));
        $I->see('Editing Work Order', 'h1');
    }
    
    /**
     * @before login
     * @depends testEdit
     */
    public function testUpdate(FunctionalTester $I)
    {
        $I->wantTo('Make sure updaing a work order works');
        $this->testEdit($I);
        $this->fillFields($I);
        $I->click('Save');
        $I->see('Successfully edited work order');
    }
    
    /**
     * @before login
     * @depends testIndex
     */
    public function testDestroy(FunctionalTester $I)
    {
        $I->wantTo('Make sure deleting a work order works');
        $this->testIndex($I);
        $I->sendAjaxPostRequest('work-orders/1', array(
            '_method' => 'DELETE',
        ));
        $I->see('Successfully deleted work order');
    }
}