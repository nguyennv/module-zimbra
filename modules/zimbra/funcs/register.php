<?php

/**
 * @Project Zimbra for NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License AGPL v3+
 * @Createdate Wed, 06 Apr 2016 02:26:16 GMT
 */

if ( ! defined( 'NV_IS_MOD_ZIMBRA' ) ) die( 'Stop!!!' );

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$array_data = array();



$contents = nv_theme_zimbra_register( $array_data );

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
