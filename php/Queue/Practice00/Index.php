<?php
/**
 *
 * @file   Index.php
 * @author liuhao
 * @date   2020/10/14
 */

use Queue\Practice00\QueueOnLinkedList;

require_once getcwd().'/../../vendor/autoload.php';

ini_set('log_errors', 'Off');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');


$queueLinkedList = new QueueOnLinkedList();
echo '初始类'.PHP_EOL;
echo json_encode($queueLinkedList).PHP_EOL;
echo '开始入列'.PHP_EOL;
$queueLinkedList->enqueue(0);
echo json_encode($queueLinkedList).PHP_EOL;
$queueLinkedList->enqueue(1);
echo json_encode($queueLinkedList).PHP_EOL;
$queueLinkedList->enqueue(2);
echo json_encode($queueLinkedList).PHP_EOL;
$queueLinkedList->enqueue(3);
echo json_encode($queueLinkedList).PHP_EOL;
$queueLinkedList->enqueue(4);
echo json_encode($queueLinkedList).PHP_EOL;

