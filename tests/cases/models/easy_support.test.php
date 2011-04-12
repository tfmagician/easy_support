<?php
class EasySupportTestCase extends CakeTestCase
{

    var $fixtures = array(
        'plugin.easy_support.support',
    );

    function startTest()
    {
        $this->EasySupport =& ClassRegistry::init('EasySupport.EasySupport');
    }

    function endTest()
    {
        unset($this->EasySupport);
        ClassRegistry::flush();

        Configure::write('Cache.disable', true);
        Configure::write('Cache.check', false);
    }

    function testSaveIfTypeIsPage()
    {
        $data = array(
            'EasySupport' => array(
                'title' => 'new title',
                'mail' => 'mail@mail.com',
                'type' => 'page',
                'content' => 'new content',
            ),
        );
        $ret = $this->EasySupport->save($data);
        $this->assertTrue($ret);

        $fields = array('title', 'mail', 'type', 'content');
        $ret = $this->EasySupport->read($fields, $this->EasySupport->id);
        $this->assertEqual($data, $ret);
    }

    function testSaveIfTypeIsBox()
    {
        $data = array(
            'EasySupport' => array(
                'type' => 'box',
                'content' => 'new content',
            ),
        );
        $ret = $this->EasySupport->save($data);
        $this->assertTrue($ret);

        $fields = array('type', 'content');
        $ret = $this->EasySupport->read($fields, $this->EasySupport->id);
        $this->assertEqual($data, $ret);
    }

    function testSaveIfValidateFalse()
    {
        $data = array(
            'EasySupport' => array(
                'type' => 'box',
                'content' => '',
            ),
        );
        $ret = $this->EasySupport->save($data);
        $this->assertFalse($ret);
    }

    function testCancel()
    {
        $id = 1;
        $ret = $this->EasySupport->cancel($id);
        $this->assertTrue($ret);

        $ret = $this->EasySupport->read(null, $id);
        $this->assertFalse($ret);
    }

    function testSend()
    {
        $data = array(
            'type' => 'box',
            'content' => 'new content',
        );
        $ret = $this->EasySupport->send($data);
        $this->assertTrue($ret);
    }

    function testSendAttack()
    {
        Configure::write('Cache.disable', false);
        Configure::write('Cache.check', true);
        Configure::write('EasySupport.repeated', 0.5);
        $old = $this->EasySupport->find('count');

        $data = array(
            'type' => 'box',
            'content' => 'new content',
        );
        $ret = $this->EasySupport->send($data);
        $this->assertTrue($ret);

        for ($i = 0; $i < 10; $i ++) {
            $data = array(
                'type' => 'box',
                'content' => 'new content',
            );
            $ret = $this->EasySupport->send($data);
            $this->assertFalse($ret);
        }

        $this->assertEqual($old + 1, $this->EasySupport->find('count'));
    }

    function testGetEmails()
    {
        $ret = $this->EasySupport->getEmails();
        $expected = array(1);
        $this->assertEqual($expected, Set::extract('/EasySupport/id', $ret));
        $expected = array(
            'id',
            'mail',
            'type',
            'title',
            'content',
        );
        $this->assertEqual($expected, array_keys($ret[0]['EasySupport']));
    }

    function testUpdateSent()
    {
        $id = 1;
        $ret = $this->EasySupport->updateSent($id);
        $this->assertTrue($ret);
        $ret = $this->EasySupport->read('sent', $id);
        $expected = array(
            'EasySupport' => array(
                'sent' => true,
            ),
        );
        $this->assertEqual($expected, $ret);
    }
}
