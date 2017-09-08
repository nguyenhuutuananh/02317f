<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default. For example,
| the database is not connected to automatically since no assumption
| is made regarding whether you intend to use it.  This file lets
| you globally define which systems you would like loaded with every
| request.
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the things you can load automatically:
|
| 1. Packages
| 2. Libraries
| 3. Drivers
| 4. Helper files
| 5. Custom config files
| 6. Language files
| 7. Models
|
*/

/*
| -------------------------------------------------------------------
|  Auto-load Packages
| -------------------------------------------------------------------
| Prototype:
|
|  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
|
*/
$autoload['packages'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Libraries
| -------------------------------------------------------------------
| These are the classes located in system/libraries/ or your
| application/libraries/ directory, with the addition of the
| 'database' library, which is somewhat of a special case.
|
| Prototype:
|
|   $autoload['libraries'] = array('database', 'email', 'session');
|
| You can also supply an alternative library name to be assigned
| in the controller:
|
|   $autoload['libraries'] = array('user_agent' => 'ua');
*/
$autoload['libraries'] = array( 'user_agent', 'encryption','email', 'encoding_lib', 'action_hooks', 'perfex_base','form_validation' );
$CI = &get_instance();

array_unshift($autoload['libraries'],'database');
$CI->load->helper('perfex_files');
$gateways = list_files(APPPATH.'/libraries/gateways');
foreach($gateways as $gateway){
    $pathinfo =  pathinfo($gateway);
    // Check if file is .php and do not starts with .dot
    // Offen happens Mac os user to have underscore prefixed files while unzipping the zip file.
    if($pathinfo['extension'] == 'php' && 0 !== strpos($gateway, '.')){
        array_push($autoload['libraries'],'gateways/'.strtolower($pathinfo['filename']));
    }
}
/*
| -------------------------------------------------------------------
|  Auto-load Drivers
| -------------------------------------------------------------------
| These classes are located in system/libraries/ or in your
| application/libraries/ directory, but are also placed inside their
| own subdirectory and they extend the CI_Driver_Library class. They
| offer multiple interchangeable driver options.
|
| Prototype:
|
|   $autoload['drivers'] = array('cache');
*/
$autoload['drivers'] = array();
array_push($autoload['drivers'],'session');


/*
| -------------------------------------------------------------------
|  Auto-load Helper Files
| -------------------------------------------------------------------
| Prototype:
|
|   $autoload['helper'] = array('url', 'file');
*/
$autoload['helper'] = array(
        'url',
        'file',
        'form',
        'perfex_action_hooks',
        'perfex_general',
        'perfex_misc',
        'perfex_func',
        'perfex_custom_fields',
        'perfex_merge_fields',
        'perfex_html',
        'perfex_db',
        'perfex_upload',
        'perfex_sales',
        'perfex_themes',
        'perfex_theme_style',
        'perfex_constants',
    );

if(file_exists(APPPATH.'helpers/my_functions_helper.php')){
    array_push($autoload['helper'],'my_functions');
}
/*
| -------------------------------------------------------------------
|  Auto-load Config files
| -------------------------------------------------------------------
| Prototype:
|
|   $autoload['config'] = array('config1', 'config2');
|
| NOTE: This item is intended for use ONLY if you have created custom
| config files.  Otherwise, leave it blank.
|
*/
$autoload['config'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Language files
| -------------------------------------------------------------------
| Prototype:
|
|   $autoload['language'] = array('lang1', 'lang2');
|
| NOTE: Do not include the "_lang" part of your file.  For example
| "codeigniter_lang.php" would be referenced as array('codeigniter');
|
*/
$autoload['language'] = array('english');

/*
| -------------------------------------------------------------------
|  Auto-load Models
| -------------------------------------------------------------------
| Prototype:
|
|   $autoload['model'] = array('first_model', 'second_model');
|
| You can also supply an alternative model name to be assigned
| in the controller:
|
|   $autoload['model'] = array('first_model' => 'first');
*/
$autoload['model'] = array( 'misc_model' , 'roles_model' , 'clients_model' , 'tasks_model' );
