<?php

/**
 * Orbital Configuration File
 *
 * Configuration for this Orbital Manager instance.
 *
 * @category   Configuration
 * @package    Orbital
 * @subpackage Manager
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

$config['orbital_manager_name'] = '##ORBITAL_MANAGER_NAME##';

/**
 * Core Location
 *
 * The location of the Orbital Core instance this Manager should use.
*/

$config['orbital_core_location'] = '##ORBITAL_CORE_LOCATION##';

/**
 * Orbital Manager Version
 *
 * The version of this instance of Orbital Manager.
*/

$config['orbital_manager_version'] = '0.0.1';

// End of file orbital.php
// Location: ./config/orbital.php