<?php
/**
 *
 * @file   PracticesSingleLinkedList.php
 * @author liuhao
 * @date   2020/9/6
 */
declare(strict_types=1);

namespace LinkedList\Practice00;

use LinkedList\Practice00\SingleLinkedListNode;

/**
 *单向链表-练习
 * @class   SingleLinkedList
 * @author  liuhao
 * @date    2020/9/18
 * @package LinkedList\Practice00
 */
class SingleLinkedList
{
    //链表的头结点位置,其实就是当前数据集
    public $head;
    //链表的长度
    public $length;
    //错误信息
    public $errMsg;

    /**
     *构造函数- 初始化链表
     * SingleLinkedList constructor.
     * @param $head
     * @author liuhao
     * @date   2020/9/18
     */
    public function __construct($head)
    {
        //初始化链表及链表数据
        if (empty($head)) {
            //初始化链表 - 数据和指针全部为null,后面可以作为哨兵使用
            $this->head = new SingleLinkedListNode(null, null);
        } else {
            $this->head = $head;
        }

        $this->length = 0;
    }

    /**
     * 获取链表当前长度
     * @return int
     * @author liuhao
     * @date   2020/9/18
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * 插入节点
     * @param  string|int  $data
     * @return bool
     * @author liuhao
     * @date   2020/9/18
     */
    public function insetData($data): bool
    {
        //将数据插入到当前数据的后面
        return $this->insertDataAfter($this->head, $data);
    }

    /**
     *在某个几点后面插入指定的数据
     * @param  SingleLinkedListNode          $originalNode
     * @param                                $data
     * @return bool
     * @author liuhao
     * @date   2020/9/18
     */
    public function insertDataAfter(SingleLinkedListNode $originalNode, $data): bool
    {
        //为新的数据初始化一个节点对象, 并将数据填充到对象中去
        $newNode            = new SingleLinkedListNode($data, $originalNode->next);
        $originalNode->next = $newNode;

        $this->length++;

        return true;
    }

    /**
     * 在指定节点后面插入新的节点
     * 1. next 中存储着下一个节点的数据, 这将newNode 插入到originalNode的下一个节点,即放到next中
     * 2. 这里我们直接将新节点的next改成源节点的next
     * 3. 再将源节点中的next指向新节点
     *
     * @param  SingleLinkedListNode  $originalNode
     * @param  SingleLinkedListNode  $newNode
     * @return bool
     * @author liuhao
     * @date   2020/9/18
     */
    public function insertNodeAfter(SingleLinkedListNode $originalNode, SingleLinkedListNode $newNode): bool
    {
        $newNode->next      = $originalNode->next;
        $originalNode->next = $newNode;

        $this->length++;

        return true;
    }


    /**
     *删除指定节点
     * 1. 查找当前节点的上一个节点
     * 2. 将当前节点的next(包含下一个节点的值,下一个节点的next包含下下一个节点的值)
     * 3. 将上一个节点的next指向下一个节点的next, 让链表直接跳过当前节点, 相当于是删除了当前节点
     * 4. 目前删除非常鸡肋,因为要删除一个节点,需要同时对比他的对象中data和next所有数据是否匹配才能确认是否是同一个节点
     * 5. 而next是下一个节点的整个数据,如果要匹配就要把next后面的数据全部传入进来,如果是删除第一个的话也还要,只要将next传入一个null
     * @param  SingleLinkedListNode  $node
     * @return bool
     * @author liuhao
     * @date   2020/9/19
     */
    public function delete(SingleLinkedListNode $node): bool
    {
        //匹配该节点的前一个节点
        $preNode = $this->getPreNode($node);
        if (empty($preNode)) {
            $this->errMsg = '前一个节点不存在,无法删除: '.$this->errMsg;

            return false;
        }

        //并非是直接删除前一个节点中的next,因为next中存储着下一个节点的数据,如果直接删除,后面的数据就都没有了
        //所以,这里是直接将该node的next放到上一个节点的next中,相当于就是将当前node直接跳过了
        $preNode->next = $node->next;

        unset($node);
        $this->length--;

        return true;
    }

    /**
     *获取节点的前一个节点
     * @param  SingleLinkedListNode  $node
     * @return false|SingleLinkedListNode|null
     * @author liuhao
     * @date   2020/9/19
     */
    public function getPreNode(SingleLinkedListNode $node)
    {
        $currentNode = $this->head;
        $preNode     = $this->head;

        /**
         * 遍历找到前置节点 要用全等判断是否是同一个对象
         * 当使用比较运算符（==）比较两个对象变量时，比较的原则是：如果两个对象的属性和属性值 都相等，而且两个对象是同一个类的实例，那么这两个对象变量相等。
         * 而如果使用全等运算符（===），这两个对象变量一定要指向某个类的同一个实例（即同一个对象）。
         */
        while ($currentNode != $node) {
            if (empty($currentNode)) {
                $this->errMsg = '没有匹配到合适的节点';
                return null;
            }

            $preNode     = $currentNode;
            $currentNode = $currentNode->next;
        }

        return $preNode ?? null;
    }

    /**
     *通过传入的索引,获取链表的第N个数据
     * @param $index
     * @return null|SingleLinkedListNode
     * @author liuhao
     * @date   2020/9/19
     */
    public function getNodeByIndex($index)
    {
        if (empty($this->head)) {
            $this->errMsg = '没有数据';
            return null;
        }
        if ($index >= $this->length) {
            $this->errMsg = 'index超过长度限制 '.$this->length;
            return null;
        }
        if ($index <= 0) {
            $this->errMsg = 'index<=0';
            return null;
        }

        //从头遍历链表,将
        $current = $this->head->next;
        for ($i = 0; $i < $index; $i++) {
            $current = $current->next;
        }

        return $current;
    }

    /**
     *直接输出对象json后的字符串
     * @return string
     * @author liuhao
     * @date   2020/9/19
     */
    public function printJson(): string
    {
        if (empty($this->head->next)) {
            return '';
        }
        return json_encode($this->head->next);
    }

    /**
     *简单的输出数据
     * @return string
     * @author liuhao
     * @date   2020/9/19
     */
    public function printSimple(): string
    {
        if (empty($this->head->next)) {
            return '';
        }

        $currentNode = $this->head;
        $printString = '';
        while ($currentNode->next != null) {
            $printString .= $currentNode->next->data.' => ';
            $currentNode = $currentNode->next;
        }

        return $printString.'null';
    }


}