<!-- Recent Pastes -->
<div class="row-fluid">
    <div class="top-bar"><h3><i class="icon-pencil"></i> Recent Pastes</h3></div>
    <div class="well no-padding" id="pagination-activity">
        <div class="list-widget pagination-content">
            <?php

            foreach ($page['recent'] as $idx => $entry) {
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