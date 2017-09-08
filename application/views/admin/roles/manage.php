<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body _buttons">
						<a href="<?php echo admin_url('roles/role'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_role'); ?></a>
					</div>
				</div>
				<div class="panel_s">
					<div class="panel-body">
						<div class="clearfix"></div>
						<?php render_datatable(array(
							_l('roles_dt_name'),
							_l('Mã vai trò'),
							_l('type_roles'),
							_l('options')
							),'roles'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php init_tail(); ?>
	<script>
	initDataTable('.table-roles', window.location.href, [1], [1]);
		function update_type_role(id)
		{
			var type="";
			if($('#type-'+id).prop("checked") == true){
				type=1;
			}
			else if($('#type-'+id).prop("checked") == false){
				type=0;
			}
			datastring={id:id,type:type};
			jQuery.ajax({
				type: "post",
				url: "<?=admin_url()?>roles/update_type_role" ,
				data: datastring,
				cache: false,
				success: function (data) {
					data = JSON.parse(data);
					if (data.success == true) {
						alert_float('success', data.message);
					}
					else
					{
						alert_float('warning', response.message);
					}
					return false;
				}
			});

		}
	</script>
</body>
</html>
