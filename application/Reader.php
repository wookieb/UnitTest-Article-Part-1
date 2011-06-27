<?php
/**
 * @author wookieb
 */
class Reader {
	protected $_data;
	protected $_errors;

	public function __construct($file) {
		$xml = $this->_readFile($file);
		$this->_parseXml($xml);
	}

	protected function _readFile($file) {
		if (!file_exists($file)) {
			throw new Reader_Exception('File "'.$file.'" not exists');
		}
		libxml_use_internal_errors(true);
		$xml = simplexml_load_file($file);
		if (!$xml) {
			$error = libxml_get_last_error();
			$message = 'Invalid xml: '.$error->message.' at line: '.$error->line.' column: '.$error->column;
			throw new Reader_Exception($message);
		}
		return $xml;
	}

	protected function _parseXml(SimpleXMLElement $xml) {
		$this->_data = array();
		$this->_errors = array();
		foreach ($xml as $entry) {
			try {
				$this->_data[] = $this->_createEntryObject($entry);
			}
			catch (Reader_Exception $e) {
				$this->_errors[] = $e->getMessage();
			}
		}
	}

	protected function _createEntryObject(SimpleXMLElement $entry) {
		$name = ucfirst($entry->getName());
		$class = 'Reader_Tag_'.$name;
		if (!class_exists($class)) {
			throw new Reader_Exception('Class '.$class.' not exists. Cannot handle "'.$name.'" entry.');
		}
		return new $class($entry);
	}

	/**
	 * @return array
	 */
	public function getData() {
		return $this->_data;
	}

	/**
	 * Błędy napotkane podczas parsowania xml-a oraz sprawdzania poszczególnych wpisów
	 * @return array
	 */
	public function getErrors() {
		return $this->_errors;
	}
}
