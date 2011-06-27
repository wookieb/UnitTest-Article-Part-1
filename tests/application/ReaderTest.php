<?php
/**
 * @author wookieb
 * @group Reader
 */
class ReaderTest extends PHPUnit_Framework_TestCase {
	/**
	 * @var Reader
	 */
	protected $object;

	public function testXmlObviouslyMustBeValidXmlOtherwiseThrowsException() {
		$this->setExpectedException('Reader_Exception', 'Invalid xml');
		$this->object = new Reader('resources/datasets/Reader/invalid_xml.xml');
	}

	public function testXmlMustExists() {
		$this->setExpectedException('Reader_Exception', 'not exists');
		$this->object = new Reader('some_non_exists.xml');
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testReaderCollectsObjectsCorrespondingToEntryTagName() {
		$this->getMockBuilder('Reader_Tag')
				->setMockClassName('Reader_Tag_Entry')
				->disableOriginalConstructor()
				->getMockForAbstractClass();

		$this->getMockBuilder('Reader_Tag')
				->setMockClassName('Reader_Tag_Entry2')
				->disableOriginalConstructor()
				->getMockForAbstractClass();

		$this->object = new Reader('resources/datasets/Reader/example.xml');
		$this->assertEmpty($this->object->getErrors(), 'Errors should be empty array');
		$data = $this->object->getData();
		$this->assertInstanceOf('Reader_Tag_Entry', $data[0]);
		$this->assertInstanceOf('Reader_Tag_Entry2', $data[1]);
	}

	/**
	 * @runInSeparateProcess
	 * @depends testReaderCollectsObjectsCorrespondingToEntryTagName
	 */
	public function testEntriesWithoutCorrespondingReaderTagReportsError() {
		$this->getMockBuilder('stdClass')
				->setMockClassName('Reader_Tag_Entry')
				->getMock();

		$this->object = new Reader('resources/datasets/Reader/example.xml');
		$this->assertContains('Class Reader_Tag_Entry2 not exists. Cannot handle', current($this->object->getErrors()), 'No error handled!');
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testReaderExceptionsThrowsDuringParseEntryAreCollectedInErrors() {
		$this->getMockBuilder('Reader_Tag_ThrowsException')
				->setMockClassName('Reader_Tag_Entry')
				->disableOriginalConstructor()
				->getMock();

		$this->getMockBuilder('Reader_Tag_ThrowsException')
				->setMockClassName('Reader_Tag_Entry2')
				->disableOriginalConstructor()
				->getMock();

		$this->object = new Reader('resources/datasets/Reader/example.xml');
		$errors = $this->object->getErrors();
		$this->assertContains('Some error', current($errors), 'Failed catch first error');
		$this->assertContains('Some error', next($errors), 'Failed catch second error');
	}

	/**
	 * @runInSeparateProcess
	 * @depends testReaderCollectsObjectsCorrespondingToEntryTagName
	 */
	public function testDataAndErrorsAreCleanOffAfterAnotherUsageTime() {
		$this->getMockBuilder('Reader_Tag')
				->setMockClassName('Reader_Tag_Entry')
				->disableOriginalConstructor()
				->getMockForAbstractClass();

		$this->getMockBuilder('Reader_Tag')
				->setMockClassName('Reader_Tag_Entry2')
				->disableOriginalConstructor()
				->getMockForAbstractClass();
		$this->object = new Reader('resources/datasets/Reader/example.xml');
		$this->assertSame(2, count($this->object->getData()));
		$this->object->__construct('resources/datasets/Reader/example_less.xml');
		$this->assertSame(1, count($this->object->getData()));
	}
}
