<?php
class Reader_Tag_ThrowsException extends Reader_Tag {

	protected function _parseSpecificEntryData(SimpleXMLElement $entry) {
		throw new Reader_Exception('Some error message');
	}
}
