<?php

/**
 *
 * @file   SkipList4.php
 * @author liuhao
 * @date   2020/12/24
 */

namespace liuhao;

/**
 *节点
 * @class   Node
 * @author  liuhao
 * @date    2020/12/24
 * @package liuhao
 */
class Node
{
    /**
     * @var int
     */
    public $data;
    /**
     * @var int
     */
    public $maxLevel;
    /**
     * @var Node[]
     */
    public $forward;

    /**
     *
     * Node constructor.
     * @param int $data
     * @param array $forward
     * @param int $maxLevel
     * @author liuhao
     * @date   2020/12/24
     */
    public function __construct($data, $forward = [], $maxLevel = 1)
    {
        $this->data = $data;
        $this->forward = $forward;
        $this->maxLevel = $maxLevel;
    }

}

/**
 *跳表
 * @class   SkipList4
 * @author  liuhao
 * @date    2020/12/24
 * @package liuhao
 */
class SkipListOnRand3
{
    /**
     * 跳表入口,每一级索引层的入口和数据层的入口
     * @var Node
     */
    public $head;

    /**
     *  当前跳表已经随机的最大层级
     * @var int
     */
    public $levelCount;

    /**
     * 最大层级, 2^16=65536, 2^32=42亿+, 当16不够用时可选择更改
     * @var int
     */
    public $maxLevel = 16;

    /**
     *
     * SkipList4 constructor.
     * @author liuhao
     * @date   2020/12/24
     */
    public function __construct()
    {
        //初始化一个节点,同时为其填充数据,设置最大索引层的限制
        $node = new Node(-1, array_fill(0, $this->maxLevel, null), $this->maxLevel);
        $this->head = $node;
    }

    /**
     * 创建随机跳表层级
     * $p = 0.5 : 概率趋向于每2个元素提取一级索引
     * $p = 0.33 : 概率趋向于每3个元素提取一级索引
     * $p = 0.25 : 概率趋向于每4个元素提取一级索引
     * ...
     * `0xFFFF` = 65536, 参考redis zslRandomLevel函数
     * @return int
     */
    public function randomLevel()
    {

        $level = 1;
        $p = 0.33;
        while ((rand() & 0xFFFF) < $p * 0xFFFF) {
            $level += 1;
        }

        return ($level < $this->maxLevel) ? $level : $this->maxLevel;
    }

    /**
     *插入数据,插入的数据对链表而言将会是顺序的
     * @param $data
     * @return Node|null
     * @author liuhao
     * @date   2020/12/24
     */
    public function insert($data): ?Node
    {
        //获取随机的索引层, 即从0层开始一直构建到第几层
        $level = $this->randomLevel();

        //准备一个新的节点,寄存数据, 同时为新的节点填充索引层的默认数据
        $newNode = new Node($data, array_fill(0, $level, null), $level);

        //将跳表入口赋值,作为指针入口,就从这里开始逐个遍历
        $p = $this->head;

        //存储的是查询出新数据将要存放位置的前一个元素,将新数据的下一个节点指向下一个元素, 将前一个元素的下一个节点指向新数据,即可完成从数据层到索引层的插入
        $update = [];

        //从上向下查找索引层,每一次循环都将下移一次索引层,直到最后一次查询到数据层结束
        for ($i = $level - 1; $i >= 0; $i--) {
            //向右查找, 横向查找索引层和数据层,查找到第一个小于新数据的元素
            while ($p->forward[$i] != null && $p->forward[$i]->data < $data) {
                //从$i这个位置往后的节点都会被保存下来,因为这是一条链
                $p = $p->forward[$i];
            }
            //将第一个小于新数据的元素保存下来
            $update[$i] = $p;
        }

        //更新第一个小于新数据元素指针,插入新的节点
        for ($i = 0; $i < $level; $i++) {
            $newNode->forward[$i] = $update[$i]->foreard[$i];
            $update[$i]->forward[$i] = $newNode;
        }

        // 如果当前随机的level 大于当前跳表的level, 更新跳表的level
        if ($level > $this->levelCount) {
            $this->levelCount = $level;
        }


        return $newNode;
    }

    public function printList()
    {
        echo PHP_EOL;
        echo PHP_EOL;
        for ($i = 0; $i < $this->levelCount; $i++) {
            $p = $this->head->forward[$i];
            echo "第{$i}级元素为:";
            while ($p != null) {
                echo $p->data . "->";
                $p = $p->forward[$i];
            }

            echo PHP_EOL;
        }
    }
}

$skipList = new SkipListOnRand3();
$skipList->insert(0);
$skipList->insert(1);
$skipList->insert(2);
$skipList->insert(3);
$skipList->insert(4);

$skipList->printList();