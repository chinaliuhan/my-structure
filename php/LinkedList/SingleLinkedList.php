<?php
/**
 *
 * @file   singleLinkedList.php
 * @author liuhao
 * @date   2020/9/6
 */

namespace LinkedList;

/**
 *单项链表
 * @class   SingleLinkedList
 * @author  liuhao
 * @date    2020/9/6
 * @package LinkedList
 */
class SingleLinkedList
{
    //头结点
    public $head;

    //链表长度
    protected $length;


    /**
     *构造函数- 初始化单项链表
     * SingleLinkedList constructor.
     * @param  null  $head
     * @author liuhao
     * @date   2020/9/6
     */
    public function __construct($head = null)
    {
        if ($head == null) {
            $this->head = new SingleLinkedListNode();
        } else {
            $this->head = $head;
        }
        //指定链表的长度为0
        $this->length = 0;
    }

    /**
     *获取链表的长度
     * @return int
     * @author liuhao
     * @date   2020/9/6
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     *插入数据 采用头插法 插入新数据
     * @param $data
     * @return bool
     * @author liuhao
     * @date   2020/9/6
     */
    public function insert($data): bool
    {
        return $this->insertDataAfter($this->head, $data);
    }

    /**
     *在某个节点后面插入新的节点(直接插入数据)
     * @param  SingleLinkedListNode  $originNode
     * @param                        $data
     * @return bool
     * @author liuhao
     * @date   2020/9/6
     */
    public function insertDataAfter(SingleLinkedListNode $originNode, $data): bool
    {
        //禁止为空
        if ($originNode == null) {
            return false;
        }

        //新建单向链表的节点
        $newNode = new SingleLinkedListNode();
        //新节点的数据
        $newNode->data = $data;
        //新节点的下一个节点为源节点的下一个节点
        $newNode->next = $originNode->next;
        //在originNode后面插入newNode
        $originNode->next = $newNode;

        //链表长度自增
        $this->length++;

        return true;
    }

    /**
     *在指定的节点后面插入一个节点
     * @param  SingleLinkedListNode  $originNode
     * @param  SingleLinkedListNode  $node
     * @return SingleLinkedListNode
     * @author liuhao
     * @date   2020/9/6
     */
    public function insertNodeAfter(SingleLinkedListNode $originNode, SingleLinkedListNode $node)
    {
        if ($originNode == null) {
            return null;
        }

        $this->next       = $originNode->next;
        $originNode->next = $node;
        $this->length++;

        return $node;
    }

    /**
     *在某个节点前插入新的节点
     * @param  SingleLinkedListNode  $originNode
     * @param                        $data
     * @return bool
     * @author liuhao
     * @date   2020/9/6
     */
    public function insertDataBefore(SingleLinkedListNode $originNode, $data): bool
    {
        //禁止为空
        if ($originNode == null) {
            return false;
        }

        //先找到originNode的前置节点,而后通过insertDataAfter来插入
        $prevNode = $this->getPrevNode($originNode);
        return $this->insertDataAfter($prevNode, $data);
    }

    /**
     *获取指定节点的前置节点
     * @param  SingleLinkedListNode  $node
     * @return SingleLinkedListNode|null
     * @author liuhao
     * @date   2020/9/6
     */
    public function getPrevNode(SingleLinkedListNode $node)
    {
        $currentNode = $this->head;
        $prevNode    = $this->head;
        /**
         * 遍历找到前置节点 要用全等判断是否是同一个对象
         * 当使用比较运算符（==）比较两个对象变量时，比较的原则是：如果两个对象的属性和属性值 都相等，而且两个对象是同一个类的实例，那么这两个对象变量相等。
         * 而如果使用全等运算符（===），这两个对象变量一定要指向某个类的同一个实例（即同一个对象）。
         */
        while ($currentNode != $node) {
            if ($currentNode == null) {
                return null;
            }
            $prevNode    = $currentNode;
            $currentNode = $currentNode->next;
        }

        return $prevNode;
    }


    /**
     *删除指定的节点
     * @param  SingleLinkedListNode  $node
     * @return bool
     * @author liuhao
     * @date   2020/9/6
     */
    public function delete(SingleLinkedListNode $node): bool
    {
        if ($node == null) {
            return false;
        }
        //获取待删除节点的前置节点
        $prevNode = $this->getPrevNode($node);
        if (empty($prevNode)) {
            return false;
        }

        //修改指针指向
        $prevNode->next = $node->next;
        unset($node);

        //自减-减少长度
        $this->length--;

        return true;
    }

    /**
     *通过索引获取指定的节点
     * @param $index
     * @return  null|SingleLinkedListNode
     * @author liuhao
     * @date   2020/9/6
     */
    public function getNodeByIndex($index)
    {
        if ($index >= $this->length) {
            return null;
        }
        $current = $this->head->next;
        for ($i = 0; $i < $index; $i++) {
            $current = $current->next;
        }

        return $current;
    }

    /**
     *打印单项链表 - 直接遍历打印- 如果是循环链表可能会出现死循环
     * @return void
     * @author liuhao
     * @date   2020/9/6
     */
    public function printListSample(): void
    {
        if ($this->head->next == null) {
            echo 'not has data'.PHP_EOL;
            return;
        }
        $currentNode = $this->head;
        while ($currentNode->next != null) {
            echo $currentNode->next->data.'-> ';
            $currentNode = $currentNode->next;
        }
        echo "NULL".PHP_EOL;
    }

    /**
     * 打印单项链表 -遍历打印 - 如果是循环链表不会出现死循环
     * @return void
     * @author liuhao
     * @date   2020/9/6
     */
    public function printList(): void
    {
        if ($this->head->next == null) {
            echo 'not has data'.PHP_EOL;
            return;
        }
        $currentNode = $this->head;
        $listLength  = $this->getLength();
        while ($currentNode->next != null && $listLength--) {
            echo $currentNode->next->data.'-> ';

            $currentNode = $currentNode->next;
        }
        echo 'NULL'.PHP_EOL;
    }

    /**
     *构建一个循环单项链表
     * @return void
     * @author liuhao
     * @date   2020/9/6
     */
    public function buildCircleList(): void
    {
        $data = [1, 2, 3, 4, 5, 6, 7, 8];

        $node0 = new SingleLinkedListNode($data[0]);
        $node1 = new SingleLinkedListNode($data[1]);
        $node2 = new SingleLinkedListNode($data[2]);
        $node3 = new SingleLinkedListNode($data[3]);
        $node4 = new SingleLinkedListNode($data[4]);
        $node5 = new SingleLinkedListNode($data[5]);
        $node6 = new SingleLinkedListNode($data[6]);
        $node7 = new SingleLinkedListNode($data[7]);

        $this->insertNodeAfter($this->head, $node0);
        $this->insertNodeAfter($node0, $node1);
        $this->insertNodeAfter($node1, $node2);
        $this->insertNodeAfter($node2, $node3);
        $this->insertNodeAfter($node3, $node4);
        $this->insertNodeAfter($node4, $node5);
        $this->insertNodeAfter($node5, $node6);
        $this->insertNodeAfter($node6, $node7);

        $node7->next = $node4;
    }


}