<?php

namespace WebLoader\Filter;

/**
 * Less CSS filter
 *
 * @author Jan Marek
 * @author Martin Takáč <martin@takac.name>
 * @license MIT
 */
class LessFilter
{

	private $lc;

	/**
	 * @return \lessc
	 */
	private function getLessC()
	{
		// lazy loading
		if (empty($this->lc)) {
			$this->lc = new \lessc();
		}

		return $this->lc;
	}

	/**
	 * Invoke filter
	 * @param string $code
	 * @param \WebLoader\Compiler $loader
	 * @param string $file
	 * @return string
	 */
	public function __invoke($code, \WebLoader\Compiler $loader, $file = Null)
	{
		if ($file && pathinfo($file, PATHINFO_EXTENSION) === 'less') {
			$this->getLessC()->importDir = pathinfo($file, PATHINFO_DIRNAME) . '/';
			return $this->getLessC()->parse($code);
		}
		else {
			$this->getLessC()->importDir = rtrim($loader->getOutputDir() . '/') . '/';
			$code = $this->getLessC()->parse($code);
		}

		return $code;
	}

}
