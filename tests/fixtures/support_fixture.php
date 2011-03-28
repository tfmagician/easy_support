<?php
class SupportFixture extends CakeTestFixture
{
    var $name = 'Support';

    var $fields = array(
        'id'           => array('type' => 'integer',  'null' => false, 'default' => NULL, 'key' => 'primary'),
        'mail'         => array('type' => 'string',   'null' => false, 'default' => NULL),
        'title'        => array('type' => 'string',   'null' => false, 'default' => NULL),
        'type'         => array('type' => 'string',   'null' => false, 'default' => NULL),
        'content'      => array('type' => 'text',     'null' => false, 'default' => NULL),
        'sent'         => array('type' => 'boolean',  'null' => false, 'default' => false),
        'sent_date'    => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'deleted'      => array('type' => 'boolean',  'null' => false, 'default' => false),
        'deleted_date' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'created'      => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'modified'     => array('type' => 'datetime', 'null' => false, 'default' => NULL),
        'indexes' => array(
            'PRIMARY' => array('column' => 'id',      'unique' => 1),
            'type'    => array('column' => 'type',    'unique' => 0),
            'created' => array('column' => 'created', 'unique' => 0),
            'deleted' => array('column' => 'deleted', 'unique' => 0),
        ),
        'tableParameters' => array(
            'charset' => 'utf8',
            'collate' => 'utf8_unicode_ci',
            'engine'  => 'InnoDB',
        ),
    );

    var $records = array(
        array(
            'id' => 1,
            'mail' => 'mail1',
            'title' => 'title1',
            'type' => 'box',
            'content' => 'content1',
            'sent' => false,
            'sent_date' => '2011-01-01 10:00:00',
            'deleted' => false,
            'deleted_date' => '2011-01-01 10:00:00',
            'created' => '2011-01-01 10:00:00',
            'modified' => '2011-01-01 10:00:00',
        ),
        array(
            'id' => 2,
            'mail' => 'mail2',
            'title' => 'title2',
            'type' => 'box',
            'content' => 'content2',
            'sent' => false,
            'sent_date' => '2011-01-01 10:00:00',
            'deleted' => true,
            'deleted_date' => '2022-02-02 20:00:00',
            'created' => '2022-02-02 20:00:00',
            'modified' => '2022-02-02 20:00:00',
        ),
        array(
            'id' => 3,
            'mail' => 'mail3',
            'title' => 'title3',
            'type' => 'box',
            'content' => 'content3',
            'sent' => true,
            'sent_date' => '2033-03-03 00:00:00',
            'deleted' => false,
            'deleted_date' => '2033-03-03 00:00:00',
            'created' => '2033-03-03 00:00:00',
            'modified' => '2033-03-03 00:00:00',
        ),
    );

}
