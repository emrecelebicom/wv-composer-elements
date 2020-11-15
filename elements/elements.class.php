<?php
/*
*  Plugin Name: WPBakery Custom Fields
*  Plugin URI: https://ofiss.com.tr/plugins/
*  Description: An extension for Visual Composer that display an community directory option
*  Author: Emre Çelebi
*  Author URI: https://emrecelebi.com
*  Version: 0.1.1
*/

require_once dirname(__FILE__) . '/textbox.class.php';
require_once dirname(__FILE__) . '/textarea.class.php';
require_once dirname(__FILE__) . '/dropdown.class.php';
require_once dirname(__FILE__) . '/image.class.php';

class element{

    public $textbox;
    public $textarea;
    public $dropdown;
    public $image;

    public function __construct()
    {
        $this->textbox = new textbox();
        $this->textarea = new textarea();
        $this->dropdown = new dropdown();
        $this->image = new image();
    }

}