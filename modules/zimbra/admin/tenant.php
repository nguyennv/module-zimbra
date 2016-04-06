<?php

/**
 * @Project Zimbra for NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 06 Apr 2016 02:54:15 GMT
 */

if ( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

if ( $nv_Request->isset_request( 'delete_id', 'get' ) and $nv_Request->isset_request( 'delete_checkss', 'get' ))
{
	$id = $nv_Request->get_int( 'delete_id', 'get' );
	$delete_checkss = $nv_Request->get_string( 'delete_checkss', 'get' );
	if( $id > 0 and $delete_checkss == md5( $id . NV_CACHE_PREFIX . $client_info['session_id'] ) )
	{
		$db->query('DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_tenant  WHERE id = ' . $db->quote( $id ) );
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
	$row['full_name'] = $nv_Request->get_title( 'full_name', 'post', '' );
	$row['tenant_uid'] = $nv_Request->get_int( 'tenant_uid', 'post', 0 );
	$row['server_id'] = $nv_Request->get_int( 'server_id', 'post', 0 );

	if( empty( $row['full_name'] ) )
	{
		$error[] = $lang_module['error_required_full_name'];
	}
	elseif( empty( $row['server_id'] ) )
	{
		$error[] = $lang_module['error_required_server_id'];
	}

	if( empty( $error ) )
	{
		try
		{
			if( empty( $row['id'] ) )
			{

				$row['uid'] = 0;
				$row['created'] = 0;
				$row['changed'] = 0;

				$stmt = $db->prepare( 'INSERT INTO ' . $db_config['prefix'] . '_' . $module_data . '_tenant (full_name, tenant_uid, server_id, uid, created, changed) VALUES (:full_name, :tenant_uid, :server_id, :uid, :created, :changed)' );

				$stmt->bindParam( ':uid', $row['uid'], PDO::PARAM_INT );
				$stmt->bindParam( ':created', $row['created'], PDO::PARAM_INT );
				$stmt->bindParam( ':changed', $row['changed'], PDO::PARAM_INT );

			}
			else
			{
				$stmt = $db->prepare( 'UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_tenant SET full_name = :full_name, tenant_uid = :tenant_uid, server_id = :server_id WHERE id=' . $row['id'] );
			}
			$stmt->bindParam( ':full_name', $row['full_name'], PDO::PARAM_STR );
			$stmt->bindParam( ':tenant_uid', $row['tenant_uid'], PDO::PARAM_INT );
			$stmt->bindParam( ':server_id', $row['server_id'], PDO::PARAM_INT );

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
	$row = $db->query( 'SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_tenant WHERE id=' . $row['id'] )->fetch();
	if( empty( $row ) )
	{
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
		die();
	}
}
else
{
	$row['id'] = 0;
	$row['full_name'] = '';
	$row['tenant_uid'] = 0;
	$row['server_id'] = 0;
}
$array_server_id_zimbra = array();
$_sql = 'SELECT id,name FROM nv4_zimbra_server';
$_query = $db->query( $_sql );
while( $_row = $_query->fetch() )
{
	$array_server_id_zimbra[$_row['id']] = $_row;
}


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
		->from( '' . $db_config['prefix'] . '_' . $module_data . '_tenant' );

	if( ! empty( $q ) )
	{
		$db->where( 'full_name LIKE :q_full_name OR server_id LIKE :q_server_id' );
	}
	$sth = $db->prepare( $db->sql() );

	if( ! empty( $q ) )
	{
		$sth->bindValue( ':q_full_name', '%' . $q . '%' );
		$sth->bindValue( ':q_server_id', '%' . $q . '%' );
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
		$sth->bindValue( ':q_full_name', '%' . $q . '%' );
		$sth->bindValue( ':q_server_id', '%' . $q . '%' );
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

foreach( $array_server_id_zimbra as $value )
{
	$xtpl->assign( 'OPTION', array(
		'key' => $value['id'],
		'title' => $value['name'],
		'selected' => ($value['id'] == $row['server_id']) ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.select_server_id' );
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
		$view['server_id'] = $array_server_id_zimbra[$view['server_id']]['name'];
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

$page_title = $lang_module['tenant'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';