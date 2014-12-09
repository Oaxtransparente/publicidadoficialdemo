<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Enable/Disable Migrations
|--------------------------------------------------------------------------
|
| Migrations are disabled by default but should be enabled 
| whenever you intend to do a schema migration.
|
*/

$config['migration_enabled'] = FALSE;
$config['migration_version'] = 0;
$config['migration_path'] = APPPATH . 'migrations/';
