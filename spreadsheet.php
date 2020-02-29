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
    <script src="https://bossanova.uk/jexcel/v3/jexcel.js"></script>
    <script src="https://bossanova.uk/jsuites/v2/jsuites.js"></script>

    <link rel="stylesheet" href="https://bossanova.uk/jsuites/v2/jsuites.css" type="text/css" />
    <link rel="stylesheet" href="https://bossanova.uk/jexcel/v3/jexcel.css" type="text/css" />
  </head>
  <body>
    <?php
      if ($_POST){
        if (!empty($_POST['csv'])){
          $fp = fopen('test.csv', 'w');

          if (!empty($_POST['headers'])){
            $headers = json_decode($_POST['headers']);
            fputcsv($fp, str_getcsv($headers,","));
          }

          $csv = json_decode($_POST['csv']);
          foreach ($csv as $fields) {
              fputcsv($fp, $fields);
          }

          fclose($fp);
        }
      }

      // READ CSV
      //$path = "/home/httpd/vhosts/interunido.ch/httpdocs/interunido/upload/kurse/";
      $path = "";
      $filename = "kurse.csv";

      $file = file_get_contents($path.$filename, FILE_USE_INCLUDE_PATH);

      $csv = str_getcsv($file,"\n");

      $headers = "";
      $data = "";
      $i=0;
      foreach ($csv as $row) {
        if ($i==0){
          $headers .= "[";
          $keys = str_getcsv($row,",");
          foreach ($keys as $value) {
            $headers .= "{ title: '".$value."' },";
          }
          $headers .= "]";
        }
        else {
          $data .= "[";
          $keys = str_getcsv($row,",");
          foreach ($keys as $value) {
            $data .= "'".$value."',";
          }
          $data .= "],";
        }
        $i++;
      }
    ?>

    <form method="post" id="cntnd_spreadsheet" name="cntnd_spreadsheet">
      <input type="text" name="csv" id="csv" />
      <input type="text" name="headers" id="headers" />
      <p><button id='download'>Export my spreadsheet as CSV</button> <a href="#" id="test">test</a></p>
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

      var data = [<?= $data ?>]; // data:data,
      var headers = <?= $headers ?>;

      /*
      nestedHeaders:[
              [
                  {
                      title: 'Supermarket information',
                      colspan: '3',
                  },
              ],
              [
                  {
                      title: 'Location',
                      colspan: '1',
                  },
                  {
                      title: ' Other Information',
                      colspan: '2'
                  }
              ],
          ],
          csv:'kurse.csv',
          csvHeaders:true,
      */

      var mySpreadsheet = jexcel(document.getElementById('spreadsheet'), {
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
        $('#csv').val(JSON.stringify(data));
        $('#headers').val(JSON.stringify(headers));
      });

      $('#cntnd_spreadsheet').submit(function() {
        var data = mySpreadsheet.getData();
        var headers = mySpreadsheet.getHeaders();
        $('#csv').val(JSON.stringify(data));
        $('#headers').val(JSON.stringify(headers));
        return true;
      });
    </script>
  </body>
</html>
