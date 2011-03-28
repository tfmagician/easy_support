<?php
App::import('Controller', 'EasySupport.EasySupport');
App::import('Component', 'Session');
App::import('Model', 'EasySupport.EasySupport');

Mock::generatePartial(
    'EasySupportController', 'TestEasySupportController',
    array('redirect', 'cakeError')
);
Mock::generate('SessionComponent', 'TestEasySupportController_Session');
Mock::generate('EasySupport', 'TestEasySupportController_Support');

class EasySupportControllerTestCase extends CakeTestCase
{

    function startTest()
    {
        $this->EasySupportController = new TestEasySupportController();
        $this->EasySupportController->Session = new TestEasySupportController_Session();
        $this->EasySupportController->Support = new TestEasySupportController_Support();
    }

    function endTest()
    {
        unset($this->EasySupportController);
    }

    function testCancel()
    {
        $id = 2;

        $Session = $this->EasySupportController->Session;
        $Session->expectOnce('check', array('Support.id'));
        $Session->setReturnValue('check', true);
        $Session->expectOnce('read', array('Support.id'));
        $Session->setReturnValue('read', $id);
        $Session->expectOnce('delete', array('Support.id'));
        $Session->setReturnValue('delete', true);

        $Support = $this->EasySupportController->Support;
        $Support->expectOnce('cancel', array($id));
        $Support->setReturnValue('cancel', true);

        $this->EasySupportController->cancel();

        $expected = array(
            'data' => true,
        );
        $this->assertEqual($expected, $this->EasySupportController->viewVars);
    }

    function testSend()
    {
        $id = 2;
        $data = array(
            'Support' => array(
                'content' => 'new content',
            ),
        );

        $Session = $this->EasySupportController->Session;
        $Session->expectOnce('write', array('Support.id', $id));
        $Session->setReturnValue('write', true);

        $Support = $this->EasySupportController->Support;
        $Support->expectOnce('send', array($data));
        $Support->setReturnValue('send', true);

        $this->EasySupportController->data = $data;
        $this->EasySupportController->Support->id = $id;
        $this->EasySupportController->send();

        $expected = array(
            'data' => true,
        );
        $this->assertEqual($expected, $this->EasySupportController->viewVars);
    }

}
