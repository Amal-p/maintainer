<?php

ob_start();
  $phpV = shell_exec('php -r "echo PHP_VERSION;"');
ob_get_clean();

echo "\n";
echo "\t======================================\n";
echo "\t|            MA!NTAINER               |\n";
echo "\t|               v0.1                  |\n";
echo "\t|             Author : P67            |\n";
echo "\t|            -Shell Picker-           |\n";
echo "\t=======================================\n";

$install = shell_exec('sudo apt-get -y install php-sqlite3');

$database = new SQLite3('.db/myDatabase.sqlite');

echo "\nChose one Option:\n";
echo "(1) Issue Code\n";
echo "(2) Tags\n";

$option = readline();
$shell_name = '';

switch ($option) {
  case 1:
    echo "\nIssue Code : \n";
    $issue_code = readline();
    $result = $database->query("SELECT `shell_name` FROM shell_list WHERE `issue_code` = '".$issue_code."'");
    $shell_name = $result->fetchArray();
    if(empty($shell_name)){
      echo "\n No Result found ! Contact Admin or Make a git pull ¯\_( ͡❛ ͜ʖ ͡❛)_/¯\n";
      exit;
    }
    $shell_name = $shell_name['shell_name'];
    break;
  
  case 2:
    echo "\nTag : \n";
    $tags = readline();
    $result = $database->query("SELECT `shell_name` FROM shell_list WHERE `tags` LIKE '%".$tags."%'");
    $shell_name = $result->fetchArray();
    if(empty($shell_name)){
      echo "\nNo Result found ! Contact Admin or Make a git pull ¯\_( ͡❛ ͜ʖ ͡❛)_/¯\n";
      exit;
    }
    $shell_name = $shell_name['shell_name'];
    break;
}
$url = "https://raw.githubusercontent.com/Amal-p/shell_collection/main/".$shell_name;
$file_download = file_put_contents($shell_name, file_get_contents($url));
if($file_download){
  shell_exec('sudo chmod 777 '.$shell_name);
  echo "\nPress Enter";
  ob_start();
    $run = shell_exec('bash '.$shell_name);
  ob_get_clean();
  if($run){
    shell_exec('sudo rm -rf '.$shell_name);
    echo "\n Done (͠≖ ͜ʖ͠≖)👌\n";
  }else{
    shell_exec('sudo rm -rf '.$shell_name);
    echo "\n Note Done ! Contact Admin ¯\_( ͡❛ ͜ʖ ͡❛)_/¯\n";
  }
}else{
  echo "\n Erorr! Contact Admin ¯\_( ͡❛ ͜ʖ ͡❛)_/¯\n";
}
