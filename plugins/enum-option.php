<?php
/** Use <input type="radio"> for enum edit instead of <select><option>
 * @link https://www.adminer.org/plugins/#use
 * @author Boden Garman
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerEnumOption {
    function editInput($table, $field, $attrs, $value) {
        if ($field["type"] == "enum") {
            return (isset($_GET["select"]) ? "<label><input type='radio'$attrs value='-1' checked><i>" . lang('original') . "</i></label> " : "")
                . enum_input("radio", $attrs, $field, ($value || isset($_GET["select"]) ? $value : 0), ($field["null"] ? "" : null))
                ;
        }
    }
}
