<?php
/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at https://mozilla.org/MPL/2.0/. */

register_module([
	"name" => "Debug Information",
	"version" => "0.4",
	"author" => "Starbeamrainbowlabs",
	"description" => "Adds a debug action for administrator use only that collects a load of useful information to make reporting bugs easier.",
	"id" => "page-debug-info",
	"code" => function() {
		global $settings, $env;
		/**
		 * @api {get} ?action=debug	Get a debug dump
		 * @apiName Debug
		 * @apiGroup Utility
		 * @apiPermission Moderator
		 *
		 * @apiUse UserNotModeratorError
		 *
		 * @apiParam {string}	secret	Optional. If you're not logged in as a moderator or better, then specifying the secret works as a substitute.
		 */
		
		/*
		 * ██████  ███████ ██████  ██    ██  ██████  
		 * ██   ██ ██      ██   ██ ██    ██ ██       
		 * ██   ██ █████   ██████  ██    ██ ██   ███ 
		 * ██   ██ ██      ██   ██ ██    ██ ██    ██ 
		 * ██████  ███████ ██████   ██████   ██████
		*/
		add_action("debug", function() {
			global $settings, $env, $paths, $version, $commit;
			header("content-type: text/plain");
			
			if(!$env->is_admin && (!isset($_GET["secret"]) && $_GET["secret"] !== $settings->secret)) {
				exit("You must be logged in as an moderator in order to generate debugging information.");
			}
			
			$title = "$settings->sitename debug report";
			echo("$title\n");
			echo(str_repeat("=", strlen($title)) . "\n");
			echo("Powered by Pepperminty Wiki version $version+" . substr($commit, 0, 7) . ".\n");
			echo("This report may contain personal information.\n\n");
			echo("Environment: ");
			echo(debug_mask_secrets(var_export($env, true)));
			echo("\nPaths: ");
			echo(var_export($paths, true));
			echo("\nServer information:\n");
			echo("uname -a: " . php_uname() . "\n");
			echo("Path: " . getenv("PATH") . "\n");
			echo("Temporary directory: " . sys_get_temp_dir() . "\n");
			echo("Server: " . $_SERVER["SERVER_SOFTWARE"] . "\n");
			echo("Web root: " . $_SERVER["DOCUMENT_ROOT"] . "\n");
			echo("Web server user: " . exec("whoami") . "\n");
			echo("PHP version: " . phpversion() . "\n");
			echo("index.php location: " . __FILE__ . "\n");
			echo("index.php file permissions: " . substr(sprintf('%o', fileperms("./index.php")), -4) . "\n");
			echo("Current folder permissions: " . substr(sprintf('%o', fileperms(".")), -4) . "\n");
			echo("Storage directory permissions: " . substr(sprintf('%o', fileperms($env->storage_prefix)), -4) . "\n");
			echo("Loaded extensions: " . implode(", ", get_loaded_extensions()) . "\n");
			echo("Settings:\n-----\n");
			echo(debug_mask_secrets(var_export($settings, true)));
			echo("\n-----\n");
			exit();
		});
		
		if($env->is_admin) {
			add_help_section("950-debug-information", "Gathering debug information", "<p>As a moderator, $settings->sitename gives you the ability to generate a report on $settings->sitename's installation of Pepperminty Wiki for debugging purposes.</p>
			<p>To generate such a report, visit the <code>debug</code> action or <a href='?action=debug'>click here</a>.</p>");
		}
	}
]);

/**
 * Masks secrets in debug output.
 * @param  string $text The text to mask.
 * @return string       The masked text.
 */
function debug_mask_secrets($text) {
	$lines = explode("\n", $text);
	foreach ($lines as &$line) {
		if(preg_match("/'(secret|sitesecret|email(?:Address)?|password)'/i", $line)) $line = "********* secret *********"; 
	}
	
	return implode("\n", $lines);
}

?>
