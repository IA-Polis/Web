<?

/*******************************************************************************************
*
* Class Name 			: phpCollection
* Version    			: 1.0
* Written By 			: Hasin Hayder
* Start Date 			: 10th March, 2005
* �ltima atualiza��o	: 11/12/2008
* Atualiza��o			: Acrescentado propriedade totalLength que pode conter a quantidade
*						  total de registros retornados independentes da cl�usula LIMIT
* Release License 		: LGPL
*
********************************************************************************************
*
* This class implements Collection object in PHP.
*
*/
namespace Config {
	class phpCollection
	{
		var $length;
		var $totalLength; // Acrescentado para indicar a quantidade de elementos independente da cl�usula LIMIT
		var $elements = array();
		var $__cnt = 0;
		var $__temp;

		function add($key, $item)
		{
			if (!array_key_exists($key, $this->elements)) {
				$this->elements[$key] = $item;
				$this->length = count($this->elements);
				$this->__temp = array_values($this->elements);
				return true;
			}
			return false;

		}

		function remove($key)
		{

			$result = false;
			if (array_key_exists($key, $this->elements)) {
				unset($this->elements[$key]);
				$result = true;
			}

			$this->length = count($this->elements);
			$this->__temp = array_values($this->elements);
			return $result;
		}

		function key_exists($k)
		{
			return array_key_exists($k, $this->elements);
		}


		function test_next()
		{
			if (($this->__cnt) < ($this->length - 1)) {
				return true;
			} else
				return false;
		}

		function move_next()
		{
			if (($this->__cnt) < ($this->length - 1)) {
				$this->__cnt++;
				return true;

			} else
				return false;
		}

		function has_next()
		{
			if (($this->__cnt) < ($this->length - 1)) {
				$this->__cnt++;
				return true;

			} else
				return false;
		}

		function rewind()
		{
			//just set the iterator position to first
			$this->__cnt = 0;
		}

		function current()
		{

			return $this->__temp[$this->__cnt];

		}

		function itemat($pos)
		{
			return $this->__temp[$pos];
		}

		function removeat($pos)
		{
			$keys = array_keys($this->elements);
			$curkey = $keys[$pos];
			return $this->remove($curkey);
		}

		function item($key)
		{
			return $this->elements[$key];
		}

		function itemarray()
		{
			return $this->__temp;
		}

		function clear()
		{
			$this->elements = array();
			$this->__temp = array();
			$this->__cnt = 0;
			$this->length = 0;
		}
	}
}
?>