<?php
// Show errors
if (count($pastebin->errors)) {
    echo '<div class="alert alert-error">';
    foreach ($pastebin->errors as $err) {
        echo '<i class="icon-exclamation-sign"></i> ' . $err . ' </div>';
    }
    $page['post']['editcode'] = $_POST['code2'];
    $page['current_format'] = $_POST['format'];
    $page['expiry'] = $_POST['expiry'];
    if ($_POST['password'] != 'EMPTY') {
        $page['post']['password'] = $_POST['password'];
    }
    $page['title'] = "";
    if (isset($_POST['title'])) {
        $page['title'] = $_POST['title'];
    }

}

// Show a paste
function showMe()
{
    global $sep;
    global $page;
    global $post;
    global $followups;
    global $CONF;
    if (strlen($page['post']['posttitle'])) {
        echo '<div class="alert alert-light">' . $page['post']['posttitle'] . ' - Format: ' . ($page['post']['format']) . '';

        if (isset($page['post']['parent_url'])&&$page['post']['parent_pid'] > 0) {
            echo ' - This is a modified post titled "<a href="' . $page['post']['parent_url'] . '" title="View original post">' . $page['post']['parent_title'] . '</a>".';
        }

        $followups = count($page['post']['followups']);
        if ($followups) {
            echo ' - See newer version(s) of this paste titled ';
            $sep = "";
            foreach ($page['post']['followups'] as $idx => $followup) {
                echo $sep . '<a title="Posted on ' . $followup['postfmt'] . '" href="' . $followup['followup_url'] . '">"' . $followup['title'] . '"</a>';
                $sep = ($idx < ($followups - 2)) ? ", " : " and ";
            }
        }

        ?>

        </div>

        <div class="row-fluid">
        <div class="span12">
        <div class="alert alert-success span12" id="copied" style="display:none;">
            <i class="icon-paste"></i>
            The text below is selected, press Ctrl+C to copy to your clipboard. (&#8984;+C on Mac) No line numbers will
            be copied.
        </div>
        <div class="top-bar">
            <ul class="tab-container">
                <li><a href="<?php echo $CONF['url'] ?>"><i class="icon-code"></i> New paste</a></li>
                <li><a href="<?php echo $page['post']['downloadurl'] ?>"><i class="icon-download"></i> Download</a></li>
                <li><a href="<?php echo  str_replace("dl=", "rw=", $page['post']['downloadurl'])  ?>"><i class="icon-search"></i> View</a></li>
                <li><a href="javascript:togglev();" title="Show/Hide line numbers"><i class="icon-list-ul"></i></a></li>
                <li><a href="#" class="copyme" onclick="if(navigator.appVersion.toLowerCase().indexOf('msie')!=-1||navigator.appVersion.toLowerCase().indexOf('trident')!=-1){ selectText('code2');}else{selectText('code'); }showdiv('copied');"
                       title="Copy text to clipboard"><i class="icon-copy"></i></a></li>
            </ul>
        </div>
    <?php } // End post title

    if (isset($page['post']['pid'])) { ?>

        <div class="well" style="background-color: #FFF;" id="code">
            <?php
            echo $page['post']['codefmt'];
            ?>
        </div>
        <div style="float:right; padding-bottom: 5px;">
            <script type="text/javascript"
                    src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-5250e0924bc5b486"></script>
            <!-- AddThis Button BEGIN -->
            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
            <a class="addthis_button_tweet"></a>
            <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
            <a class="addthis_counter addthis_pill_style"></a>
            <!-- AddThis Button END -->
        </div>
        </div>
        </div>

    <?php }
} // End showing of a paste

// Check for a password
$postPass = null;
if (isset($_POST['password'])) {
    $postPass = $_POST['password'];
}


if (isset($pid) && $pid > 0) {
    global $pid;
    $result = $pastebin->getPaste($pid);
    $pass = $result['password'];

    if (isset($pass) && ($pass != "EMPTY")) {
        if (!isset($postPass)) { ?>

            <div class="row-fluid">
                <div class="span5">
                    <form class="form-horizontal" method="post" action="">
                        <div class="top-bar">
                            <h3><i class="icon-warning-sign"></i> This paste is password protected.</b></h3>
                        </div>
                        <div class="well no-padding">
                            <div class="control-group">
                                <label class="control-label" for="password"><i class="icon-key"></i></label>
                                <div class="controls">
                                    <input type="password" name="password" placeholder="Password">
                                    <button class="btn btn-primary" type="submit">Show</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        <?php } else if (sha1($postPass) == $pass) {
            showMe();
        } else { ?>

            <div class="row-fluid">
                <div class="span5">
                    <div class="alert alert-error">
                        <i class="icon icon-warning-sign"></i> The password you entered was incorrect, <a
                            href="#tryagain" onClick="history.go(-1); return false;">Try again.</a></i>
                    </div>
                </div>
            </div>

        <?php }
    } else {
        showMe();
    }
}; // End password page

if (!(isset($pass) && (sha1($postPass) !== $pass)) || $pass == "EMPTY") { ?>
    <!-- Paste area -->
    <div class="row-fluid">
        <div class="span8">
            <form name="editor" method="post" action="index.php">
                <input type="hidden" name="parent_pid" value="<?php if (isset($page['post']['pid'])) {
                    echo $page['post']['pid'];
                } ?>"/>
                <div class="top-bar"><h3><i class="icon-edit"></i> New Paste</h3></div>
                <div class="well">
                    <div class="btn-toolbar">
                        <div class="btn-group" style="margin-top: -5px;">
                            <select name="format">
                                <?php // Show popular GeSHi formats
                                foreach ($CONF['geshiformats'] as $code => $name) {
                                    if (in_array($code, $CONF['popular_formats'])) {
                                        $sel = ($code == $page['current_format']) ? 'selected="selected"' : ' ';
                                        echo '<option ' . $sel . 'value="' . $code . '">' . $name . '</option>';
                                    }
                                }

                                echo '<option value="text">------------------------------</option>';

                                // Show all GeSHi formats.
                                foreach ($CONF['geshiformats'] as $code => $name) {
                                    $sel = ($code == $page['current_format']) ? 'selected="selected"' : ' ';
                                    if (in_array($code, $CONF['popular_formats']))
                                        $sel = "";
                                    echo '<option ' . $sel . 'value="' . $code . '">' . $name . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="btn-group">
                            <a class="btn" onclick="highlight(document.getElementById('code2')); return false;"><i
                                    class="icon-pencil"></i>Highlight Selection</a>
                        </div>
                    </div>
			<textarea id="code2" name="code2" onkeydown="return catchTab(this,event)"><?php

                if (isset($page['post']['editcode'])) {
                    echo htmlspecialchars($page['post']['editcode']);
                } ?></textarea>

                </div>

                <!-- Options -->
                <div class="top-bar"><h3><i class="icon-gear"></i> Paste Options</h3></div>
                <div class="well no-padding">
                    <div class="control-group">
                        <label class="control-label">Paste Title</label>
                        <div class="controls">
                            <div class="input-icon left">
                                <i class="icon-edit"></i>
                                <input class="m-wrap" type="text" maxlength="24" id="title" name="title" value="<?php
                                $page['title'] = "";
                                if (isset($_POST['title'])) {
                                    $page['title'] = $_POST['title'];
                                }
                                echo $page['title'] ?>">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Password</label>
                        <div class="controls">
                            <div class="input-icon left">
                                <i class="icon-lock"></i>
                                <input class="m-wrap" type="password"
                                       value="<?php if (strcmp($postPass, 'EMPTY') != 0) {
                                           echo $postPass;
                                       } else {
                                           echo '';
                                       }
                                      ?>" name="password">
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Paste Expiration</label>
                        <div class="controls">
                            <div class="input-icon left">
                                <i class="icon-trash"></i>
                                <select class="span3 m-wrap" name="expiry" tabindex="1">
                                    <option id="expiry_forever"
                                            value="f" <?php if (isset($page['post'][9])?$page['post'][9]=='f':$page['expiry'] == 'f') echo 'selected="selected"'; ?>>
                                        None
                                    </option>
                                    <option id="expiry_day"
                                            value="d" <?php if (isset($page['post'][9])?$page['post'][9]=='d':$page['expiry'] == 'd') echo 'selected="selected"'; ?>>
                                        One Day
                                    </option>
                                    <option id="expiry_month"
                                            value="m" <?php if (isset($page['post'][9])?$page['post'][9]=='m':$page['expiry'] == 'm') echo 'selected="selected"'; ?>>
                                        One Month
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <?php if ($CONF['useRecaptcha']) {
                        require_once('includes/libraries/recaptchalib.php'); ?>
                        <p>Please input the image below to prove you're not a spambot.
                            <!-- reCAPTCHA -->
                            <!-- Quick hack to maintain responsiveness -->
                            <script
                                src="http://korylprince.github.io/reCAPTCHA_Responsive/recaptcha_mobile.min.js"></script>
                            <script> var RecaptchaOptions = {theme: 'clean'}; </script>
                            <?php echo recaptcha_get_html($CONF['pubkey']) . "\n"; ?><br/>
                            <?php } ?>
                            <button class="btn" type="submit" name="paste"><i class="icon-arrow-right"></i> Submit
                            </button>
                        </p>
                    </div>
            </form>
        </div>
    </div>
    <!-- Recent Pastes -->
    <div class="span4">
        <div class="top-bar"><h3><i class="icon-pencil"></i> Recent Pastes</h3></div>
        <div class="well no-padding" id="pagination-activity">
            <div class="list-widget pagination-content">
                <?php foreach ($page['recent'] as $idx => $entry) {
                    if (isset($pid) && $entry['pid'] == $pid) $cls = "background-color: #e0e0e0;";
                    else $cls = ""; ?>
                    <div class="item" style="display: block; <?php echo $cls; ?>">
                        <small class="pull-right"><?php echo $entry['agefmt']; ?></small>
                        <p class="no-margin"><i class="icon-code"></i>
                            <?php if ($CONF['mod_rewrite'] == true) {
                                echo '<a href="' . $CONF['url'] . $entry['pid'] . '">' . $entry['title'] . '</a>';
                            } else {
                                echo '<a href="' . $CONF['url'] . '?paste=' . $entry['pid'] . '">' . $entry['title'] . '</a>';
                            } ?>
                        </p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    </div>
<?php } ?>
