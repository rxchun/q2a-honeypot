<?php

/*
	Plugin Name: Q2A Honeypot
	Plugin URI: https://github.com/heliochun/honeypot
	Plugin Update Check URI: https://raw.githubusercontent.com/heliochun/q2a-honeypot/master/qa-plugin.php
	Plugin Description: Creates a honeypot for Spam Bots, preventing them from auto-filling and continuing user registration.
	Plugin Version: 1.11
	Plugin Update: 2023-01-06
	Plugin Date: 2022-11-14
	Plugin Author: Chun
	Plugin Author URI: https://github.com/heliochun
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.8.6
*/

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}

qa_register_plugin_layer('qa-honeypot.php', 'honeypot');