<?php
/** Use filter in tables list
 * @link https://www.adminer.org/plugins/#use
 * @author Jakub Vrana, https://www.vrana.cz/
 * @edit Andrea Mariani, https://www.fasys.it (2024-06-26)
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */

class AdminerTablesFilter {
    function tablesPrint($tables) { ?>
        <p style="display: table; padding-left: 10px; border-bottom: none;">
            <input type="search" id="filter-field" autocomplete="off" placeholder="Ctrl + Shift + F"  style="display: table-cell;" />
            <a href=""; id="filter-field-reset" style="pointer: cursor; width:30px; display: table-cell; background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAIhSURBVDjLlZPrThNRFIWJicmJz6BWiYbIkYDEG0JbBiitDQgm0PuFXqSAtKXtpE2hNuoPTXwSnwtExd6w0pl2OtPlrphKLSXhx07OZM769qy19wwAGLhM1ddC184+d18QMzoq3lfsD3LZ7Y3XbE5DL6Atzuyilc5Ciyd7IHVfgNcDYTQ2tvDr5crn6uLSvX+Av2Lk36FFpSVENDe3OxDZu8apO5rROJDLo30+Nlvj5RnTlVNAKs1aCVFr7b4BPn6Cls21AWgEQlz2+Dl1h7IdA+i97A/geP65WhbmrnZZ0GIJpr6OqZqYAd5/gJpKox4Mg7pD2YoC2b0/54rJQuJZdm6Izcgma4TW1WZ0h+y8BfbyJMwBmSxkjw+VObNanp5h/adwGhaTXF4NWbLj9gEONyCmUZmd10pGgf1/vwcgOT3tUQE0DdicwIod2EmSbwsKE1P8QoDkcHPJ5YESjgBJkYQpIEZ2KEB51Y6y3ojvY+P8XEDN7uKS0w0ltA7QGCWHCxSWWpwyaCeLy0BkA7UXyyg8fIzDoWHeBaDN4tQdSvAVdU1Aok+nsNTipIEVnkywo/FHatVkBoIhnFisOBoZxcGtQd4B0GYJNZsDSiAEadUBCkstPtN3Avs2Msa+Dt9XfxoFSNYF/Bh9gP0bOqHLAm2WUF1YQskwrVFYPWkf3h1iXwbvqGfFPSGW9Eah8HSS9fuZDnS32f71m8KFY7xs/QZyu6TH2+2+FAAAAABJRU5ErkJggg==') no-repeat scroll 5px center;"></a>
        </p>

        <script<?php echo nonce(); ?>>
            (function() {

                let timeout;
                let lastValue = '';
                const filterField = qs('#filter-field');

                function filter() {
                    let reg;
                    timeout && (timeout = null);
                    const value = filterField.value.toLowerCase();
                    if (value == lastValue) {
                        return;
                    }
                    lastValue = value;
                    if (value != '') {
                        reg = (value + '').replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                        reg = new RegExp('('+ reg + ')', 'gi');
                    }
                    if (window.sessionStorage) {
                        sessionStorage.setItem('adminer_tables_filter', value);
                    }
                    const tables = qsa('li', qs('#tables'));
                    let a;
                    let text;
                    for (let i = 0; i < tables.length; i++) {
                        text = tables[i].getAttribute('data-table-name');
                        if (text == null) {
                            a = qsa('a', tables[i])[1];
                            text = a.innerHTML.trim();

                            tables[i].setAttribute('data-table-name', text);
                            a.setAttribute('data-link', 'main');
                        }
                        else {
                            a = qs('a[data-link="main"]', tables[i]);
                        }
                        if (value == '') {
                            tables[i].className = '';
                            a.innerHTML = text;
                        }
                        else {
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
                        && (!document.activeElement || document.activeElement != filterField)
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
                    let db = qs('#dbs select');
                    let value;
                    db = db.options[db.selectedIndex].text;
                    if (db == sessionStorage.getItem('adminer_tables_filter_db') && (value = sessionStorage.getItem('adminer_tables_filter'))) {
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

