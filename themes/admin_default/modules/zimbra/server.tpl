<!-- BEGIN: main -->
<!-- BEGIN: view -->
<div class="well">
<form action="{NV_BASE_ADMINURL}index.php" method="get">
	<input type="hidden" name="{NV_LANG_VARIABLE}"  value="{NV_LANG_DATA}" />
	<input type="hidden" name="{NV_NAME_VARIABLE}"  value="{MODULE_NAME}" />
	<input type="hidden" name="{NV_OP_VARIABLE}"  value="{OP}" />
	<div class="row">
		<div class="col-xs-24 col-md-6">
			<div class="form-group">
				<input class="form-control" type="text" value="{Q}" name="q" maxlength="255" placeholder="{LANG.search_title}" />
			</div>
		</div>
		<div class="col-xs-12 col-md-3">
			<div class="form-group">
				<input class="btn btn-primary" type="submit" value="{LANG.search_submit}" />
			</div>
		</div>
	</div>
</form>
</div>
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th class="w100">{LANG.number}</th>
					<th>{LANG.name}</th>
					<th>{LANG.service_location}</th>
					<th class="w150">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN: loop -->
				<tr>
					<td> {VIEW.number} </td>
					<td> {VIEW.name} </td>
					<td> {VIEW.service_location} </td>
					<td class="text-center"><i class="fa fa-edit fa-lg">&nbsp;</i> <a href="{VIEW.link_edit}#edit">{LANG.edit}</a> - <em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="{VIEW.link_delete}" onclick="return confirm(nv_is_del_confirm[0]);">{LANG.delete}</a></td>
				</tr>
				<!-- END: loop -->
			</tbody>
		</table>
	</div>
</form>
<!-- END: view -->

<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->
<div class="panel panel-default">
<div class="panel-body">
<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
	<input type="hidden" name="id" value="{ROW.id}" />
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.name}</strong> <span class="red">(*)</span></label>
		<div class="col-sm-19 col-md-20">
			<input class="form-control" type="text" name="name" value="{ROW.name}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.service_location}</strong> <span class="red">(*)</span></label>
		<div class="col-sm-19 col-md-20">
			<input class="form-control" type="text" name="service_location" value="{ROW.service_location}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.admin_user}</strong> <span class="red">(*)</span></label>
		<div class="col-sm-19 col-md-20">
			<input class="form-control" type="text" name="admin_user" value="{ROW.admin_user}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.admin_password}</strong> <span class="red">(*)</span></label>
		<div class="col-sm-19 col-md-20">
			<input class="form-control" type="text" name="admin_password" value="{ROW.admin_password}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.exclude_mailbox}</strong></label>
		<div class="col-sm-19 col-md-20">
			<textarea class="form-control" style="height:100px;" cols="75" rows="5" name="exclude_mailbox">{ROW.exclude_mailbox}</textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.delete_domain}</strong></label>
		<div class="col-sm-19 col-md-20">
			<select class="form-control" name="delete_domain">
				<option value=""> --- </option>
				<!-- BEGIN: select_delete_domain -->
				<option value="{OPTION.key}" {OPTION.selected}>{OPTION.title}</option>
				<!-- END: select_delete_domain -->
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.delete_dl}</strong></label>
		<div class="col-sm-19 col-md-20">
			<select class="form-control" name="delete_dl">
				<option value=""> --- </option>
				<!-- BEGIN: select_delete_dl -->
				<option value="{OPTION.key}" {OPTION.selected}>{OPTION.title}</option>
				<!-- END: select_delete_dl -->
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.delete_account}</strong></label>
		<div class="col-sm-19 col-md-20">
			<select class="form-control" name="delete_account">
				<option value=""> --- </option>
				<!-- BEGIN: select_delete_account -->
				<option value="{OPTION.key}" {OPTION.selected}>{OPTION.title}</option>
				<!-- END: select_delete_account -->
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.delete_alias}</strong></label>
		<div class="col-sm-19 col-md-20">
			<select class="form-control" name="delete_alias">
				<option value=""> --- </option>
				<!-- BEGIN: select_delete_alias -->
				<option value="{OPTION.key}" {OPTION.selected}>{OPTION.title}</option>
				<!-- END: select_delete_alias -->
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.uid}</strong></label>
		<div class="col-sm-19 col-md-20">
			<input class="form-control" type="text" name="uid" value="{ROW.uid}" pattern="^[0-9]*$"  oninvalid="setCustomValidity( nv_digits )" oninput="setCustomValidity('')" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.created}</strong></label>
		<div class="col-sm-19 col-md-20">
			<input class="form-control" type="text" name="created" value="{ROW.created}" pattern="^[0-9]*$"  oninvalid="setCustomValidity( nv_digits )" oninput="setCustomValidity('')" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.changed}</strong></label>
		<div class="col-sm-19 col-md-20">
			<input class="form-control" type="text" name="changed" value="{ROW.changed}" pattern="^[0-9]*$"  oninvalid="setCustomValidity( nv_digits )" oninput="setCustomValidity('')" />
		</div>
	</div>
	<div class="form-group" style="text-align: center"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
</form>
</div></div>
<!-- END: main -->