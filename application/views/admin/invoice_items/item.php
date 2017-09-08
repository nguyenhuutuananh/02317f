<div class="modal fade" id="sales_item_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l('invoice_item_edit_heading'); ?></span>
                    <span class="add-title"><?php echo _l('invoice_item_add_heading'); ?></span>
                </h4>
            </div>
            <?php echo form_open('admin/invoice_items/manage',array('id'=>'invoice_item_form')); ?>
            <?php echo form_hidden('itemid'); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-warning affect-warning hide">
                            <?php echo _l('changing_items_affect_warning'); ?>
                        </div>
                        <?php echo render_input('description','invoice_item_add_edit_description'); ?>
                        <div class="form-group"  >
                            <label class="control-label" for="landtype">Loại nhà đất</label>
                            <select class="selectpicker display-block" data-width="100%" name="landtypeid"
                            id="landtypeid" title='Chọn loại nhà đất' data-none-selected-text="Chưa chọn loại nhà đất">
                                <option value=""></option>
                                <?php 
                                foreach($landtype as $lt){ 
                                    $rs=0;
                                    if($lt['parentid']==0){
                                ?>
                                    <?php foreach ($landtype as  $value) {
                                        if($value['parentid']==$lt['id'])
                                            {$rs=1;break;}
                                    } 
                                    if($rs==0){
                                    ?>

                                    <option value="<?php echo $lt['id']; ?>"><?php echo $lt['name']; ?></option>
                                    <?php } 
                                    else {
                                    
                                    ?>
                                    <optgroup label="<?php echo $lt['name']; ?>">
                                       <?php 

                                        foreach($landtype as $ltsupp){ 
                                            
                                            if($ltsupp['parentid']==$lt['id']){

                                        ?>

                                            <option value="<?php echo $ltsupp['id']; ?>" ><?php echo $ltsupp['name']; ?></option>
                                        <?php   }}  ?>
                                    </optgroup>
                                    
                                <?php } }   ?>
                                <?php } ?>
                                    
                            </select>
                        </div>
                       <!--  <?php echo render_select('provinceid',$provinces,array('provinceid','name'),'Tỉnh/Thành phố')?> -->
                        <div class="form-group">  
                            <label class="control-label" for="provinceid">Tỉnh/thành phố</label>
                            <select class="selectpicker display-block" data-width="100%" name="provinceid" 
                            id="provinceid" title='---Chọn tỉnh/thành phố---' data-none-selected-text="Chưa chọn tỉnh/thành phố" >
                                <option value=""></option>
                                <?php foreach($provinces as $province){ ?>
                                <option value="<?php echo $province['provinceid']; ?>" ><?php echo  $province['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group"> 

                            <label class="control-label" for="district_id">Quận/huyện</label>

                            <select class="form-control" data-width="100%" name="district_id" id="district_id" title='---Chọn quận/huyện---' data-none-selected-text="Chưa chọn quận/huyện'); ?>">
                                <option value=""></option>

                                <?php foreach($districts as $dt){ ?>
                                <option value="<?php echo $dt['districtid']; ?>">
                                <?php echo $dt['name']; ?> </option> 

                                <?php }  ?>

                            </select>
                        </div>

                        <?php echo render_textarea('long_description','invoice_item_long_description'); ?>
                        <?php echo render_input('rate','invoice_item_add_edit_rate','','number'); ?>
                        <div class="form-group">
                            <label class="control-label" for="tax"><?php echo _l('invoice_item_add_edit_tax'); ?></label>
                            <select class="selectpicker display-block" data-width="100%" name="tax" title='<?php echo _l('invoice_item_add_edit_tax_select'); ?>' data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                <option value=""></option>
                                <?php foreach($taxes as $tax){ ?>
                                <option value="<?php echo $tax['id']; ?>" data-subtext="<?php echo $tax['name']; ?>"><?php echo $tax['taxrate']; ?>%</option>
                                <?php } ?>
                            </select>
                        </div>
                  
                         <?php echo render_input('unit','unit'); ?>

                        <?php echo render_select('group_id',$items_groups,array('id','name'),'item_group'); ?>
                        <div class="clearfix mbot15"></div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
 <script type="text/javascript">
 
    function remove_validate()
          {
              var result;
              var url = "{{url('qty-valid')}}";
              var mvid = $("#rmid").val();
              var loc1 = $("#loc_rm").val();
              var qty = $("#qtyremove").val();
              var token = $("#token-rm").val();

              $.ajax({
                          url   :url,
                          async : false,
                          data:{                  // data that will be sent
                              _token:token,
                              mvid:mvid,
                              loc1:loc1,
                              qty:qty
                          },
                          type:"POST",
                          dataType: "JSON",            // type of submision
                          success:function(data){
                              console.log(data.fail);

                              if (data.fail == 1) {
                                  $("#val_error").html('<span style="color:red">You can not remove more than '+data.stock+' item</span>');
                                  result = 0;
                              } else {
                                  $("#val_error").html('');
                                  result = 1;
                              }
                          },
                           error: function(xhr, desc, err) {
                              
                              return 0;
                          }
                      });
              return result;
          }
 // });

</script>