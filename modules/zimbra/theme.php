<?php

/**
 * @Project Zimbra for NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License AGPL v3+
 * @Createdate Wed, 06 Apr 2016 02:26:16 GMT
 */

if ( ! defined( 'NV_IS_MOD_ZIMBRA' ) ) die( 'Stop!!!' );

/**
 * nv_theme_zimbra_main()
 * 
 * @param mixed $array_data
 * @return
 */
function nv_theme_zimbra_main ( $array_data )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}

/**
 * nv_theme_zimbra_register()
 * 
 * @param mixed $array_data
 * @return
 */
function nv_theme_zimbra_register ( $array_data )
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;

    $xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
    $xtpl->assign( 'LANG', $lang_module );

    

    $xtpl->parse( 'main' );
    return $xtpl->text( 'main' );
}