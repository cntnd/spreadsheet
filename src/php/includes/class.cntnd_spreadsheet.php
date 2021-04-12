<?php

/**
 * cntnd_spreadsheet Class
 */
class CntndSpreadsheet {

  private $file;
  private $separator;

  function __construct(string $file, string $separator=",") {
    $this->file = $file;
    $this->separator = $separator;
  }

  public function store(array $post){
    if ($post['cntnd_spreadsheet-csv']){
      $fp = fopen($this->file, 'w');

      if (!empty($post['cntnd_spreadsheet-headers'])){
        $b64h = base64_decode($_POST['cntnd_spreadsheet-headers']);
        $headers = json_decode($b64h);
        fputcsv($fp, str_getcsv($headers,','),$this->separator);
      }

      $b64c = base64_decode($_POST['cntnd_spreadsheet-csv']);
      $csv = json_decode($b64c);
      foreach ($csv as $fields) {
          fputcsv($fp, $fields, $this->separator);
      }

      fclose($fp);

      return true;
    }
    return false;
  }
  
  public function load(){
    $csv = $this->loadRows();

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

  private function loadFile() : string {
    $file = file_get_contents($this->file, FILE_USE_INCLUDE_PATH);
    if (!self::isUTF8($file)){
      return utf8_encode($file);
    }
    return $file;
  }

  private function loadRows() : array {
    $file = $this->loadFile();
    return str_getcsv($file,"\n");
  }

  private function headers(array $headers){
    $result=array();
    foreach ($headers as $header){
      $result[]=preg_replace('/\s+/', '', $header);
    }
    return $result;
  }

  public function spreadsheet() : array {
    $callback = function($row){ return str_getcsv($row, $this->separator); };
    $rows   = array_map($callback, $this->loadRows());
    $header = $this->headers(array_shift($rows));
    $csv    = array();
    foreach($rows as $row) {
      $data = array_combine($header, $row);
      $csv[] = $data;
    }
    return $csv;
  }

  private static function isUTF8(string $string) : bool {
    return mb_detect_encoding($string, 'UTF-8', true);
  }
}
?>
