<?php

/**
 * Import SQL files from a directory
 *
 * @author joshcangit, https://github.com/joshcangit
 * @author Roy-Orbitson, https://github.com/Roy-Orbison
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */

class AdminerImportFromDir {

	protected $dir;

	/**
	 * @param string $dir optional directory to read from, other than Adminer's current working dir.
	 */
	function __construct($dir = '') {
		$dir = (string) $dir;
		if ($dir != '') {
			$dir = rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
		}
		$this->dir = $dir;
	}

	protected function _readFiles($gz = false) {
		$mapped = array();
		$glob = "$this->dir*.[Ss][Qq][Ll]";
		if ($gz) {
			$suffix = '.gz'; # lowercase only because of core
			$glob .= $suffix;
			$suffix_cut = -3;
		}
		if ($files = glob($glob)) {
			$from = strlen($this->dir);
			foreach ($files as $file) {
				if ($from) {
					$file = substr($file, $from); # do not expose server paths in output
				}
				if ($gz) {
					$mapped[substr($file, 0, $suffix_cut)] = $file;
				}
				else {
					$mapped[$file] = $file;
				}
			}
		}
		return $mapped;
	}

	function importServerPath() {
		static $posted = null;

		$files = $this->_readFiles();
		if (extension_loaded('zlib')) {
			$files += $this->_readFiles(true); # core prioritises files without .gz
		}
		if (count($files) > 1) {
			ksort($files);
		}

		if ($posted !== null || !isset($_POST['webfile'])) {
			# use existing translation strings
			echo "<fieldset><legend>" . lang('From server') . "</legend><div>";
			echo lang('Webserver file %s', '<select name="webfilename">' . optionlist(array('' => lang('Select')) + $files, $posted, true) . '</select>');
			echo ' <input type="submit" name="webfile" value="' . lang('Run file') . '">';
			echo "</div></fieldset>\n";
			$posted = null;
			return false; # skip core UI
		}

		if (
			empty($_POST['webfilename'])
			|| !is_string($_POST['webfilename'])
			|| !array_key_exists($_POST['webfilename'], $files)
		) {
			$posted = '';
			return 'SELECTED_FILE_DOES_NOT_EXIST'; # can't return empty string because of core file_exists() check
		}

		$posted = $_POST['webfilename'];
		return $this->dir . $posted;
	}
}
