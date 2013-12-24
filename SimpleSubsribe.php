<?php
/*
    Plugin Name: Simple Subscribe
    Description: The easiest to use subscribe plugin, just for you :)
    Author: latorante
    Author URI: http://latorante.name
    Author Email: martin@latorante.name
    Version: 1.2.3.1
    License: GPLv2
*/
/*
    Copyright 2013  Martin Picha  (email : martin@latorante.name)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * 1. If no Wordpress, go home
 */

if (!defined('ABSPATH')) { exit; }

/**
 * 2. Check minimum requirements (wp version, php version)
 * Reason behind this is, we just need PHP 5.3.1 at least,
 * and wordpress 3.3 or higher. We just can't run the show
 * on some outdated installation.
 */

require_once('SimpleSubscribeCheck.php');
SimpleSubscribeCheck::checkRequirements();

/**
 * 3. Activation / deactivation
 */

register_activation_hook(__FILE__,      array('SimpleSubscribe', 'activate'));
register_deactivation_hook( __FILE__,   array('SimpleSubscribe', 'deactivate'));

/**
 * 4. Go, and do Simple Subscribe!
 */

require_once('SimpleSubscribeInit.php');