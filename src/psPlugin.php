<?php
/**
 *@author Sayyed Jamal Ghasemi <https://www.linkedin.com/in/jamal1364/>
 * Date: 02/16/2019
 * Time: 14:40 PM
 */

namespace pgsavis\psmstructure;


abstract psPlugin extends Module
{
    abstract function __construct();
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


}