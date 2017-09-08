<?php init_head(); ?>
<div id="wrapper">
 <div class="content accounting-template">
  <div class="row">
   <?php
   if(isset($proposal)){
    echo form_hidden('isedit',$proposal->id);
  }
  $rel_type = '';
  $rel_id = '';
  if(isset($proposal) || ($this->input->get('rel_id') && $this->input->get('rel_type'))){
    if($this->input->get('rel_id')){
      $rel_id = $this->input->get('rel_id');
      $rel_type = $this->input->get('rel_type');
    } else {
      $rel_id = $proposal->rel_id;
      $rel_type = $proposal->rel_type;
    }
  }
  ?>
  <?php echo form_open($this->uri->uri_string(),array('id'=>'proposal-form','class'=>'_transaction_form')); ?>
  <div class="col-md-12">
    <div class="panel_s">
     <div class="panel-body">
       <?php if(isset($proposal) && count($proposal->items) == 0 && $proposal->total > 0){ ?>
       <div class="alert alert-warning">
         Proposal <b>total</b> field wont be used anymore from version 1.2.9 because we added items feature for the proposal to simplify the process when converting the proposal to estimate and invoice. You should add items to fit the total for your needs. In all previous created proposals the total still be shown on proposal view but if you click SAVE (at the bottom of the page) from this area and dont add items the proposal total will be reset to 0.
       </div>
       <?php } ?>
       <div class="row">
        <?php if(isset($proposal)){ ?>
        <div class="col-md-12">
          <?php echo format_proposal_status($proposal->status); ?>
          <hr />
        </div>
        <?php } ?>

        <div class="col-md-6 border-right">
          <?php $value = (isset($proposal) ? $proposal->subject : ''); ?>
          <?php $attrs = (isset($proposal) ? array() : array('autofocus'=>true)); ?>
          <?php echo render_input('subject','proposal_subject',$value,'text',$attrs); ?>
          <div class="form-group">
           <label for="rel_type" class="control-label"><?php echo _l('proposal_related'); ?></label>
           <select name="rel_type" id="rel_type" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
            <option value=""></option>
            <option value="lead" <?php if((isset($proposal) && $proposal->rel_type == 'lead') || $this->input->get('rel_type')){if($rel_type == 'lead'){echo 'selected';}} ?>><?php echo _l('proposal_for_lead'); ?></option>
            <option value="customer" <?php if((isset($proposal) &&  $proposal->rel_type == 'customer') || $this->input->get('rel_type')){if($rel_type == 'customer'){echo 'selected';}} ?>><?php echo _l('proposal_for_customer'); ?></option>
          </select>
        </div>
        <div class="form-group<?php if($rel_id == ''){echo ' hide';} ?>" id="rel_id_wrapper">
         <label for="rel_id"><span class="rel_id_label"></span></label>
         <div id="rel_id_select">
           <select name="rel_id" id="rel_id" class="selectpicker" data-width="100%" data-live-search="true" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
            <?php if($rel_id != '' && $rel_type != ''){
              $rel_data = get_relation_data($rel_type,$rel_id);
              $rel_val = get_relation_values($rel_data,$rel_type);
              echo '<option value="'.$rel_val['id'].'">'.$rel_val['name'].'</option>';
            } ?>
          </select>
        </div>
      </div>
      <?php $value = (isset($proposal) ? _d($proposal->date) : _d(date('Y-m-d'))) ?>
      <?php echo render_date_input('date','proposal_date',$value); ?>
      <?php $value = (isset($proposal) ? _d($proposal->open_till) : (get_option('proposal_due_after') != 0) ? _d(date('Y-m-d',strtotime('+'.get_option('proposal_due_after').' DAY',strtotime(date('Y-m-d'))))) : ''); ?>
      <?php echo render_date_input('open_till','proposal_open_till',$value); ?>

      <?php
      $selected = '';
      $s_attrs = array();
      foreach($currencies as $currency){
       if($currency['isdefault'] == 1){
         $s_attrs['data-base'] = $currency['id'];
       }
       if(isset($proposal)){
         if($currency['id'] == $proposal->currency){
           $selected = $currency['id'];
         }
         if($proposal->rel_type == 'customer'){
           $s_attrs['disabled'] = true;
         }
       } else {
         if($rel_type == 'customer'){
           $customer_currency = $this->clients_model->get_customer_default_currency($rel_id);
           if($customer_currency != 0){
             $selected = $customer_currency;
           } else {
             if($currency['isdefault'] == 1){
               $selected = $currency['id'];
             }
           }
           $s_attrs['disabled'] = true;
         } else {
          if($currency['isdefault'] == 1){
           $selected = $currency['id'];
         }
       }
     }
   }
   ?>
   <?php echo render_select('currency',$currencies,array('id','name','symbol'),'proposal_currency',$selected,$s_attrs);
   ?>

   <div class="form-group">
     <label for="discount_type" class="control-label"><?php echo _l('discount_type'); ?></label>
     <select name="discount_type" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
      <option value="" selected><?php echo _l('no_discount'); ?></option>
      <option value="before_tax" <?php
      if(isset($estimate)){ if($estimate->discount_type == 'before_tax'){ echo 'selected'; }}?>><?php echo _l('discount_type_before_tax'); ?></option>
      <option value="after_tax" <?php if(isset($estimate)){if($estimate->discount_type == 'after_tax'){echo 'selected';}} ?>><?php echo _l('discount_type_after_tax'); ?></option>
    </select>
  </div>

  <?php $fc_rel_id = (isset($proposal) ? $proposal->id : false); ?>
  <?php echo render_custom_fields('proposal',$fc_rel_id); ?>

  <div class="form-group">
   <div class="checkbox checkbox-primary" data-toggle="tooltip" title="<?php echo _l('proposal_allow_comments_help'); ?>">
    <input type="checkbox" name="allow_comments" id="allow_comments" <?php if(isset($proposal)){if($proposal->allow_comments == 1){echo 'checked';}}; ?>>
    <label for="allow_comments"><?php echo _l('proposal_allow_comments'); ?></label>
  </div>
</div>

</div>
<div class="col-md-6">
 <div class="form-group">
  <label for="tags" class="control-label"><i class="fa fa-tag" aria-hidden="true"></i> <?php echo _l('tags'); ?></label>
  <input type="text" class="tagsinput" id="tags" name="tags" value="<?php echo (isset($proposal) ? prep_tags_input(get_tags_in($proposal->id,'proposal')) : ''); ?>" data-role="tagsinput">
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
     <label for="status" class="control-label"><?php echo _l('proposal_status'); ?></label>
     <?php
     $disabled = '';
     if(isset($proposal)){
      if($proposal->estimate_id != NULL || $proposal->invoice_id != NULL){
        $disabled = 'disabled';
      }
    }
    ?>
    <select name="status" class="selectpicker" data-width="100%" <?php echo $disabled; ?> data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
      <?php foreach($statuses as $status){ ?>
      <option value="<?php echo $status; ?>" <?php if((isset($proposal) && $proposal->status == $status) || (!isset($proposal) && $status == 0)){echo 'selected';} ?>><?php echo format_proposal_status($status,'',false); ?></option>
      <?php } ?>
    </select>
  </div>
</div>

<div class="col-md-6">
  <?php
  $i = 0;
  $selected = '';
  foreach($staff as $member){
   if(isset($proposal)){
     if($proposal->assigned == $member['staffid']) {
       $selected = $member['staffid'];
     }
   }
   $i++;
 }
 echo render_select('assigned',$staff,array('staffid',array('firstname','lastname')),'proposal_assigned',$selected);
 ?>
</div>

</div>
<?php $value = (isset($proposal) ? $proposal->proposal_to : ''); ?>
<?php echo render_input('proposal_to','proposal_to',$value); ?>
<?php $value = (isset($proposal) ? $proposal->address : ''); ?>
<?php echo render_input('address','proposal_address',$value); ?>
<div class="row">
  <div class="col-md-6">
   <?php $value = (isset($proposal) ? $proposal->city : ''); ?>
   <?php echo render_input('city','billing_city',$value); ?>
 </div>
 <div class="col-md-6">
   <?php $value = (isset($proposal) ? $proposal->state : ''); ?>
   <?php echo render_input('state','billing_state',$value); ?>
 </div>

 <div class="col-md-6">
  <?php $countries = get_all_countries(); ?>
  <?php $selected = (isset($proposal) ? $proposal->country : ''); ?>
  <?php echo render_select('country',$countries,array('country_id',array('short_name'),'iso2'),'billing_country',$selected); ?>
</div>
<div class="col-md-6">
 <?php $value = (isset($proposal) ? $proposal->zip : ''); ?>
 <?php echo render_input('zip','billing_zip',$value); ?>
</div>
<div class="col-md-6">
 <?php $value = (isset($proposal) ? $proposal->email : ''); ?>
 <?php echo render_input('email','proposal_email',$value); ?>
</div>
<div class="col-md-6">
  <?php $value = (isset($proposal) ? $proposal->phone : ''); ?>
  <?php echo render_input('phone','proposal_phone',$value); ?>
</div>
</div>


</div>
</div>
</div>
</div>
</div>
<div class="col-md-12">
  <div class="panel_s">
   <?php $this->load->view('admin/estimates/_add_edit_items'); ?>
 </div>
 <div class="panel_s">
   <div class="panel-body">
    <p class="no-mbot pull-left mtop5"><?php echo _l('include_proposal_items_merge_field_help','<b>{proposal_items}</b>'); ?></p>
    <button class="btn btn-info pull-right" type="submit"><?php echo _l('submit'); ?></button>
  </div>
</div>
</div>
<?php echo form_close(); ?>
<?php $this->load->view('admin/invoice_items/item'); ?>
</div>
</div>
</div>
<?php init_tail(); ?>
<script>
 var _rel_id = $('#rel_id'),
 _rel_type = $('#rel_type'),
 _rel_id_wrapper = $('#rel_id_wrapper'),
 data = {};

 $(function(){
  init_currency_symbol();
  _validate_form($('#proposal-form'), {
    subject : 'required',
    proposal_to : 'required',
    rel_type: 'required',
    rel_id : 'required',
    'date' : 'required',
    email: {
     email:true,
     required:true
   },
   currency : 'required',
 });
  $('body').on('change','#rel_id', function() {
   if($(this).val() != ''){
    $.get(admin_url + 'proposals/get_relation_data_values/' + $(this).val() + '/' + _rel_type.val(), function(response) {
      $('input[name="proposal_to"]').val(response.to);
      $('input[name="address"]').val(response.address);
      $('input[name="email"]').val(response.email);
      $('input[name="phone"]').val(response.phone);
      $('input[name="city"]').val(response.city);
      $('input[name="state"]').val(response.state);
      $('input[name="zip"]').val(response.zip);
      $('select[name="country"]').selectpicker('val',response.country);
      var currency_selector = $('#currency');
      if(_rel_type.val() == 'customer'){
       currency_selector.attr('disabled',true);
     } else {
       currency_selector.attr('disabled',false);
     }
     /* Check if customer default currency is passed */
     if(response.currency){
       currency_selector.selectpicker('val',response.currency);
     } else {
      /* Revert back to base currency */
      currency_selector.selectpicker('val',currency_selector.data('base'));
    }
    currency_selector.selectpicker('refresh');
    currency_selector.change();
  }, 'json');
  }
});
  $('.rel_id_label').html(_rel_type.find('option:selected').text());
  _rel_type.on('change', function() {
    var clonedSelect = _rel_id.html('').clone();
    _rel_id.selectpicker('destroy').remove();
    _rel_id = clonedSelect;
    $('#rel_id_select').append(clonedSelect);
    proposal_rel_id_select();
    if($(this).val() != ''){
      _rel_id_wrapper.removeClass('hide');
    } else {
      _rel_id_wrapper.addClass('hide');
    }
    $('.rel_id_label').html(_rel_type.find('option:selected').text());
  });
  proposal_rel_id_select();
  <?php if(!isset($proposal) && $rel_id != ''){ ?>
    _rel_id.change();
    <?php } ?>
  });
 function proposal_rel_id_select(){
  clearInterval(autocheck_notifications_timer_id);
  var options = {
    ajax: {
      url: admin_url + 'misc/get_relation_data',
      data: function () {
        data.q = '{{{q}}}';
        data.type = _rel_type.val();
        data.rel_id = _rel_id.val();
        <?php if(isset($proposal)){ ?>
         data.connection_type = 'proposal';
         data.connection_id = '<?php echo $proposal->id; ?>';
         <?php } ?>
         return data;
       }
     },
     locale: {
      emptyTitle: "<?php echo _l('search_ajax_empty'); ?>",
      statusInitialized: "<?php echo _l('search_ajax_initialized'); ?>",
      statusSearching:"<?php echo _l('search_ajax_searching'); ?>",
      statusNoResults:"<?php echo _l('not_results_found'); ?>",
      searchPlaceholder:"<?php echo _l('search_ajax_placeholder'); ?>",
      currentlySelected:"<?php echo _l('currently_selected'); ?>",
    },
    requestDelay:500,
    cache:false,
    preprocessData: function(processData){
      var bs_data = [];
      var len = processData.length;
      for(var i = 0; i < len; i++){
        var curr = processData[i];
        bs_data.push(
        {
          'value': curr.id,
          'text': curr.name,
        }
        );
      }
      return bs_data;
    },
    preserveSelectedPosition:'after',
    preserveSelected:true
  }
  _rel_id
  .selectpicker()
  .ajaxSelectPicker(options)

}
</script>
</body>
</html>
