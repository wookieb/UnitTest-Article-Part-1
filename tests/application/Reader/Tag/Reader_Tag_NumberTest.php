<?php
/**
 * @author wookieb
 * @group Reader
 * @group Reader_Tags
 */
class Reader_Tag_NumberTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var Reader_Tag_Number
	 */
	protected $object;

	public function testGetValueReturnNumericValueIfItIsNumeric() {
		$element = $this->_getFirstElementFromXml('resources/datasets/Reader/Tag/Number/valid.xml');
		$this->object = new Reader_Tag_Number($element);
		$this->assertSame('100', $this->object->getValue());
	}

	protected function _getFirstElementFromXml($xml) {
		$xml = simplexml_load_file($xml);
		return $xml->children();
	}

	public function testNonNumericValuesThrowsException() {
		$element = $this->_getFirstElementFromXml('resources/datasets/Reader/Tag/Number/not_valid.xml');
		$this->setExpectedException('Reader_Exception', 'not numeric value');
		$this->object = new Reader_Tag_Number($element);
	}
}
