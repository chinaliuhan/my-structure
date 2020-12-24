<?php
/**
 *
 * @file   SkipList3.php
 * @author liuhao
 * @date   2020/12/22
 */


/**
 *节点类
 * @class  Node
 * @author liuhao
 * @date   2020/12/22
 */
class Node
{

    /**
     * @var string
     */
    public $id;
    /**
     * @var string|int|object
     */
    public $value;
    /**
     * @var int
     */
    public $level;
    /**
     * @var array
     */
    public $forward;

    /**
     *
     * Node constructor.
     * @param $value
     * @param $level
     * @author liuhao
     * @date   2020/12/22
     */
    public function __construct($value, $level)
    {
        //为节点的id value level 分别复制
        $this->id    = uniqid();
        $this->value = $value;
        $this->level = $level;

        //初始化节点
        for ($i = 0; $i < $level; $i++) {
            $this->forward[$i] = 0;
        }
    }

    /**
     *获取当前ID
     * @return mixed
     * @author liuhao
     * @date   2020/12/22
     */
    public function getID()
    {
        return $this->id;
    }
}

/**
 *跳表
 * @class  SkipList
 * @author liuhao
 * @date   2020/12/22
 */
class SkipListOnRand2
{
    /**
     * @var int
     */
    public $maxLevel;
    /**
     * @var array
     */
    public $nodePool;
    /**
     * @var string
     */
    public $header;

    /**
     *
     * SkipList constructor.
     * @param $indexMaxLevel
     * @author liuhao
     * @date   2020/12/22
     */
    public function __construct($indexMaxLevel)
    {
        //设置索引等级, 添加初始节点, 设置入口的ID
        $this->maxLevel                   = $indexMaxLevel;
        $header                           = new Node(-1, $indexMaxLevel);
        $this->nodePool[$header->getID()] = $header;
        $this->header                     = $header->getID();
    }


    public function insert($value)
    {
        $visitTrace = [];

        $count = 0;

        $tmp = $this->nodePool[$this->header] ?? null;

        for ($i = $this->maxLevel - 1; $i >= 0; $i--) {
            while ($tmp && $tmp->forward[$i]) {
                $count++;
                if ($count > 20) {
                    break;
                }
                $forward = $this->nodePool[$tmp->forward[$i]];

                if ($forward->value < $value) {
                    $tmp = $forward;
                } else {
                    if ($forward->value > $value) {
                        break;
                    } else {
                        return false;
                    }
                }
            }
            if ($tmp) {
                $visitTrace[$i] = $tmp->getID();
            }
        }

        $level   = $this->randomLevel();
        $newNode = new Node($value, $level);
        $this->addToNodePool($newNode->getID(), $newNode);

        for ($i = 0; $i < $level; $i++) {
            $trace                = $this->getFromNodePool($visitTrace[$i]);
            $newNode->forward[$i] = $trace->forward[$i];
            $trace->forward[$i]   = $newNode->getID();
        }

        return true;
    }

    public function addToNodePool($id, $object)
    {
        $this->nodePool[$id] = $object;
    }

    public function getFromNodePool($id)
    {
        return isset($this->nodePool[$id]) ? $this->nodePool[$id] : null;
    }

    public function randomLevel()
    {
        $level = 1;

        for ($i = 1; $i < $this->maxLevel; $i++) {
            if (rand(0, 1)) {
                $level++;
            }
        }

        return $level;
    }

    public function getNodePool()
    {
        return $this->nodePool;
    }
}

$skipList = new SkipListOnRand2(5);
$skipList->insert(0);
$skipList->insert(1);
//$skipList->insert(2);
//$skipList->insert(3);
//$skipList->insert(4);

echo json_encode($skipList->getNodePool()).PHP_EOL;