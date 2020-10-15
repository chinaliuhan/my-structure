<?php
/**
 *
 * @file   StackOnLinkedList.php
 * @author liuhao
 * @date   2020/10/14
 */

namespace Stack;


use LinkedList\SingleLinkedListNode;

/**
 * 栈 基于链表
 * @class   StackOnLinkedList
 * @author  liuhao
 * @date    2020/10/14
 * @package Stack
 */
class StackOnLinkedList
{
    //头指针
    public $head;

    //长度
    public $length;

    /**
     *
     * StackOnLinkedList constructor.
     * @author liuhao
     * @date   2020/10/14
     */
    public function __construct()
    {
        $this->head   = new SingleLinkedListNode();
        $this->length = 0;
    }

    //todo 待续
}