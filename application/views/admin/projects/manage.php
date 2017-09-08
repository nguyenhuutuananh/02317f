<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body _buttons">
            <?php if(has_permission('projects','','create')){ ?>
              <a class="btn btn-info pull-left display-block" onclick="new_project()" data-toggle="modal" data-target="#add_project">
                <?php echo _l('new_project'); ?>
              </a>
              <?php } ?>
              <div class="btn-group pull-right mleft4 btn-with-tooltip-group _filter_data" data-toggle="tooltip" data-title="<?php echo _l('filter_by'); ?>">
                </div>
              </div>
            </div>
            <div class="panel_s">
              <div class="panel-body">
             <div class="clearfix"></div>
             <hr />
             <?php echo form_hidden('custom_view'); ?>
             <?php
             $table_data = array(
              '#',
              _l('Mã tiếp đầu ngữ'),
              _l('Tên dự án'),
              _l('Loại bất động sản'),
              _l('Ngày tạo')
              );
              array_push($table_data, _l('options'));

            render_datatable($table_data,'projects'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="add_project" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url().'projects/project',array('id'=>'project_form')); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="bold no-margin font-medium">Thêm dự án</h4>
                </div>
                <div class="modal-body">
                        <div class="panel_s">
                            <?php echo render_input('code_project','Mã tiếp đầu ngữ dự án','','text'); ?>
                            <?php echo render_input('name','project_name','','text'); ?>
                            <?php echo render_select('id_menu',$menu_id,array('id','menu_name'),'Danh sách Loại BDS',''); ?>

                        </div>
                        <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
    <!--                <button type="submit" data-form="#project_form" class="btn btn-info" autocomplete="off" data-loading-text="--><?php //echo _l('wait_text'); ?><!--">--><?php //echo _l('submit'); ?><!--</button>-->
                    <button type="submit" id="btnadd_project" class="btn btn-info"><?php echo _l('submit'); ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        <?php echo form_close(); ?>

    </div>
</div>
<?php init_tail(); ?>
<script>
 initDataTable('.table-projects', window.location.href, [4], [4]);
 <?php if(isset($project)){ ?>
 var original_project_status = '<?php echo $project->status; ?>';
 <?php } ?>


 $(function() {
     _validate_form($('#project_form'), {
         code_project: 'required',
         name: 'required',
     }, managa_upload);
 });
 function managa_upload(form) {
     var data = $(form).serialize();
     var url = form.action;
     $.post(url, data).done(function(response) {
         response=JSON.parse(response);
         if(response.success){
             alert_float('success', response.message);
             $('.table-projects').DataTable().ajax.reload();
             $('#add_project').modal('hide');
         }
         else
         {
             alert_float('danger', response.message);
         }
     });
     return false;
 }
    function view_project(id)
    {
        jQuery.ajax({
            type: "post",
            url: "<?=admin_url()?>projects/get_project",
            data: {id:id},
            dataType: "json",
            cache: false,
            success: function (data) {
                $('#code_project').val(data.code_project);
                $('#name').val(data.name);
                $('#id_menu').val(data.id_menu).selectpicker('refresh');;
                $('#project_form').prop('action','<?=admin_url()?>projects/project/'+id);

            }
        });

    }
    function new_project()
    {
        $('#code_project').val('');
        $('#name').val('');
        $('#project_form').prop('action','<?=admin_url()?>projects/project/');
    }
</script>
</body>
</html>
