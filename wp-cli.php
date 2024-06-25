<?php

if (!defined('ABSPATH')) {
		die();
}

if (!defined('WP_CLI')) return;

class WP_CLI_WP_Hestia_Nginx_Cache extends WP_CLI_Command {

	public function __construct(){
		$this -> plugin = Hestia_Nginx_Cache::get_instance();
	}

	public function purge(){
		$result = $this -> plugin -> purge(true);
		if ($result) {
			$exit_code = wp_remote_retrieve_header($result, 'Hestia-Exit-Code');
		}
		if($exit_code == 0){
			WP_CLI::success('Cache purged');
		} else {
			WP_CLI::error('Cache purge failed');
		}
	}
}

WP_CLI::add_command('hestia-cache', 'WP_CLI_WP_Hestia_Nginx_Cache');
