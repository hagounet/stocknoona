<?php



$path = dirname(__FILE__).'/../../../../app/console';
$argument = $_SERVER['argv'][1];

$message = shell_exec($path.' rappel:send '.$argument);
print_r($message);
