<?php
/**
 *
 * @file   SkipList3.php
 * @author liuhao
 * @date   2020/12/22
 */

namespace SkipList\Practice;

/**
 *节点类
 * @class   Node2
 * @author  liuhao
 * @date    2020/12/22
 * @package SkipList\Practice
 */
class Node2
{
    /**
     * 数据
     * @var int
     */
    public $data;
    /**
     * 下级节点
     * @var Node2
     */
    public $next = [];

    /**
     * 索引高度
     * @var int
     */
    public $indexMaxLevel;


    /**
     *
     * Node2 constructor.
     * @param  int    $data
     * @param  array  $next
     * @param  int    $indexMaxLevel
     * @author liuhao
     * @date   2020/12/22
     */
    public function __construct(int $data, array $next, int $indexMaxLevel)
    {
        $this->data          = $data;
        $this->next          = $next;
        $this->indexMaxLevel = $indexMaxLevel;
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
     * 跳表入口
     * @var Node2
     */
    public $head;

    /**
     * 前跳表已经随机的最大层级
     * @var int
     */
    public $levelCount;

    /**
     * 索引极限高度: 2^16=65536, 2^32=42亿+
     * @var int
     */
    public $indexMaxLevel = 16;

    /**
     *
     * SkipListOnRand2 constructor.
     * @author liuhao
     * @date   2020/12/22
     */
    public function __construct()
    {
        //初始化跳表,并为初始化节点填充默认的: 数据,索引,和索引高度
        $nextNode   = array_fill(0, $this->indexMaxLevel, null);
        $node       = new Node2(-1, $nextNode, $this->indexMaxLevel);
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
     * @author liuhao
     * @date   2020/12/22
     */
    public function randomLevel()
    {
        $level = 1;
        $p     = 0.33;
        while ((rand() & 0xFFFF) < $p * 0xFFFF) {
            $level += 1;
        }

        return ($level < $this->indexMaxLevel) ? $level : $this->indexMaxLevel;
    }

    /**
     * 插入数据
     * 不管怎么样传数据, 插入后都会变成有序的
     *
     * 跳表示例:
     * 如下跳表, $levelCount应该等于3
     * 1---------->9  索引层 第2级
     * 1---->5---->9  索引层 第1级
     * 1->3->5->7->9  数据层 第0级
     * @param $data
     * @return $this
     * @author liuhao
     * @date   2020/12/22
     */
    public function insert($data)
    {
        /**
         * 计算本次插入的数据, 会更新到几级跳表索引, 最低为1, 因为跳表是从0开始的, 故计算时此level需要减1
         * 数据层是第0层, level = 1 意味着只会写入到数据层, 不会创建跳表索引
         */
        $level = $this->randomLevel();
        // 等待被插入的数据, 它会出现在 从0 到 $level - 1 层中
        $newNode = new Node2($data, array_fill(0, $level, null), $level);

        // 将跳表入口赋予$p, 相当于指针
        $p = $this->head;
        /**
         * 等待被更新的数据
         * 存储的是查询出新数据存放的位置的前一个元素, 将新数据的下一个节点指向下一个元素, 将前一个元素的下一个节点指向新数据
         * 即可完成从数据层到索引层的插入
         */
        $update = [];
        // 向下查找, 每一次循环都将下移一次索引层, 直到最后一次查询到数据层结束
        for ($i = $level - 1; $i >= 0; $i--) {
            // 向右查找, 横向查找索引层和数据层, 查找到第一个小于新数据的元素
            while ($p->next[$i] !== null && $p->next[$i]->data < $data) {
                $p = $p->next[$i];
            }
            // 将第一个小于新数据的元素保存下来
            $update[$i] = $p;
        }

        /**
         * 更新第一个小于新数据元素指针, 插入新元素
         */
        for ($i = 0; $i < $level; $i++) {
            $newNode->next[$i]    = $update[$i]->next[$i];
            $update[$i]->next[$i] = $newNode;
        }

        // 如果当前随机的level 大于当前跳表的level, 更新跳表的level
        if ($level > $this->levelCount) {
            $this->levelCount = $level;
        }

        return $this;
    }

    /**
     *查找数据
     * @param  int  $data
     * @return false|mixed
     * @author liuhao
     * @date   2020/12/22
     */
    public function find(int $data)
    {
        $p = $this->head;
        for ($i = $this->levelCount - 1; $i >= 0; $i--) {
            while ($p->next[$i] !== null && $p->next[$i]->data < $data) {
                $p = $p->next[$i];
            }
        }
        if ($p->next[0] !== null && $p->next[0]->data == $data) {
            return $p->next[0];
        }

        return false;
    }

    /**
     *删除节点
     * @param $data
     * @return bool
     * @author liuhao
     * @date   2020/12/22
     */
    public function delete($data)
    {
        // 跳表入口
        $p = $this->head;
        /**
         * 记录该元素所在层级的前一个元素, 存储的元素并不一定指向要删除的元素
         */
        $update = [];
        for ($i = $this->levelCount - 1; $i >= 0; $i--) {
            while ($p->next[$i] !== null && $p->next[$i]->data < $data) {
                $p = $p->next[$i];
            }
            $update[$i] = $p;
        }

        /**
         * 如果没有找到该元素
         */
        if ($p->next[0] === null || $p->next[0]->data != $data) {
            return false;
        }

        /**
         * 该元素最多会出现在它对应的maxLevel-1层中, 所以从这一层往下查找
         * $update中存储的都是 第一个小于 $data的指针, 因此, 下一个元素不一定是$data, 所以需要判断一下
         */
        $pLevel = $p->next[0]->maxLevel;
        for ($i = $pLevel - 1; $i >= 0; $i--) {
            if ($update[$i]->next[$i] !== null && $update[$i]->next[$i]->data == $data) {
                $update[$i]->next[$i] = $update[$i]->next[$i]->next[$i];
            }

        }
        /**
         * 当被删除的元素处于最大层级时, 才检查删除该元素后是否需要减少层级
         */
        if ($this->levelCount == $pLevel) {
            // 当前层级的没有其他元素了, 说明该层级已空, 需要将当前最大层级减1
            while ($this->levelCount > 1 && $this->head->next[$this->levelCount - 1] === null) {
                $this->levelCount--;
            }
        }

        return true;
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

        for ($i = 0; $i < $this->levelCount; $i++) {
            $p = $this->head->next[$i];
            echo sprintf('第 %d 级元素为: ', $i);
            while ($p !== null) {
                echo $p->data, '->';

                $p = $p->next[$i];
            }

            echo PHP_EOL;
        }
    }

    /**
     *直接返回整个跳表
     * @return Node2
     * @author liuhao
     * @date   2020/12/22
     */
    public function getHead()
    {
        return $this->head;
    }
}

$skipList = new SkipListOnRand2();
$skipList->insert(0);
$skipList->insert(1);
$skipList->insert(2);
$skipList->insert(3);
$skipList->insert(4);
$skipList->printAll();

$skipList->insert(5);
$skipList->insert(6);
$skipList->insert(7);
$skipList->insert(8);
$skipList->insert(9);
$skipList->printAll();

//数据量太大,可能会导致PHP内存溢出
echo json_encode($skipList->getHead()).PHP_EOL;