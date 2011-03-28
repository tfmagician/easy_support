<?php
/**
 * EasySupportController
 *
 * @package easy_support
 * @subpackage easy_support.controllers
 */
class EasySupportController extends EasySupportAppController
{

    /**
     * Models to use.
     *
     * @access public
     * @var array
     */
    var $uses = array(
        'EasySupport',
    );

    /**
     * Components to use.
     *
     * @access public
     * @var array
     */
    var $components = array(
        'Ajax',
        'Session',
        'Sanitization',
    );

    /**
     * Ajax actions.
     *
     * Automaticlly change a view tamplate and reject incorrect protocol accesses.
     *
     * @access public
     * @var array
     */
    var $ajaxActions = array(
        'send',
        'cancel',
    );

    /**
     * Check the protocol accessing actions.
     *
     * @access private
     * @return boolean
     */
    function _isAjaxAction()
    {
        return in_array($this->params['action'], $this->ajaxActions);
    }

    /**
     * Sanitize data sending as POST and GET.
     *
     * @access private
     * @return void
     */
    function _sanitize()
    {
        $Controller->data = Sanitize::clean($Controller->data, array('escape' => false));
    }

    /**
     * beforeFilter callback.
     *
     * @access public
     */
    function beforeFilter()
    {
        $this->_sanitize();
        if ($this->_AjaxAction()) {
            if (!$this->RequestHandler->{$checkMethod}()) {
                if (Configure::read('debug') == 0) {
                    $this->cakeError('error404');
                }
                Configure::write('debug', 0);
            }
        }
        parent::beforeFilter();
    }

    /**
     * Index page.
     *
     * @access public
     */
    function index()
    {
    }

    /**
     * Ajax action to send messages.
     *
     * @access public
     */
    function send()
    {
        $return = $this->Support->send($this->data);
        if (is_numeric($this->Support->id)) {
            $return &= $this->Session->write('Support.id', $this->Support->id);
        }
        $this->set('data', $return);
    }

    /**
     * Ajax action to cancel sending messages.
     *
     * @access public
     */
    function cancel()
    {
        $data = false;
        if ($this->Session->check('Support.id')) {
            $id = $this->Session->read('Support.id');
            $data = $this->Support->cancel($id);
            $this->Session->delete('Support.id');
        }
        $this->set('data', $data);
    }

}
