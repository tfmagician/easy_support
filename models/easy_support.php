<?php
/**
 * EasySupport
 *
 * Add messages when a customer clicks send button.
 *
 * @package easy_support
 * @subpackage easy_support.models
 */
class EasySupport extends EasySupportAppModel
{

    /**
     * Table name to use.
     *
     * @access public
     * @var string
     */
    var $useTable = 'supports';

    /**
     * Validation settings.
     *
     * @access public
     * @var array
     */
    var $validate = array(
        'mail' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => '入力してください',
                'allowEmpty' => false,
                'required' => false,
                'last' => true,
                'on' => null,
            ),
            'limit' => array(
                'rule' => array('maxLength', 50),
                'message' => '50文字以内で入力してください',
                'allowEmpty' => false,
                'required' => false,
                'last' => true,
                'on' => null,
            ),
            'isCorrectFormat' => array(
                'rule' => array('custom', '/[a-z0-9.\-_]+@[a-z0-9.\-_]+/u'),
                'message' => '形式が間違っています',
                'allowEmpty' => false,
                'required' => false,
                'last' => true,
                'on' => null,
            ),
        ),
        'title' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => '選択してください',
                'allowEmpty' => false,
                'required' => false,
                'last' => true,
                'on' => null,
            ),
            'limit' => array(
                'rule' => array('maxLength', 50),
                'message' => '50字以内で入力してください',
                'allowEmpty' => false,
                'required' => false,
                'last' => true,
                'on' => null,
            ),
        ),
        'type' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => '不正なデータが入力されました',
                'allowEmpty' => false,
                'required' => true,
                'last' => true,
                'on' => null,
            ),
            'isCorrectType' => array(
                'rule' => array('inList', array('box', 'page')),
                'message' => '不正なデータが入力されました',
                'allowEmpty' => false,
                'required' => true,
                'last' => true,
                'on' => null,
            ),
        ),
        'content' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => '入力してください',
                'allowEmpty' => false,
                'required' => false,
                'last' => true,
                'on' => null,
            ),
            'limit' => array(
                'rule' => array('between', 0, 2000),
                'message' => '2000文字以内で入力してください',
                'allowEmpty' => false,
                'required' => false,
                'last' => true,
                'on' => null,
            ),
        ),
    );

    /**
     * Behavior settings.
     *
     * @access public
     * @var array
     */
    var $actsAs = array(
        'Utils.SoftDelete',
    );

    /**
     * Writable fields.
     *
     * @accesss public
     * @var array
     */
    var $whitelist = array(
        'mail',
        'title',
        'type',
        'content',
    );

    /**
     * Send messages.
     *
     * @access public
     * @param array $data
     * @return mixed
     */
    function send($data)
    {
        $this->create();
        $this->set($data);
        return $this->save($data);
    }

    /**
     * Cancel sending a message.
     *
     * @access public
     * @param integer $id
     * @return boolean
     */
    function cancel($id)
    {
        return $this->Behaviors->SoftDelete->delete($this, $id);
    }

    /**
     * Get records to send messages as email.
     *
     * @access public
     * @return array
     */
    function getEmails()
    {
        $params = array(
            'conditions' => array($this->alias.'.sent = ' => false),
            'fields' => array(
                $this->alias.'.id',
                $this->alias.'.mail',
                $this->alias.'.type',
                $this->alias.'.title',
                $this->alias.'.content',
            ),
            'recursive' => -1,
        );
        return $this->find('all', $params);
    }

    /**
     * Update sent field.
     *
     * @access public
     * @param integer $id
     * @return boolean
     */
    function updateSent($id)
    {
        $field = array(
            $this->alias.'.sent' => true,
            $this->alias.'.sent_date' => "'".date('Y-m-d H:i:s')."'",
        );
        $conditions = array(
            $this->alias.'.'.$this->primaryKey.' = ' => $id,
        );
        return $this->updateAll($field, $conditions);
    }

}
