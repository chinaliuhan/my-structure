<?php
/**
 *
 * @file   SingleLinkedListNode.php
 * @author liuhao
 * @date   2020/10/13
 */
declare(strict_types=1);

namespace LinkedList\Practice01;

/**
 * 单项链表练习的节点类
 * @class   SingleLinkedListNode
 * @author  liuhao
 * @date    2020/10/13
 * @package Practice01
 */
class SingleLinkedListNode
{

    //数据
    public $data;
    //下一个节点的指针
    public $next;


    /**
     *构造函数
     * SingleLinkedListNode constructor.
     * @param  void                       $data  数据
     * @param  SingleLinkedListNode|null  $next  下一个节点的指针
     * @author liuhao
     * @date   2020/10/13
     */
    public function __construct($data, $next)
    {
        $this->data = $data;
        $this->next = $next;
    }

}