<?php

/**
 * @Project Zimbra for NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License AGPL v3+
 * @Createdate Wed, 06 Apr 2016 02:26:16 GMT
 */

if (!defined('NV_IS_MOD_ZIMBRA')) die('Stop!!!');

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$preauthURL = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA;
if (defined('NV_IS_USER')) {
    $key = md5($user_info['email'] . $global_config['sitekey'] . $client_info['session_id']);
    
    $_config = $nv_Request->get_string('config', 'get');
    $_config = nv_base64_decode($_config);
    $_config = $crypt->aes_decrypt($_config, $key);
    if (!empty($_config)) {
        $_config = unserialize($_config);
        if (strpos($user_info['email'], '@' . $_config['domain_name'])) {
            $timestamp = time() * 1000;
            $preauthToken = hash_hmac('sha1', $user_info['email'] . '|name|0|' . $timestamp, $_config['domain_preauth_key']);
            $preauthURL = $_config['web_mail_preauth_url'] . '?account=' . $user_info['email'] . '&by=name&timestamp=' . $timestamp . '&expires=0&preauth=' . $preauthToken;
        }
    }
}
header('Location: ' . $preauthURL);
exit();