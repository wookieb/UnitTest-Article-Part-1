<?php
/**
 * @author wookieb
 * @group Reader
 * @group Reader_Tags
 */
class Reader_TagTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var Reader_Tag
	 */
	protected $object;

	protected function setUp() {
		parent::setUp();
		$this->object = $this->getMockBuilder('Reader_Tag')
				->disableOriginalConstructor()
				->getMockForAbstractClass();
	}

	public function testGetNameReturnNameAttribute() {
		$element = $this->_getFirstElementFromXml('resources/datasets/Reader/Tag/name.xml');
		$this->object->__construct($element);
		$this->assertSame('some_name', $this->object->getName());
	}

	protected function _getFirstElementFromXml($xml) {
		$xml = simplexml_load_file($xml);
		return $xml->children();
	}

	public function testEntryNameCannotBeEmpty() {
		$element = $this->_getFirstElementFromXml('resources/datasets/Reader/Tag/empty_name.xml');
		$this->setExpectedException('Reader_Exception', 'name is empty');
		$this->object->__construct($element);
	}
}
