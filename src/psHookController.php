<?php
/**
 * Created by PhpStorm.
 * User: j.ghasemi
 * Date: 2/18/2019
 * Time: 9:23 AM
 */

namespace pgsavis\psmstructure;


abstract class psHookController implements hookController
{

    public $module, $file, $path,$context;
    public function __construct($module, $file, $path,$context)
    {
        $this->file = $file;
        $this->module = $module;
        $this->context = $context;
        $this->_path = $path;
    }

    abstract public function assign($params);

    abstract public function proccess();

    abstract public function run($params);
}