<?php

/**
 * @Project Zimbra for NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 06 Apr 2016 02:44:12 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $row = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_server WHERE id=' . $id)->fetch();
        if (!empty($row)) {
            // Lấy authToken khi kết nối với Zimbra server
            try {
                $api = \Zimbra\Admin\AdminFactory::instance($row['service_location']);
                if ($nv_Request->isset_request('delete_id', 'get')) {
                    // Cần kiểm tra lại biến lifetime trước khi  kiểm tra authToken
                    $Zimbra_authToken = $nv_Request->get_string('Zimbra_authToken', 'session');
                    // Kiểm tra lại  authToken
                    $z_auth = $api->authByToken($Zimbra_authToken);
                } else {
                    $z_auth = $api->auth($row['admin_user'], $row['admin_password']);
                    $nv_Request->set_Session('Zimbra_authToken', $z_auth->authToken);
                    $nv_Request->set_Session('Zimbra_lifetime', $$z_auth->lifetime);
                }
            } catch (Exception $e) {
                // print_r($e);
            }
            $Zimbra_authToken = $z_auth->authToken;
            
            // Tạo thử domain:
            $domain_name = 'nukeviet.net'; // Không đổi được domain, chỉ được thay đổi  zimbraDomainStatus
            $domain_id = '';
            if ($nv_Request->isset_request('Zimbra_domain_id', 'get')) {
                $domain_id = $nv_Request->get_string('Zimbra_domain_id', 'session');
                die('A11');
            } else {
                try {
                    //zimbraDomainStatus: active,maintenance,locked,closed,suspended,shutdown
                    $_kp = new Zimbra\Struct\KeyValuePair('zimbraDomainStatus', 'active');
                    $return = $api->createDomain($domain_name, array(
                        $_kp
                    ));
                    $domain_name = $return->domain->name;
                    $domain_id = $return->domain->id;
                    $nv_Request->set_Session('Zimbra_domain_id', $domain_id);
                } catch (Exception $e) {
                    // Lấy lại ID
                    $_DomainSelector = new Zimbra\Admin\Struct\DomainSelector(Zimbra\Enum\DomainBy::NAME(), $domain_name);
                    $return = $api->getDomain($_DomainSelector);
                    $domain_id = $return->domain->id;
                    $nv_Request->set_Session('Zimbra_domain_id', $domain_id);
                }
            }
            
            // Tạo Email:
            try {
                //zimbraDomainStatus: active,maintenance,locked,closed,suspended,shutdown
                $_kp1 = new Zimbra\Struct\KeyValuePair('displayName', 'Vũ Văn Thảo');
                $_kp2 = new Zimbra\Struct\KeyValuePair('mobile', '0945 33 8080');
                
                $return = $api->CreateAccount('nukeviet4@' . $domain_name, 'nukeviet2345', array(
                    $_kp1,
                    $_kp2
                ));
                
                $account_id = $return->account->id;
            } catch (Exception $e) {
                $_AcSelector = new Zimbra\Struct\AccountSelector(Zimbra\Enum\AccountBy::NAME(), 'nukeviet4@' . $domain_name);
                $return = $api->getAccount($_AcSelector);
                
                $account_id = $return->account->id;
            }
            
            // SetPass: Cần dùng CheckPasswordStrength  trước khi set
            //  $return = $api->setPassword($account_id, '123'); //nukeviet234567
            //  $message = $return->message;
            

            // Đổi tên tài khoản: dùng RenameAccount tượng tự như đổi pass
            //ModifyAccount  cập nhật các thuôc tính.
            echo '<pre>';
            print_r($return);
            echo '</pre>';
            die('$setPassword message = ' . $message);
        }
        die('Test');
        
        $db->query('DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_server  WHERE id = ' . $db->quote($id));
        $nv_Cache->delMod($module_name);
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
        die();
    }
}

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
    $row['name'] = $nv_Request->get_title('name', 'post', '');
    $row['service_location'] = $nv_Request->get_title('service_location', 'post', '');
    $row['admin_user'] = $nv_Request->get_title('admin_user', 'post', '');
    $row['admin_password'] = $nv_Request->get_title('admin_password', 'post', '');
    $row['exclude_mailbox'] = $nv_Request->get_string('exclude_mailbox', 'post', '');
    $row['delete_domain'] = $nv_Request->get_int('delete_domain', 'post', 0);
    $row['delete_dl'] = $nv_Request->get_int('delete_dl', 'post', 0);
    $row['delete_account'] = $nv_Request->get_int('delete_account', 'post', 0);
    $row['delete_alias'] = $nv_Request->get_int('delete_alias', 'post', 0);
    $row['uid'] = $nv_Request->get_int('uid', 'post', 0);
    $row['created'] = $nv_Request->get_int('created', 'post', 0);
    $row['changed'] = $nv_Request->get_int('changed', 'post', 0);
    
    if (empty($row['name'])) {
        $error[] = $lang_module['error_required_name'];
    } elseif (empty($row['service_location'])) {
        $error[] = $lang_module['error_required_service_location'];
    } elseif (empty($row['admin_user'])) {
        $error[] = $lang_module['error_required_admin_user'];
    } elseif (empty($row['admin_password'])) {
        $error[] = $lang_module['error_required_admin_password'];
    }
    
    if (empty($error)) {
        try {
            if (empty($row['id'])) {
                $stmt = $db->prepare('INSERT INTO ' . $db_config['prefix'] . '_' . $module_data . '_server (name, service_location, admin_user, admin_password, exclude_mailbox, delete_domain, delete_dl, delete_account, delete_alias, uid, created, changed) VALUES (:name, :service_location, :admin_user, :admin_password, :exclude_mailbox, :delete_domain, :delete_dl, :delete_account, :delete_alias, :uid, :created, :changed)');
            } else {
                $stmt = $db->prepare('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_server SET name = :name, service_location = :service_location, admin_user = :admin_user, admin_password = :admin_password, exclude_mailbox = :exclude_mailbox, delete_domain = :delete_domain, delete_dl = :delete_dl, delete_account = :delete_account, delete_alias = :delete_alias, uid = :uid, created = :created, changed = :changed WHERE id=' . $row['id']);
            }
            $stmt->bindParam(':name', $row['name'], PDO::PARAM_STR);
            $stmt->bindParam(':service_location', $row['service_location'], PDO::PARAM_STR);
            $stmt->bindParam(':admin_user', $row['admin_user'], PDO::PARAM_STR);
            $stmt->bindParam(':admin_password', $row['admin_password'], PDO::PARAM_STR);
            $stmt->bindParam(':exclude_mailbox', $row['exclude_mailbox'], PDO::PARAM_STR, strlen($row['exclude_mailbox']));
            $stmt->bindParam(':delete_domain', $row['delete_domain'], PDO::PARAM_INT);
            $stmt->bindParam(':delete_dl', $row['delete_dl'], PDO::PARAM_INT);
            $stmt->bindParam(':delete_account', $row['delete_account'], PDO::PARAM_INT);
            $stmt->bindParam(':delete_alias', $row['delete_alias'], PDO::PARAM_INT);
            $stmt->bindParam(':uid', $row['uid'], PDO::PARAM_INT);
            $stmt->bindParam(':created', $row['created'], PDO::PARAM_INT);
            $stmt->bindParam(':changed', $row['changed'], PDO::PARAM_INT);
            
            $exc = $stmt->execute();
            if ($exc) {
                $nv_Cache->delMod($module_name);
                Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
                die();
            }
        } catch (PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); //Remove this line after checks finished
        }
    }
} elseif ($row['id'] > 0) {
    $row = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_server WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
        die();
    }
} else {
    $row['id'] = 0;
    $row['name'] = '';
    $row['service_location'] = '';
    $row['admin_user'] = '';
    $row['admin_password'] = '';
    $row['exclude_mailbox'] = '';
    $row['delete_domain'] = 0;
    $row['delete_dl'] = 0;
    $row['delete_account'] = 0;
    $row['delete_alias'] = 0;
    $row['uid'] = 0;
    $row['created'] = 0;
    $row['changed'] = 0;
}

$array_delete_domain = array();
$array_delete_domain[1] = 'Allow delete domain on zimbra server.';

$array_delete_dl = array();
$array_delete_dl[1] = 'Allow delete dl on zimbra server.';

$array_delete_account = array();
$array_delete_account[1] = 'Allow delete account on zimbra server.';

$array_delete_alias = array();
$array_delete_alias[1] = 'Allow delete alias on zimbra server.';

$q = $nv_Request->get_title('q', 'post,get');

// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
    $show_view = true;
    $db->sqlreset()
        ->select('*')
        ->from('' . $db_config['prefix'] . '_' . $module_data . '_server')
        ->order('id DESC');
    
    if (!empty($q)) {
        $db->where('name LIKE :q_name OR service_location LIKE :q_service_location');
    }
    $sth = $db->prepare($db->sql());
    
    if (!empty($q)) {
        $sth->bindValue(':q_name', '%' . $q . '%');
        $sth->bindValue(':q_service_location', '%' . $q . '%');
    }
    $sth->execute();
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('NV_ASSETS_DIR', NV_ASSETS_DIR);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);

foreach ($array_delete_domain as $key => $title) {
    $xtpl->assign('OPTION', array(
        'key' => $key,
        'title' => $title,
        'selected' => ($key == $row['delete_domain']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_delete_domain');
}

foreach ($array_delete_dl as $key => $title) {
    $xtpl->assign('OPTION', array(
        'key' => $key,
        'title' => $title,
        'selected' => ($key == $row['delete_dl']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_delete_dl');
}

foreach ($array_delete_account as $key => $title) {
    $xtpl->assign('OPTION', array(
        'key' => $key,
        'title' => $title,
        'selected' => ($key == $row['delete_account']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_delete_account');
}

foreach ($array_delete_alias as $key => $title) {
    $xtpl->assign('OPTION', array(
        'key' => $key,
        'title' => $title,
        'selected' => ($key == $row['delete_alias']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_delete_alias');
}
$xtpl->assign('Q', $q);

if ($show_view) {
    $number = 0;
    while ($view = $sth->fetch()) {
        $view['number'] = $number++;
        $view['delete_domain'] = $array_delete_domain[$view['delete_domain']];
        $view['delete_dl'] = $array_delete_dl[$view['delete_dl']];
        $view['delete_account'] = $array_delete_account[$view['delete_account']];
        $view['delete_alias'] = $array_delete_alias[$view['delete_alias']];
        $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $view['id'];
        $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
        $xtpl->assign('VIEW', $view);
        $xtpl->parse('main.view.loop');
    }
    $xtpl->parse('main.view');
}

if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['server'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';