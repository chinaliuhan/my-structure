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


$practiceSingle = new \LinkedList\Practice\PracticeSingleLinkedList(null);

$total = 11;
for ($i = 0; $i < $total; $i++) {
    $practiceSingle->insetData($i);
}
echo $practiceSingle->getLength().PHP_EOL;
//循环打印的结果
echo $practiceSingle->printSimple().PHP_EOL;
//value: 10 => value: 9 => value: 8 => value: 7 => value: 6 => value: 5 => value: 4 => value: 3 => value: 2 => value: 1 => value: 0 => NULL

//直接输出的json结果,可以看到一环扣一环,如同俄罗斯套娃,可以看到data是值,next则直接是下一个数据
echo $practiceSingle->printJson().PHP_EOL;
//{"data":"value: 10","next":{"data":"value: 9","next":{"data":"value: 8","next":{"data":"value: 7","next":{"data":"value: 6","next":{"data":"value: 5","next":{"data":"value: 4","next":{"data":"value: 3","next":{"data":"value: 2","next":{"data":"value: 1","next":{"data":"value: 0","next":null}}}}}}}}}}}


//删除
$deleteResult = $practiceSingle->delete(new \LinkedList\Practice\PracticeSingleLinkedListNode(0, null));
$deleteResult = $practiceSingle->delete(new \LinkedList\Practice\PracticeSingleLinkedListNode(1, null));
if (!$deleteResult) {
    echo $practiceSingle->errMsg.PHP_EOL;
}
echo $practiceSingle->printSimple().PHP_EOL;
//10 => 9 => 8 => 7 => 6 => 5 => 4 => 3 => 2 => null


//用下标获取节点,因为上面删了, 所以这里的下标看起来有点不连续
$node = $practiceSingle->getNodeByIndex(5);
echo json_encode($node).PHP_EOL;
//{"data":5,"next":{"data":4,"next":{"data":3,"next":{"data":2,"next":null}}}}
