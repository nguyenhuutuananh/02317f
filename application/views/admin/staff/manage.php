<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<?php if(has_permission('staff','','create')){ ?>
				<div class="panel_s">
					<div class="panel-body _buttons">
<!--						--><?php //if(is_admin()&& $_SESSION['rule']==1){?>
<!--							<a href="--><?php //echo admin_url('staff/member'); ?><!--" class="btn btn-info mright5 test pull-left display-block">--><?php //echo _l('export_money_bonus'); ?><!--</a>-->
<!--						--><?php //}?>
						<a href="<?php echo admin_url('staff/member'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_staff'); ?></a>
					</div>
				</div>
				<?php } ?>
				<div class="panel_s">
					<div class="panel-body">
						<div class="clearfix"></div>
						<?php
						$table_data = array(
							_l('Mã nhân viên'),
							_l('staff_dt_name'),
							_l('staff_dt_email'),
							_l('Bộ phận'),
							_l('Nhân viên quản lý'),
							_l('staff_dt_last_Login'),
							_l('setting_rule'),
							_l('staff_dt_active'),
							);
						$custom_fields = get_custom_fields('staff',array('show_on_table'=>1));
						foreach($custom_fields as $field){
							array_push($table_data,$field['name']);
						}
						array_push($table_data,_l('options'));
						render_datatable($table_data,'staff');
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="delete_staff" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<?php echo form_open(admin_url('staff/delete',array('delete_staff_form'))); ?>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo _l('delete_staff'); ?></h4>
			</div>
			<div class="modal-body">
				<div class="delete_id">
					<?php echo form_hidden('id'); ?>
				</div>
				<p><?php echo _l('delete_staff_info'); ?></p>
				<?php
				echo render_select('transfer_data_to',$staff_members,array('staffid',array('firstname','lastname')),'staff_member',get_staff_user_id(),array(),array(),'','',false);
				?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
				<button type="submit" class="btn btn-danger _delete"><?php echo _l('confirm'); ?></button>
			</div>
		</div><!-- /.modal-content -->
		<?php echo form_close(); ?>
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php init_tail(); ?>
<script>
	$(function(){
		var headers_staff = $('.table-staff').find('th');
		var not_sortable_staff = (headers_staff.length - 1);
		initDataTable('.table-staff', window.location.href, [not_sortable_staff], [not_sortable_staff]);
	});
	function delete_staff_member(id){
		$('#delete_staff').modal('show');
		$('#transfer_data_to').find('option').prop('disabled',false);
		$('#transfer_data_to').find('option[value="'+id+'"]').prop('disabled',true);
		$('#delete_staff .delete_id input').val(id);
		$('#transfer_data_to').selectpicker('refresh');
	}
</script>
</body>
</html>