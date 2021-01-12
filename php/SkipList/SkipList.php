<?php

/**
 *
 * @file   SkipList.php
 * @author liuhao
 * @date   2020/12/22
 */


namespace SkipList;

/**
 * Class SkipList
 */
class SkipList
{

    /**
     * 链表入口,即链表的整个列表
     * @var SkipListNode
     */
    public $head;

    /**
     * 当前索引层级
     * @var int
     */
    public $levelCount;

    /**
     * 当前节点的索引最大高度
     * @var int
     */
    public $maxLevel;

    /**
     *
     * SkipList constructor.
     * @param int $maxLevel
     * @author liuhao
     * @date   2020/12/31
     */
    public function __construct(int $maxLevel)
    {
        //设计索引最大层级,初始化链表的第一个节点,同时为该节点补充默认的数据
        $this->maxLevel = $maxLevel;
        $node = new SkipListNode(-1, array_fill(0, $this->maxLevel, null), $this->maxLevel);
        $this->head = $node;

    }

    /**
     * 创建随机跳表层级 -
     * $p = 0.5 : 概率趋向于每2个元素提取一级索引
     * $p = 0.33 : 概率趋向于每3个元素提取一级索引
     * $p = 0.25 : 概率趋向于每4个元素提取一级索引
     * ...
     * `0xFFFF` = 65536, 参考redis zslRandomLevel函数
     * @return int
     */
    public function getRandomLevel()
    {
        $level = 1;
        $p = 0.33;
        while ((rand() & 0xFFFF) < $p * 0xFFFF) {
            $level += 1;
        }

        return ($level < $this->maxLevel) ? $level : $this->maxLevel;
    }


    /**
     *添加数据
     * @param int $data
     * @return SkipListNode
     * @author liuhao
     * @date   2020/12/31
     */
    public function addData(int $data)
    {
        //获取要随机的索引高度,为新的节点补充默认数据
        $level = $this->getRandomLevel();
        $newNode = new SkipListNode($data, array_fill(0, $level, null), $level);

        //等待被处理的数据
        $p = $this->head;
        $update = [];
        //遍历节点找到合适的位置
        for ($i = $level - 1; $i >= 0; $i--) {
            while ($p->next[$i] != null && $p->next[$i]->data < $data) {
                $p = $p->next[$i];
            }
            // 将第一个小于新数据的元素保存下来
            $update[$i] = $p;
        }

        /**
         * 更新第一个小于新数据元素指针, 插入新元素
         */
        for ($i = 0; $i < $level; $i++) {
            $newNode->next[$i] = $update[$i]->next[$i];
            $update[$i]->next[$i] = $newNode;
        }

        // 如果当前随机的level >当前跳表的level, 更新跳表的level
        if ($level > $this->levelCount) {
            $this->levelCount = $level;
        }

        return $this->head;
    }



    /**
     *打印跳表元素
     * @author liuhao
     * @date   2020/12/31
     */
    public function printList()
    {
        for ($i = 0; $i < $this->levelCount; $i++) {
            $point = $this->head->next[$i];
            echo sprintf('第 %d 级元素为: ', $i);
            while ($point !== null) {
                echo $point->data, '->';

                $point = $point->next[$i];
            }

            echo PHP_EOL;
        }
    }

}