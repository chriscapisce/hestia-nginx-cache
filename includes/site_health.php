<?php

/**
 * Hestia Nginx Cache
 *
 * @package           Hestia_Nginx_Cache
 * @author            Jakob Bouchard
 * @license           GPL-3.0+
 *
 * Class Hestia_Nginx_Cache_Site_Health adds the plugin status and information to the WP Site Health admin page.
 *
 * @since 2.1.0
 */

if (!defined('ABSPATH')) {
	exit();
}

class Hestia_Nginx_Cache_Site_Health
{

	private $plugin = null;

	public function __construct()
	{
		$this->plugin = Hestia_Nginx_Cache::get_instance();

		add_filter('debug_information', array($this, 'register_debug_information'));
	}

	/**
	 * Register plugin WP Site Health debug information.
	 * This will be displayed in the "Info" tab of the WP Site Health page.
	 *
	 * @since 1.9.0
	 *
	 * @param array $debug_info Array of existing debug information.
	 *
	 * @return array
	 */
	public function register_debug_information($debug_info)
	{
		$options = get_option($this->plugin::NAME);

		$debug_info[$this->plugin::NAME] = [
			'label'  => esc_html__('Hestia Nginx Cache', 'hestia-nginx-cache'),
			'fields' => [
				'version' => [
					'label' => esc_html__('Version', 'hestia-nginx-cache'),
					'value' => $this->plugin::VERSION,
				],
				'configured' => [
					'label' => esc_html__('Configured', 'hestia-nginx-cache'),
					'value' => 'The plugin has ' . ($this->plugin::$is_configured ? '' : 'not') . ' been configured',
				],
			],
		];

		if ($this->plugin::$is_configured) {
			$debug_info[$this->plugin::NAME]['fields']['host'] = [
				'label' => esc_html__('Server hostname', 'hestia-nginx-cache'),
				'value' => $options['host']
			];
			$debug_info[$this->plugin::NAME]['fields']['port'] = [
				'label' => esc_html__('Server port', 'hestia-nginx-cache'),
				'value' => $options['port']
			];
		}
		return $debug_info;
	}
}
