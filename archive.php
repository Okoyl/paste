<?php
/**
 * Created by PhpStorm.
 * User: Yosef
 * Date: 01/04/2016
 * Time: 00:35
 */

require_once('includes/config.inc.php');
require_once('includes/libraries/geshi.php');
require_once('includes/diff.php');
require_once('includes/paste.php');


// Create our pastebin object
$pastebin=new Pastebin($CONF);

/// Clean up older posts
$pastebin->doGarbageCollection();

// If we get this far, we're going to be displaying some HTML, so let's kick off here.
$page=array();



// Add list of recent posts.
$list=isset($_REQUEST["list"]) ? intval($_REQUEST["list"]) : 9999;
$page['recent']=$pastebin->getRecentPosts($list);


$page['title']=$CONF['sitetitle'];


// HTML page output.
include('templates/'.$CONF['template'].'/header.php');
include('templates/'.$CONF['template'].'/archive.php');
include('templates/'.$CONF['template'].'/footer.php');



?>