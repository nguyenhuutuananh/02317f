<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">

              <?php echo form_open(admin_url('newview/add'),array('id'=>"insert_menu")); ?>
                <div class="row">
                      <div class="col-md-3">
                          <button type="button" onclick="clear_input()" class="btn btn-info btn-lg" data-toggle="modal" data-target="#view_render">Thêm</button>
                          <div class="modal fade" id="view_render" role="dialog">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h4 class="modal-title">Thêm bất động sản</h4>
                                      </div>
                                      <div class="modal-body">
                                          <?php echo render_input('Menu_name','Tên Loại BDS'); ?>
                                          <?php echo render_select('menu_chil[]',$exigency,array('id','name'),'','',array('multiple'=>true)); ?>
                                          <table class="table table-hover">
                                              <thead>
                                                  <th>Trường</th>
                                                  <th class="text-center">hiển thị trên bảng</th>
                                                  <th class="text-center">Hiên thị trên form</th>
                                              </thead>
                                              <tbody>
                                              <?php foreach($field as $rom=>$value){?>
                                                  <tr>
                                                      <td><?=$value['name']?></td>
                                                      <td class="text-center">
                                                          <div class="checkbox checkbox-primary" id="required_wrap">
                                                              <input type="checkbox" name="fields_table[menu_bds][<?=$value['id']?>]" id="<?=$value['id_field']?>_table">
                                                              <label for="required"></label>
                                                          </div>
                                                      </td class="text-center">
                                                      <td class="text-center">
                                                          <div class="checkbox checkbox-primary" id="required_wrap">
                                                              <input type="checkbox" name="fields_form[menu_bds][<?=$value['id']?>]" id="<?=$value['id_field']?>_from">
                                                              <label for="required"></label>
                                                          </div>
                                                      </td>
                                                  </tr>
                                              <?php }?>
                                              <tr>
                                                  <td>Quận/Huyện</td>
                                                  <td class="text-center">
                                                      <div class="checkbox checkbox-primary" id="required_wrap">
                                                          <input type="checkbox" name="district_table" id="district_table" value="1">
                                                          <label for="required"></label>
                                                      </div>
                                                  </td class="text-center">
                                                  <td class="text-center">
                                                      <div class="checkbox checkbox-primary" id="required_wrap">
                                                          <input type="checkbox" name="district_from" id="district_from" value="1">
                                                          <label for="required"></label>
                                                      </div>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td>Thành Phố</td>
                                                  <td class="text-center">
                                                      <div class="checkbox checkbox-primary" id="required_wrap">
                                                          <input type="checkbox" name="province_table" id="province_table" value="1">
                                                          <label for="required"></label>
                                                      </div>
                                                  </td class="text-center">
                                                  <td class="text-center">
                                                      <div class="checkbox checkbox-primary" id="required_wrap">
                                                          <input type="checkbox" name="province_from" id="province_from" value="1">
                                                          <label for="required"></label>
                                                      </div>
                                                  </td>
                                              </tr>
                                              </tbody>
                                          </table>
                                      </div>
                                      <div class="modal-footer">
                                          <button type="submit" data-form="#new_ticket_form" autocomplete="off" data-loading-text="<?php echo _l('wait_text'); ?>" class="btn btn-info"><?php echo _l('submit'); ?></button>
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                  </div>

                              </div>
                          </div>
                     </div>
                </div>
              <?php echo form_close(); ?>

        </div>
      </div>

       <div class="row">
               <div class="col-md-12" id="small-table">
                  <div class="panel_s">
                     <div class="panel-body">
                        <div class="clearfix"></div>
                      <?php
                 $table_data = array();
                 $_table_data = array(
                   'Loại bất động sản',
                    );
                 foreach($_table_data as $_t){
                    array_push($table_data,$_t);
                }
                array_unshift($table_data,'<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="clients"><label></label></div>');

//                $custom_fields = get_fields('menu_bds',array('show_on_table'=>1));
//                foreach($custom_fields as $field){
//
//                    array_push($table_data,$field['name']);
//
//                }

                $_op = _l('options');

                array_push($table_data, $_op);
                render_datatable($table_data,'clients');

                ?>
                      

                     </div>
                  </div>
               </div>
               <div class="col-md-7 small-table-right-col">
                  <div id="expense" class="hide">
                  </div>
               </div>
            </div>
      </div>
    </div>
  </div>
</div>
      <?php init_tail(); ?>
          <script>
              $(function() {
                  _validate_form($('#insert_menu'), {
                      code_menu: 'required',
                      Menu_name: 'required',
                  }, managa_upload);
              });
              function managa_upload(form) {
                  var data = $(form).serialize();
                  var url = form.action;
                  $.post(url, data).done(function(response) {
                      console.log(response);
                      response=JSON.parse(response);
                      if(response.success){
                          alert_float('success', response.message);
                      }
                      else
                      {
                          alert_float('danger', response.message);
                      }
                  });
                  return false;
              }
          </script>
      <?php echo app_script('assets/js','tickets.js'); ?>
    </body>
    </html>
<script>
    $(function() {
        _validate_form($('#insert_menu'), {
            Menu_name: 'required',
            menu_chil: 'required'
        }, managa_upload);
    });
    function managa_upload(form) {
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            console.log(response);
            response=JSON.parse(response);
            if(response.success){
                $('.table-clients').DataTable().ajax.reload();
                alert_float('success', response.message);
                $('#insert_menu').model('hide');
            }
            else
            {
                alert_float('danger', response.message);
            }
        });
        return false;
    }
    function clear_input()
    {
        $('#insert_menu').prop('action','<?=admin_url()?>newview/add');
        $('#Menu_name').val('');
        $('input:checkbox').prop('checked','');
    }


    function add_render()
    {
        $('#return_render').html('');
        var data = $('#get_render').serialize();
        var url = $('#get_render').prop('action');
        jQuery.ajax({
            dataType: "json",
            type: "post",
            url: url,
            data: data,
            cache: false,
            success: function (data) {
                console.log(data);
                $.each(data, function(index, value) {
                    if(value.id)
                    {
                        if(!$('#'+value.id_field+'_'+value.id).length)
                        {
                            $('#return_render').append(value.data);
                            $('#return_render input').prop('readonly','true');
                            $('#check_add_render').modal('hide');
                        }
                        else
                        {
                            $('#check_add_render').modal('hide');
                        }
                    }

                });
            }
        });
    }
    function get_data(id)
    {
        $('#return_render').html('');
        var url = '<?=admin_url()?>newview/get_menu/'+id;
        jQuery.ajax({
            dataType: "json",
            type: "post",
            url: url,
            data: '',
            cache: false,
            success: function (data) {
                console.log(data[1]);
                $('#Menu_name').val(data[1].menu_name);
                $('#insert_menu').prop('action','<?=admin_url()?>newview/add/'+id);
                var res = data[1].menu_chil.split(",");
                $('select[name=menu_chil\\[\\]]').selectpicker('val', res).selectpicker('refresh');


                console.log(data[1].province_table);
                if(data[1].province_table=='1')
                {
                    $('#province_table').prop('checked','checked');
                }
                else
                {
                    $('#province_table').prop('checked','');
                }
                if(data[1].province_from=='1')
                {
                    $('#province_from').prop('checked','checked');
                }
                else
                {
                    $('#province_from').prop('checked','');
                }
                if(data[1].district_table=='1')
                {
                    $('#district_table').prop('checked','checked');
                }
                else
                {
                    $('#district_table').prop('checked','');
                }
                if(data[1].province_from=='1')
                {
                    $('#district_from').prop('checked','checked');
                }
                else
                {
                    $('#district_from').prop('checked','');
                }
                $.each($(data[0]), function(index, value) {
                    if(value.fields_from=="1")
                    {
                        $('#'+value.id_field+'_from').prop('checked','checked');
                    }
                    else
                    {
                        $('#'+value.id_field+'_from').prop('checked','');
                    }

                    if(value.fields_table=="1")
                    {
                        $('#'+value.id_field+'_table').prop('checked','checked');
                    }
                    else
                    {
                        $('#'+value.id_field+'_table').prop('checked','');
                    }
                })
            }
        });
    }









    $("select[name=menu_chil\\[\\]] option[value='']").remove().selectpicker('refresh');
    var CustomersServerParams = {};
    $.each($('._hidden_inputs._filters input'),function(){
     CustomersServerParams[$(this).attr('name')] = '[name="'+$(this).attr('name')+'"]';
 });
    var headers_clients = $('.table-clients').find('th');
    var not_sortable_clients = (headers_clients.length - 1);
    initDataTable('.table-clients', window.location.href, [not_sortable_clients,0], [not_sortable_clients,0], CustomersServerParams,<?php echo do_action('customers_table_default_order',json_encode(array(1,'ASC'))); ?>);

    function customers_bulk_action(event) {
        var r = confirm(confirm_action_prompt);
        if (r == false) {
            return false;
        } else {
            var mass_delete = $('#mass_delete').prop('checked');
            var ids = [];
            var data = {};
            if(mass_delete == false || typeof(mass_delete) == 'undefined'){
                data.groups = $('select[name="move_to_groups_customers_bulk[]"]').selectpicker('val');
                if (data.groups.length == 0) {
                    data.groups = 'remove_all';
                }
            } else {
                data.mass_delete = true;
            }
            var rows = $('.table-clients').find('tbody tr');
            $.each(rows, function() {
                var checkbox = $($(this).find('td').eq(0)).find('input');
                if (checkbox.prop('checked') == true) {
                    ids.push(checkbox.val());
                }
            });
            data.ids = ids;
            $(event).addClass('disabled');
            setTimeout(function(){
              $.post(admin_url + 'clients/bulk_action', data).done(function() {
                 window.location.reload();
             });
          },50);
        }
    }

   $(document).ready(function(){
setInterval(function(){
$("#screen").load('banners.php')
}, 2000);
});


    $(document).on('click', '#edit_menu', function(){

        id=$(this).data("id");
        jQuery.ajax({
            dataType: "json",
            type: "post",
            url: "<?=admin_url()?>newview/get_menubds/"+id,
            data: '',
            cache: false,
            success: function (data) {
                if(data)
                {
                    $('#menu_name').val(data.menu_name);
                    $('#update_menu_bds').prop('action','<?=admin_url()?>newview/update_menu_bds/'+id);
                    var res = data.menu_chil.split(",");
                    $('select[name=menu_chil\\[\\]]').selectpicker('val', res).selectpicker('refresh');
                }
            }
        });
    });


</script>