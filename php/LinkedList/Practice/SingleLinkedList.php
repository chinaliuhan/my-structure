<?php
/**
 *
 * @file singleLinkedList.php
 * @author liuhao
 * @date 2020/9/6
 */

namespace LinkedList\Practice;

/**
 *单项链表
 * @class SingleLinkedList
 * @author liuhao
 * @date 2020/9/6
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
	 * @param null $head
	 * @author liuhao
	 * @date 2020/9/6
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
	
	
}