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
					<th>{LANG.domain_id}</th>
					<th>{LANG.name}</th>
					<th>{LANG.password}</th>
					<th class="w150">&nbsp;</th>
				</tr>
			</thead>
			<!-- BEGIN: generate_page -->
			<tfoot>
				<tr>
					<td class="text-center" colspan="5">{NV_GENERATE_PAGE}</td>
				</tr>
			</tfoot>
			<!-- END: generate_page -->
			<tbody>
				<!-- BEGIN: loop -->
				<tr>
					<td> {VIEW.number} </td>
					<td> {VIEW.domain_id} </td>
					<td> {VIEW.name} </td>
					<td> {VIEW.password} </td>
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
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.domain_id}</strong> <span class="red">(*)</span></label>
		<div class="col-sm-19 col-md-20">
			<select class="form-control" name="domain_id">
				<option value=""> --- </option>
				<!-- BEGIN: select_domain_id -->
				<option value="{OPTION.key}" {OPTION.selected}>{OPTION.title}</option>
				<!-- END: select_domain_id -->
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.name}</strong> <span class="red">(*)</span></label>
		<div class="col-sm-19 col-md-20">
			<input class="form-control" type="text" name="name" value="{ROW.name}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.password}</strong> <span class="red">(*)</span></label>
		<div class="col-sm-19 col-md-20">
			<input class="form-control" type="password" name="password" value="{ROW.password}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.title}</strong></label>
		<div class="col-sm-19 col-md-20">
			<input class="form-control" type="text" name="title" value="{ROW.title}" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.full_name}</strong> <span class="red">(*)</span></label>
		<div class="col-sm-19 col-md-20">
			<input class="form-control" type="text" name="full_name" value="{ROW.full_name}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.status}</strong> <span class="red">(*)</span></label>
		<div class="col-sm-19 col-md-20">
			<select class="form-control" name="status">
				<option value=""> --- </option>
				<!-- BEGIN: select_status -->
				<option value="{OPTION.key}" {OPTION.selected}>{OPTION.title}</option>
				<!-- END: select_status -->
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.telephone}</strong></label>
		<div class="col-sm-19 col-md-20">
			<input class="form-control" type="text" name="telephone" value="{ROW.telephone}" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.mobile}</strong></label>
		<div class="col-sm-19 col-md-20">
			<input class="form-control" type="text" name="mobile" value="{ROW.mobile}" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.company}</strong></label>
		<div class="col-sm-19 col-md-20">
			<input class="form-control" type="text" name="company" value="{ROW.company}" />
		</div>
	</div>
	<div class="form-group" style="text-align: center"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
</form>
</div></div>
<!-- END: main -->