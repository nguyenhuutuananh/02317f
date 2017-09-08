<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
        <form role="form" method="post" action="<?php echo admin_url('clients/mail')?>">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                    <h1><a href="#" title="CRM">Sms Marketing</a></h1>
                      <h2></h2>
                      
                         <?php 
                               if(isset($message_display)){?>
                                   <div class="alert alert-info">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>info!</strong> <?php echo $message_display; ?>
                                  </div>
                          <?php     }
                         ?>
                        <div class="form-group">
                          <label for="user_email">Sms SDT người gữi:</label>
                          <input type="email" class="form-control" id="user_email" name="user_email" value="0164974794" placeholder="Nhập email của bạn..." required>
                        </div>
                       <!--  <div class="form-group">
                          <label for="user_password">Password:</label>
                          <input type="password" class="form-control" id="user_password" name="user_password" value="Never06Mind" placeholder="Nhập mật khẩu của bạn..." required>
                        </div> -->
                        <div class="form-group">
                          <label for="to_email">Sms SDT người nhận:</label>
                          <input type="email" class="form-control" id="to_email" name="to_email"  value="" placeholder="Nhập email người nhận..." >
                        </div>
                        <div class="form-group">
                          <label for="subject">Chủ đề:</label>
                          <input type="text" class="form-control" id="subject" name="subject"  value="" placeholder="Nhập chủ đề của bạn..." >
                        </div>
                       <div class="form-group">
                          <label for="message">Tin nhắn:</label>
                          <textarea name="message" id="message" rows="5" cols="88" placeholder="Tin nhắn gì...." value="" ></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Gửi</button>
                             
                    </div>
                </div>
                <div class="panel_s">
                  <div class="panel-body">
                      <?php
                       $table_data = array();
                       $_table_data = array(
                          _l('clients_list_company'),
                          _l('contact_primary'),
                          _l('company_primary_email'),
                          _l('clients_list_phone'),
                          _l('customer_active'),
                          _l('customer_groups'),
                          );
                       foreach($_table_data as $_t){
                          array_push($table_data,$_t);
                      }
                      array_unshift($table_data,'<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="clients"><label></label></div>');

                      $custom_fields = get_custom_fields('customers',array('show_on_table'=>1));
                      foreach($custom_fields as $field){
                          array_push($table_data,$field['name']);
                      }

                      $table_data = do_action('customers_table_columns',$table_data);

                      $_op = _l('options');

                      array_push($table_data, $_op);
                      render_datatable($table_data,'clients');
                      ?>
                  </div>
               </div>          
            </div>
          </form> 
        </div>
    </div>
</div>

<?php init_tail(); ?>
<script>
    var do_alert = setTimeout(function(){
        $('.alert.alert-info').hide();
    }, 3000);
 
    function clearAlert()
    {
        clearTimeout(do_alert);
    }

var CustomersServerParams = {};
 //    $.each($('._hidden_inputs._filters input'),function(){
 //     CustomersServerParams[$(this).attr('name')] = '[name="'+$(this).attr('name')+'"]';
 // });
    var headers_clients = $('.table-clients').find('th');
    var not_sortable_clients = (headers_clients.length - 1);
    initDataTable('.table-clients', window.location.href, [not_sortable_clients,0], [not_sortable_clients,0], CustomersServerParams,<?php echo do_action('customers_table_default_order',json_encode(array(1,'ASC'))); ?>);

</script>
</body>
</html>
