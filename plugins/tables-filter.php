<?php

/** Use filter in tables list
* @link https://www.adminer.org/plugins/#use
* @author Jakub Vrana, https://www.vrana.cz/
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerTablesFilter {
	function tablesPrint($tables) { ?>
<script<?php echo nonce(); ?>>
var tablesFilterTimeout = null;
var tablesFilterValue = '';

function tablesFilter(){
	var value = qs('#filter-field').value.toLowerCase();
	if (value == tablesFilterValue) {
		return;
	}
	tablesFilterValue = value;
	if (value != '') {
		var reg = (value + '').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!\<\>\|\:])/g, '\\$1');
		reg = new RegExp('('+ reg + ')', 'gi');
	}
	if (sessionStorage) {
		sessionStorage.setItem('adminer_tables_filter', value);
	}
	var tables = qsa('li', qs('#tables'));
	for (var i = 0; i < tables.length; i++) {
		var a = null;
		var text = tables[i].getAttribute('data-table-name');
		if (text == null) {
			a = qsa('a', tables[i])[1];
			text = a.innerHTML.trim();

			tables[i].setAttribute('data-table-name', text);
			a.setAttribute('data-link', 'main');
		} else {
			a = qs('a[data-link="main"]', tables[i]);
		}
		if (value == '') {
			tables[i].className = '';
			a.innerHTML = text;
		} else {
			tables[i].className = (text.toLowerCase().indexOf(value) == -1 ? 'hidden' : '');
			a.innerHTML = text.replace(reg, '<strong>$1</strong>');
		}
	}
}

function tablesFilterInput() {
	window.clearTimeout(tablesFilterTimeout);
	tablesFilterTimeout = window.setTimeout(tablesFilter, 200);
}

sessionStorage && document.addEventListener('DOMContentLoaded', function () {
	if (qs('#dbs') != null) {
		var db = qs('#dbs').querySelector('select');
		db = db.options[db.selectedIndex].text;
		if (db == sessionStorage.getItem('adminer_tables_filter_db') && sessionStorage.getItem('adminer_tables_filter')){
			qs('#filter-field').value = sessionStorage.getItem('adminer_tables_filter');
			tablesFilter();
		}
		sessionStorage.setItem('adminer_tables_filter_db', db);
	}
	document.addEventListener('keyup', function(event) {
		if (event.ctrlKey && event.shiftKey && event.key == 'F') {
			qs('#filter-field').focus();
			return;
		}
	});
	qs('#filter-field').addEventListener('keydown', function(event) {
		if (event.key == 'Enter' || event.keyCode == 13 || event.which == 13) {
			event.preventDefault();
			return false;
		}
	});
});
</script>

<fieldset style="margin-left: .8em;">
	<legend><?php echo lang('Filter tables'); ?></legend>
	<div>
		<input type="search" id="filter-field" autocomplete="off" placeholder="Ctrl + Shift + F"><?php echo script("qs('#filter-field').oninput = tablesFilterInput;"); ?>
		<input type="button" id="filter-field-reset" value="<?php echo lang('Clear'); ?>">
		<?php echo script("qs('#filter-field-reset').onclick = function() { qs('#filter-field').value = ''; qs('#filter-field').dispatchEvent(new Event('input')); }"); ?>
	</div>
</fieldset>

<?php
	}
}
