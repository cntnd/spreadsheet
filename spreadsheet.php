<!DOCTYPE html>
<html class="no-js" lang="en-US"> <!--<![endif]-->
  <head>
    <title>spreadsheet</title>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-base64@2.5.2/base64.min.js"></script>
    <script src="https://bossanova.uk/jexcel/v3/jexcel.js"></script>
    <script src="https://bossanova.uk/jsuites/v2/jsuites.js"></script>

    <link rel="stylesheet" href="https://bossanova.uk/jsuites/v2/jsuites.css" type="text/css" />
    <link rel="stylesheet" href="https://bossanova.uk/jexcel/v3/jexcel.css" type="text/css" />
  </head>
  <body>
    <?php

      include('src/php/includes/class.cntnd_spreadsheet.php');
      // READ CSV
      //$path = "/home/httpd/vhosts/interunido.ch/httpdocs/interunido/upload/kurse/";
      $path = "";
      $filename = "kurse.csv";
      $spreadsheet = new CntndSpreadsheet($filename, $path);

      if ($_POST){
        //$stored = $spreadsheet->store($_POST);
      	$base64 = base64_decode($_POST['cntnd_simple_spreadsheet-csv']);
      	$csv = json_decode($base64);
      	var_dump($csv);
      }

      $data = $spreadsheet->load();
    ?>

    <form method="post" id="cntnd_spreadsheet" name="cntnd_spreadsheet">
      <input type="text" name="cntnd_simple_spreadsheet-csv" id="cntnd_simple_spreadsheet-csv" />
      <input type="text" name="cntnd_simple_spreadsheet-headers" id="cntnd_simple_spreadsheet-headers" />
      <p><button id='download'>SAVE</button> <a href="#" id="test">test</a></p>
      <div id="spreadsheet"></div>
    </form>
    <script type="text/javascript">
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
          columnSorting:false
      });

      $('#test').click(function(){
        var data = mySpreadsheet.getData();
        var headers = mySpreadsheet.getHeaders();
        $('#cntnd_simple_spreadsheet-csv').val(Base64.encode(JSON.stringify(data)));
        $('#cntnd_simple_spreadsheet-headers').val(Base64.encode(JSON.stringify(headers)));
      });

      $('#cntnd_spreadsheet').submit(function() {
        var data = mySpreadsheet.getData();
        var headers = mySpreadsheet.getHeaders();
        $('#cntnd_simple_spreadsheet-csv').val(Base64.encode(JSON.stringify(data)));
        $('#cntnd_simple_spreadsheet-headers').val(Base64.encode(JSON.stringify(headers)));
        return true;
      });
    </script>
  </body>
</html>
