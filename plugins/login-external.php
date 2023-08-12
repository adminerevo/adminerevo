<?php

/**
 * Enables use of saved credentials for accessing a database, without divulging
 * them. Provides a mechanism to authenticate each request against any login
 * system external to Adminer, or to bypass authentication (for local
 * development on a private machine).
 *
 * @author Roy Orbitson, https://github.com/Roy-Orbison
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */

class AdminerLoginExternal {

	protected $externals;

	/**
	 * Provide access details of your database, the current user's authentication status, and other config.
	 *
	 * @param array|object $externals An enumeration containing the fields normally completed on the login form:
	 *                                server
	 *                                database (optional, but recommended. user can always access any db the credentials allow)
	 *                                username
	 *                                password
	 *                                driver (defaults to 'server' for MySQL, but must be specified otherwise,
	 *                                        e.g. 'pgsql', 'sqlite')
	 *
	 *                                Plus fields to control the behaviour of this plugin:
	 *                                authenticated (required boolean, ideally checked on *every* request, true if the
	 *                                               user is known, currently authenticated, and has db privileges
	 *                                               equivalent to the specified username)
	 *                                app_name (dynamically change the name of the tool from Adminer/AdminerEvo)
	 *                                manual_login (optional boolean to control auto-submission of Adminer's own login
	 *                                              form, and prevents logging out whilst authenticated)
	 *                                expired_html (optional HTML message to show when user's external authentication
	 *                                              expires whilst logged in to Adminer)
	 *                                failure_html (optional HTML message to show user they are not authenticated, e.g. a
	 *                                              paragraph containing a link to the login page)
	 */
	function __construct($externals) {
		$externals = (object) $externals;
		if (empty($externals->driver)) {
			$externals->driver = 'server';
		}
		if (isset($_POST['auth'])) {
			$_POST['auth']['driver'] = $externals->driver;
			$_POST['auth']['server'] = $_POST['auth']['username'] = $_POST['auth']['password'] = '';
		}
		$this->externals = $externals;
	}

	function name() {
		return empty($this->externals->app_name) ? null : $this->externals->app_name;
	}

	function credentials() {
		if (empty($this->externals->authenticated)) {
			# always check external stat rather than relying on adminer's session login
			auth_error(
				empty($this->externals->expired_html) ?
					'External authentication expired.' :
					$this->externals->expired_html
			);
			return false;
		}
		return [
			$this->externals->server,
			$this->externals->username,
			$this->externals->password,
		];
	}

	function database() {
		return empty($this->externals->database) ? null : $this->externals->database;
	}

	function loginForm() {
		if (empty($this->externals->authenticated)) {
			if (empty($this->externals->failure_html)) {
				echo '<p>You must first log in to the system that grants access to this tool.</p>';
			}
			else {
				echo $this->externals->failure_html;
			}
			return false;
		}

		if (empty($this->externals->manual_login)) {
			echo script(
				<<<EOJS
document.addEventListener(
	'DOMContentLoaded',
	function() {
		document.forms[0].submit();
	},
	true
);
EOJS
			);
		}
	}

	function loginFormField($name, $heading) {
		# only for user's benefit, submitted values are overridden by config
		$value = '';
		switch ($name) {
			case 'db':
				$value = h(isset($_GET['username']) ? (isset($_GET['db']) ? $_GET['db'] : '') : $this->database());
				return <<<EOHTML
$heading<input type="text" name="auth[$name]" value="$value">

EOHTML;
			case 'driver':
				if (function_exists('get_driver')) {
					$value = h($this->externals->driver);
					$driver = h(get_driver($this->externals->driver)) ?: 'Unknown';
					return <<<EOHTML
$heading<input type="hidden" name="auth[$name]" value="$value">$driver

EOHTML;
				}
				$value = ' value="' . h($this->externals->driver) . '"';
				# don't break
			case 'server':
			case 'username':
			case 'password':
				return <<<EOHTML
<input type="hidden" name="auth[$name]"$value>

EOHTML;
		}
	}

	function login($login, $password) {
		return !empty($this->externals->authenticated);
	}
}
