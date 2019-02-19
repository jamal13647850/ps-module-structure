<?php

/**
 *@author Sayyed Jamal Ghasemi <https://www.linkedin.com/in/jamal1364/>
 * Date: 02/16/2019
 * Time: 14:40 PM
 */
declare(strict_types=1);
namespace pgsavis\psmstructure;


use Couchbase\BooleanFieldSearchQuery;

abstract class psPlugin extends \Module
{
    private  $sqlFileInstall;
    private  $sqlFileUinstall;
    private  $hooks;
    private  $tabs;
    private  $DBPrefix;

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }
    public function __construct(setRequiredCLS $required){
        parent::__construct();
        $this->name = $required->getName(); // internal identifier, unique and lowercase
        $this->tab = $required->getTab(); // backend module coresponding category
        $this->version = $required->getVersion(); // version number for the module
        $this->author = $required->getAuthor(); // module author
        $this->need_instance = $required->getNeedInstance(); // load the module when displaying the "Modules" page in backend
        $this->bootstrap = $required->getBootstrap();

        $this->displayName = $this->l($required->getDisplayName()); // public name
        $this->description = $this->l($required->getDescription()); // public description

        $this->confirmUninstall = $this->l($required->getConfirmUninstall()); // confirmation message at uninstall

        $this->ps_versions_compliancy = array('min' => $required->getMin(), 'max' => $required->getMax());

        $this->sqlFileInstall= $required->getSqlFileInstall();
        $this->sqlFileUinstall= $required->getSqlFileUinstall();
        $this->hooks = $required->getHooks();
        $this->tabs = $required->getTabs();
        $this->DBPrefix = $required->getDBPrefix();
    }

    public function install(){
        // Call install parent method
        if (!parent::install())
            return false;

        // Execute module install SQL statements
        //$sql_file = dirname(__FILE__).'/install/install.sql';
        if($this->sqlFileInstall){
            if (!$this->loadSQLFile($this->sqlFileInstall))
                return false;
        }

        if(!empty($this->hooks)){
            foreach ($this->hooks as $hook){
                if (!$this->registerHook($hook))
                    return false;
            }
        }

        if(!empty($this->tabs)){
            foreach ($this->tabs as $tab){
                // Install admin tab
                if (!$this->installTab($tab['parent'], $tab['className'], $tab['name']))
                    return false;
            }
        }

        // All went well!
        return true;

    }
    public function uninstall(){
        // Call uninstall parent method
        if (!parent::uninstall())
            return false;

        // Execute module install SQL statements
        if($this->sqlFileUinstall){
            if (!$this->loadSQLFile($this->sqlFileUinstall))
                return false;
        }

        // Uninstall admin tab
        if(!empty($this->tabs)){
            foreach ($this->tabs as $tab){
                // Install admin tab
                if (!$this->uninstallTab($tab['className']))
                    return false;
            }
        }

        // All went well!
        return true;
    }

    public function loadSQLFile($sql_file){
        // Get install SQL file content
        $sql_content = file_get_contents($sql_file);

        // Replace prefix and store SQL command in array
        $sql_content = str_replace('PREFIX_', $this->DBPrefix, $sql_content);
        $sql_requests = preg_split("/;\s*[\r\n]+/", $sql_content);

        // Execute each SQL statement
        $result = true;
        foreach($sql_requests as $request)
            if (!empty($request))
                $result &= \Db::getInstance()->execute(trim($request));

        // Return result
        return $result;
    }
    public function installTab($parent, $class_name, $name)
    {
        // Create new admin tab
        $tab = new \Tab();
        $tab->id_parent = (int)\Tab::getIdFromClassName($parent);
        $tab->name = array();
        foreach (\Language::getLanguages(true) as $lang)
            $tab->name[$lang['id_lang']] = $name;
        $tab->class_name = $class_name;
        $tab->module = $this->name;
        $tab->active = 1;
        return $tab->add();
    }
    public function uninstallTab($class_name)
    {
        // Retrieve Tab ID
        $id_tab = (int)\Tab::getIdFromClassName($class_name);

        // Load tab
        $tab = new \Tab((int)$id_tab);

        // Delete it
        return $tab->delete();
    }

    public function getHookController($hookName,$moduleObject,$file,$path){
        // Build dynamically the controller name
        $controllerName = $hookName.'HookController';

        // Instanciate controller
        $controllerName = "gosafirschemagenerator\controllers\hook\\".$controllerName ;
        $controller = new $controllerName($moduleObject, $file, $path);

        // Return the controller
        return $controller;
    }


}