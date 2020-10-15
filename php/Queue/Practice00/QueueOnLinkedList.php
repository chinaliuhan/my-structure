<?php
/**
 *
 * @file   QueueOnLinkedList.php
 * @author liuhao
 * @date   2020/10/14
 */

namespace Queue\Practice00;


use LinkedList\SingleLinkedListNode;

/**
 *队列 基于链表实现
 * @class   QueueOnLinkedList
 * @author  liuhao
 * @date    2020/10/14
 * @package Queue
 */
class QueueOnLinkedList
{
    //头尾节点和长度
    public $head;
    public $tail;
    public $length;

    /**
     *
     * QueueOnLinkedList constructor.
     * @author liuhao
     * @date   2020/10/14
     */
    public function __construct()
    {
        //初始化队列
        $this->head = new SingleLinkedListNode();
        /**
         * 这里尾结点直接用上面的实例化后的的对象,而不是重新new一个处理,主要是因为
         * 1. 两边变量(成员属性)用同一个对象,只要修改其中一个对象,另一个遍历的对象也会受到影响,因为两个变量指向的是同一个对象
         * 2. 所以下面在入列的时候只要插入到$this->tail->next即可,$this->head自然OK
         */
        $this->tail = $this->head;

        $this->length = 0;
    }

    /**
     *入列
     * @param $data
     * @return int
     * @author liuhao
     * @date   2020/10/14
     */
    public function enqueue($data): int
    {
        //初始化一个节点来存放数据
        $node       = new SingleLinkedListNode();
        $node->data = $data;

        //每次入列都将最新数据赋值到队尾
        $this->tail->next = $node;
        $this->tail       = $node;

        $this->length++;

        return $this->length;
    }

    /**
     *出列
     * @return string|null
     * @author liuhao
     * @date   2020/10/14
     */
    public function dequeue()
    {
        if ($this->length <= 0) {
            return '';
        }

        /**
         * 1. 获取当前最早入列的节点
         * 2. 将该节点中的下一个节点覆盖到最早入列的节点的指针(相当于删除了最早入列的节点)
         */
        $node             = $this->head->next;
        $this->head->next = $this->head->next->next;

        $this->length--;

        return $node;
    }

    public function printSelf()
    {
        if (0 == $this->length) {
            echo 'empty queue'.PHP_EOL;
            return;
        }

        echo 'head.next -> ';
        $curNode = $this->head;
        while ($curNode->next) {
            echo $curNode->next->data.' -> ';

            $curNode = $curNode->next;
        }
        echo 'NULL'.PHP_EOL;
    }

}
