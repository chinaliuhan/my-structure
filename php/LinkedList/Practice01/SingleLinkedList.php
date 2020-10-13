<?php
/**
 *
 * @file   SingleLinkedList.php
 * @author liuhao
 * @date   2020/10/13
 */

declare(strict_types=1);

namespace LinkedList\Practice01;

/**
 *单项链表
 * @class   SingleLinkedList
 * @author  liuhao
 * @date    2020/10/13
 * @package LinkedList\Practice01
 */
class SingleLinkedList
{
    //链表的头结点位置
    public $head;
    //链表的长度
    public $length;
    //错误信息
    public $errorMsg;

    /**
     *构造函数
     * SingleLinkedList constructor.
     * @param $head
     * @author liuhao
     * @date   2020/10/13
     */
    public function __construct($head)
    {
        //初始化链表及链表数据时未传入节点
        if (empty($head)) {
            //初始化链表 - 数据和指针全部为null,后面可以作为哨兵使用
            $this->head = new SingleLinkedListNode(null, null);
        } else {
            //赋值
            $this->head = $head;
        }

        $this->length = 0;
    }

    /**
     *打印链表-json形式
     * @return void
     * @author liuhao
     * @date   2020/10/13
     */
    public function printJson()
    {
        echo json_encode($this->head).PHP_EOL;
    }

    /**
     *打印链表的字符串
     * @return void
     * @author liuhao
     * @date   2020/10/13
     */
    public function printString()
    {
        if (empty($this->head->next)) {
            echo 'none'.PHP_EOL;
        } else {
            $currentNode = $this->head;
            $string      = '';
            while ($currentNode->next != null) {
                $string      .= $currentNode->next->data.'=>';
                $currentNode = $currentNode->next;
            }

            echo $string.'null'.PHP_EOL;
        }
    }

    /**
     *print_r
     * @return void
     * @author liuhao
     * @date   2020/10/13
     */
    public function print()
    {
        return print_r($this->head);
    }

    /**
     * 获取链表的长度
     * @return int
     * @author liuhao
     * @date   2020/10/13
     */
    public function getLength(): int
    {

        return $this->length;
    }


    /**
     *在当前节点后插入数据
     * @param $data
     * @return bool
     * @author liuhao
     * @date   2020/10/13
     */
    public function insertData($data): bool
    {
        return $this->insertDataAfterByNode($this->head, $data);
    }

    /**
     *在指定的节点后插入数据
     * @param  SingleLinkedListNode  $node
     * @param  void                  $data
     * @return bool
     * @author liuhao
     * @date   2020/10/13
     */
    public function insertDataAfterByNode(SingleLinkedListNode $node, $data): bool
    {
        //为新的数据初始化一个节点对象, 并将数据填充到对象中去
        $node->next = new SingleLinkedListNode($data, $node->next);;
        $this->length++;

        return true;
    }

    /**
     *在指定的节点后插入一个节点
     * 1. next 中存储着下一个节点的数据, 这将newNode 插入到node的下一个节点,即放到next中
     * 2. 这里我们直接将新节点的next改成源节点的next
     * 3. 再将源节点中的next指向新节点
     * @param  SingleLinkedListNode  $node
     * @param  SingleLinkedListNode  $newNode
     * @return bool
     * @author liuhao
     * @date   2020/10/13
     */
    public function insertNodeAfterByNode(SingleLinkedListNode $node, SingleLinkedListNode $newNode): bool
    {
        $newNode->next = $node->next;
        $node->next    = $newNode;

        $this->length++;

        return true;
    }

    /**
     *通过节点来删除指定的节点 - 单纯通过节点来删除有点鸡肋-因为节点会包括子节点
     * 1. 查找当前节点的上一个节点
     * 2. 将当前节点的next(包含下一个节点的值,下一个节点的next包含下下一个节点的值)
     * 3. 将上一个节点的next指向下一个节点的next, 让链表直接跳过当前节点, 相当于是删除了当前节点
     * 4. 目前删除非常鸡肋,因为要删除一个节点,需要同时对比他的对象中data和next所有数据是否匹配才能确认是否是同一个节点
     * 5. 而next是下一个节点的整个数据,如果要匹配就要把next后面的数据全部传入进来,如果是删除第一个的话也还要,只要将next传入一个null
     * @param  SingleLinkedListNode  $node
     * @return bool
     * @author liuhao
     * @date   2020/10/13
     */
    public function deleteNodeByNode(SingleLinkedListNode $node): bool
    {
        $prevNode = $this->getPrevNode($node);
        if (empty($prevNode)) {
            $this->errorMsg = '该节点不存在前一个节点,故无法删除: '.$this->errorMsg;
            return false;
        }

        //并非是直接删除前一个节点中的next,因为next中存储着下一个节点的数据,如果直接删除,后面的数据就都没有了
        //所以,这里是直接将该node的next放到上一个节点的next中,相当于就是将当前node直接跳过了
        $prevNode->next = $node->next;
        $this->length--;
        return true;
    }


    /**
     *获取指定节点的上一个节点啊
     * @param  SingleLinkedListNode  $node
     * @return SingleLinkedListNode|null
     * @author liuhao
     * @date   2020/10/13
     */
    public function getPrevNode(SingleLinkedListNode $node)
    {
        //初始化当前节点和前一个节点
        $currentNode = $this->head;
        $prevNode    = $this->head;

        /**
         * 遍历找到前置节点 要用全等判断是否是同一个对象
         * 当使用比较运算符（==）比较两个对象变量时，比较的原则是：如果两个对象的属性和属性值 都相等，而且两个对象是同一个类的实例，那么这两个对象变量相等。
         * 而如果使用全等运算符（===），这两个对象变量一定要指向某个类的同一个实例（即同一个对象）。
         */
        while ($currentNode != $node) {
            if (empty($currentNode)) {
                $this->errorMsg = '没有匹配到合适的节点';
                return null;
            }
            $prevNode    = $currentNode;
            $currentNode = $currentNode->next;
        }

        return $prevNode ?? null;
    }

    public function getPrev(SingleLinkedListNode $node)
    {
        $currentNode = $this->head;
        $prevNode    = $this->head;
        while ($currentNode != $node) {
            if (empty($currentNode)) {
                $this->errorMsg = '没有匹配到合适的节点';
                return false;
            }

            $prevNode    = $currentNode;
            $currentNode = $currentNode->next;
        }

        return $prevNode ?? null;
    }


}