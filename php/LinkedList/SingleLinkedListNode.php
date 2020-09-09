<?php
/**
 *
 * @file SingleLinkedListNode.php
 * @author liuhao
 * @date 2020/9/6
 */

namespace LinkedList;

/**
 *单向链表节点
 * @class SingleLinkedListNode
 * @author liuhao
 * @date 2020/9/6
 * @package LinkedList
 */
class SingleLinkedListNode
{
	//节点中的数据域
	public $data;
	
	//节点中的指针域,指向下一个节点
	public $next;
	
	/**
	 *构造函数 - 初始化节点的数据域
	 * SingleLinkedListNode constructor.
	 * @param null $data
	 * @author liuhao
	 * @date 2020/9/6
	 */
	public function __construct($data = null)
	{
		$this->data = $data;
		$this->next = null;
	}
}