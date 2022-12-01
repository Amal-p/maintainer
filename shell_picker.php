<?php

ob_start();
  $output = shell_exec('php -r "echo PHP_VERSION;"');
ob_get_clean();

$install = shell_exec('sudo apt-get -y install php-sqlite3');

$database = new SQLite3('myDatabase.sqlite');

echo "Chose one Option:\n";
echo "(1) Issue Code\n";
echo "(2) Tags\n";

$option = readline();
$shell_name = '';

switch ($option) {
  case 1:
    echo "Issue Code : \n";
    $issue_code = readline();
    $result = $database->query("SELECT `shell_name` FROM shell_list WHERE `issue_code` = '".$issue_code."'");
    $shell_name = $result->fetchArray();
    $shell_name = $shell_name['shell_name'];
    break;
  
  case 2:
    echo "Tag : \n";
    $tags = readline();
    $result = $database->query("SELECT `shell_name` FROM shell_list WHERE `tags` LIKE '%".$tags."%'");
    $shell_name = $result->fetchArray();
    $shell_name = $shell_name['shell_name'];
    break;
}
$url = "https://raw.githubusercontent.com/Amal-p/shell_collection/main/".$shell_name;
$file_download = file_put_contents($shell_name, file_get_contents($url));
if($file_download){
  shell_exec('sudo chmod 777 '.$shell_name);
  echo "\nPress Enter";
  ob_start();
    $run = shell_exec('./'.$shell_name);
  ob_get_clean();
  if($run){
    shell_exec('sudo rm -rf '.$shell_name);
    echo "\n Done\n";
  }else{
    shell_exec('sudo rm -rf '.$shell_name);
    echo "\n Note Done\n";
  }
}else{

}
