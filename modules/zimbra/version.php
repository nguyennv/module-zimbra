<?php

/**
 * @Project Zimbra for NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License AGPL v3+
 * @Createdate Wed, 06 Apr 2016 02:26:16 GMT
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$module_version = array(
	'name' => 'Zimbra',
	'modfuncs' => 'main,preauth',
	'change_alias' => 'main,preauth',
	'submenu' => 'main,preauth',
	'is_sysmod' => 0,
	'virtual' => 1,
	'version' => '4.0.00',
	'date' => 'Wed, 6 Apr 2016 02:26:16 GMT',
	'author' => 'VINADES.,JSC (contact@vinades.vn)',
	'uploads_dir' => array($module_name),
	'note' => 'Module quản lý tài khoản mở rộng cho Zimbra'
);