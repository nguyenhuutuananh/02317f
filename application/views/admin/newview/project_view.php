<?php init_head(); ?>
<link href="<?= base_url() ?>assets/css/multiple-select.css" rel="stylesheet">
<style>
    .select-div{
        position: relative;
        top: 9px;
    }
    select {
        min-width: 130px!important;
    }
    .col-sm-5{
        margin-top: 40px!important;
    }
    .col-sm-7{
        margin-top: 40px!important;
    }
    .DTFC_LeftBodyWrapper{
        background-color: white!important;
    }
    .DTFC_LeftHeadWrapper{
        background-color: white!important;
    }
    .view_people {
        background-color: aliceblue!important;
    );
    .bootstrap-select {
        min-width: 160px!important;
    };
    th, td { white-space: nowrap; };

</style>
<style href="https://cdn.datatables.net/fixedcolumns/3.2.2/css/fixedColumns.dataTables.min.css"></style>
<div id="wrapper">

    <div class="content">

<!--    --><?php //echo form_open(admin_url('newview/indexproject/'.$id)); ?>
    <?php echo form_open(admin_url('newview/indexproject/' . $id)); ?>

        <div class="row">

            <div class="col-md-12">

                <div class="panel_s">

        <!-- Import -->

        <div class="panel_s">



               <div class="panel-body _buttons">


                  <div class="row">

                     <div class="row">



                       <div class="container" style="min-width: 100%;">

                           <div class="col-md-6">
                              <a href="<?= admin_url() ?>newview/project/<?= $menu->id ?>" class="btn mright5   btn-info pull-left display-block">
                                  Thêm bất động sản mới
                              </a>
                               <?php $input_header = json_decode($_COOKIE[$menu->id]);
                                ?>
                               <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#view_total"><i class="fa fa-bar-chart"></i></button>
                           </div>
                           <div class="dropdown col-md-6">
                               <a class="dropdown-toggle btn btn-default pull-right" data-toggle="dropdown" href="#">
                                   Tìm kiếm
                                   <b class="caret"></b>
                               </a>
                               <div class="dropdown-menu dropdown-menu-right col-md-9" role="menu"  style="">
                                   <div class="modal-body">
                                       <div class="clearfix"></div>
                                       <div class="col-md-12">
                                           <?php if ($_COOKIE['_where_' . $id]) {
                                                $value_where = json_decode($_COOKIE['_where_' . $id]);
                                            }
                                            ?>
                                           <div class="col-md-6">
                                               <?php $value = (isset($value_where) ? $value_where->pricestart : ''); ?>
                                               <div class="form-group">
                                                   <label for="pricestart" class="control-label ">Giá từ</label>
                                                   <input type="text" id="pricestart" name="pricestart" class="form-control" value="<?= $value ?>">
                                               </div>
                                           </div>
                                           <div class="col-md-6">
                                               <?php $value = (isset($value_where) ? $value_where->priceend : ''); ?>
                                               <div class="form-group">
                                                   <label for="priceend" class="control-label ">Giá Đến</label>
                                                   <input type="text" id="priceend" name="priceend" class="form-control" value="<?= $value ?>">
                                               </div>
                                           </div>
                                           <div class="col-md-6">
                                               <?php $value = (isset($value_where) ? $value_where->hhdstart : ''); ?>
                                               <div class="form-group">
                                                   <label for="hhdstart" class="control-label ">Thời hạn thuê từ</label>
                                                   <input type="text" id="hhdstart" name="hhdstart" class="form-control datepicker" value="<?= $value ?>">
                                               </div>
                                           </div>
                                           <div class="col-md-6">
                                               <?php $value = (isset($value_where) ? $value_where->hhdend : ''); ?>
                                               <div class="form-group">
                                                   <label for="hhdend" class="control-label ">Thời hạn thuê Đến</label>
                                                   <input type="text" id="hhdend" name="hhdend" class="form-control datepicker" value="<?= $value ?>">
                                               </div>
                                           </div>
                                           <div class="col-md-6">
                                               <?php $value = (isset($value_where) ? $value_where->pnstart : ''); ?>
                                               <div class="form-group">
                                                   <label for="pnstart" class="control-label ">Phòng ngủ từ</label>
                                                   <input type="text" id="pnstart" name="pnstart" class="form-control" value="<?= $value ?>">
                                               </div>
                                           </div>
                                           <div class="col-md-6">
                                               <?php $value = (isset($value_where) ? $value_where->pnend : ''); ?>
                                               <div class="form-group">
                                                   <label for="pnend" class="control-label ">phòng ngủ Đến</label>
                                                   <input type="text" id="pnend" name="pnend" class="form-control" value="<?= $value ?>">
                                               </div>
                                           </div>
                                           <div class="col-md-6">
                                               <?php $value = (isset($value_where) ? $value_where->laustart : ''); ?>
                                               <div class="form-group">
                                                   <label for="laustart" class="control-label ">Lầu từ</label>
                                                   <input type="text" id="laustart" name="laustart" class="form-control" value="<?= $value ?>">
                                               </div>
                                           </div>
                                           <div class="col-md-6">
                                               <?php $value = (isset($value_where) ? $value_where->lauend : ''); ?>
                                               <div class="form-group">
                                                   <label for="lauend" class="control-label ">Lầu Đến</label>
                                                   <input type="text" id="lauend" name="lauend" class="form-control" value="<?= $value ?>">
                                               </div>
                                           </div>
                                           <div class="col-md-6">
                                               <?php $value = (isset($value_where) ? $value_where->canstart : ''); ?>
                                               <div class="form-group">
                                                   <label for="canstart" class="control-label ">Căn từ</label>
                                                   <input type="text" id="canstart" name="canstart" class="form-control" value="<?= $value ?>">
                                               </div>
                                           </div>
                                           <div class="col-md-6">
                                               <?php $value = (isset($value_where) ? $value_where->canend : ''); ?>
                                               <div class="form-group">
                                                   <label for="canend" class="control-label ">Căn đến</label>
                                                   <input type="text" id="canend" name="canend" class="form-control" value="<?= $value ?>">
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <?php $value = (isset($value_where) ? $value_where->convenientstart : ''); ?>
                                               <div class="form-group">
                                                   <label for="convenientstart" class="control-label ">Diện tích từ</label>
                                                   <input type="text" id="convenientstart" name="convenientstart" class="form-control" value="<?= $value ?>">
                                               </div>
                                           </div>
                                           <div class="col-md-6">
                                               <?php $value = (isset($value_where) ? $value_where->convenientend : ''); ?>
                                               <div class="form-group">
                                                   <label for="convenientend" class="control-label ">Diện tích đến</label>
                                                   <input type="text" id="convenientend" name="convenientend" class="form-control" value="<?= $value ?>">
                                               </div>
                                           </div>
                                           <div class="col-md-6">

                                               <div class="form-group">
                                                   <?php $selected = (isset($value_where) ? json_decode($value_where->furniture_fill) : array()); ?>
                                                   <label for="furniture_fill" class="control-label ">Nội thất</label>
                                                   <select  multiple="multiple" id="furniture_fill" name="furniture_fill">
                                                       <option></option>
                                                       <?php foreach ($furniture as $fur) {
                                                            if ($selected == array())
                                                                {
                                                                echo "<option value='" . $fur['id'] . "'>" . $fur['name'] . "</option>";
                                                            }
                                                            else {
                                                                $si = 0;
                                                                foreach ($selected as $select) {
                                                                    if ($select == $fur['id'])
                                                                        {
                                                                        echo "<option value='" . $fur['id'] . "' selected>" . $fur['name'] . "</option>";
                                                                        $si = 1;
                                                                    }
                                                                }
                                                                if ($si == 0)
                                                                    {
                                                                    echo "<option value='" . $fur['id'] . "'>" . $fur['name'] . "</option>";
                                                                }
                                                            }
                                                        } ?>
                                                   </select>
                                                </div>
                                           </div>
                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <?php $selected = (isset($value_where) ? json_decode($value_where->district_fill) : array()); ?>
                                                   <label for="district_fill" class="control-label ">Quận</label>
                                                   <select  multiple="multiple" id="district_fill" name="district_fill">
                                                       <?php foreach ($district as $dis) {
                                                            if ($selected == array())
                                                                {
                                                                echo "<option value='" . $dis['districtid'] . "'>" . $dis['name'] . "</option>";
                                                            }
                                                            else {
                                                                $si = 0;
                                                                foreach ($selected as $select) {
                                                                    if ($select == $dis['districtid'])
                                                                        {
                                                                        echo "<option value='" . $dis['districtid'] . "' selected>" . $dis['name'] . "</option>";
                                                                        $si = 1;
                                                                    }
                                                                }
                                                                if ($si == 0)
                                                                    {
                                                                    echo "<option value='" . $dis['districtid'] . "'>" . $dis['name'] . "</option>";
                                                                }
                                                            }
                                                        } ?>
                                                   </select>
                                               </div>
                                           </div>
                                       </div>


                                       <button class="btn btn-danger mright5 pull-right" type="button" onclick="reset_fill(<?= $menu->id ?>)">Làm mới</button>
                                       <button class="btn mright5  btn-info pull-right display-block" type="button" onclick="search_fill()">Tìm kiếm</button>

                                       <div class="clearfix"></div>
                                   </div>

                               </div>
                           </div>



                          <!-- Modal -->

                        </div>



                     </div>


                     <div class="col-md-4 col-xs-12 pull-right leads-search">

                        <?php if ($this->session->userdata('leads_kanban_view') == 'true') { ?>

                        <div data-toggle="tooltip" data-placement="bottom" data-title="<?php echo _l('search_by_tags'); ?>">

                        <?php echo render_input('search', '', '', 'search', array('data-name' => 'search', 'onkeyup' => 'leads_kanban();', 'placeholder' => _l('leads_search')), array(), 'no-margin') ?>

                        </div>

                        <?php 
                    } ?>

                        <?php echo form_hidden('sort_type'); ?>

                        <?php echo form_hidden('sort'); ?>

                     </div>

                  </div>

                

                  <div class="clearfix"></div>

                  <div class="row hide leads-overview">

                     <hr />

                     <div class="col-md-12">

                        <h3 class="text-success no-margin"><?php echo _l('leads_summary'); ?></h3>

                     </div>

                     <?php
                        $where_not_admin = '(addedfrom = ' . get_staff_user_id() . ' OR assigned=' . get_staff_user_id() . ' OR is_public = 1)';

                        $numStatuses = count($statuses);

                        $is_admin = is_admin();

                        foreach ($statuses as $status) { ?>

                     <div class="col-md-2 col-xs-6 border-right">

                        <?php
                        $this->db->where('status', $status['id']);

                        if (!$is_admin) {

                            $this->db->where($where_not_admin);

                        }

                        $total = $this->db->count_all_results('tblleads');

                        ?>

                        <h3 class="bold"><?php echo $total; ?></h3>

                        <span style="color:<?php echo $status['color']; ?>"><?php echo $status['name']; ?></span>

                     </div>

                     <?php 
                    } ?>

                     <?php
                        if (!$is_admin) {

                            $this->db->where($where_not_admin);

                        }

                        $total_leads = $this->db->count_all_results('tblleads');

                        ?>

                     <div class="col-md-2 col-xs-6">

                        <?php
                        $this->db->where('lost', 1);

                        if (!$is_admin) {

                            $this->db->where($where_not_admin);

                        }

                        $total_lost = $this->db->count_all_results('tblleads');

                        $percent_lost = ($total_leads > 0 ? number_format( ($total_lost * 100) / $total_leads, 2) : 0);

                        ?>

                        <h3 class="bold"><?php echo $percent_lost; ?>%</h3>

                        <span class="text-danger"><?php echo _l('lost_leads'); ?></span>

                     </div>

                     <div class="col-md-2 col-xs-6">

                        <?php
                        $this->db->where('junk', 1);

                        if (!$is_admin) {

                            $this->db->where($where_not_admin);

                        }

                        $total_junk = $this->db->count_all_results('tblleads');

                        $percent_junk = ($total_leads > 0 ? number_format( ($total_junk * 100) / $total_leads, 2) : 0);

                        ?>

                        <h3 class="bold"><?php echo $percent_junk; ?>%</h3>

                        <span class="text-danger"><?php echo _l('junk_leads'); ?></span>

                     </div>

                  </div>

               </div>



            </div>

      </div>



                <div class="row">
                    <div id="view_table">
                        <div class="col-md-12" id="small-table">
                            <div class="panel_s">

                                <div class="panel-body">
                                    <div>
                             <?php
                                $f_colum = ceil(12 / (count($exigency) + 1));
                                if ($f_colum <= 1)
                                    {
                                    $f_colum = 1;
                                }

                                ?>
                            <div id="view_total" class="collapse">
                                 <div class="row">
                                     <div class="col-lg-<?= $f_colum ?> col-xs-12 col-md-12 total-column">
                                         <div class="panel_s">
                                             <div class="panel-body">
                                                 <h4 class="text-muted"><?= count($status_project) ?></h4>
                                                 <span class="text-success"><?php echo _l('Tổng ' . $menu->menu_name); ?></span>
                                             </div>
                                         </div>
                                     </div>
                                     <?php foreach ($exigency as $rum => $va) {
                                            $all = $this->newview_model->get_status_project_exigency($id, $id_project, $va['id']);
                                            ?>
                                         <div class="col-lg-<?= $f_colum ?> col-xs-12 col-md-12 total-column">
                                             <div class="panel_s">
                                                 <div class="panel-body">
                                                     <h4 class="text-muted"><?= $all ?></h4>
                                                     <span class="text-info"><?php echo _l($menu->menu_name . ' ' . $va['name']); ?></span>
                                                 </div>
                                             </div>
                                         </div>

                                     <?php 
                                    } ?>
                                 </div>
                             </div>
                             <div class="clearfix"></div>
                         </div>

                                         <style>
                                             .table-hover th input{min-width: 150px;}
                                         </style>
                                    <ul class="nav nav-tabs">
                                         <li class="active"><a data-toggle="tab" onclick="click_input()" style="cursor:pointer">Tất cả</a></li>
                                         <?php foreach ($exigency as $rom => $value) { ?>
                                                <li><a data-toggle="tab" onclick="click_input('<?= $value['id'] ?>')" style="cursor:pointer"><?= $value['name'] ?></a></li>
                                         <?php 
                                        } ?>
                                     </ul>

                                    <div class="tab-content">

                                         <style>
                                             .btn
                                             {
                                                 border:1px;
                                             }
                                         </style>
                                     <?php /*array_push($exigency, '')*/ ?>
                                                 <div id="tab-all" class="tab-pane active">
                                                    <h3 style="text-align: center"><?= $title ?></h3>
                                                 <div class="table-responsive no-dt">
                                                     <button type="button" onclick="reset_input(<?= $menu->id ?>)" class="btn btn-info pull-left display-block">Làm mới</button>
                                                     <div class="clearfix"></div>
                                                     <div style="margin-bottom: 20px;"></div>
                                                     <?php
                                                        if ($_COOKIE['where_' . $id])
                                                            {
                                                            $where = (array)json_decode($_COOKIE['where_' . $id]);
                                                        }
                                                        if ($_COOKIE['where_field_' . $id])
                                                            {
                                                            $where_field = (array)json_decode($_COOKIE['where_field_' . $id]);
                                                        }
                                                        ?>

                                                    <table id="table_all" class="table stripe table_all row-border order-column" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>

                                                                    <?php $va = json_decode($order_colum->active);
                                                                    $j = 0;
                                                                    $colum_one = array(); ?>
                                                                    <?php foreach ($va as $ra => $vi) {
                                                                        $j++; ?>
                                                                        <?php if ($vi->id == 'province_name')
                                                                            {
                                                                            if ($menu->province_table == 1) { ?>
                                                                            <th class="bold">
                                                                                <div class="select-div">
                                                                                    <p class="text-center"><?= get_name_lable_row('province_name') ?></p>
                                                                                    <?php
                                                                                    $selected = (isset($input_header) ? $input_header->province_name : ''); ?>
                                                                                        <select class="form-control input-sm" onchange="search_select(this.value,'province_name')">
                                                                                            <option></option>
                                                                                            <?php foreach ($province_name as $pro) { ?>
                                                                                                <?php if ($selected == $pro['name']) { ?>
                                                                                                    <option value="<?= $pro['name'] ?>" selected><?= $pro['name'] ?></option>
                                                                                                <?php 
                                                                                            }
                                                                                            else { ?>
                                                                                                    <option value="<?= $pro['name'] ?>"><?= $pro['name'] ?></option>
                                                                                                <?php 
                                                                                            } ?>
                                                                                            <?php 
                                                                                        } ?>
                                                                                        </select>
                                                                                    <input id="province_name" name="province_name" style="width:0px; height:0px;border:0px!important;color: white" value="<?= $selected ?>">
                                                                                </div>
                                                                            </th>
                                                                        <?php 
                                                                    }
                                                                } ?>
                                                                        <?php if ($vi->id == 'district_name') {
                                                                            if ($menu->district_table == 1) { ?>
                                                                                <th class="bold">
                                                                                    <div class="select-div">
                                                                                        <p class="text-center"><?= get_name_lable_row('district_name') ?></p>
                                                                                        <?php
                                                                                        $selected = (isset($input_header) ? $input_header->district_name : ''); ?>
                                                                                            <select class="form-control input-sm" onchange="search_select(this.value,'district_name')">
                                                                                                <option></option>
                                                                                                <?php foreach ($district_name as $pro) { ?>
                                                                                                    <?php if ($selected == $pro['name']) { ?>
                                                                                                        <option value="<?= $pro['name'] ?>" selected><?= $pro['name'] ?></option>
                                                                                                    <?php 
                                                                                                }
                                                                                                else { ?>
                                                                                                        <option value="<?= $pro['name'] ?>"><?= $pro['name'] ?></option>
                                                                                                    <?php 
                                                                                                } ?>
                                                                                                <?php 
                                                                                            } ?>
                                                                                            </select>
                                                                                        <input id="district_name" name="district_name" style="width:0px; height:0px;border:0px!important;color: white" value="<?= $selected ?>">
                                                                                    </div>

                                                                                </th>
                                                                        <?php 
                                                                    }
                                                                } ?>
                                                                        <?php if ($vi->id == 'door_direction_name') { ?>
                                                                            <th class="bold">
                                                                                <div class="select-div">
                                                                                    <p class="text-center"><?= get_name_lable_row('door_direction_name') ?></p>
                                                                                    <?php
                                                                                    $selected = (isset($input_header) ? $input_header->door_direction_name : ''); ?>
                                                                                        <select class="form-control input-sm" onchange="search_select(this.value,'door_direction_name')">
                                                                                            <option></option>
                                                                                            <?php foreach ($door_direction_name as $pro) { ?>
                                                                                                <?php if ($selected == $pro['name']) { ?>
                                                                                                    <option value="<?= $pro['name'] ?>" selected><?= $pro['name'] ?></option>
                                                                                                <?php 
                                                                                            }
                                                                                            else { ?>
                                                                                                    <option value="<?= $pro['name'] ?>"><?= $pro['name'] ?></option>
                                                                                                <?php 
                                                                                            } ?>
                                                                                            <?php 
                                                                                        } ?>
                                                                                        </select>
                                                                                    <input id="door_direction_name" name="door_direction_name" style="width:0px; height:0px;border:0px!important;color: white" value="<?= $selected ?>">
                                                                                </div>
                                                                            </th>
                                                                        <?php 
                                                                    } ?>
                                                                        <?php if ($vi->id == 'status') { ?>
                                                                            <th class="bold">
                                                                                <div class="select-div">
                                                                                    <p class="text-center"><?= get_name_lable_row('status') ?></p>
                                                                                    <?php
                                                                                    $selected = (isset($input_header) ? $input_header->status : ''); ?>
                                                                                        <select class="form-control input-sm" onchange="search_select(this.value,'status')">
                                                                                            <option></option>
                                                                                            <?php foreach ($status as $statu) { ?>
                                                                                                <?php if ($selected == $statu['name']) { ?>
                                                                                                    <option value="<?= $statu['name'] ?>" selected><?= $statu['name'] ?></option>
                                                                                                <?php 
                                                                                            }
                                                                                            else { ?>
                                                                                                    <option value="<?= $statu['name'] ?>"><?= $statu['name'] ?></option>
                                                                                                <?php 
                                                                                            } ?>
                                                                                            <?php 
                                                                                        } ?>
                                                                                        </select>
                                                                                    <input id="status" name="status" style="width:0px; height:0px;border:0px!important;color: white" value="<?= $selected ?>">
                                                                                </div>
                                                                            </th>
                                                                        <?php 
                                                                    } ?>

                                                                        <?php if ($vi->id == 'furniture_name') { ?>
                                                                            <th class="bold">
                                                                                <div class="select-div">
                                                                                    <p class="text-center"><?= get_name_lable_row('furniture_name') ?></p>
                                                                                    <?php
                                                                                    $selected = (isset($input_header) ? $input_header->door_direction_name : ''); ?>
                                                                                    <select class="form-control input-sm" onchange="search_select(this.value,'furniture')">
                                                                                        <option></option>
                                                                                        <?php foreach ($furniture as $pro) { ?>
                                                                                            <?php if ($selected == $pro['name']) { ?>
                                                                                                <option value="<?= $pro['name'] ?>" selected><?= $pro['name'] ?></option>
                                                                                            <?php 
                                                                                        }
                                                                                        else { ?>
                                                                                                <option value="<?= $pro['name'] ?>"><?= $pro['name'] ?></option>
                                                                                            <?php 
                                                                                        } ?>
                                                                                        <?php 
                                                                                    } ?>
                                                                                    </select>
                                                                                    <input id="furniture" name="furniture" style="width:0px; height:0px;border:0px!important;color: white" value="<?= $selected ?>">
                                                                                </div>
                                                                            </th>
                                                                        <?php 
                                                                    } ?>

                                                                            <?php if ($vi->id != 'province_name' && $vi->id != 'district_name' && $vi->id != 'door_direction_name' && $vi->id != 'furniture_name' && $vi->id != 'status') { ?>
                                                                                <?php
                                                                                if ($j == 1 || $j == 2) {
                                                                                    $colum_one[] = '[name="' . $vi->id . '"]';
                                                                                }
                                                                                ?>
                                                                                <?php
                                                                                $index_name = $vi->id;
                                                                                $value = (isset($input_header) ? $input_header->$index_name : ''); ?>
                                                                                    <?php if (get_name_lable_row($vi->id) != "") {
                                                                                        $lable_name = get_name_lable_row($vi->id);
                                                                                    }
                                                                                    else $lable_name = $vi->permission ?>
                                                                                <th class="bold">
                                                                                    <p class="text-center">
                                                                                        <?= $lable_name ?>
                                                                                    </p><input class="form-control input-sm" name="<?= $vi->id ?>" id="<?= $vi->id ?>"  value="<?= $value ?>"></th>
                                                                             <?php 
                                                                            } ?>
                                                                        <?php 
                                                                    } ?>
                                                                    <th class="bold">
                                                                        <div class="select-div">
                                                                            <p class="text-center">Hình ảnh</p>
                                                                            <select class="form-control input-sm" onchange="search_select(this.value,'images')">
                                                                                <option></option>
                                                                                <option value="Có" selected>Có hình ảnh</option>
                                                                                <option value="Không">Không có hình ảnh</option>

                                                                            </select>
                                                                            <input id="images" name="images" style="width:0px; height:0px;border:0px!important;color: white" value="<?= $selected ?>">
                                                                        </div>
                                                                    </th>
                                                                    <th class="bold">
                                                                        DS Chủ sở hữu
                                                                    </th>
                                                                    <th class="bold"><p style="width: 150px;"><?= _l('actions') ?></p></th>
                                                                    
                                                                    <th class="bold"> <input style="width:0px; height:0px;border:0px!important;color: white" name="filter"></th>
                                                                </tr>
                                                            </thead>
                                                        <?php if ($order_colum) { ?>

                                                            <tbody>
                                                                <?php if ($id)
                                                                    {
                                                                    $project = $this->newview_model->get_project_menu($id, '', $id_project, $where);

                                                                }
                                                                ?>
                                                                <?php foreach ($project as $r => $rom) { ?>
                                                                    <?php
                                                                    $kiemtra_value = $this->newview_model->kiemtra_fields($rom['id_project'], $where_field);
                                                                    if ($kiemtra_value)
                                                                        {
                                                                        ?>
                                                                            <tr >

                                                                                <?php foreach ($va as $ra => $v) { ?>
                                                                                    <?php $exigency_project = $this->newview_model->get_exigency_project($rom['id_project']) ?>
                                                                                    <?php
                                                                                    $val = "";
                                                                                    $tag_val = "";
                                                                                    if ($exigency_project)
                                                                                        {
                                                                                        foreach ($exigency_project as $c_rex => $rex)
                                                                                            {
                                                                                            $val = $val . '{' . $rex['id'] . '}';
                                                                                            if ($c_rex != count($exigency_project) - 1)
                                                                                                {
                                                                                                $tag_val = $tag_val . $rex['name'] . ' ,';
                                                                                            }
                                                                                            else {
                                                                                                $tag_val = $tag_val . $rex['name'];
                                                                                            }

                                                                                        }
                                                                                    }

                                                                                    ?>
                                                                                    <?php
                                                                                    if ($v->id == 'province_name') {
                                                                                        if ($menu->province_table == 1) {
                                                                                            echo '<td class="province_name" title="' . $rom['province_name'] . '" >'; ?>
                                                                                                    <select style="border:0px;" onclick="addoption(this);return false;" field="<?= $_field ?>" data_id="<?= $rom['id_project'] ?>" data_name="<?= $v->id ?>">
                                                                                                        <option value="<?= $rom['provinceid'] ?>"><?= $rom['province_name'] ?></option>
                                                                                                    </select>
                                                                                                    <?= '</td>' ?>
                                                                                    <?php

                                                                                }
                                                                            }
                                                                            else if ($v->id == 'district_name') {
                                                                                if ($menu->district_table == 1) {
                                                                                    echo '<td class="district_name" title="' . $rom['district_name'] . '" >'; ?>
                                                                                                    <select style="border:0px;" onclick="addoption(this)" field="<?= $_field ?>" data_id="<?= $rom['id_project'] ?>" data_name="<?= $v->id ?>">
                                                                                                          <option value="<?= $rom['districtid'] ?>" selected><?= $rom['district_name'] ?></option>;
                                                                                                    </select>
                                                                                                <?= '</td>' ?>
                                                                                             <?php

                                                                                            }
                                                                                        }
                                                                                        else if ($v->id == 'furniture_name') {
    //
                                                                                            echo '<td class="' . $v->id . '" title="' . $rom[$v->id] . '" >'; ?>
                                                                                                <select style="border:0px;" onclick="addoption(this)" field="<?= $_field ?>" data_id="<?= $rom['id_project'] ?>" data_name="<?= $v->id ?>">
                                                                                                    <?php foreach ($furniture as $fur) {
                                                                                                        if ($fur['id'] == $rom['furniture']) {
                                                                                                            echo "<option value='" . $fur['id'] . "' selected>" . $fur['name'] . "</option>";
                                                                                                        }
                                                                                                    } ?>
                                                                                                </select>
                                                                                                <?= '</td>' ?>
                                                                                        <?php

                                                                                    }
                                                                                    else if ($v->id == 'door_direction_name') {
                                                                                        echo '<td class="' . $v->id . '" title="' . $rom[$v->id] . '" >'; ?>
                                                                                            <select style="border:0px;" onclick="addoption(this)" field="<?= $_field ?>" data_id="<?= $rom['id_project'] ?>" data_name="<?= $v->id ?>">
                                                                                                <?php foreach ($door_direction as $door) {
                                                                                                    if ($door['id'] == $rom['door_direction']) {
                                                                                                        echo "<option value='" . $door['id'] . "' selected>" . $door['name'] . "</option>";
                                                                                                    }
                                                                                                } ?>
                                                                                            </select>
                                                                                            <?= '</td>' ?>
                                                                                            <?php

                                                                                        }
                                                                                        else if ($v->id == 'status') {
                                                                                            echo '<td class="' . $v->id . '" title="' . $rom[$v->id] . '" >'; ?>
                                                                                            <select style="border:0px;" onclick="addoption(this)" field="<?= $_field ?>" data_id="<?= $rom['id_project'] ?>" data_name="<?= $v->id ?>">
                                                                                                <?php foreach ($status as $statu) {
                                                                                                    if ($statu['id'] == $rom['status']) {
                                                                                                        echo "<option value='" . $statu['id'] . "' selected>" . $statu['name'] . "</option>";
                                                                                                    }
                                                                                                } ?>
                                                                                            </select>
                                                                                            <?= '</td>' ?>
                                                                                            <?php

                                                                                        }
                                                                                        else if ($v->id == 'tag')
                                                                                            {
                                                                                            $view = '';
                                                                                            $view = '<td class="tag" title="' . prep_tags_input(get_tags_in($rom['id_project'], 'project_bds')) . '">';
                                                                                            $tags = get_tags_in($rom['id_project'], 'project_bds');
                                                                                            if (count($tags) > 0) {
                                                                                                $view .= render_tags($tags);
                                                                                                $view .= '<div class="clearfix"></div>';
                                                                                            }
                                                                                            $view .= '</td>';
                                                                                            echo $view;
                                                                                        }
                                                                                        else if ($v->id == 'price') {
                                                                                            echo '<td class="price" title="' . $rom['price'] . '">' .
                                                                                                number_format($rom['price'], 0, ".", ".") .
                                                                                                '</td>';
                                                                                        }
                                                                                        else if ($v->id == 'code') {

                                                                                            if ($id_project)
                                                                                                {
                                                                                                $type_project = '?project=' . $id_project;
                                                                                            }
                                                                                            else
                                                                                                {
                                                                                                $type_project = "";
                                                                                            }
                                                                                            echo '<td class="code" title="' . $rom['code'] . '">';
                                                                                            echo '<button data-toggle="tooltip" data-original-title="' . $tag_val . '" data-loading-text="' . $rom['code'] . ' <i class=\'fa fa-spinner fa-spin \'></i>" data-view="modalEdit" data-bmdSrc="' . admin_url() . 'newview/project/' . $rom['id_menu'] . '/' . $rom['id_project'] . $type_project . '" class="btn btn-primary btn-icon bmd-modalButton" type="button">
                                                                                        ' . $rom['code'] . ' <i class="glyphicon glyphicon-option-vertical"></i>
                                                                                    </button></td>';

                                                                                        }
                                                                                        else if ($v->id == 'staff_id') {
                                                                                            echo '<td class="staff_id" title="' . get_staff_full_name($rom['staff_id']) . '">' .
                                                                                                '<a data-toggle="tooltip" data-title="' . get_staff_full_name($rom['staff_id']) . '" href="' . admin_url('profile/' . $rom['staff_id']) . '">' . staff_profile_image($rom['staff_id'], array(
                                                                                                'staff-profile-image-small'
                                                                                            )) . ' ' . get_staff_full_name($rom['staff_id']) . '</a>' . '</td>';

                                                                                        }
                                                                                        else if ($v->id == 'cost') {
                                                                                            echo ' <td class="cost" title="' . $rom['cost'] . '">' . number_format($rom['cost'], 0, ".", ".") . '</td>';
                                                                                        }
                                                                                        else {
                                                                                            $_data = "";
                                                                                            $_field = "";
                                                                                            foreach ($render_colum as $rcolum) {
                                                                                                if ($v->id == $rcolum['id_input'] . '_' . $rcolum['id_field']) {
                                                                                                    $_field = $rcolum['id_input'];
                                                                                                    $data_value = get_field_value($rcolum['id_field'], $rom['id_project'], 'menu_bds', false);
                                                                                                    if ($data_value)
                                                                                                        {
                                                                                                        $_data = '<td class="' . $rcolum['id_input'] . '_' . $rcolum['id_field'] . '" title="' . $data_value . '">' .
                                                                                                            '<input style="border:0px;" readonly="true" ondblclick="true_input(this)" field="' . $_field . '" data_id="' . $rom['id_project'] . '" data_name="' . $v->id . '" value="' . $data_value . '"><a style="display:none">' . $data_value . '</a>' .
                                                                                                            '</td>';
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                            if ($_data == "")
                                                                                                {
                                                                                                echo '<td class="' . $v->id . '" title="' . $rom[$v->id] . '">' .
                                                                                                    '<input style="border:0px;" readonly="true" ondblclick="true_input(this)" field="' . $_field . '" data_id="' . $rom['id_project'] . '" data_name="' . $v->id . '" value="' . $rom[$v->id] . '"><a style="display:none">' . $rom[$v->id] . '</a>
                                                                                                </td>';
                                                                                            }
                                                                                            else
                                                                                                {
                                                                                                echo $_data;
                                                                                            }
                                                                                        }
                                                                                    } ?>
                                                                                <td>
                                                                                    <?php $images = $this->newview_model->get_table_where('tblfile_bds', 'type=1 and id_project=' . $rom['id_project']); ?>
                                                                                    <?php if (isset($images) && $images != array()) { ?>
                                                                                        <?php foreach ($images as $r_img => $img) {
                                                                                            if ($r_img == 0) { ?>
                                                                                                <div class="col-md-3 btn btn-icon display-block contract-attachment-wrapper img-<?= $img['id'] ?>">
                                                                                                    <a href="<?= base_url() ?>uploads/project_bds/<?= $img['file'] ?>" data-lightbox="customer-profile" class="display-block mbot5">
                                                                                                        <i class="mime mime-image"></i><p style="display: none">Có</p>
                                                                                                    </a>
                                                                                                </div>
                                                                                            <?php 
                                                                                        }
                                                                                        else { ?>
                                                                                                <div class="contract-attachment-wrapper img-<?= $img['id'] ?>">
                                                                                                    <a href="<?= base_url() ?>uploads/project_bds/<?= $img['file'] ?>" data-lightbox="customer-profile" class="display-block mbot5">

                                                                                                    </a>
                                                                                                </div>
                                                                                            <?php 
                                                                                        }
                                                                                    } ?>
                                                                                    <?php 
                                                                                }
                                                                                else
                                                                                    { ?>
                                                                                        <div class="col-md-3"><p style="display: none">Không</p></div>
                                                                                    <?php 
                                                                                } ?>
                                                                                </td>
                                                                                <td>
                                                                                    <button data-loading-text="<i class='fa fa-spinner fa-spin '></i>" data-bmdSrc="<?= admin_url() . 'newview/project/' . $rom['id_menu'] . '/' . $rom['id_project'] . $type_project ?>" class="btn btn-primary btn-icon bmd-modalButton" type="button">
                                                                                        <i class="glyphicon glyphicon-user"></i>
                                                                                    </button>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="btn-group">
                                                                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                                                            <?=_l('actions')?> <span class="caret"></span>
                                                                                        </button>
                                                                                        <ul class="dropdown-menu" role="menu">
                                                                                            <?php $project_exigency = $this->newview_model->get_table_where('tblproject_exigency', 'id_project=' . $rom['id_project']); 
                                                                                            // var_dump($exigency);
                                                                                            // exit();
                                                                                            ?>
                                                                                                <?php foreach ($exigency as $ex_value) {
                                                                                                $co = 0; ?>
                                                                                                <?php foreach ($project_exigency as $pe) { ?>
                                                                                                    <?php if ($pe['id_exigency'] == $ex_value['id'])
                                                                                                        {
                                                                                                        $co = 1;
                                                                                                    } ?>
                                                                                                <?php 
                                                                                                } ?>
                                                                                                <?php if ($co == 0) { ?>
                                                                                                    <li>
                                                                                                        <a onclick="status_project(<?= $rom['id_project'] ?>,<?= $ex_value['id'] ?>)" href="javacript:void(0)" class="btn dropdown-item">
                                                                                                            <i class="fa fa-exchange"></i> 
                                                                                                            <?= $ex_value['name'] ?>
                                                                                                        </a>
                                                                                                    </li>
                                                                                                <?php 
                                                                                                } ?>
                                                                                            <?php } ?>
                                                                                            <li>
                                                                                            <?= icon_btn('newview/delete_project/' . $rom['id_project'], 'remove', 'dropdown-item btn-danger _delete', array('data_id   ' => $rom['id_project']), "Xóa"); ?>    
                                                                                            </li>
                                                                                        </ul>
                                                                                        
                                                                                    </div>
                                                                                    
                                                                                </td>


                                                                                <td style="display: none" title="<?= $val ?>"><?= $val ?></td>
                                                                        </tr>
                                                                    <?php 
                                                                } ?>
                                                                <?php 
                                                            } ?>
                                                            </tbody>
                                                        <?php 
                                                    } ?>
                                                    </table>
                                                 </div>
                                               </div>
                                        </div>

                                        <div class="clearfix"></div>

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
    </div>
</div>
<style type="text/css">
    .bmd-modalButton {
    /* display: block;
    margin: 15px auto;
    padding: 5px 15px; */
    }

    .close-button {
    overflow: hidden;
    }

    .bmd-modalContent {
    box-shadow: none;
    background-color: transparent;
    border: 0;
    }
    
    .bmd-modalContent .close {
    font-size: 30px;
    line-height: 30px;
    padding: 7px 4px 7px 13px;
    text-shadow: none;
    opacity: .7;
    color:#fff;
    }

    .bmd-modalContent .close span {
    display: block;
    }

    .bmd-modalContent .close:hover,
    .bmd-modalContent .close:focus {
    opacity: 1;
    outline: none;
    }

    .bmd-modalContent iframe {
    display: block;
    margin: 0 auto;
    }
</style>
<div class="modal fade" id="modalPage">
    <div class="modal-dialog" style="width: 90%;top: -50px;">
        <div class="modal-content bmd-modalContent">

            <div class="modal-body">
        
        <div class="close-button">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="embed-responsive" style="padding-bottom: 52%;">
                            <iframe class="embed-responsive-item" frameborder="0"></iframe>
        </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

    <?php init_tail(); ?>
    <div id="script">
    <div id="content-script">
        <script>
            let latestButton;
            (function($) {
                
                $.fn.bmdIframe = function( options ) {
                    var self = this;
                    var settings = $.extend({
                        classBtn: '.bmd-modalButton',
                        defaultW: 1240,
                        defaultH: 635
                    }, options );
                
                    $(settings.classBtn).on('click', function(e) {
                    var allowFullscreen = $(this).attr('data-bmdVideoFullscreen') || false;
                    
                    var dataVideo = {
                        'src': $(this).attr('data-bmdSrc'),
                        'width': ($(this).attr('data-bmdWidth') || settings.defaultW) + 'px',
                        'height': ($(this).attr('data-bmdHeight') || settings.defaultH) + 'px',
                    };
                    
                    if ( allowFullscreen ) dataVideo.allowfullscreen = "";
                    
                    // stampiamo i nostri dati nell'iframe
                    $(self).find("iframe").attr(dataVideo);
                    });
                    this.on('shown.bs.modal', function(){
                        // $(this).find('iframe').hide();
                    });
                    // se si chiude la modale resettiamo i dati dell'iframe per impedire ad un video di continuare a riprodursi anche quando la modale è chiusa
                    this.on('hidden.bs.modal', function(){
                        $(this).find('iframe').html("").attr("src", "");
                    });
                
                    return this;
                };

                $('#modalPage iframe').on('load', function() {
                    if(!$(this).attr('src')) return;
                    // console.log(latestButton.attr('data-bmdSrc'));
                    // console.log($(this).attr('src'));
                    // console.log(latestButton.attr('data-bmdSrc') !==  $(this).attr('src'));
                    
                    let iframeContent = $(this).contents();
                    
                    // Remove header
                    iframeContent.find('body').addClass('hide-sidebar');
                    iframeContent.find('div#header').hide();
                    iframeContent.find('div#setup-menu-wrapper').removeClass('display-block');
                    iframeContent.find('div#wrapper').css('margin-left', '0px');
                    iframeContent.find('aside#menu').hide();
                    
                    if(latestButton.data('view') !== 'modalEdit') {
                        // Tabs auto click
                        iframeContent.find('a[href="#review_host"]').tab('show');
                        iframeContent.find('.profile-tabs').next().find('.tab-pane.active').removeClass('active');
                        iframeContent.find('#review_host').addClass('active');
                        iframeContent.find('#profile').addClass('active');

                        // Remove button
                        iframeContent.find('.tab-content > h4').text('Chủ sở hữu');
                        iframeContent.find('ul.profile-tabs').hide();
                    }
                    iframeContent.find('.tab-content > a').remove();

                    // Remove footer
                    iframeContent.find('div#wrapper').css('min-height', '');

                    $(this).show();
                    $('#modalPage').modal('show');
                    latestButton.button('reset');
                });
            })(jQuery);


            $(document).on('click', '.bmd-modalButton', function() {
                $(this).button('loading');
                latestButton = $(this);
            });

            jQuery(document).ready(function(){
                jQuery("#modalPage").bmdIframe();
            });


            $(function() {
                $('#furniture_fill,#district_fill').change(function() {
                }).multipleSelect({
                    width: '100%'
                });
            });
            $(document).ready(function() {
                    var table_all = $('#table_all').DataTable( {
                        ordering: false,
                        scrollY:        true,
                        scrollX:        true,
                        scrollCollapse: true,
                        paging:         true,
                        fixedColumns:   {
                            leftColumns: 2
                        }
                    } );
                table_all.columns().every( function () {
                        var that = this;
                        
                        $( 'input,select', this.header() ).on( 'keyup change focus', function () {
                            if ( that.search() !== this.value ) {
                                that
                                    .search( this.value )
                                    .draw();
                            }
                        } );
                } );
                    var fouces_input=$('th input');
                    $.each($(fouces_input), function( index, value ) {
                        // console.log(value.value);
                        if(value.value!="") {
                            $(value).focus();
                        }
                    })


                $('table').removeClass('dataTable ');
                <?php $full_colum = implode(',', $colum_one) ?>
                <?php if ($full_colum != "") { ?>
                    $('table input<?= $full_colum ?>').on('keyup', function (va) {
                        type=va.target.name;
                        jQuery.ajax({
                            type: "post",
                            url:'<?= admin_url() . "newview/save_input" ?>',
                            data: {menu_id:<?= $menu->id ?>,name:va.target.name,value:va.target.value},
                            cache: false,
                            success: function (data) {
                            }
                        });

                       var input_key=$( 'input[name="'+type+'"]');
                        $.each($(input_key), function( index, value ) {
                            $(value).val(va.target.value);
                            $(value).focus();

                        })
                    });
                <?php 
            } ?>

                $('table input').on('keyup change focus', function (va) {
                    type=va.target.name;
                    // console.log(va);
                    jQuery.ajax({
                        type: "post",
                        url:'<?= admin_url() . "newview/save_input" ?>',
                        data: {menu_id:<?= $menu->id ?>,name:va.target.name,value:va.target.value},
                        cache: false,
                        success: function (data) {

                        }
                    });
                });
                
            } );

//

            function click_input(name="")
            {
                <?php
                if ($id_project)
                    {
                    $object = '?project=' . $id_project;
                }
                else
                    {
                    $object = '';
                }
                ?>
                var _object="";
                if(name!="")
                {
                    $('input[name="filter"]').val('{'+name+'}');
                    $('input[name="filter"]').focus();
                    _object='/<?= $menu->id ?>/'+name+'<?= $object ?>';
                    var btn_delete=$('._delete');
                    $.each($(btn_delete),function( index, value ){
                        data_id=$(value).attr('data_id');
                        $(value).prop('href','<?= admin_url() ?>newview/delete_project/'+data_id+_object);
                    })
                }
                else
                {
                    $('input[name="filter"]').val(name);
                    $('input[name="filter"]').focus();
                     _object='/<?= $menu->id ?>/<?= $object ?>';
                    // console.log(_object);
                    btn_delete=$('._delete');
                    $.each($(btn_delete),function( index, value ){
                        data_id=$(value).attr('data_id');
                        // console.log(data_id);
                        $(value).prop('href','<?= admin_url() ?>newview/delete_project/'+data_id+_object);
                    })
//                    $('._delete').prop('href','<?//=admin_url()?>//newview/delete_project/'+_object);
                }
            }
            function search_select(data,id)
            {
                $('#'+id).val(data);
                $('#'+id).focus();
            }
        </script>
        <script src="<?= base_url() ?>assets/js/dataTables.fixedColumns.min.js"></script>

        <script>

                $(document).ready(function(){

                    setInterval(function(){

                        $("#screen").load('banners.php')

                    }, 2000);

                });

        </script>
    </div>
</div>

    <script>
        function status_project(id_project,id)
        {
           var dataString={id_project:id_project,id:id};
            jQuery.ajax({
                type: "post",
                url: "<?= admin_url() ?>newview/status_project",
                data: dataString,
                dataType: "json",
                cache: false,
                success: function (data) {
                    if(data.success)
                    {
                        alert_float('success', data.message);
                        $('#view_table').load(document.URL +  ' #small-table');
                        window.location.reload();
                    }

                }
            });
        }
        function true_input(_this)
        {
            var _colum=$(_this).attr('data_name');
            var _id=$(_this).attr('data_id');
            var _field=$(_this).attr('field');
            $(_this).removeAttr("readonly");
                $(_this).blur(function(){
                    if(!$(_this).prop('readonly'))
                    {
                        kiemtra=confirm("Bạn có muốn lưu?");
                        if(kiemtra==true)
                        {
                            var _value=$(_this).val();
                            jQuery.ajax({
                            type: "post",
                            dataType: "json",
                            url:'<?= admin_url() ?>newview/update_data',
                            data: {id:_id,colum:_colum,field:_field,value:_value,menu_id:<?= $menu->id ?>},
                            cache: false,
                            success: function (data) {
                                if(data.success)
                                {
                                    alert_float('success',data.message);
                                }
                                else
                                {
                                    alert_float('danger','Cập nhật không thành công');
                                }
                            }
                        });
                        }
                        $(_this).prop('readonly','readonly');
                        // console.log($(_this).prop('readonly'));
                    }

                });

        }

        function true_select(_this)
        {
            var _colum=$(_this).attr('data_name');
            var _id=$(_this).attr('data_id');
            var _field=$(_this).attr('field');
            var _value=$(_this).val();
                jQuery.ajax({
                type: "post",
                dataType: "json",
                url:'<?= admin_url() ?>newview/update_data',
                data: {id:_id,colum:_colum,field:_field,value:_value,menu_id:<?= $menu->id ?>},
                cache: false,
                success: function (data) {
                    if(data.success)
                    {
                        alert_float('success',data.message);
                        if(_colum=="province_name"){
                            jQuery.ajax({
                                type: "post",
                                dataType: "json",
                                url:'<?= admin_url() ?>newview/get_district/'+_value,
                                data: "",
                                cache: false,
                                success: function (district) {
                                    $('select[data_id="'+_id+'"][data_name="district_name"]').html("");
                                    var option_district="<option></option>";
                                    $.each($(district), function( index, value ) {
                                        option_district=option_district+"<option value='"+value.districtid+"'>"+value.name+"</option>";
                                    })
                                    $('select[data_id="'+_id+'"][data_name="district_name"]').html(option_district);

                                }
                            })
                        }
                    }
                    else
                    {
                        alert_float('danger','Cập nhật không thành công');
                    }
                }
            });

        }
        function reset_input()
        {
            var fouces_input=$('th input,th select');
            jQuery.ajax({
                type: "post",
                url:'<?= admin_url() . "newview/delete_input" ?>',
                data: {menu_id:<?= $menu->id ?>},
                cache: false,
                success: function (data) {
                }
            });
            $.each($(fouces_input), function( index, value ) {
                if(value.value!="") {
                    $(value).val('');
                    $(value).focus();
                }
            })

        }
        function reset_fill(id)
        {
            jQuery.ajax({
                type: "post",
                url:'<?= admin_url() . "newview/delete_fill" ?>',
                data: {menu_id:id},
                cache: false,
                success: function (data) {
                }
            });
            setTimeout(function(){ window.location.reload(); }, 1000);

            

        }
        function addoption(_this)
        {
            var _colum=$(_this).attr('data_name');
            var _id=$(_this).attr('data_id');
            var _op_history=$(_this).find('option:selected').text();
            var _val_history=$(_this).find('option:selected').val();
            var _option="";
            if(_colum=='district_name')
            {
               _data_id= $('select[data_id="'+_id+'"][data_name="province_name"]').find('option:selected').val();
            }
            else
            {
                _data_id="";
            }
            var kiemtra=0;
                jQuery.ajax({
                    type: "post",
                    dataType: "json",
                    url:'<?= admin_url() ?>newview/get_option',
                    data:  {id:_id,colum:_colum,menu_id:<?= $menu->id ?>,not_id:_val_history,id_pro:_data_id},
                    cache: false,
                    success: function (data) {
                        // console.log(data);
                        kiemtra=$(_this).find('option').length;
                        _option="";
                        $.each($(data), function( index, value ) {
                            if(kiemtra<2){
                                if(value.provinceid&&_colum=='province_name'){
                                    _option=_option+"<option value='"+value.provinceid+"'>"+value.name+"</option>";
                                }
                                else
                                {
                                    if(value.districtid&&_colum=='district_name')
                                    {
                                        _option=_option+"<option value='"+value.districtid+"'>"+value.name+"</option>";
                                    }
                                    else
                                    {
                                        _option=_option+"<option value='"+value.id+"'>"+value.name+"</option>";
                                    }
                                }
                            }
                        });

                        if(kiemtra<2){
                            $(_this).append(_option);
                        }

                        $(_this).blur(function(){
                            _op=$(_this).find('option:selected').text();
                            _val=$(_this).find('option:selected').val();
                                var r = confirm("Bạn có muốn thay đổi!");
                                if(r==true){
                                    $(_this).find('option').remove();
                                    $(_this).append('<option value="'+_val+'">'+_op+'</option>');
                                    var _value=$(_this).val();
                                    // console.log(_value);
                                    jQuery.ajax({
                                        type: "post",
                                        dataType: "json",
                                        url:'<?= admin_url() ?>newview/update_data',
                                        data: {id:_id,colum:_colum,value:_value,menu_id:<?= $menu->id ?>},
                                        cache: false,
                                        success: function (data) {
                                            if(data.success)
                                            {
                                                alert_float('success',data.message);
                                                if(_colum=="province_name"){
                                                    $('select[data_id="'+_id+'"][data_name="district_name"]').html('<option></option>');
                                                }
                                            }
                                            else
                                            {
                                                alert_float('danger','Cập nhật không thành công');
                                            }
                                        }
                                    })
                                    $(_this).off('blur');
                                }
                                else
                                {
                                    var history=$(_this).find('option');
                                    _val_history=history[0].value;
                                    _op_history=history[0].text;
                                    // console.log(_op_history);
                                    $(_this).find('option').remove();
                                    $(_this).append('<option value="'+_val_history+'">'+_op_history+'</option>');
                                    $(_this).off('blur');
                                }
                        })
                    }
                })
                $(_this).off('click');
                $(_this).off('blur');


        }



        $('.dropdown-menu').on('click', function(e) {
            if($(this).hasClass('dropdown-menu-form')) {
                e.stopPropagation();
            }
        });

        function search_fill()
        {
           var priceend= $('#priceend').val();
           var pricestart= $('#pricestart').val();

           var hhdstart= $('#hhdstart').val();
           var hhdend= $('#hhdend').val();

           var pnstart= $('#pnstart').val();
           var pnend= $('#pnend').val();

            var laustart= $('#laustart').val();
           var lauend= $('#lauend').val();

            var canstart= $('#canstart').val();
           var canend= $('#canend').val();

            var convenientstart= $('#convenientstart').val();
           var convenientend= $('#convenientend').val();

            var furniture_fill= $('#furniture_fill').val();
           var district_fill= $('#district_fill').val();
            if(district_fill.length>7){ alert('Quận chỉ được chọn tối đa 7 quận');return false;}
            if(furniture_fill.length>7){ alert('Nội thất chỉ được chọn tối đa 7'); return false;}

            var datastring={
                pricestart:pricestart,
                priceend:priceend,
                hhdstart:hhdstart,
                hhdend:hhdend,
                pnstart:pnstart,
                pnend:pnend,
                laustart:laustart,
                lauend:lauend,
                canstart:canstart,
                canend:canend,
                convenientstart:convenientstart,
                convenientend:convenientend,
                furniture_fill:furniture_fill,
                district_fill:district_fill
            }
            jQuery.ajax({
                type: "post",
                dataType: "json",
                url:'<?= admin_url() ?>newview/setcokki/'+<?= $id ?>,
                data: datastring,
                cache: false,
                success: function (data) {
                    // console.log(data);
                }
            })
            window.location.reload();
        }
    </script>
<script src="<?= base_url() ?>assets/js/multiple-select.js"></script>

</body>

</html>