<?php

/**
 * Orbital Configuration File
 *
 * Configuration for this Orbital Manager instance.
 *
 * PHP Version 5
 *
 * @category   Configuration
 * @package    Orbital
 * @subpackage Manager
 * @licence    https://www.gnu.org/licenses/agpl-3.0.html  GNU Affero General Public License
 * @author     Nick Jackson <nijackson@lincoln.ac.uk>
 * @link       https://github.com/lncd/Orbital-Manager
*/

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Orbital Manager Name
 *
 * A name for this instance of Orbital Manager. Useful if your institution
 * wants to call it by something else.
*/

$config['orbital_manager_name'] = $_SERVER['ORBITAL_MANAGER_NAME'];

/**
 * Core Location
 *
 * The location of the Orbital Core instance this Manager should use.
*/

$config['orbital_core_location'] = $_SERVER['ORBITAL_CORE_LOCATION'];

/**
 * Application ID
 *
 * ID of this application in Orbital Core
*/

$config['orbital_app_id'] = $_SERVER['ORBITAL_APP_ID'];

/**
 * Application Secret
 *
 * Secret of this application in Orbital Core
*/

$config['orbital_app_secret'] = $_SERVER['ORBITAL_APP_SECRET'];;

/**
 * Orbital Manager Version
 *
 * The version of this instance of Orbital Manager.
*/

$config['orbital_manager_version'] = '0.2.2.1';

// End of file orbital.php
// Location: ./config/orbital.php