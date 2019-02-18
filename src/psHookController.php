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

    public function __construct($module, $file, $path)
    {
        $this->file = $file;
        $this->module = $module;
        $this->context = \Context::getContext();
        $this->_path = $path;
    }

    abstract public function assign($params);

    abstract public function proccess();

    abstract public function run();
}