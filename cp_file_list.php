#!/usr/bin/env php
<?php

if (empty($argv[1])) {
    fputs(STDERR, 'Pass me a text file which contains file list as 1st argument');
    exit(1);
}
if (empty($argv[2])) {
    fputs(STDERR, 'Pass me a path to destination as 2nd argument');
    exit(1);
}
$destination = trim($argv[2]);

$files      = file_get_contents($argv[1]);
$files_list = explode("\n", $files);
$files_list = array_filter($files_list, 'strlen');

foreach ($files_list as $filepath) {
    $filepath = trim($filepath);
    if (is_file($filepath) || is_dir($filepath)) {
        $command = sprintf("cp -a --parents %s %s 2>&1", $filepath, $destination);
        exec($command, $outout, $return_var);
        // echo $command, PHP_EOL;
        if ($return_var !== 0) {
            fputs(STDERR, $output[0]);
            exit(1);
        }
    } else {
        fputs(STDERR, "No such file or directory: $filepath");
        exit(1);
    }
}
exit(0);