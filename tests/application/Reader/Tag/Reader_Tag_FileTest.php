<?php
/**
 * @author wookieb
 * @group Reader
 * @group Reader_Tags
 */
class Reader_Tag_FileTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var Reader_Tag_File
	 */
	protected $object;

	public function testGetFileReturnFilePathIfItExists() {
		$element = $this->_getFirstElementFromXml('resources/datasets/Reader/Tag/File/exists.xml');
		$this->object = new Reader_Tag_File($element);
		$this->assertSame('resources/datasets/Reader/Tag/File/exists.xml', $this->object->getFile());
	}

	protected function _getFirstElementFromXml($xml) {
		$xml = simplexml_load_file($xml);
		return $xml->children();
	}

	public function testPathForNonExistedFileThrowsException() {
		$element = $this->_getFirstElementFromXml('resources/datasets/Reader/Tag/File/not_exists.xml');
		$this->setExpectedException('Reader_Exception', 'does not exists');
		$this->object = new Reader_Tag_File($element);
	}
}
