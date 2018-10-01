<?php

class TeamDevFloatCart {


    /**
	 * The single instance of the class
	 *
	 * @var TeamDevFloatCart
	 */
	protected static $instance = null;

	/**
	 * Main instance
	 *
	 * @return TeamDevFloatCart
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
    }
    
    public function enqueue_script() {
        
	}
	
	public function tdf_show_cart() {

		$items = WC()->cart->get_cart();
		
	}

	/*
		Cart Items
	*/
	public function tdf_get_cart_items() {

	}
	
}