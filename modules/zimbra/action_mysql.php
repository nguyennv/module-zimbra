<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 06 Apr 2016 14:16:46 GMT
 */

if ( ! defined( 'NV_IS_FILE_MODULES' ) ) die( 'Stop!!!' );

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_account";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_alias";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_cos";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_domain";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_domain_cos";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_group";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_group_member";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_server";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_tenant";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_tenant_cos";

$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_account(
  id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The primary identifier for an account, used internally only.',
  domain_id smallint(5) NOT NULL DEFAULT '0' COMMENT 'The domain.id of the account.',
  cos_id int(11) NOT NULL DEFAULT '0' COMMENT 'The cos_id.id of the account.',
  name varchar(200) NOT NULL DEFAULT '' COMMENT 'The name of the account, always treated as non-markup plain text.',
  password varchar(100) NOT NULL DEFAULT '',
  title varchar(200) NOT NULL DEFAULT '' COMMENT 'The title of the account.',
  full_name varchar(200) NOT NULL DEFAULT '' COMMENT 'The full name of the account.',
  status varchar(32) NOT NULL DEFAULT '' COMMENT 'The status of the account.',
  telephone varchar(200) NOT NULL DEFAULT '' COMMENT 'The telephone of the account.',
  mobile varchar(200) NOT NULL DEFAULT '' COMMENT 'The mobile of the account.',
  company varchar(200) NOT NULL DEFAULT '' COMMENT 'The company of the account.',
  zimbra_id varchar(200) NOT NULL DEFAULT '' COMMENT 'The zimbra identify of the account.',
  uid int(11) NOT NULL DEFAULT '0' COMMENT 'The users.uid that created the account.',
  created_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the account was created.',
  changed_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the account was most recently saved.',
  PRIMARY KEY (id),
  UNIQUE KEY account_name (domain_id,name),
  KEY account_domain_id (domain_id),
  KEY account_cos_id (cos_id),
  KEY account_status (status),
  KEY account_creator_uid (uid),
  KEY account_created (created_time),
  KEY account_changed (changed_time)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_alias(
  id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The primary identifier for an alias, used internally only.',
  domain_id smallint(5) NOT NULL DEFAULT '0' COMMENT 'The domain.id of the alias.',
  name varchar(200) NOT NULL DEFAULT '' COMMENT 'The name of the alias.',
  account_id int(11) NOT NULL DEFAULT '0' COMMENT 'The target account of the alias.',
  zimbra_target_id varchar(200) NOT NULL DEFAULT '' COMMENT 'The zimbra target id of the alias.',
  uid int(11) NOT NULL DEFAULT '0' COMMENT 'The users.uid that created the alias.',
  created_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the alias was created.',
  changed_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the alias was most recently saved.',
  PRIMARY KEY (id),
  UNIQUE KEY alias_name (domain_id,name),
  KEY alias_domain_id (domain_id),
  KEY alias_account_id (account_id),
  KEY alias_creator_uid (uid),
  KEY alias_created (created_time),
  KEY alias_changed (changed_time)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_cos(
  id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The primary identifier for a cos, used internally only.',
  server_id int(11) NOT NULL DEFAULT '0' COMMENT 'The server.id of zimbra server.',
  name varchar(200) NOT NULL DEFAULT '' COMMENT 'The name of the cos, always treated as non-markup plain text.',
  description text COMMENT 'The description of the cos.',
  mail_quota int(11) NOT NULL DEFAULT '0' COMMENT 'The mail quota of the cos.',
  max_account int(11) NOT NULL DEFAULT '0' COMMENT 'The default max account number of the cos.',
  zimbra_id varchar(64) DEFAULT '' COMMENT 'The zimbra identify for class of service.',
  uid int(11) NOT NULL DEFAULT '0' COMMENT 'The users.uid that created the cos.',
  created_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the cos was created.',
  changed_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the cos was most recently saved.',
  PRIMARY KEY (id),
  UNIQUE KEY cos_zimbra_id (zimbra_id),
  KEY cos_server_id (server_id),
  KEY cos_creator_uid (uid),
  KEY cos_created (created_time),
  KEY cos_changed (changed_time)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_domain(
  id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The primary identifier for a domain, used internally only.',
  server_id int(11) NOT NULL DEFAULT '0' COMMENT 'The server.id of the domain.',
  tenant_id int(11) NOT NULL DEFAULT '0' COMMENT 'The tenant.id of the domain.',
  name varchar(200) NOT NULL DEFAULT '' COMMENT 'The name of the domain, always treated as non-markup plain text.',
  status varchar(32) NOT NULL DEFAULT '' COMMENT 'The status of the domain.',
  zimbra_id varchar(200) NOT NULL DEFAULT '' COMMENT 'The zimbra identify of the domain.',
  domain_uid int(11) NOT NULL DEFAULT '0' COMMENT 'The users.uid representation of the domain.',
  uid int(11) NOT NULL DEFAULT '0' COMMENT 'The users.uid that created the domain.',
  created_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the domain was created.',
  changed_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the domain was most recently saved.',
  PRIMARY KEY (id),
  UNIQUE KEY domain_name (name),
  KEY domain_server_id (server_id),
  KEY domain_tenant_id (tenant_id),
  KEY domain_status (status),
  KEY domain_uid (domain_uid),
  KEY domain_creator_uid (uid),
  KEY domain_created (created_time),
  KEY domain_changed (changed_time)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_domain_cos(
  id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The primary identifier, used internally only.',
  domain_id smallint(5) NOT NULL DEFAULT '0' COMMENT 'The domain.id of domain.',
  cos_id int(11) NOT NULL DEFAULT '0' COMMENT 'The cos.id of class of service.',
  max_account int(11) NOT NULL DEFAULT '0' COMMENT 'The max account number of the mapping.',
  uid int(11) NOT NULL DEFAULT '0' COMMENT 'The users.uid that created the mapping.',
  created_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the mapping was created.',
  PRIMARY KEY (id),
  UNIQUE KEY domain_cos_unique (domain_id,cos_id),
  KEY domain_id_mapping (domain_id),
  KEY cos_id_mapping (cos_id),
  KEY domain_cos_created (created_time)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_group(
  id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The primary identifier for a group, used internally only.',
  domain_id smallint(5) NOT NULL DEFAULT '0' COMMENT 'The domain.id of the group.',
  name varchar(200) NOT NULL DEFAULT '' COMMENT 'The name of the group, always treated as non-markup plain text.',
  full_name varchar(200) NOT NULL DEFAULT '' COMMENT 'The full name of the group.',
  zimbra_id varchar(200) NOT NULL DEFAULT '' COMMENT 'The zimbra identify of the group.',
  group_uid int(11) NOT NULL DEFAULT '0' COMMENT 'The users.uid representation of the group.',
  uid int(11) NOT NULL DEFAULT '0' COMMENT 'The users.uid that created the group.',
  created_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the group was created.',
  changed_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the group was most recently saved.',
  PRIMARY KEY (id),
  UNIQUE KEY group_name (domain_id,name),
  KEY group_domain_id (domain_id),
  KEY group_uid (group_uid),
  KEY group_creator_uid (uid),
  KEY group_created (created_time),
  KEY group_changed (changed_time)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_group_member(
  id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The primary identifier for a group member, used internally only.',
  name varchar(200) NOT NULL DEFAULT '' COMMENT 'The name of the group member.',
  group_id int(11) NOT NULL DEFAULT '0' COMMENT 'The group.id of the group member.',
  member_id int(11) NOT NULL DEFAULT '0' COMMENT 'The member id of the group member.',
  type tinyint(4) NOT NULL DEFAULT '0' COMMENT 'The member type of the group member.',
  uid int(11) NOT NULL DEFAULT '0' COMMENT 'The users.uid that created the group member.',
  created_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the group member was created.',
  PRIMARY KEY (id),
  UNIQUE KEY group_member_name (group_id,name),
  UNIQUE KEY group_member_unique (group_id,type,member_id),
  KEY group_member_group_id (group_id),
  KEY group_member_type (type),
  KEY group_member_created (created_time)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_server(
  id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The primary identifier for a server, used internally only.',
  name varchar(200) NOT NULL DEFAULT '' COMMENT 'The name of this server, always treated as non-markup plain text.',
  service_location varchar(200) NOT NULL DEFAULT '' COMMENT 'The service location of the server.',
  admin_user varchar(200) NOT NULL DEFAULT '' COMMENT 'The admin user of the server.',
  admin_password varchar(200) NOT NULL DEFAULT '' COMMENT 'The admin password of the server.',
  exclude_mailbox text COMMENT 'The exclude mailbox of the server.',
  delete_domain tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Allow delete domain on zimbra server.',
  delete_dl tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Allow delete dl on zimbra server.',
  delete_account tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Allow delete account on zimbra server.',
  delete_alias tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Allow delete alias on zimbra server.',
  uid int(11) NOT NULL DEFAULT '0' COMMENT 'The users.uid that created the server.',
  created_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the tenant was created.',
  changed_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the tenant was most recently saved.',
  PRIMARY KEY (id),
  KEY server_creator_uid (uid),
  KEY server_created (created_time),
  KEY server_changed (changed_time)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_tenant(
  id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The primary identifier for a tenant, used internally only.',
  full_name varchar(200) NOT NULL DEFAULT '' COMMENT 'The full name of the tenant.',
  tenant_uid int(11) NOT NULL DEFAULT '0' COMMENT 'The users.uid representation of the tenant.',
  server_id int(11) NOT NULL DEFAULT '0' COMMENT 'The server.id of the tenant.',
  uid int(11) NOT NULL DEFAULT '0' COMMENT 'The users.uid that created the tenant.',
  created_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the tenant was created.',
  changed_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the tenant was most recently saved.',
  PRIMARY KEY (id),
  UNIQUE KEY tenant_uid (tenant_uid),
  KEY tenant_server_id (server_id),
  KEY tenant_creator_uid (uid),
  KEY tenant_created (created_time),
  KEY tenant_changed (changed_time)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_tenant_cos(
  id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The primary identifier, used internally only.',
  tenant_id int(11) NOT NULL DEFAULT '0' COMMENT 'The tenant.id of tenant.',
  cos_id int(11) NOT NULL DEFAULT '0' COMMENT 'The cos.id of class of service.',
  max_account int(11) NOT NULL DEFAULT '0' COMMENT 'The max account number of the mapping.',
  uid int(11) NOT NULL DEFAULT '0' COMMENT 'The users.uid that created the mapping.',
  created_time int(11) NOT NULL DEFAULT '0' COMMENT 'The Unix timestamp when the mapping was created.',
  PRIMARY KEY (id),
  UNIQUE KEY tenant_cos_unique (tenant_id,cos_id),
  KEY tenant_id_mapping (tenant_id),
  KEY cos_id_mapping (cos_id),
  KEY tenant_cos_created (created_time)
) ENGINE=MyISAM";