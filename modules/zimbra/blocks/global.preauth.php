<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 12 Apr 2016 06:43:59 GMT
 */

//https://wiki.zimbra.com/wiki/Preauth
//zmprov generateDomainPreAuthKey nukeviet.net
if (!defined('NV_MAINFILE')) die('Stop!!!');

if (!nv_function_exists('nvb_config_zimbra_global_preauth')) {

    function nvb_config_zimbra_global_preauth($module, $data_block, $lang_block)
    {
        global $global_config, $db, $site_mods;
        
        $html = '<tr>';
        $html .= '<td>' . $lang_block['domain_name'] . '</td>';
        $html .= '<td><input type="text" class="form-control" name="config_domain_name" value="' . $data_block['domain_name'] . '"/></td>';
        $html .= '</tr>';
        
        $html . '<tr>';
        $html .= '<td><a target="_blank" href="https://wiki.zimbra.com/wiki/Preauth">' . $lang_block['domain_preauth_key'] . '</a></td>';
        $html .= '<td><input type="text" class="form-control" name="config_domain_preauth_key" value="' . $data_block['domain_preauth_key'] . '"/></td>';
        $html .= '</tr>';
        
        $html . '<tr>';
        $html .= '<td>' . $lang_block['web_mail_preauth_url'] . '</td>';
        $html .= '<td><input type="text" class="form-control" name="config_web_mail_preauth_url" value="' . $data_block['web_mail_preauth_url'] . '"/></td>';
        $html .= '</tr>';
        return $html;
    }

    function nvb_config_zimbra_global_preauth_submit($module, $lang_block)
    {
        global $nv_Request;
        
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['domain_name'] = $nv_Request->get_title('config_domain_name', 'post', '');
        $return['config']['domain_preauth_key'] = $nv_Request->get_title('config_domain_preauth_key', 'post', '');
        $return['config']['web_mail_preauth_url'] = $nv_Request->get_title('config_web_mail_preauth_url', 'post', '');
        return $return;
    }
}

function nvb_zimbra_global_preauth($block_config)
{
    global $global_config, $site_mods, $user_info, $client_info, $crypt;
    
    $mod_name = $block_config['module'];
    if (isset($site_mods[$mod_name])) {
        $mod_file = $site_mods[$mod_name]['module_file'];
        $mod_upload = $site_mods[$mod_name]['module_upload'];
        $mod_data = $site_mods[$mod_name]['module_data'];
        
        $xtpl = new XTemplate('global.preauth.tpl', NV_ROOTDIR . '/themes/default/modules/' . $mod_file);
        $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);
        $xtpl->assign('TEMPLATE', $global_config['module_theme']);
        if (defined('NV_IS_USER') and strpos($user_info['email'], '@' . $block_config['domain_name'])) {
            $_config = array(
                'domain_name' => $block_config['domain_name'],
                'domain_preauth_key' => $block_config['domain_preauth_key'],
                'web_mail_preauth_url' => $block_config['web_mail_preauth_url']
            );
            $_config = serialize($_config);
            $xtpl->assign('USER_EMAIL', $user_info['email']);
            $xtpl->assign('PREAUTHURL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $mod_name . '&' . NV_OP_VARIABLE . '=preauth&config=' . nv_base64_encode($crypt->aes_encrypt($_config, md5($user_info['email'] . $global_config['sitekey'] . $client_info['session_id']))));
            $xtpl->parse('main.email');
        } else {
            $xtpl->assign('DOMAIN_NAME', $block_config['domain_name']);
            $xtpl->assign('REGISTERURL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=' . $site_mods['users']['alias']['register']);
            $xtpl->parse('main.register');
        }
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    $content = nvb_zimbra_global_preauth($block_config);
}