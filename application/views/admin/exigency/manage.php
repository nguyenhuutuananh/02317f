<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body _buttons">
						<a href="javacript:void(0)" onclick="clear_data()" data-toggle="modal" data-target="#model_exigency" class="btn btn-info pull-left display-block"><?php echo _l('Thêm nhu cầu mới'); ?></a>
					</div>
				</div>
				<div class="panel_s">
					<div class="panel-body">
						<div class="clearfix"></div>
						<?php render_datatable(array(
							_l('id'),
							_l('Nhu cầu'),
							_l('options')
							),'exigency'); ?>
						</div>
					</div>
				</div>
				<div id="model_exigency" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<?php echo form_open(admin_url('exigency/exigency'),array('id'=>'exigency_form','autocomplete'=>'off')); ?>
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Thêm nhu cầu</h4>
								</div>
								<div class="modal-body">
									<?php echo render_input('name','Tên nhu cầu');?>
								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-info">Lưu</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							<?php echo form_close()?>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<?php init_tail(); ?>
	<script>
	initDataTable('.table-exigency', window.location.href, [2], [2]);
		function view_exigency(id)
		{
			jQuery.ajax({
				type: "post",
				url: "<?=admin_url()?>exigency/exigency/"+id ,
				data: '',
				cache: false,
				success: function (data) {
					data = JSON.parse(data);
					$('#name').val(data[0].name);
					$('#exigency_form').prop('action','<?=admin_url()?>exigency/exigency/'+data[0].id);
				}
			});

		}
		function clear_data()
		{
			$('#name').val('');
			$('#exigency_form').prop('action','<?=admin_url()?>exigency/exigency');
		}
	</script>
</body>
</html>
