<?php

/**
 * cntnd_simple_spreadsheet Class
 */
class CntndSpreadsheet {

  private $file;
  private $separator;

  function __construct($file, $separator=',') {
    $this->file = $file;
    $this->separator = $separator;
  }

  public function store($post){
    if ($post['cntnd_simple_spreadsheet-csv']){
      $fp = fopen($this->file, 'w');

      if (!empty($post['cntnd_simple_spreadsheet-headers'])){
        $b64h = base64_decode($_POST['cntnd_simple_spreadsheet-headers']);
        $headers = json_decode($b64h);
        fputcsv($fp, str_getcsv($headers,$this->separator));
      }

      $b64c = base64_decode($_POST['cntnd_simple_spreadsheet-csv']);
      $csv = json_decode($b64c);
      foreach ($csv as $fields) {
          fputcsv($fp, $fields);
      }

      fclose($fp);

      return true;
    }
    return false;
  }

  public function load(){
    $file = file_get_contents($this->file, FILE_USE_INCLUDE_PATH);

    $csv = str_getcsv($file,"\n");

    $headers = "";
    $data = "";
    $i=0;
    foreach ($csv as $row) {
      if ($i==0){
        $headers .= "[";
        $keys = str_getcsv($row,$this->separator);
        foreach ($keys as $value) {
          $headers .= "{ title: '".$value."' },";
        }
        $headers .= "]";
      }
      else {
        $data .= "[";
        $keys = str_getcsv($row,$this->separator);
        foreach ($keys as $value) {
          $data .= "'".$value."',";
        }
        $data .= "],";
      }
      $i++;
    }

    return array('headers' => $headers, 'data' => $data);
  }
}
?>
