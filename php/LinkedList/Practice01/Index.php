#!/usr/local/bin/php
<?php
/**
 *
 * @file   Index.php
 * @author liuhao
 * @date   2020/9/18
 */

require_once getcwd().'/../../vendor/autoload.php';

ini_set('log_errors', 'Off');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');


$singleLinkedList = new \LinkedList\Practice01\SingleLinkedList(null);
for ($i = 0; $i < 10; $i++) {
    $singleLinkedList->insertData($i);
}
$singleLinkedList->print();
$singleLinkedList->printJson();
$singleLinkedList->printString();

