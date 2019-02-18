<?php
/**
 * Created by PhpStorm.
 * User: j.ghasemi
 * Date: 2/17/2019
 * Time: 10:12 AM
 */

namespace pgsavis\psmstructure;


interface setRequired{
    public function setSqlFile($sqlFile);
    public function setName($name);
    public function setTab($tab);
    public function setVersion($version);
    public function setAuthor($author);
    public function setNeedInstance($needInstance);
    public function setBootstrap($bootstrap);
    public function setDisplayName($displayName);
    public function setDescription($description);
    public function setConfirmUninstall($confirmUninstall);
    public function setMin($min);
    public function setMax($max);

    public function getSqlFile():String;
    public function getName():String;
    public function getTab():String;
    public function getVersion():String;
    public function getAuthor():String;
    public function getNeedInstance():Int;
    public function getBootstrap():Boolean;
    public function getDisplayName():String;
    public function getDescription():String;
    public function getConfirmUninstall():String;
    public function getMin():String;
    public function getMax():String;
}