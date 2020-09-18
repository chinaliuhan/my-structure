<?php
/**
 *
 * @file PracticeSingleLinkedListNode.php
 * @author liuhao
 * @date 2020/9/6
 */
declare(strict_types=1);

namespace LinkedList\Practice;

/**
 *单项链表练习的节点类
 * @class PracticeSingleLinkedListNode
 * @author liuhao
 * @date 2020/9/18
 * @package LinkedList\Practice
 */
class PracticeSingleLinkedListNode
{
	//数据
	public $data;
	//指针 - 指向下一个节点
	public $next;
	
	public function __construct($data, $next)
	{
		$this->data = $data;
		$this->next = $next;
	}
}