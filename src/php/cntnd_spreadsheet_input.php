?><?php
// cntnd_spreadsheet_input
$cntnd_module = "cntnd_spreadsheet";

// input/vars
$filename = "CMS_VALUE[1]";
$separator = "CMS_VALUE[2]";
if (empty($separator)){
  $separator=',';
}
$files = array();
$active = (bool) "CMS_VALUE[3]";
$noOutput = (bool) "CMS_VALUE[4]";
$noOutputMessage = "CMS_VALUE[5]";

// includes
cInclude('module', 'includes/style.cntnd_spreadsheet.php');

// data load
$db = new cDb;

$cfgClient = cRegistry::getClientConfig();
$uploadDir = $cfgClient[$client]['upl']['path'];

// medien, images, folders
$cfg = cRegistry::getConfig();

$sql = "SELECT * FROM :table WHERE idclient=:idclient AND filetype IN ('csv') ORDER BY dirname ASC, filename ASC";
$values = array(
    'table' => $cfg['tab']['upl'],
    'idclient' => cSecurity::toInteger($client)
);
$db->query($sql, $values);
while ($db->nextRecord()) {
    $files[$db->f('idupl')] = array('filename' => $db->f('dirname').$db->f('filename'), 'filepath' => $uploadDir.$db->f('dirname').$db->f('filename'));
}
?>
<div class="form-vertical" xmlns="http://www.w3.org/1999/html">
    <div class="form-group">
        <div class="form-check form-check-inline">
            <input id="activate_module" class="form-check-input" type="checkbox" name="CMS_VAR[3]" value="true" <?php if($active){ echo 'checked'; } ?> />
            <label for="activate_module" class="form-check-label"><?= mi18n("ACTIVATE_MODULE") ?></label>
        </div>
    </div>

    <fieldset>
        <legend><?= mi18n("NO_OUTPUT") ?></legend>

        <div class="form-group">
            <div class="form-check form-check-inline">
                <input id="no_output" class="form-check-input" type="checkbox" name="CMS_VAR[4]" value="true" <?php if($noOutput){ echo 'checked'; } ?> />
                <label for="no_output" class="form-check-label"><?= mi18n("NO_OUTPUT") ?></label>
            </div>
        </div>

        <div class="form-group">
            <label for="no_output_message"><?= mi18n("NO_OUTPUT_MESSAGE") ?></label>
            <textarea id="no_output_message" name="CMS_VAR[5]"><?= $noOutputMessage ?></textarea>
        </div>
    </fieldset>

    <fieldset class="d-flex">
        <legend><?= mi18n("LABEL_FILE") ?></legend>

        <div class="form-group" style="margin-right: 12px;">
            <label for="filename"><?= mi18n("LABEL_FILE") ?></label>
            <select name="CMS_VAR[1]" id="filename" size="1" onchange="this.form.submit()">
                <option value="false"><?= mi18n("SELECT_CHOOSE") ?></option>
                <?php
                foreach ($files as $value) {
                    $selected='';
                    if ($filename==$value['filepath']){
                        $selected='selected="selected"';
                    }
                    echo '<option value="'.$value['filepath'].'" '.$selected.'>'.$value['filename'].'</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="filename"><?= mi18n("LABEL_SEPARATOR") ?></label>
            <input type="text" maxlength="1" name="CMS_VAR[2]" value="<?= $separator ?>"/>
        </div>
    </fieldset>
</div>
<?php
