<?php
/*
* $ID PROJECT: Paste - index.php, v2 J.Samuel - 10/03/2013 GMT+1 (dd/mm/yy/)
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 3
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*/

// Includes
require_once('includes/config.inc.php');
require_once('includes/libraries/geshi.php');
require_once('includes/diff.php');
require_once('includes/paste.php');

// Magic quotes are anything but magic - lose them!
if (get_magic_quotes_gpc())
{
	function callback_stripslashes(&$val, $name) 
	{
		if (get_magic_quotes_gpc()) 
			$val=stripslashes($val);
	}


	if (count($_GET))
		array_walk ($_GET, 'callback_stripslashes');
	if (count($_POST))
		array_walk ($_POST, 'callback_stripslashes');
	if (count($_COOKIE))
		array_walk ($_COOKIE, 'callback_stripslashes');
}

// Create our pastebin object
$pastebin=new Pastebin($CONF);

/// Clean up older posts 
$pastebin->doGarbageCollection();

// Process new posting
$errors=array();
if (isset($_POST['paste']))
{	/* Process posting and redirect */
	$id=$pastebin->doPost($_POST);
	if ($id)
	{
		$pastebin->redirectToPost($id);
		exit;
	}
}

// Process downloads.
if (isset($_GET['dl'])) 
{
  global $errors;
   if (isset($_GET['pass']))
      $getPass = $_GET['pass'];
	$pid=intval($_GET['dl']);
    $result = $pastebin->getPaste($pid);
   
   if ($result == FALSE) {
	   header('HTTP/1.0 404 Not Found');
      echo "Paste $pid is not available.";
      exit;
   }
    $pass = $result['password'];

   if ($pass == 'EMPTY') {
      $pastebin->doDownload($pid);
	  exit;
   }

   else if ($pass == $getPass){
      $pastebin->doDownload($pid);
	  exit;
   }
}


// Process raw display requets.
if (isset($_GET['rw']))
{
	global $errors;
	if (isset($_GET['pass']))
		$getPass = $_GET['pass'];
	$pid=intval($_GET['rw']);
	$result = $pastebin->getPaste($pid);

	if ($result == FALSE) {
		header('HTTP/1.0 404 Not Found');
		echo "Paste $pid is not available.";
		exit;
	}
	$pass = $result['password'];

	if ($pass == 'EMPTY') {
		$pastebin->doDisplay($pid);
		exit;
	}
	else if($pass == $getPass){
		$pastebin->doDisplay($pid);
		exit;
	}
}




// If we get this far, we're going to be displaying some HTML, so let's kick off here.
$page=array();

// Figure out some nice defaults.
$page['current_format']=$CONF['default_highlighter'];
$page['expiry']=$CONF['default_expiry'];
$page['remember']='';

// Add list of recent posts.
$list=isset($_REQUEST["list"]) ? intval($_REQUEST["list"]) : 10;
$page['recent']=$pastebin->getRecentPosts($list);

// Show a post.
if (isset($_REQUEST["paste"]))
{
	$pid=intval($_REQUEST['paste']);
	// Get the post.
	$page['post']=$pastebin->getPaste($pid);
	// Ensure corrent format is selected.
	$page['current_format']=$page['post']['format'];
}
else
{
	$page['posttitle']='New posting';
}

if ($page['current_format']!='text')
{
	// Give the page a title which features the syntax used.
	$page['title']=$CONF['geshiformats'][$page['current_format']] . " - ".$CONF['sitetitle'];
}
else
{
	$page['title']=$CONF['sitetitle'];
}

// HTML page output.
include('templates/'.$CONF['template'].'/header.php');
include('templates/'.$CONF['template'].'/main.php');
include('templates/'.$CONF['template'].'/footer.php');
