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


$lArray = new LArray1(20);
for ($i = 0; $i < 11; $i++) {
	$lArray->append('value:' . $i) ? '' : __LINE__ . $lArray->errorMsg . PHP_EOL;
}
$lArray->dump();;


echo $lArray->delete(3) ? '' : __LINE__ . $lArray->errorMsg . PHP_EOL;
$lArray->dump();

echo $lArray->delete(5) ? '' : __LINE__ . $lArray->errorMsg . PHP_EOL;
$lArray->dump();


/**
 * 不可自定义下标的数组
 * @class LArray
 * @author liuhao
 * @date 2020/9/3
 */
class LArray1
{
	protected $size;
	protected $length;
	protected $data;
	
	public $errorMsg;
	
	/**
	 *构造函数
	 * LArray constructor.
	 * @author liuhao
	 * @date 2020/9/3
	 */
	public function __construct(int $size)
	{
		$this->size   = $size;
		$this->length = 0;
		$this->data   = [];
	}
	
	/**
	 *追加数据
	 * @param $value
	 * @return int
	 * @author liuhao
	 * @date 2020/9/3
	 */
	public function append($value): int
	{
		if ($this->isFull()) {
			return 0;
		}
		//append不需要重整索引
		$this->data[$this->length] = $value;
		$this->length++;
		
		return $this->length;
	}
	
	/**
	 *删除指定下标的元素
	 * @param int $index
	 * @return bool
	 * @author liuhao
	 * @date 2020/9/3
	 */
	public function delete(int $index): bool
	{
		if (!$this->isRange($index)) {
			$this->errorMsg = 'out of range';
			return false;
		}
		
		//重整数组,通过将指定下标后面的数据前移的形式删除数据,并保持索引的连续性
		for ($i = $index; $i < $this->length; $i++) {
			$this->data[$i] = $this->data[$i + 1] ?? null;
		}
		
		$this->length--;
		echo '数组的当前长度为:' . $this->length . PHP_EOL;
		
		return true;
	}
	
	/**
	 *通过下标查找元素
	 * @param $index
	 * @return false|mixed
	 * @author liuhao
	 * @date 2020/9/3
	 */
	public function find($index)
	{
		if (!$this->isRange($index)) {
			return false;
		}
		return $this->data[$index];
	}
	
	/**
	 *是否超过范围
	 * @param $index
	 * @return bool
	 * @author liuhao
	 * @date 2020/9/3
	 */
	public function isRange($index): bool
	{
		if ($index > $this->size || $index > $this->length) {
			return false;
		}
		return true;
	}
	
	/**
	 *是否已满
	 * @return bool
	 * @author liuhao
	 * @date 2020/9/3
	 */
	public function isFull(): bool
	{
		if ($this->length >= $this->size) {
			return true;
		}
		return false;
	}
	
	/**
	 *void
	 * @return void
	 * @author liuhao
	 * @date 2020/9/3
	 */
	public function dump(): void
	{
		var_dump($this->data);
	}
	
}