<?php
/**
 * @author wookieb
 */
abstract class Reader_Tag {
	protected $_name;

	public function __construct(SimpleXMLElement $entry) {
		$this->_parseEntry($entry);
	}

	protected function _parseEntry(SimpleXMLElement $entry) {
		$this->_parseName($entry);
		$this->_parseSpecificEntryData($entry);
	}

	protected function _parseName($entry) {
		$this->_name = (string)$entry->attributes()->name;
		$this->_name = trim($this->_name);
		if (empty($this->_name)) {
			throw new Reader_Exception('Entry name is empty');
		}
	}

	abstract protected function _parseSpecificEntryData(SimpleXMLElement $entry);

	public function getName() {
		return $this->_name;
	}
}
