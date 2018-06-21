<?php

/**
* Find out the plugins which are activated in the site (multisite include)
*
* @return array $activated_plugins
*/
function get_activated_plugins() {
	$plugin_blog = get_option('active_plugins');
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$plugins = get_plugins();
	$wordpress_version = get_bloginfo('version');
	$activated_plugins = array(
		'core' => $wordpress_version,
		'plugins' => array(),
	);


	foreach ( $plugin_blog as $plugin ) {           
	    if( isset( $plugins[$plugin] ) ) {
         	$activated_plugins['plugins'][] = array(
         		'Id' => $plugin,
         		'Name' => $plugins[$plugin]['Name'],
         		'Version' => $plugins[$plugin]['Version'],
         	);
	    }           
	}
	if ( is_multisite() ) { 
		$plugin_network = get_site_option('active_sitewide_plugins');
		foreach ( $plugin_network as $nom => $id ){           
		    if( isset( $plugins[$nom] ) ){
	        	$activated_plugins['plugins'][] = array(
	        		'Id' => $nom,
	         		'Name' => $plugins[$nom]['Name'],
	         		'Version' => $plugins[$nom]['Version'],
	         	);
		    }           
		}
	}

	return $activated_plugins;
}