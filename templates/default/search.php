<!-- Recent Pastes -->
<div class="row-fluid">
    <form action="search.php" method="POST">
        <div class="top-bar"><h3><i class="icon-gear"></i> Paste Options</h3></div>
        <div class="well no-padding">
            <div class="control-group">
                <label class="control-label">Query</label>
                <div class="controls">
                    <div class="input-icon left">
                        <i class="icon-edit"></i>
                        <input class="m-wrap" type="text" maxlength="24" id="Your search query" name="query" value=""
                               placeholder='public static void main'>
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Search in</label>
                <div class="controls">
                    <div class="input-icon left">
                        <i class="icon-trash"></i>
                        <select name="query_type[]" class="row-fluid" multiple>
                            <option value="title" selected>Title</option>
                            <option value="code" selected>Code</option>
                            <option value="format" selected>Code Format</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <input value="Search" class="btn" type="submit" name="paste">
                </input>
                <p></p>
            </div>
    </form>
</div>
</div>

