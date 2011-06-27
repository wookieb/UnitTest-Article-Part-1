<?php
/**
 * @author wookieb
 */
class Reader_Tag_Number extends Reader_Tag {
	private $_value;

	protected function _parseSpecificEntryData(SimpleXMLElement $entry) {
		$this->_value = (string)$entry;
		if (!is_numeric($this->_value)) {
			throw new Reader_Exception('"'.$this->_value.'" is not numeric value');
		}
	}

	public function getValue() {
		return $this->_value;
	}
}
