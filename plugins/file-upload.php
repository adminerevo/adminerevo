<?php
//! delete

/** Edit fields ending with "_path" by <input type="file"> and link to the uploaded files from select
* @link https://www.adminer.org/plugins/#use
* @author Jakub Vrana, https://www.vrana.cz/
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerFileUpload {
	/** @access protected */
	var $uploadPath, $displayPath, $extensions;

	/**
	* @param string prefix for uploading data (create writable subdirectory for each table containing uploadable fields)
	* @param string prefix for displaying data, null stands for $uploadPath
	* @param string regular expression with allowed file extensions
	*/
	function __construct($uploadPath = "../static/data/", $displayPath = null, $extensions = "[a-zA-Z0-9]+") {
		$this->uploadPath = $uploadPath;
		$this->displayPath = ($displayPath !== null ? $displayPath : $uploadPath);
		$this->extensions = $extensions;
	}

	function editInput($table, $field, $attrs, $value) {
		if (preg_match('~(.*)_path$~', $field["field"])) {
			return "<input type='file'$attrs>";
		}
	}

	function processInput($field, $value, $function = "") {
		if (preg_match('~(.*)_path$~', $field["field"], $regs)) {
			$table = ($_GET["edit"] != "" ? $_GET["edit"] : $_GET["select"]);
			$name = "fields-$field[field]";
			if ($_FILES["fields"]["error"][$field["field"]] || !preg_match("~(\\.($this->extensions))?\$~", $_FILES["fields"]["name"][$field["field"]], $regs2)) {
				return false;
			}
			// create sub-directory if needed
			if (file_exists(__DIR__ . '/' . $this->uploadPath . '/' . $table) === false) {
				mkdir(__DIR__ . '/' . $this->uploadPath . '/' . $table);
			}
			// generate filename
			$filename = realpath(tempnam(__DIR__ . '/' . $this->uploadPath . '/' . $table, '.htfile'));
			
			// prevent the final to be anywhere else then under the upload directory
			if (strpos($filename, realpath(__DIR__ . '/' . $this->uploadPath)) !== 0) {
				return false;
			}
			// move file to its final location
			if (!move_uploaded_file($_FILES["fields"]["tmp_name"][$field["field"]], $filename)) {
				return false;
			}
			return q($filename);
		}
	}

	function selectVal($val, &$link, $field, $original) {
		if ($val != "" && preg_match('~(.*)_path$~', $field["field"], $regs)) {
			$link = "$this->displayPath$_GET[select]/$regs[1]-$val";
		}
	}

}
