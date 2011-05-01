<?php
App::import('Shell', 'Email.EmailShell');

/**
 * SendShell
 *
 * @package easy_support
 * @subpackage easy_support.vendors.shells
 */
class EasySupportShell extends EmailShell
{

    /**
     * Models to use.
     *
     * @access public
     * @var array
     */
    var $uses = array(
        'EasySupport.EasySupport',
    );

    /**
     * Email settings.
     *
     * @access public
     * @var string
     */
    var $useMailerConfig = 'default';

    /**
     * Subject of email.
     *
     * @access public
     * @var array
     */
    var $subjects = array(
        'box' => 'お問い合わせボックスから送信',
        'page' => 'お問い合わせフォームから送信 - :title',
    );

    /**
     * startup callback.
     *
     * @access public
     */
    function startup()
    {
    }

    /**
     * Method to send email.
     *
     * @access public
     * @param string $subject
     * @param string $content
     * @return boolean
     */
    function _send($subject, $content)
    {
        $this->ExEmail->reset();
        $this->ExEmail->subject = $subject;
        if (!$return = $this->ExEmail->send($content)) {
            $this->error('Could not send the support mail.');
        }
        if (!empty($this->ExEmail->smtpError)) {
            $this->error($this->ExEmail->smtpError);
        }
        return $return;
    }

    /**
     * Command to send email.
     *
     * @access public
     */
    function send()
    {
        $supports = $this->EasySupport->getEmails();
        $alias = $this->EasySupport->alias;
        foreach ($supports as $support) {
            extract($support[$this->EasySupport->alias]);
            if ($this->_send(String::insert($this->subjects[$type], compact($title)), $content)) {
                $this->EasySupport->updateSent($id);
            }
        }
    }

    /**
     * Test method.
     *
     * @access public
     */
    function test()
    {
        $subject = 'これはお問い合わせのメール送信テストです。';
        $content = "お問い合わせの1行目です。\n";
        $content .= "お問い合わせの2行目です。\n";
        $content .= "お問い合わせの3行目です。\n";
        $content .= "お問い合わせの4行目です。\n";
        $this->ExEmail->to = 'bergmenn1122@gmail.com';
        $this->_send($subject, $content);
    }

}
