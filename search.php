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
$pastebin = new Pastebin($CONF);

/// Clean up older posts
$pastebin->doGarbageCollection();

// If we get this far, we're going to be displaying some HTML, so let's kick off here.
$page = array();

// Figure out some nice defaults.
$page['current_format'] = $CONF['default_highlighter'];
$page['expiry'] = $CONF['default_expiry'];
$page['remember'] = '';

// Add list of recent posts.
$list = isset($_REQUEST["list"]) ? intval($_REQUEST["list"]) : 9999;
$page['title'] = "Search - " . $CONF['sitetitle'];

// HTML page output.
include('templates/' . $CONF['template'] . '/header.php');
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $title = in_array("title", $_POST['query_type']) ? $_POST['query'] : null;
    $code = in_array("code", $_POST['query_type']) ? $_POST['query'] : null;
    $format = in_array("format", $_POST['query_type']) ? $_POST['query'] : null;
    $page['recent'] = $pastebin->getQueryResults($title, $code, $format, $list);
    $page['title'] = "Search Results- " . $CONF['sitetitle'];
    include('templates/' . $CONF['template'] . '/archive.php');
} else {
    include('templates/' . $CONF['template'] . '/search.php');
}
include('templates/' . $CONF['template'] . '/footer.php');


?>