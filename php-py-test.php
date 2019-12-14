<?php

$floats = "2.106 2.386 2.353\n3.12 3.26 3.67\n";
$floats2 = preg_replace("[\n]", " : ", $floats);
$PATH_TO_SCRIPT = "scripts/foo.py";

// There also exists an escapeshellcmd() function.
$command = escapeshellcmd('python ' // . dirname(__DIR__) . '/' 
. $PATH_TO_SCRIPT . " \"" . $floats2 . "\"");

$output = [];
$retcode = -1;

echo "$floats2<br>";
echo "$command<br>";

exec($command, $output, $retcode);

if($retcode !== 0) echo "Error $retcode<br>";

echo implode("<br>",$output);
//echo $pyout;