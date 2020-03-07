<?php
// cntnd_simple_spreadsheet_output

// assert framework initialization
defined('CON_FRAMEWORK') || die('Illegal call: Missing framework initialization - request aborted.');

// editmode and more
$editmode = cRegistry::isBackendEditMode();

// input/vars
$filename = "CMS_VALUE[1]";
$separator = "CMS_VALUE[2]";

// includes #1
cInclude('module', 'includes/class.cntnd_spreadsheet.php');

// other/vars
$spreadsheet = new CntndSpreadsheet($filename, $separator);

if ($_POST){
  $stored = $spreadsheet->store($_POST);
}

$data = $spreadsheet->load();

// includes #2
if ($editmode){
  cInclude('module', 'includes/script.cntnd_simple_spreadsheet_output.php');

	echo '<div class="content_box"><label class="content_type_label">'.mi18n("MODULE").'</label>';
  ?>
  <script>
  $(document).ready(function(){
    var texts = {
      noRecordsFound:'Keine Einträge gefunden',
      showingPage:'Seite {0} von {1}',
      show:'Zeige',
      entries:'Einträge',
      insertANewColumnBefore:'Tabellenspalte links einfügen',
      insertANewColumnAfter:'Tabellenspalte rechts einfügen',
      deleteSelectedColumns:'Spalte löschen',
      renameThisColumn:'Spalte umbennen',
      orderAscending:'Aufsteigend sortieren',
      orderDescending:'Absteigend sortieren',
      insertANewRowBefore:'Zeile oberhalb einfügen',
      insertANewRowAfter:'Zeile unterhalb einfügen',
      deleteSelectedRows:'Zeile löschen',
      editComments:'Kommentar bearbeiten',
      addComments:'Kommentar hinzufügen',
      comments:'Kommentare',
      clearComments:'Kommentare löschen',
      copy:'Kopieren ...',
      paste:'Einfügen ...',
      saveAs:'Speichern unter ...',
      about: 'Über',
      areYouSureToDeleteTheSelectedRows:'Ausgewählte Zeilen löschen?',
      areYouSureToDeleteTheSelectedColumns:'Ausgewählte Tabellenspalten löschen?',
      thisActionWillDestroyAnyExistingMergedCellsAreYouSure:'Diese Aktion überschreibt bereits verbundene Zellen. Fortfahren?',
      thisActionWillClearYourSearchResultsAreYouSure:'Diese Aktion löschte alle Suchresultate. Fortfahren?',
      thereIsAConflictWithAnotherMergedCell:'Es gibt ein konflikt mit einer bestehenden verbundenen Zelle',
      invalidMergeProperties:'Ungültige Aktion',
      cellAlreadyMerged:'Zellen bereits verbunden',
      noCellsSelected:'Keine Zellen ausgewählt',
    };
    var data = [<?= $data['data'] ?>];
    var headers = <?= $data['headers'] ?>;
    var mySpreadsheet = $('#spreadsheet').jexcel({
        data: data,
        columns: headers,
        defaultColWidth:120,
        defaultColAlign: 'left',
        text:texts,
        columnSorting:false,
        toolbar:[{
            type: 'i',
            content: 'save',
            onclick: function () {
                $('#cntnd_simple_spreadsheet').submit();
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
    $('#cntnd_simple_spreadsheet').submit(function() {
      var data = mySpreadsheet.getData();
      var headers = mySpreadsheet.getHeaders();
      $('#cntnd_simple_spreadsheet-csv').val(Base64.encode(JSON.stringify(data)));
      $('#cntnd_simple_spreadsheet-headers').val(Base64.encode(JSON.stringify(headers)));
      return true;
    });
  });
  </script>
  <form id="cntnd_simple_spreadsheet" name="cntnd_simple_spreadsheet" method="post">
    <div id="spreadsheet"></div>
    <input type="hidden" name="cntnd_simple_spreadsheet-csv" id="cntnd_simple_spreadsheet-csv" />
    <input type="hidden" name="cntnd_simple_spreadsheet-headers" id="cntnd_simple_spreadsheet-headers" />
  </form>
<?php
}
?>
