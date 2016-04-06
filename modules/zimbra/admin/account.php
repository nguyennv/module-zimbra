<?php

/**
 * @Project Zimbra for NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 06 Apr 2016 03:10:59 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

if ( $nv_Request->isset_request( 'delete_id', 'get' ) and $nv_Request->isset_request( 'delete_checkss', 'get' ))
{
	$id = $nv_Request->get_int( 'delete_id', 'get' );
	$delete_checkss = $nv_Request->get_string( 'delete_checkss', 'get' );
	if( $id > 0 and $delete_checkss == md5( $id . NV_CACHE_PREFIX . $client_info['session_id'] ) )
	{
		$db->query('DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_account  WHERE id = ' . $db->quote( $id ) );
		$nv_Cache->delMod( $module_name );
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();
	}
}

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int( 'id', 'post,get', 0 );
if ( $nv_Request->isset_request( 'submit', 'post' ) )
{
	$row['domain_id'] = $nv_Request->get_int( 'domain_id', 'post', 0 );
	$row['name'] = $nv_Request->get_title( 'name', 'post', '' );
	$row['password'] = $nv_Request->get_title( 'password', 'post', '' );
	$row['title'] = $nv_Request->get_title( 'title', 'post', '' );
	$row['full_name'] = $nv_Request->get_title( 'full_name', 'post', '' );
	$row['status'] = $nv_Request->get_title( 'status', 'post', '' );
	$row['telephone'] = $nv_Request->get_title( 'telephone', 'post', '' );
	$row['mobile'] = $nv_Request->get_title( 'mobile', 'post', '' );
	$row['company'] = $nv_Request->get_title( 'company', 'post', '' );

	if( empty( $row['domain_id'] ) )
	{
		$error[] = $lang_module['error_required_domain_id'];
	}
	elseif( empty( $row['name'] ) )
	{
		$error[] = $lang_module['error_required_name'];
	}
	elseif( empty( $row['password'] ) )
	{
		$error[] = $lang_module['error_required_password'];
	}
	elseif( empty( $row['full_name'] ) )
	{
		$error[] = $lang_module['error_required_full_name'];
	}
	elseif( empty( $row['status'] ) )
	{
		$error[] = $lang_module['error_required_status'];
	}

	if( empty( $error ) )
	{
		try
		{
			if( empty( $row['id'] ) )
			{

				$row['cos_id'] = 0;
				$row['zimbra_id'] = '';
				$row['uid'] = 0;
				$row['created'] = 0;
				$row['changed'] = 0;

				$stmt = $db->prepare( 'INSERT INTO ' . $db_config['prefix'] . '_' . $module_data . '_account (domain_id, cos_id, name, password, title, full_name, status, telephone, mobile, company, zimbra_id, uid, created, changed) VALUES (:domain_id, :cos_id, :name, :password, :title, :full_name, :status, :telephone, :mobile, :company, :zimbra_id, :uid, :created, :changed)' );

				$stmt->bindParam( ':cos_id', $row['cos_id'], PDO::PARAM_INT );
				$stmt->bindParam( ':zimbra_id', $row['zimbra_id'], PDO::PARAM_STR );
				$stmt->bindParam( ':uid', $row['uid'], PDO::PARAM_INT );
				$stmt->bindParam( ':created', $row['created'], PDO::PARAM_INT );
				$stmt->bindParam( ':changed', $row['changed'], PDO::PARAM_INT );

			}
			else
			{
				$stmt = $db->prepare( 'UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_account SET domain_id = :domain_id, name = :name, password = :password, title = :title, full_name = :full_name, status = :status, telephone = :telephone, mobile = :mobile, company = :company WHERE id=' . $row['id'] );
			}
			$stmt->bindParam( ':domain_id', $row['domain_id'], PDO::PARAM_INT );
			$stmt->bindParam( ':name', $row['name'], PDO::PARAM_STR );
			$stmt->bindParam( ':password', $row['password'], PDO::PARAM_STR );
			$stmt->bindParam( ':title', $row['title'], PDO::PARAM_STR );
			$stmt->bindParam( ':full_name', $row['full_name'], PDO::PARAM_STR );
			$stmt->bindParam( ':status', $row['status'], PDO::PARAM_STR );
			$stmt->bindParam( ':telephone', $row['telephone'], PDO::PARAM_STR );
			$stmt->bindParam( ':mobile', $row['mobile'], PDO::PARAM_STR );
			$stmt->bindParam( ':company', $row['company'], PDO::PARAM_STR );

			$exc = $stmt->execute();
			if( $exc )
			{
				$nv_Cache->delMod( $module_name );
				Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
				die();
			}
		}
		catch( PDOException $e )
		{
			trigger_error( $e->getMessage() );
			die( $e->getMessage() ); //Remove this line after checks finished
		}
	}
}
elseif( $row['id'] > 0 )
{
	$row = $db->query( 'SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_account WHERE id=' . $row['id'] )->fetch();
	if( empty( $row ) )
	{
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();
	}
}
else
{
	$row['id'] = 0;
	$row['domain_id'] = 0;
	$row['name'] = '';
	$row['password'] = '';
	$row['title'] = '';
	$row['full_name'] = '';
	$row['status'] = '';
	$row['telephone'] = '';
	$row['mobile'] = '';
	$row['company'] = '';
}
$array_domain_id_zimbra = array();
$_sql = 'SELECT id,name FROM nv4_zimbra_domain';
$_query = $db->query( $_sql );
while( $_row = $_query->fetch() )
{
	$array_domain_id_zimbra[$_row['id']] = $_row;
}


$array_status = array();
$array_status[active] = 'Active';
$array_status[closed] = 'Closed';
$array_status[suspended] = 'Suspended';

$q = $nv_Request->get_title( 'q', 'post,get' );

// Fetch Limit
$show_view = false;
if ( ! $nv_Request->isset_request( 'id', 'post,get' ) )
{
	$show_view = true;
	$per_page = 20;
	$page = $nv_Request->get_int( 'page', 'post,get', 1 );
	$db->sqlreset()
		->select( 'COUNT(*)' )
		->from( '' . $db_config['prefix'] . '_' . $module_data . '_account' );

	if( ! empty( $q ) )
	{
		$db->where( 'domain_id LIKE :q_domain_id OR name LIKE :q_name OR password LIKE :q_password' );
	}
	$sth = $db->prepare( $db->sql() );

	if( ! empty( $q ) )
	{
		$sth->bindValue( ':q_domain_id', '%' . $q . '%' );
		$sth->bindValue( ':q_name', '%' . $q . '%' );
		$sth->bindValue( ':q_password', '%' . $q . '%' );
	}
	$sth->execute();
	$num_items = $sth->fetchColumn();

	$db->select( '*' )
		->order( 'id DESC' )
		->limit( $per_page )
		->offset( ( $page - 1 ) * $per_page );
	$sth = $db->prepare( $db->sql() );

	if( ! empty( $q ) )
	{
		$sth->bindValue( ':q_domain_id', '%' . $q . '%' );
		$sth->bindValue( ':q_name', '%' . $q . '%' );
		$sth->bindValue( ':q_password', '%' . $q . '%' );
	}
	$sth->execute();
}


$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'MODULE_UPLOAD', $module_upload );
$xtpl->assign( 'NV_ASSETS_DIR', NV_ASSETS_DIR );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'ROW', $row );

foreach( $array_domain_id_zimbra as $value )
{
	$xtpl->assign( 'OPTION', array(
		'key' => $value['id'],
		'title' => $value['name'],
		'selected' => ($value['id'] == $row['domain_id']) ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.select_domain_id' );
}

foreach( $array_status as $key => $title )
{
	$xtpl->assign( 'OPTION', array(
		'key' => $key,
		'title' => $title,
		'selected' => ($key == $row['status']) ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.select_status' );
}
$xtpl->assign( 'Q', $q );

if( $show_view )
{
	$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
	if( ! empty( $q ) )
	{
		$base_url .= '&q=' . $q;
	}
	$generate_page = nv_generate_page( $base_url, $num_items, $per_page, $page );
	if( !empty( $generate_page ) )
	{
		$xtpl->assign( 'NV_GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.view.generate_page' );
	}
	$number = $page > 1 ? ($per_page * ( $page - 1 ) ) + 1 : 1;
	while( $view = $sth->fetch() )
	{
		$view['number'] = $number++;
		$view['domain_id'] = $array_domain_id_zimbra[$view['domain_id']]['name'];
		$view['status'] = $array_status[$view['status']];
		$view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;id=' . $view['id'];
		$view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5( $view['id'] . NV_CACHE_PREFIX . $client_info['session_id'] );
		$xtpl->assign( 'VIEW', $view );
		$xtpl->parse( 'main.view.loop' );
	}
	$xtpl->parse( 'main.view' );
}


if( ! empty( $error ) )
{
	$xtpl->assign( 'ERROR', implode( '<br />', $error ) );
	$xtpl->parse( 'main.error' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

$page_title = $lang_module['account'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';