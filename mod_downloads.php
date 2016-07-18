<?php

/**
 * Helpdesk Module Entry Point
 * 
 * @package    Joomla
 * @subpackage Modules
 * @license    MIT
 *     
 */
 
// No direct access
defined('_JEXEC') or die;

// Gather FuelPHP
use Fuel\Validation\Validator;

// Settings
$filter   = $params->get('types', array('.pdf', '.docx', '.xlsx', '.pptx', '.doc', '.xls', '.ppt'));
$folder   = $params->get('folder');
$category = $params->get('category', 0);

// Default Variables
$catid = false;

// Find current category ID
if(JRequest::getVar('option')=='com_content'){
  if(JRequest::getVar('view')=='article'){
    $catid = JRequest::getInt('catid');
  }
  elseif(JRequest::getVar('view')=='category'){
    $catid = JRequest::getInt('id');
  }
}

// This module may only display on a selected category
if($catid != $category){
  return null;
}

// Load vendor and helper files
include 'vendor/autoload.php';
include 'helpers/db.php';

// Gather file list
$path = 'images'.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR;
$filter = implode('|', $filter);

// Check the folder exists
if(file_exists($path)){

  // Include required js and css files
  JHtml::_('jquery.framework');
  $doc = JFactory::getDocument();
  $doc->addScript('modules/mod_downloads/assets/js/actions.js');
  //$doc->addScript('https://www.google.com/recaptcha/api.js');
  //$doc->addStyleSheet('components/com_downloads/assets/css/download.css');

  // Joomla doesn't autoload JFile and JFolder
  JLoader::register('JFolder', JPATH_LIBRARIES . '/joomla/filesystem/folder.php');
  
  // Pull the files
  $files = JFolder::files($path, $filter);

  // Loop in extra info
  $newFiles = [];
  foreach($files as $file){
    $src = $path . $file;
    $size = filesize($src);
    $newFiles[md5($file)] = (object) ['name' => $file, 'size' => formatBytes($size)];
  }

  // Check for post data
  if($post = JRequest::getVar('email', false, 'post')){

    // Check honeypot
    if( ! empty($_POST['birthday']) ){
      return true;
    }

    // Validate email
    if(filter_var(JRequest::getVar('email'), FILTER_VALIDATE_EMAIL) === false){
      throw new Exception('Required data invalid', 403);
    }

    // Get flename
    if($filename = JRequest::getVar('filename', false, 'post')){
      header("Location: ".JUri::base()."images/".$folder."/".$filename);
      die();
    }
  }

  // Display data
  if(count($newFiles)){
    require JModuleHelper::getLayoutPath('mod_downloads', 'default');
  }
}

/**
 * Get friendly file size
 *
 * http://php.net/manual/en/function.filesize.phpuser contributed example
 */
function formatBytes($bytes, $decimals = 2) { 
  $sz = 'BKMGTP';
  $factor = floor((strlen($bytes) - 1) / 3);
  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}