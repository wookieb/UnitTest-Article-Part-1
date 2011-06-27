<?php
/**
 * @author wookieb
 */
class Reader_Tag_File extends Reader_Tag {
	private $_file;

	protected function _parseSpecificEntryData(SimpleXMLElement $entry) {
		$this->_file = (string)$entry;
		if (!file_exists($this->_file)) {
			throw new Reader_Exception('File "'.$this->_file.'" does not exists');
		}
	}

	public function getFile() {
		return $this->_file;
	}
}
