<?php
/**
 *
 * @file   QueueOnLinkedList.php
 * @author liuhao
 * @date   2020/10/14
 */

namespace Queue;

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

    //队列的头节点
    public $head;

    //队列的尾结点
    public $tail;


    //队列的长度
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
        $this->head = new SingleLinkedListNode(null);
        /**
         * 这里尾结点直接用上面的实例化后的的对象,而不是重新new一个处理,主要是因为
         * 1. 两边变量(成员属性)用同一个对象,只要修改其中一个对象,另一个遍历的对象也会受到影响,因为两个变量指向的是同一个对象
         * 2. 所以下面在入列的时候只要插入到$this->tail->next即可,$this->head自然OK
         */
        $this->tail   = $this->head;
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
        //将入列数据初始化成节点
        $node       = new SingleLinkedListNode(null);
        $node->data = $data;


        $this->tail->next = $node;
        $this->tail       = $node;
        $this->length++;

        return $this->length;
    }


    /**
     *出列
     * @return null|SingleLinkedListNode
     * @author liuhao
     * @date   2020/10/14
     */
    public function dequeue()
    {
        if ($this->length <= 0) {
            return null;
        }

        $node             = $this->head->next;
        $this->head->next = $this->head->next->next;
        $this->length--;
        return $node;
    }

    /**
     * 获取队列长度
     * @return int
     * @author liuhao
     * @date   2020/10/14
     */
    public function getLength()
    {
        return $this->length;
    }


    /**
     * 以字符串的形式打印队列
     * @return void
     * @author liuhao
     * @date   2020/10/14
     */
    public function printString()
    {
        if ($this->length <= 0) {
            echo '队列长度为空'.PHP_EOL;
            return;
        }

        $currentNode = $this->head;
        while ($currentNode->next) {
            echo $currentNode->next->data.'->';
            $currentNode = $currentNode->next;
        }
        echo 'NULL'.PHP_EOL;
    }


}