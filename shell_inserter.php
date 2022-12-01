<?php

ob_start();
  $phpV = shell_exec('php -r "echo PHP_VERSION;"');
ob_get_clean();

$install = shell_exec('sudo apt-get -y install php-sqlite3');

$database = new SQLite3('myDatabase.sqlite');

$shell_name_input = readline('Enter youer Shell name : ');
$shell_name_input = "'".$shell_name_input."'";
$issue_code_input = readline('Enter youer Issue code : ');
$issue_code_input = "'".$issue_code_input."'";
$tags_input = (string)readline('Enter youer Tag : ');
$tags_input = "'".$tags_input."'";
// echo "INSERT INTO shell_list(shell_name, tags) VALUES($shell_name, $tags)";die;

$create = $database->exec('CREATE TABLE IF NOT EXISTS "shell_list" (
  "id" INTEGER PRIMARY KEY,
  "issue_code" TEXT, 
  "shell_name" TEXT, 
  "tags" TEXT);
  ');

//   if(!$create){
//     echo "Error";
//   }
// $insert = $database->exec("INSERT INTO shell_list (`shell_name`, `tags`) VALUES($shell_name_input, $tags_input)");
$insert = $database->exec("INSERT INTO shell_list (`shell_name`,`issue_code`, `tags`) VALUES (".$shell_name_input.",".$issue_code_input.",". $tags_input.")");


if($insert){
  echo "\nInserted\n";
}else{
  echo "\nNot Inserted\n";
}