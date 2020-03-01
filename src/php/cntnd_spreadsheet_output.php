<?php
// cntnd_spreadsheet_output

// assert framework initialization
defined('CON_FRAMEWORK') || die('Illegal call: Missing framework initialization - request aborted.');

// editmode and more
$editmode = cRegistry::isBackendEditMode();

// input/vars
$filename = "CMS_VALUE[1]";

// includes #1
cInclude('module', 'includes/class.cntnd_spreadsheet.php');

// other/vars
$spreadsheet = new CntndSpreadsheet($filename);

if ($_POST){
  $stored = $spreadsheet->store($_POST);
}

$data = $spreadsheet->load();

// includes #2
if ($editmode){
  cInclude('module', 'includes/script.cntnd_spreadsheet_output.php');

	echo '<div class="content_box"><label class="content_type_label">'.mi18n("MODULE").'</label>';
  ?>
  <script>
  $(document).ready(function(){
    var texts = {
      noRecordsFound:'<?= mi18n("noRecordsFound") ?>',
      showingPage:'<?= mi18n("showingPage") ?>',
      show:'<?= mi18n("show") ?>',
      entries:'<?= mi18n("entries") ?>',
      insertANewColumnBefore:'<?= mi18n("insertANewColumnBefore") ?>',
      insertANewColumnAfter:'<?= mi18n("insertANewColumnAfter") ?>',
      deleteSelectedColumns:'<?= mi18n("deleteSelectedColumns") ?>',
      renameThisColumn:'<?= mi18n("renameThisColumn") ?>',
      orderAscending:'<?= mi18n("orderAscending") ?>',
      orderDescending:'<?= mi18n("orderDescending") ?>',
      insertANewRowBefore:'<?= mi18n("insertANewRowBefore") ?>',
      insertANewRowAfter:'<?= mi18n("insertANewRowAfter") ?>',
      deleteSelectedRows:'<?= mi18n("deleteSelectedRows") ?>',
      editComments:'<?= mi18n("editComments") ?>',
      addComments:'<?= mi18n("addComments") ?>',
      comments:'<?= mi18n("comments") ?>',
      clearComments:'<?= mi18n("clearComments") ?>',
      copy:'<?= mi18n("copy") ?>',
      paste:'<?= mi18n("paste") ?>',
      saveAs:'<?= mi18n("saveAs") ?>',
      about: '<?= mi18n("about") ?>',
      areYouSureToDeleteTheSelectedRows:'<?= mi18n("areYouSureToDeleteTheSelectedRows") ?>',
      areYouSureToDeleteTheSelectedColumns:'<?= mi18n("areYouSureToDeleteTheSelectedColumns") ?>',
      thisActionWillDestroyAnyExistingMergedCellsAreYouSure:'<?= mi18n("thisActionWillDestroyAnyExistingMergedCellsAreYouSure") ?>',
      thisActionWillClearYourSearchResultsAreYouSure:'<?= mi18n("thisActionWillClearYourSearchResultsAreYouSure") ?>',
      thereIsAConflictWithAnotherMergedCell:'<?= mi18n("thereIsAConflictWithAnotherMergedCell") ?>',
      invalidMergeProperties:'<?= mi18n("invalidMergeProperties") ?>',
      cellAlreadyMerged:'<?= mi18n("cellAlreadyMerged") ?>',
      noCellsSelected:'<?= mi18n("noCellsSelected") ?>',
    };
    var data = [<?= $data['data'] ?>];
    var headers = <?= $data['headers'] ?>;
    var mySpreadsheet = $('#spreadsheet').jexcel({
        data: data,
        columns: headers,
        defaultColWidth: 120,
        defaultColAlign: 'left',
        text: texts,
        columnSorting: false,
        toolbar:[{
            type: 'i',
            content: 'save',
            onclick: function () {
                $('#cntnd_spreadsheet').submit();
            }
        },{
            type: 'i',
            content: 'undo',
            onclick: function() {
                mySpreadsheet.undo();
            }
        },{
            type: 'i',
            content: 'redo',
            onclick: function() {
                mySpreadsheet.redo();
            }
        }]
    });
    $('#cntnd_spreadsheet').submit(function() {
      var data = mySpreadsheet.getData();
      var headers = mySpreadsheet.getHeaders();
      $('#cntnd_spreadsheet-csv').val(Base64.encode(JSON.stringify(data)));
      $('#cntnd_spreadsheet-headers').val(Base64.encode(JSON.stringify(headers)));
      return true;
    });
  });
  </script>
  <form id="cntnd_spreadsheet" name="cntnd_spreadsheet" method="post">
    <div id="spreadsheet"></div>
    <input type="hidden" name="cntnd_spreadsheet-csv" id="cntnd_spreadsheet-csv" />
    <input type="hidden" name="cntnd_spreadsheet-headers" id="cntnd_spreadsheet-headers" />
  </form>
<?php
}
?>
