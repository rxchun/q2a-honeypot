<?php

/*
	Plugin Name: Q2A Honeypot
	Plugin Author: Chun
*/

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}

qa_register_plugin_layer('qa-honeypot.php', 'honeypot');