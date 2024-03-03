<div class="grid-left" markdown>
![image](assets/logo.svg){.index-logo}
</div>

<div class="grid-right" markdown>
<p>
<b>AdminerEvo</b> is a web-based database management interface, with a focus on
security, user experience, performance, functionality and size.
</p>

<p>
It is available for download as a single self-contained PHP file, making it easy
to deploy anywhere.
</p>

[Download](https://download.adminerevo.org){ .md-button .md-button--primary target=\_blank }
[View Source](https://github.com/adminerevo/adminerevo){ .md-button .md-button--secondary target=\_blank }
</div>

<div class="clear"></div>

AdminerEvo works out of the box with MySQL, MariaDB, PostgreSQL, SQLite, MS SQL,
Oracle, Elasticsearch and MongoDB. In addition, there are plugins for
[SimpleDB](https://github.com/adminerevo/adminerevo/blob/main/plugins/drivers/simpledb.php),
[Firebird](https://github.com/adminerevo/adminerevo/blob/main/plugins/drivers/firebird.php) and
[ClickHouse](https://github.com/adminerevo/adminerevo/blob/main/plugins/drivers/clickhouse.php).

AdminerEvo is developed by the AdminerEvo community and is a continuation of
the [Adminer](https://www.adminer.org/) project by
[Jakub Vrána](https://www.vrana.cz/).

## Rationale

Existing database management interfaces often come in the form of desktop
clients, or as large web applications. They often only support a single DBMS.

Adminer aims to offer a familiar interface in a lightweight package, no matter
the environment. The only requirement is a webserver configured to run a current
version of [PHP](https://php.net/).

## Plugins

AdminerEvo and AdminerEvo Editor can be extended by plugins. [To use a plugin](#to-use-a-plugin)

| Name / link | Description |
| --- | --- |
| [plugin](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/plugin.php) | Required to run any plugin |
| [database-hide](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/database-hide.php) | Hide some databases from the interface - just to improve design, not a security plugin |
| [designs](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/designs.php) | Allow switching designs |
| [dump-alter](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/dump-alter.php) | Exports one database (e.g. `development`) so that it can be synced with other database (e.g. `production`) |
| [dump-bz2](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/dump-bz2.php) | Dump to Bzip2 format |
| [dump-date](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/dump-date.php) | Include current date and time in export filename |
| [dump-json](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/dump-json.php) | Dump to JSON format |
| [dump-xml](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/dump-xml.php) | Dump to XML format in structure `<database name="><table name="><column name=">` value |
| [dump-zip](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/dump-zip.php) | Dump to ZIP format |
| [edit-calendar](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/edit-calendar.php) | Display [jQuery UI](http://jqueryui.com/) [Timepicker](http://trentrichardson.com/examples/timepicker/) for each date and datetime field |
| [edit-foreign](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/edit-foreign.php) | Select foreign key in edit form |
| [edit-textarea](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/edit-textarea.php) | Use `<textarea>` for `char` and `varchar` |
| [enum-option](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/enum-option.php) | Use `<select><option>` for `enum` edit instead of `<input type="radio">` |
| [enum-types](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/enum-types.php) | Use `<select><option>` for `enum` edit instead of regular input text on enum type in PostgreSQL |
| [file-upload](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/file-upload.php) | Edit fields ending with _path by `<input type="file">` and link to the uploaded files from select |
| [foreign-system](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/foreign-system.php) | Link system tables (in `mysql` and `information_schema` databases) by foreign keys |
| [frames](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/frames.php) | Allow using Adminer inside a frame |
| [json-column](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/json-column.php) | Display JSON values as table in edit |
| [login-otp](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/login-otp.php) | Require One Time Password at login |
| [login-servers](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/login-servers.php) | Display constant list of servers in login form |
| [login-password-less](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/login-password-less.php) | Enable login without password ([example](https://github.com/adminerevo/adminerevo/blob/main/adminer/sqlite.php)) |
| [login-ssl](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/login-ssl.php) | Connect to MySQL using SSL |
| [login-table](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/login-table.php) | Authenticate a user from the login table |
| [master-slave](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/master-slave.php) | Execute writes on master and reads on slave |
| [pretty-json-column](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/pretty-json-column.php) | Pretty print JSON values in edit |
| [slugify](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/slugify.php) | Prefill field containing `_slug` with slugified value of a previous field (JavaScript) |
| [sql-log](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/sql-log.php) | Log all queries to SQL file |
| [struct-comments](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/struct-comments.php) | Show comments of sql structure in more places (mainly where you edit things) |
| [tables-filter](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/tables-filter.php) | Filter names in tables list |
| [tinymce](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/tinymce.php) | Edit all fields containing `_html` by HTML editor [TinyMCE](http://tinymce.moxiecode.com/) and display the HTML in select |
| [translation](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/translation.php) | Translate all table and field comments, enum and set values from the translation table (automatically inserts new translations) |
| [version-noverify](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/version-noverify.php) | Disable version checker |
| [wymeditor](https://raw.githubusercontent.com/adminerevo/adminerevo/master/plugins/wymeditor.php) | Edit all fields containing `_html` by HTML editor [WYMeditor](http://www.wymeditor.org/) and display the HTML in select |

### User contributed plugins

| Name / link | Author | Description |
| --- | --- | --- |
| [allowed-prefixes](https://github.com/LinkedList/Adminer-Allowed-Prefixes) | Martin Macko | Show only tables with user set prefixes |
| [checkbox-select](https://bitbucket.org/beholder/adminer-checkboxselect/src) | Alexander Shabunevich | Check multiple checkboxes at once by Shift+click. |
| [colorfields](https://github.com/smuuf/adminer-colorfields) | Prema van Smuuf |  |
| [convention-foreign-keys](https://gist.github.com/raw/821510/convention-foreign-keys.php) | Ivan Nečas | Links for foreign keys by convention `user_id => users.id` |
| [convention-foreign-keys](https://raw.github.com/Michal-Mikolas/Adminer-Editor-package/master/plugins/ConventionsForeignKeys.php) | Michal Mikoláš | Links for foreign keys by convention `user_id => users.id` |
| [AdminerCopy](https://github.com/adilyildiz/AdminerCopy) | Adil Yildiz |  |
| [Camera Upload](https://github.com/margenn/adminer-camera-upload-plugin) | Marcelo Gennari |  |
| [cellformula](https://gist.github.com/redfish-d86e/bd6e1bb86424bec46c1289a997cfe972) | Tommy Tan |  |
| [CustomizeThemeBasedOnServer](https://github.com/mmokross/AdminerCustomizeThemeBasedOnServer) | Michael Mokroß |  |
| [Disable tables](https://github.com/icyz/adminer/blob/master/plugins/disable-tables.php) | Andrea Mariani |  |
| [DisplayForeignKeyName](https://gist.github.com/anonymous/13b657087cf55323150c#file-display-foreign-key-name-php) | Bruno Vibert |  |
| [DumpMarkdownDict](https://github.com/sc419/AdminerDumpMarkdownDict) |  |  |
| [dump-markdown](https://github.com/fthiella/adminer-plugin-dump-markdown) | Federico Thiella |  |
| [dump-xml-dataset](https://github.com/Gobie/adminer-plugins) | Michal Brašna | Dump to XML format specifically PHPUnit's XML DataSet structure |
| [FasterTablesFilter](https://github.com/LinkedList/FasterTablesFilter) | Martin Macko |  |
| [favorites tables](https://openuserjs.org/scripts/knedle/Adminer_-_favorites_tables) | Ladislav Ševcůj |  |
| [FillLoginForm](https://github.com/arxeiss/Adminer-FillLoginForm) | Pavel Kutáč |  |
| [fk-disable](https://github.com/icyz/adminer/blob/master/plugins/fk-disable.php) | Andrea Mariani |  |
| [floatThead](https://github.com/stano/adminer-floatThead) | Stano Paška | Floating table header plugin |
| [folder-import](https://gist.github.com/joshcangit/ad28f82baf1c9c2fab22dd9e8f39f799) | Joshua |  |
| [ForeignKeys](https://github.com/mhucik/AdminerForeignKeysPlugin) | Marek Hučík |  |
| [hidePgSchemas](https://github.com/raitocz/hidePgSchemas) | Martin Jagr | Hide schemas with `pg_` prefix |
| [HideTables](https://github.com/arxeiss/Adminer-HideTables) | Pavel Kutáč |  |
| [HideableColumns](https://github.com/derStephan/AdminerPlugins/blob/master/hideableColumns.php) | Stephan |  |
| [input-uuid-generator](https://github.com/arxeiss/adminer-input-uuid-generator) | Pavel Kutáč |  |
| [ispconfig](https://github.com/natanfelles/adminer-ispconfig) | Natan Felles | Authenticate and auto-check host by ISPConfig Remote API |
| [JsonVarDumper](https://gist.github.com/marcbln/22dd713966cbda67af2e6bfc465a5c46) | Marc Christenfeldt |  |
| [login-servers-enhanced](https://github.com/crazy-max/login-servers-enhanced) | CrazyMax | Fork of the official login-servers Adminer plugin with enhancements |
| [nette-user-login](https://gist.github.com/3423745) | Mikuláš Dítě |  |
| [one-click-login](https://github.com/giofreitas/one-click-login) | Sérgio Freitas |  |
| [PHP Export](https://github.com/gremki/AdminerPHPExport) | Adrian Andreescu |  |
| [PHP Serialized Data](https://gist.github.com/donwilson/0bc0ec7c3701fb20747777a1a7b4cab4) | Don Wilson |  |
| [readable-dates](https://gist.github.com/scr4bble/9ee4a9f1405ffc1465f59e03768e2768) | Dora Bulkins | Replaces UNIX timestamps with human-readable dates in your local format |
| [resize](https://github.com/TiagoGilMarques/adminer.resize) | Tiago Gil Marques | Left column (tables) resizer (allow you to resize left table column) |
| [restore-menu-scroll](https://gist.github.com/NoxArt/8085521) | Jiří Petruželka | Remembers and restores scollbar position of side menu |
| [SchemaDefaultToPublic](https://github.com/MartinZubek/adminer-schema-default-to-public) | Martin Zubek |  |
| [SearchAutocomplete](https://github.com/derStephan/AdminerPlugins/blob/master/searchAutocomplete.php) | Stephan |  |
| [SQLite3 without password](https://github.com/FrancoisCapon/LoginToASqlite3DatabaseWithoutCredentialsWithAdminer) | François Capon |  |
| [StickyColumns](https://github.com/derStephan/AdminerPlugins/blob/master/stickyColumns.php) | Stephan |  |
| [suggest-tablefields](https://github.com/icyz/adminer/blob/master/plugins/suggest-tablefields.php) | Andrea Mariani |  |
| [table-filter](https://github.com/zhgabor/adminer-table-filter) | Gábor Zabojszky-Horvath | Quickly filtering tables, works only with custom themes where table list is floated |
| [table-header-scroll](https://github.com/jnvsor/adminer-table-header-scroll/) | Jonathan Vollebregt | Makes the table header scroll with the viewport |
| [tablesCollapse](https://github.com/TiagoGilMarques/adminer.tablesCollapse) | Tiago Gil Marques | Left column tables collapse (allows you to collapse tables, and translations tables with some sufix patterns, like phpmyadmin) |
| [tables_fuzzy_search](https://github.com/brunetton/adminer-tables_fuzzy_search) | Bruno Duyé | Fuzzy search (filter) in tables list |
| [tables-history](https://gist.github.com/aoloe/303f314aec36851d4c88) | Ale Rimoldi |  |
| [tree-view](https://github.com/PetroKostyuk/adminer-tree-view) | Petro Kostyuk |  |
| [login-serversjson-previewsimple-menucollations](https://github.com/pematon/adminer-plugins) | Pematon |  |
| [Adminer Bootstrap-Like Design](https://github.com/natanfelles/adminer-bootstrap-like) | Natan Felles |  |
| [Theme for Adminer](https://github.com/pematon/adminer-theme) | Pematon | Responsive touch-friendly theme |
| [Theme Switcher](https://github.com/felladrin/adminer-theme-switcher) | Victor Nogueira |  |

### To use a plugin

Create a PHP file specifying which plugins do you want to use:
```php
<?php
function adminer_object() {
    // required to run any plugin
    include_once "./plugins/plugin.php";
    
    // autoloader
    foreach (glob("plugins/*.php") as $filename) {
        include_once "./$filename";
    }
    
    // enable extra drivers just by including them
    //~ include "./plugins/drivers/simpledb.php";
    
    $plugins = array(
        // specify enabled plugins here
        new AdminerDumpXml(),
        new AdminerTinymce(),
        new AdminerFileUpload("data/"),
        new AdminerSlugify(),
        new AdminerTranslation(),
        new AdminerForeignSystem(),
    );
    
    /* It is possible to combine customization and plugins:
    class AdminerCustomization extends AdminerPlugin {
    }
    return new AdminerCustomization($plugins);
    */
    
    return new AdminerPlugin($plugins);
}

// include original Adminer or Adminer Editor
include "./adminer.php";
```

## History

The project was started by Jakub Vrána as phpMinAdmin, with the aim of providing
a light-weight alternative to phpMyAdmin. A 1.0.0 version was released on the
11th of July 2007.

Nearly two years later, Jakub renamed the project to Adminer, as its former name
started as somewhat of a joke and caused confusion with the phpMyAdmin project.

Around the same time, Jakub had an article published in the _php|architect_
August 2009 edition, which he made available on his
[blog](https://php.vrana.cz/architecture-of-adminer.php)
([archive](https://archive.is/XjTDx)). The article goes into detail about his
ideas for Adminer and how it was designed. Some of this is still relevant today.

A major announcement came the following year, with the release of 3.0.0. This
release introduced support for multiple database drivers and already included
SQLite, PostgreSQL, MS SQL and Oracle.

In 2016 the project's source code was moved from its home on
[SourceForge](https://sourceforge.net/p/adminer/) to
[GitHub](https://github.com/vrana/adminer/). Bug reports and user forums,
however, remained where they were.

Finally, in May of 2023, after a long period without released and with user
contributions piling up without being merged, a group of individuals decided to
join forces and revive the project as AdminerEvo.

## Support

The community is available at
[GitHub Discussions](https://github.com/adminerevo/adminerevo/discussions) where
we discuss ideas and issues.

If you would like to report a bug, please look through the open
[issues](https://github.com/adminerevo/adminerevo/issues) or create a new one.

### Contributions

We welcome [pull requests](https://github.com/adminerevo/adminerevo/pulls),
however we suggest discussing your idea first via the
[discussion board](https://github.com/adminerevo/adminerevo/discussions).

