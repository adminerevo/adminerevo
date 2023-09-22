<?php

/** Use filter in tables list
* @link https://www.adminer.org/plugins/#use
* @author Jakub Vrana, https://www.vrana.cz/
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/

class AdminerTablesFilter {
	function tablesPrint($tables) { ?>
<fieldset class="jsonly" style="margin-left: .8em;">
	<legend><?php echo lang('Filter tables'); ?></legend>
	<div>
		<input type="search" id="filter-field" autocomplete="off" placeholder="Ctrl + Shift + F">
		<input type="button" id="filter-field-reset" value="<?php echo lang('Clear'); ?>">
	</div>
</fieldset>

<script<?php echo nonce(); ?>>
(function() {

var timeout;
var lastValue = '';
var filterField = qs('#filter-field');

function filter() {
	timeout && (timeout = null);
	var value = filterField.value.toLowerCase();
	if (value == lastValue) {
		return;
	}
	lastValue = value;
	if (value != '') {
		var reg = (value + '').replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
		reg = new RegExp('('+ reg + ')', 'gi');
	}
	if (window.sessionStorage) {
		sessionStorage.setItem('adminer_tables_filter', value);
	}
	var tables = qsa('li', qs('#tables'));
	var a;
	var text;
	for (var i = 0; i < tables.length; i++) {
		text = tables[i].getAttribute('data-table-name');
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

filterField.addEventListener('input', function input() {
	timeout && window.clearTimeout(timeout);
	timeout = window.setTimeout(filter, 200);
});
document.addEventListener('keyup', function(event) {
	if (
		event.ctrlKey
		&& event.shiftKey
		&& event.key == 'F'
		&& !event.altKey
		&& !event.metaKey
		&& (
			!document.activeElement
			|| document.activeElement != filterField
		)
	) {
		filterField.focus();
	}
});
filterField.addEventListener('keydown', function(event) {
	if (event.key == 'Enter' || event.keyCode == 13 || event.which == 13) {
		event.preventDefault();
		return false;
	}
});

qs('#filter-field-reset').addEventListener('click', function() {
	filterField.value = '';
	filterField.dispatchEvent(new Event('input'));
});

window.sessionStorage && document.addEventListener('DOMContentLoaded', function restore() {
	var db = qs('#dbs select');
	var value;
	db = db.options[db.selectedIndex].text;
	if (
		db == sessionStorage.getItem('adminer_tables_filter_db')
		&& (value = sessionStorage.getItem('adminer_tables_filter'))
	) {
		filterField.value = value;
		filter();
	}
	sessionStorage.setItem('adminer_tables_filter_db', db);
});

})();
</script>
<?php
	}
}
