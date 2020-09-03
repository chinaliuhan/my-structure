#!/usr/local/bin/php
<?php

/**
 *
 * @file array.php
 * @author liuhao
 * @date 2020/9/3
 */
//declare(strict_types=1);
ini_set('log_errors', 'Off');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');

$lArray = new LArray(20);
echo $lArray->errorMsg ? $lArray->errorMsg . PHP_EOL : '';

for ($i = 0; $i < 15; $i++) {
	$insertResult = $lArray->insert($i, 'value:' . $i);
	echo $lArray->errorMsg ? $lArray->errorMsg . PHP_EOL : '';
}
$lArray->dump();


$deleteValue = $lArray->delete(5);
echo $lArray->errorMsg ? $lArray->errorMsg . PHP_EOL : '';
echo 'delete element is: ' . ($lArray->errorMsg ?? $deleteValue) . PHP_EOL;
$lArray->dump();

$deleteValue = $lArray->delete(6);
echo $lArray->errorMsg ? $lArray->errorMsg . PHP_EOL : '';
echo 'delete element is: ' . ($lArray->errorMsg ?? $deleteValue) . PHP_EOL;
$lArray->dump();

$deleteValue = $lArray->delete(10);
echo $lArray->errorMsg ? $lArray->errorMsg . PHP_EOL : '';
echo 'delete element is: ' . ($lArray->errorMsg ?? $deleteValue) . PHP_EOL;
$lArray->dump();

$findValue = $lArray->find(400);
echo 'get element is: ' . ($lArray->errorMsg ?? $findValue) . PHP_EOL;
$lArray->dump();

/**
 *可自定义下标的数组
 * @class LArray
 * @author liuhao
 * @date 2020/9/3
 */
class LArray
{
	/**
	 * @var int array相关
	 */
	//容量
	protected $size;
	//长度
	protected $length;
	//数组
	protected $data;
	
	/**
	 * @var string 其他
	 */
	//错误信息
	public $errorMsg;
	
	/**
	 *构造函数
	 * LArray constructor.
	 * @param int $size
	 * @author liuhao
	 * @date 2020/9/3
	 */
	public function __construct(int $size)
	{
		//validate
		if ($size <= 0) {
			$this->errorMsg = '容量不能<=0';
			return null;
		}
		
		//设置数组大小;初始化长度;初始化数组
		$this->size   = $size;
		$this->length = 0;
		$this->data   = [];
	}
	
	
	/**
	 *插入数据
	 * @param int $index
	 * @param string $value
	 * @return int
	 * @author liuhao
	 * @date 2020/9/3
	 */
	public function insert(int $index, string $value): int
	{
		//validate
		if ($index < 0) {
			$this->errorMsg = '下标不能<0; ' . "index:{$index} - value:{$value}";
			return 0;
		}
		if (empty($value)) {
			$this->errorMsg = '请勿插入空数据; ' . "index:{$index} - value:{$value}";
			return 0;
		}
		if ($this->isFull()) {
			$this->errorMsg = "数组已满; 当前容量:{$this->size} - " . "index:{$index} - value:{$value}";
			return 0;
		}
		
		//重整数组索引
		for ($i = $this->length - 1; $i >= $index; $i--) {
			$this->data[$i + 1] = $this->data[$i];
		}
		
		//insert
		$this->data[$index] = $value;
		$this->length++;
		
		return $this->length;
	}
	
	
	/**
	 *删除元素
	 * @param int $index
	 * @return string
	 * @author liuhao
	 * @date 2020/9/3
	 */
	public function delete(int $index): string
	{
		//validate
		if ($index < 0) {
			$this->errorMsg = '下标不能<0';
			return '';
		}
		if (!$this->isRange($index)) {
			$this->errorMsg = '超出索引范围; 当前索引范围:{$this->length}; index:' . $index;
			return '';
		}
		
		//取出指定下标的数据;
		$value = $this->data[$index];
		//重整数组,通过将指定下标后面的数据前移的形式删除数据,并保持索引的连续性
		for ($i = $index; $i < $this->length - 1; $i++) {
			$this->data[$i] = $this->data[$i + 1];
		}
		
		$this->length--;
		return $value;
	}
	
	/**
	 *
	 * @return bool
	 * @author liuhao
	 * @date 2020/9/3
	 */
	public function isFull(): bool
	{
		if ($this->size == $this->length) {
			return true;
		}
		return false;
	}
	
	
	/**
	 *判断索引是否在数组范围内
	 * @param $index
	 * @return bool
	 * @author liuhao
	 * @date 2020/9/3
	 */
	public function isRange($index): bool
	{
		if ($index < $this->length) {
			return true;
		}
		return false;
	}
	
	
	/**
	 *通过索引获取数据
	 * @param int $index
	 * @return string
	 * @author liuhao
	 * @date 2020/9/3
	 */
	public function find(int $index): string
	{
		//validate
		if ($index < 0) {
			$this->errorMsg = '下标不能<0';
			return '';
		}
		if (!$this->isRange($index)) {
			$this->errorMsg = "超出索引范围; 当前索引范围:{$this->length}; index:" . $index;
			return '';
		}
		
		//get data
		return $this->data[$index];
	}
	
	
	/**
	 *打印数组所有的元素
	 * @return void
	 * @author liuhao
	 * @date 2020/9/3
	 */
	public function dump()
	{
		$printString = "";
		for ($i = 0; $i < $this->length; $i++) {
			$printString .= $this->data[$i] . ' - ';
		}
		echo $printString . PHP_EOL;
	}
	
}