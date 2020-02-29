<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://bossanova.uk/jexcel/v3/jexcel.js"></script>
<script src="https://bossanova.uk/jsuites/v2/jsuites.js"></script>

<link rel="stylesheet" href="https://bossanova.uk/jsuites/v2/jsuites.css" type="text/css" />
<link rel="stylesheet" href="https://bossanova.uk/jexcel/v3/jexcel.css" type="text/css" />

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

  $('#cntnd_spreadsheet').submit(function() {
    var data = mySpreadsheet.getData();
    var headers = mySpreadsheet.getHeaders();
    $('#cntnd_spreadsheet-csv').val(JSON.stringify(data));
    $('#cntnd_spreadsheet-headers').val(JSON.stringify(headers));
    return true;
  });

});
</script>
