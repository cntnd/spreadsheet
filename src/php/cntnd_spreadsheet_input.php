?><?php
// cntnd_spreadsheet_input

// input/vars
$filename = "CMS_VALUE[1]";
$separator = "CMS_VALUE[2]";
if (empty($separator)){
  $separator=',';
}
$files = array();

// includes
cInclude('module', 'includes/style.cntnd_simple_spreadsheet_input.php');

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
<div class="form-vertical">
  <div class="form-group">
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
</div>
<?php
