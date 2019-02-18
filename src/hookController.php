<?php
/**
 * Created by PhpStorm.
 * User: j.ghasemi
 * Date: 2/17/2019
 * Time: 4:08 PM
 */

namespace pgsavis\psmstructure;


interface hookController
{
    public function assign($params);
    public function proccess();
    public function run();
}