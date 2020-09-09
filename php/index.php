<?php
/**
 *
 * @file index.php
 * @author liuhao
 * @date 2020/9/6
 */
ini_set('log_errors', 'Off');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');

require_once './vendor/autoload.php';

/**
 * 数组
 */
echo '数组开始 ---' . PHP_EOL;
$arr00 = new \MyArray\Array00(10);
for ($i = 0; $i < 10; $i++) {
	$arr00->insert($i, "value:{$i}");
}
$arr00->delete(5);
$arr00->dump();
$arr00->delete(3);
$arr00->dump();


$arr01 = new \MyArray\Array01(5);
for ($i = 0; $i < 10; $i++) {
	$arr01->append($i);
}
$arr01->delete(5);
$arr01->dump();
$arr01->delete(3);
$arr01->dump();
echo '数组结束 ---' . PHP_EOL . PHP_EOL;


/**
 * 链表
 */
echo '链表开始 ---' . PHP_EOL;
//单向链表
$singleLinkedList = new \LinkedList\SingleLinkedList();
$singleLinkedList->printListSample();
for ($i = 0; $i < 10; $i++) {
	$singleLinkedList->insert("value:{$i}");
}
$singleLinkedList->printListSample();
$singleLinkedList->insert("last insert");
$singleLinkedList->printListSample();

echo '链表结束 ---' . PHP_EOL;







