<?php
/**
 *@author Sayyed Jamal Ghasemi <https://www.linkedin.com/in/jamal1364/>
 * Date: 02/16/2019
 * Time: 14:40 PM
 */

namespace pgsavis\psmstructure;


abstract class psPlugin extends Module
{
    public function __construct($name,$tab,$version,$author,$need_instance=0,$bootstrap=true,$displayName,$description,$confirmUninstall,$min,$max=_PS_VERSION_){
        parent::__construct();
        $this->name = $name; // internal identifier, unique and lowercase
        $this->tab = $tab; // backend module coresponding category
        $this->version = $version; // version number for the module
        $this->author = $author; // module author
        $this->need_instance = $need_instance; // load the module when displaying the "Modules" page in backend
        $this->bootstrap = $bootstrap;



        $this->displayName = $this->l($displayName); // public name
        $this->description = $this->l($description); // public description

        $this->confirmUninstall = $this->l($confirmUninstall); // confirmation message at uninstall

        $this->ps_versions_compliancy = array('min' => $min, 'max' => $max);
    }
    public function install($sql_file='',$hooks=[],$tabs=[]){
        // Call install parent method
        if (!parent::install())
            return false;

        // Execute module install SQL statements
        //$sql_file = dirname(__FILE__).'/install/install.sql';
        if($sql_file){
            if (!$this->loadSQLFile($sql_file))
                return false;
        }

        if(!empty($hooks)){
            foreach ($hooks as $hook){
                if (!$this->registerHook($hook))
                    return false;
            }
        }

        if(!empty($tabs)){
            foreach ($tabs as $tab){
                // Install admin tab
                if (!$this->installTab($tab['parent'], $tab['className'], $tab['name']))
                    return false;
            }
        }

        // All went well!
        return true;

    }
    public function uninstall(){

    }

    public function loadSQLFile($sql_file)
    {
        // Get install SQL file content
        $sql_content = file_get_contents($sql_file);

        // Replace prefix and store SQL command in array
        $sql_content = str_replace('PREFIX_', _DB_PREFIX_, $sql_content);
        $sql_requests = preg_split("/;\s*[\r\n]+/", $sql_content);

        // Execute each SQL statement
        $result = true;
        foreach($sql_requests as $request)
            if (!empty($request))
                $result &= Db::getInstance()->execute(trim($request));

        // Return result
        return $result;
    }

}