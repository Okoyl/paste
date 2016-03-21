<?php
/*
* $ID PROJECT: Paste - sqlite.php, v2 J.Samuel - 10/03/2013 GMT+1 (dd/mm/yy/)
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
 *
 * This file was created by yosef & amin as a pop in replacement for the old mysql, it simply replaces
 * mysql/mysqli/postgre with sqlite.
*/

// Database handler
class DB
{

    var $dblink;
    var $dbresult;

    // Constructor - establishes DB connection
    function DB()
    {
        try {
            global $CONF;
            $this->dblink = new SQLite3($CONF['sqlitefile']);
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            echo "Database was not connected! check file permission&exsistence of " . $CONF['sqlitefile'];

        }
    }

    // How many pastes are in the database?
    function getPasteCount()
    {
        $this->_query('select count(*) as cnt from paste');
        return $this->_next_record() ? $this->_f('cnt') : 0;
    }

    // Delete oldest $deletecount pastes from the database.
    function trimPastes($deletecount)
    {
        // Build a one-shot statement to delete old pastes
        $sql = 'delete from paste where pid in (';
        $sep = '';
        $this->_query("select * from paste order by posted asc limit $deletecount");
        while ($this->_next_record()) {
            $sql .= $sep . $this->_f('pid');
            $sep = ',';
        }
        $sql .= ')';

        // Delete extra pastes.
        $this->_query($sql);
    }

    // Delete all expired pastes.
    function deleteExpiredPastes()
    {
        $this->_query("delete from paste where expires is not null and strftime('%s','now') > expires");
    }

    // Add paste and return ID.
    function addPost($title, $format, $code, $parent_pid, $expiry_flag, $password)
    {
        //figure out expiry time
        switch ($expiry_flag) {
            case 'd':
                //$expires = "DATE_ADD(NOW(), INTERVAL 1 DAY)";
                $expires = "datetime('now','+1 day')";
                break;
            case 'f':
                $expires = "NULL";
                break;
            default:
                //$expires = "DATE_ADD(NOW(), INTERVAL 1 MONTH)";
                $expires = "datetime('now','+1 month')";
                break;
        }
        $this->_query('insert into paste (title, posted, format, code, parent_pid, expires, expiry_flag, password) ' .
            "values (?, strftime('%s','now'), ?, ?, ?, $expires, ?, ?)",
            $title, $format, $code, $parent_pid, $expiry_flag, $password);
        $id = $this->_get_insert_id();
        return $id;
    }

    // Return entire paste row for given ID.
    function getPaste($id)
    { //date_format(posted, '%M %a %D %l:%i %p') as postdate
        $this->_query('select *, strftime(\'%d-%m-%Y %H:%M:%S\', posted) as postdate ' . 'from paste where pid=?', $id);

        if ($this->_next_record()) {
            return $this->row;
        } else
            return false;

    }

    // Return summaries for $count posts ($count=0 means all)
    function getRecentPostSummary($count)
    {
        $limit = $count ? "limit $count" : "";
        $posts = array();// CAST(strftime('%s', 'now') AS INT);
        $this->_query("select pid,title,(select strftime('%s','now'))-posted as age, posted as postdate from paste order by posted desc, pid desc $limit");
        while ($this->_next_record()) {
            $posts[] = $this->row;
        }
        return $posts;
    }

    // Get follow up posts for a particular post
    function getFollowupPosts($pid, $limit = 5)
    {
        //any amendments?
        $childposts = array();
        $this->_query("select pid,title," .
            "strftime('%d-%m-%Y %H:%M:%S', posted) as postfmt " .
            "from paste where parent_pid=? " .
            "order by posted limit $limit", $pid);
        while ($this->_next_record()) {
            $childposts[] = $this->row;
        }
        return $childposts;
    }

    // Save formatted code for displaying.
    function saveFormatting($pid, $codefmt, $codecss)
    {
        //strip comments from css marking

        $regex = array(
            "`^([\t\s]+)`ism" => '',
            "`^\/\*(.+?)\*\/`ism" => "",
            "`([\n\A;]+)\/\*(.+?)\*\/`ism" => "$1",
            "`([\n\A;\s]+)//(.+?)[\n\r]`ism" => "$1\n",
            "`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism" => "\n"
        );
        $strippedcss = preg_replace(array_keys($regex), $regex, $codecss);
        $this->_query("update paste set codefmt=?,codecss=? where pid=?",
            $codefmt, $strippedcss, $pid);
    }

    // Execute query - should be regarded as private to insulate the rest ofthe application from sql differences.
    function _query($sql)
    {
        // Been passed more parameters? do some smart replacement.
        if (func_num_args() > 1) {
            // Query contains ? placeholders, but it's possible the
            // replacement string have ? in too, so we replace them in
            // our sql with something more unique
            $q = md5(uniqid(rand(), true));
            $sql = str_replace('?', $q, $sql);

            $args = func_get_args();
            for ($i = 1; $i <= count($args); $i++) {
                if (isset($args[$i])) {
                    $sql = preg_replace("/$q/", "'" . $this->dblink->escapeString($args[$i]) . "'", $sql, 1);
                }

            }
            // We shouldn't have any $q left, but it will help debugging if we change them back!
            $sql = str_replace($q, '?', $sql);
        }
        $this->dbresult = $this->dblink->query($sql);
        if (!$this->dbresult) {
            die ("FAILED: " + $sql);
        }
        return $this->dbresult;
    }

    // get next record after executing _query.
    function _next_record()
    {

        $this->row = $this->dbresult->fetchArray();
        return $this->row != FALSE;
    }

    // Get result column $field.
    function _f($field)
    {
        return $this->row[$field];
    }

    // Get the last insertion ID.
    function _get_insert_id()
    {
        $this->_query("select seq from sqlite_sequence where name='paste' limit 1");
        return $this->_next_record() ? $this->_f('seq') : false;
    }

    // Get last error.
    function get_db_error()
    {
        return $this->dblink->lastError();
    }
}

?>
