<?php
/**
 *
 * @file   SkipList0.php
 * @author liuhao
 * @date   2020/12/22
 */

ini_set('memory_limit', "2048M");

/**
 *节点
 * @class  SLNode
 * @author liuhao
 * @date   2020/12/22
 */
class SLNode
{
    //数据
    public $data;
    //指针(这里主要是包含了下一个节点)
    public $next;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * 获取当前节点的索引层级
     * @return int
     * @author liuhao
     * @date   2020/12/22
     */
    public function getMaxLevel()
    {
        return count($this->next) - 1;
    }
}

/**
 *跳表
 * @class  SkipList
 * @author liuhao
 * @date   2020/12/22
 */
class SkipListOnRand0
{

    //索引最大层数
    public $indexMaxLevel;
    //头部节点
    protected $head;

    public function __construct($indexMaxLevel)
    {
        $this->indexMaxLevel = max($indexMaxLevel, 0);
        $this->head          = new SLNode();
    }

    /**
     *获取当前节点的索引层数
     * @return int
     * @author liuhao
     * @date   2020/12/22
     */
    public function getRandLevel(): int
    {
        return mt_rand(0, $this->indexMaxLevel);
    }

    /**
     *添加数据
     * @param $data
     * @return SLNode
     * @author liuhao
     * @date   2020/12/22
     */
    public function addData(int $data)
    {
        $newNode   = new SLNode($data);
        $node      = $this->head;
        $randLevel = $this->getRandLevel();
        for ($level = $randLevel; $level >= 0; $level--) {
            while (isset($node->next[$level]) && $data < $node->next[$level]->data) {
                $node = $node->next[$level];
            }

            //未匹配到,则直接插入数据
            if (isset($node->next[$level])) {
                $newNode->next[$level] = $node->next[$level];
            }
            // 认为是首次添加,直接插入数
            $node->next[$level] = $newNode;
        }
        return $newNode;
    }

    /**
     *删除数据
     * @param $data
     * @return bool
     * @author liuhao
     * @date   2020/12/22
     */
    public function deleteData(int $data)
    {
        $deleted   = false;
        $node      = $this->head;
        $randLevel = $this->getRandLevel();
        for ($level = $randLevel; $level >= 0; $level--) {
            while (isset($node->next[$level]) && $data < $node->next[$level]->data) {
                $node = $node->next[$level];
            }
            if (isset($node->next[$level]) && $data == $node->next[$level]->data) {
                $node->next[$level] = isset($node->next[$level]->next[$level]) ?
                    $node->next[$level]->next[$level] : null;
                $deleted            = true;
            }
        }
        return $deleted;
    }

    /**
     * 查找数据
     * @param $data
     * @return false|mixed
     * @author liuhao
     * @date   2020/12/22
     */
    public function findData(int $data)
    {
        $node      = $this->head;
        $randLevel = $this->getRandLevel();
        for ($level = $randLevel; $level >= 0; $level--) {
            while (isset($node->next[$level]) && $data < $node->next[$level]->data) {
                $node = $node->next[$level];
            }
            if (isset($node->next[$level]) && $data == $node->next[$level]->data) {
                return $node->next[$level];
            }
        }
        return false;
    }

    public function getTotalNode()
    {
        return $this->head;
    }

    public function printList()
    {
        echo PHP_EOL;
        echo PHP_EOL;
        for ($i = 0; $i < $this->indexMaxLevel; $i++) {
            $p = $this->head->next[$i];
            echo "第{$i}级元素为:";
            while ($p != null) {
                echo $p->data."->";
                $p = $p->next[$i];
            }

            echo PHP_EOL;
        }
    }

}


//最大加索引等级
$indexMaxLevel = 3;
$skipList      = new SkipListOnRand0($indexMaxLevel);
for ($i = 20; $i >= 0; $i--) {
    $skipList->addData($i);
}


echo $skipList->printList().PHP_EOL;
exit;

//打印0到10组成的跳表
echo json_encode($skipList).PHP_EOL;


echo json_encode($skipList->getTotalNode());
exit;
//返回节点对象
$findInfo = $skipList->findData(5);
echo json_encode($findInfo).PHP_EOL;

$skipList->deleteData(5);

//返回false
$findInfo = $skipList->findData(5);
echo json_encode($findInfo).PHP_EOL;
