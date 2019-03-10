<?php
/**
 * Created by PhpStorm.
 * User: j.ghasemi
 * Date: 2/17/2019
 * Time: 10:12 AM
 */

namespace pgsavis\psmstructure;


interface setRequired{
    public function setSqlFileInstall($sqlFile);
    public function setSqlFileUinstall($sqlFile);
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

    public function getSqlFileInstall();
    public function getSqlFileUinstall();
    public function getName();
    public function getTab();
    public function getVersion();
    public function getAuthor();
    public function getNeedInstance();
    public function getBootstrap();
    public function getDisplayName();
    public function getDescription();
    public function getConfirmUninstall();
    public function getMin();
    public function getMax();
}