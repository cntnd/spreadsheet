?><?php
// cntnd_spreadsheet_input

// input/vars
$filename = "CMS_VALUE[1]";

// data load
$db = new cDb;

$cfgClient = cRegistry::getClientConfig();
$uploadDir = $cfgClient[$client]['upl']['path'];

// medien, images, folders
$cfg = cRegistry::getConfig();
$mediatypes=array('csv');

$sql = "SELECT * FROM :table WHERE idclient=:idclient ORDER BY dirname ASC, filename ASC";
$values = array(
    'table' => $cfg['tab']['upl'],
    'idclient' => cSecurity::toInteger($client)
);
$db->query($sql, $values);
while ($db->nextRecord()) {
  if (in_array($db->f('filetype'),$mediatypes)){
    $files[$db->f('idupl')] = array('filename' => $db->f('dirname').$db->f('filename'), 'filepath' => $uploadDir.$db->f('dirname').$db->f('filename'));
  }
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
</div>
<?php
