<?php

/**
 * cntnd_spreadsheet Class
 */
class CntndSpreadsheet {

  private $file;
  private $path;

  function __construct($file, $path) {
    $this->file = $file;
    $this->path = $path;
  }

  public function store($post){
    if ($post['cntnd_spreadsheet-csv']){
      $fp = fopen($this->filePath(), 'w');

      if (!empty($post['cntnd_spreadsheet-headers'])){
        $headers = json_decode($_POST['cntnd_spreadsheet-headers']);
        fputcsv($fp, str_getcsv($headers,","));
      }

      $csv = json_decode($post['cntnd_spreadsheet-csv']);
      foreach ($csv as $fields) {
          fputcsv($fp, $fields);
      }

      fclose($fp);

      return true;
    }
    return false;
  }

  public function load(){
    $file = file_get_contents($this->filePath(), FILE_USE_INCLUDE_PATH);

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

    return array('headers' => $headers, 'data' => $data);
  }

  private function filePath(){
    return $this->path.$this->file;
  }
}
?>
