#!/usr/bin/env php
<?php

if (empty($argv[1])) {
    fputs(STDERR, "1st argument is empty; Pass me a text file which contains file list\n");
    exit(1);
}
if (empty($argv[2])) {
    fputs(STDERR, "2nd argument is empty; Pass me a path to destination\n");
    exit(1);
}
$destination = trim($argv[2]);

$files = file_get_contents($argv[1]);
$files = explode("\n", $files);
$files = array_filter($files, 'strlen');

foreach ($files as $filepath) {
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
        fputs(STDERR, "No such file or directory: $filepath\n");
        exit(1);
    }
}
exit(0);