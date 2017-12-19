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
$filter = $params->get('types', array('.pdf', '.docx', '.xlsx', '.pptx', '.doc', '.xls', '.ppt'));
$folder = $params->get('folder');
$text   = $params->get('text');

// Load vendor and helper files
include_once 'libraries/vendor/autoload.php';
include_once 'helpers/database.php';
include_once 'helpers/format.php';

// Gather file list
$path = 'images'.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR;
$filter = implode('|', $filter);

// Check the folder exists
if(file_exists($path)){

	// Include required js and css files
	$doc = JFactory::getDocument();
	$doc->addScript('modules/mod_downloads/assets/js/actions.js');

	// Find current full url
	$uri = JUri::getInstance() and $uri = $uri->toString();

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
	if($email = JRequest::getVar('email', false, 'post')){

	// Check honeypot
	if( ! empty($_POST['birthday']) ){
		return true;
	}

	// Save to database
	DownloadsHelperDatabase::save(
		array(
		'name'     => JRequest::getVar('name', false, 'post'),
		'email'    => JRequest::getVar('email', false, 'post'),
		'filename' => JRequest::getVar('filename', false, 'post')
		)
	);

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