<?php

/**
 *
 * @file   SkipListNode.php
 * @author liuhao
 * @date   2020/12/22
 */

namespace SkipList;

/**
 * Class SkipListNode
 * @package SkipList
 */
class SkipListNode
{
    /**
     * 数据
     * @var int
     */
    public $data;

    /**
     * 下级节点
     * @var SkipListNode
     */
    public $next;

    /**
     * 索引高度
     * @var int
     */
    public $maxLevel;

    /**
     *
     * SkipListNode constructor.
     * @param $data
     * @param $next
     * @param $maxLevel
     * @author liuhao
     * @date   2020/12/31
     */
    public function __construct($data, $next, $maxLevel)
    {
        $this->data     = $data;
        $this->next     = $next;
        $this->maxLevel = $maxLevel;
    }
}



