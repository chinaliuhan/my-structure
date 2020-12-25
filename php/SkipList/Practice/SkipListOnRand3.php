<?php

/**
 *
 * @file   SkipList2.php
 * @author liuhao
 * @date   2020/12/22
 */

namespace SkipList\Practice;

/**
 *跳表节点
 * @class  SNode
 * @author liuhao
 * @date   2020/12/22
 */
class Node
{
    /**
     * 数据域
     * @var mixed|null
     */
    public $data;

    /**
     * 指针域，引用SNode对象
     * @var array
     */
    public $next = [];

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * 索引最大层数
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
class SkipList
{
    /**
     * 索引最大层数
     * @var int
     */
    public $indexLevel;

    /**
     * 头节点
     * @var Node
     */
    protected $head;

    /**
     *
     * SkipList constructor.
     * @param  int  $indexLevel
     * @author liuhao
     * @date   2020/12/22
     */
    public function __construct(int $indexLevel)
    {
        $this->indexLevel = max($indexLevel, 0);
        $this->head       = new Node();
    }

    /**
     *添加数据
     * @param $data
     * @return Node
     * @author liuhao
     * @date   2020/12/22
     */
    public function addData($data)
    {
        $newNode = new Node($data);
        for ($level = $this->getRandomLevel(), $node = $this->head; $level >= 0; $level--) {
            while (isset($node->next[$level]) && $data < $node->next[$level]->data) {
                $node = $node->next[$level];
            }
            if (isset($node->next[$level])) {
                $newNode->next[$level] = $node->next[$level];
            }
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
    public function deleteData($data)
    {
        $deleted = false;
        for ($level = $this->head->getMaxLevel(), $node = $this->head; $level >= 0; $level--) {
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
     *查找数据
     * @param $data
     * @return false|mixed
     * @author liuhao
     * @date   2020/12/22
     */
    public function findData($data)
    {
        for ($level = $this->head->getMaxLevel(), $node = $this->head; $level >= 0; $level--) {
            while (isset($node->next[$level]) && $data < $node->next[$level]->data) {
                $node = $node->next[$level];
            }
            if (isset($node->next[$level]) && $data == $node->next[$level]->data) {
                return $node->next[$level];
            }
        }
        return false;
    }

    /**
     *获取随机节点层
     * @return int
     * @author liuhao
     * @date   2020/12/22
     */
    protected function getRandomLevel()
    {
        return mt_rand(0, $this->indexLevel);
    }

    /**
     *打印跳表的节点和索引
     * @return void
     * @author liuhao
     * @date   2020/12/22
     */
    public function printAll()
    {
        echo PHP_EOL;

        for ($i = 0; $i < $this->indexLevel; $i++) {
            $p = $this->head->next[$i];
            echo sprintf('第 %d 级元素为: ', $i);
            while ($p !== null) {
                echo $p->data, '->';

                $p = $p->next[$i];
            }

            echo PHP_EOL;
        }
    }
}

/**
 * 示例
 */

$indexLevel = 3;
$skipList = new SkipList($indexLevel);

for ($i = 10; $i >= 0; $i--) {
    $skipList->addData($i);
}

//打印0到10组成的跳表
var_dump($skipList);
$skipList->printAll();;
