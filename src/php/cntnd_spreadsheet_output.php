<?php
// cntnd_core_output

// assert framework initialization
defined('CON_FRAMEWORK') || die('Illegal call: Missing framework initialization - request aborted.');

// editmode and more
$editmode = cRegistry::isBackendEditMode();

// input/vars
// todo

// includes
cInclude('module', 'includes/class.cntnd_spreadsheet.php');
if ($editmode){
  cInclude('module', 'includes/script.cntnd_spreadsheet_output.php');
}

// other/vars
$path = "/home/httpd/vhosts/interunido.ch/httpdocs/interunido/upload/kurse/";
$filename = "kurse.csv";

$spreadsheet = new CntndSpreadsheet($file, $path);

?>
<script>
var data = [<?= $data['data'] ?>];
var headers = <?= $data['headers'] ?>;
var mySpreadsheet = jexcel(document.getElementById('spreadsheet'), {
    data: data,
    defaultColWidth:120,
    defaultColAlign: 'left',
    text:texts,
    columnSorting:false
});
</script>
