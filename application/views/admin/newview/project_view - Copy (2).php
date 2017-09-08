<?php init_head(); ?>
<style>

    /*div.dataTables_wrapper {*/
        /*width: 800px;*/
        /*margin: 0 auto;*/
    /*}*/

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
    th, td { white-space: nowrap; }
</style>
<style href="https://cdn.datatables.net/fixedcolumns/3.2.2/css/fixedColumns.dataTables.min.css"></style>
<div id="wrapper">

    <div class="content">

    <?php echo form_open(admin_url('newview/add')); ?>

        <div class="row">

            <div class="col-md-12">

                <div class="panel_s">

        <!-- Import -->

        <div class="panel_s">



               <div class="panel-body _buttons">


                  <div class="row">

                     <div class="col-md-5">



                       <div class="container">

                          <!-- Trigger the modal with a button -->
                          <a href="<?=admin_url()?>newview/project/<?=$menu->id?>" class="btn btn-info pull-left display-block">
                              Thêm bất động sản mới
                          </a>



                          <!-- Modal -->

                        </div>



                     </div>


                     <div class="col-md-4 col-xs-12 pull-right leads-search">

                        <?php if($this->session->userdata('leads_kanban_view') == 'true') { ?>

                        <div data-toggle="tooltip" data-placement="bottom" data-title="<?php echo _l('search_by_tags'); ?>">

                        <?php echo render_input('search','','','search',array('data-name'=>'search','onkeyup'=>'leads_kanban();','placeholder'=>_l('leads_search')),array(),'no-margin') ?>

                        </div>

                        <?php } ?>

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

                        $where_not_admin = '(addedfrom = '.get_staff_user_id().' OR assigned='.get_staff_user_id().' OR is_public = 1)';

                        $numStatuses = count($statuses);

                        $is_admin = is_admin();

                        foreach($statuses as $status){ ?>

                     <div class="col-md-2 col-xs-6 border-right">

                        <?php

                           $this->db->where('status',$status['id']);

                           if(!$is_admin){

                            $this->db->where($where_not_admin);

                           }

                           $total = $this->db->count_all_results('tblleads');

                           ?>

                        <h3 class="bold"><?php echo $total; ?></h3>

                        <span style="color:<?php echo $status['color']; ?>"><?php echo $status['name']; ?></span>

                     </div>

                     <?php } ?>

                     <?php

                        if(!$is_admin){

                         $this->db->where($where_not_admin);

                        }

                        $total_leads = $this->db->count_all_results('tblleads');

                        ?>

                     <div class="col-md-2 col-xs-6">

                        <?php

                           $this->db->where('lost',1);

                           if(!$is_admin){

                            $this->db->where($where_not_admin);

                           }

                           $total_lost = $this->db->count_all_results('tblleads');

                           $percent_lost = ($total_leads > 0 ? number_format(($total_lost * 100) / $total_leads,2) : 0);

                           ?>

                        <h3 class="bold"><?php echo $percent_lost; ?>%</h3>

                        <span class="text-danger"><?php echo _l('lost_leads'); ?></span>

                     </div>

                     <div class="col-md-2 col-xs-6">

                        <?php

                           $this->db->where('junk',1);

                           if(!$is_admin){

                            $this->db->where($where_not_admin);

                           }

                           $total_junk = $this->db->count_all_results('tblleads');

                           $percent_junk = ($total_leads > 0 ? number_format(($total_junk * 100) / $total_leads,2) : 0);

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
                                $f_colum= ceil(12/(count($exigency)+1));
                                if($f_colum<=1)
                                {
                                    $f_colum=1;
                                }

                             ?>
                             <div class="row">
                                 <div class="col-lg-<?=$f_colum?> col-xs-12 col-md-12 total-column">
                                     <div class="panel_s">
                                         <div class="panel-body">
                                             <h4 class="text-muted"><?=count($status_project)?></h4>
                                             <span class="text-success"><?php echo _l('Tổng Bất Động Sản'); ?></span>
                                         </div>
                                     </div>
                                 </div>
                                 <?php foreach($exigency as $rum=> $va){
                                     $true=0;
                                     $all=0;
                                     ?>
                                     <?php foreach($status_project as $item) {
                                         if ($item['exigency'] == $va['id']){
                                             $all++;
                                             if ($item['status_project'] == 1) {
                                                 $true++;
                                             }
                                         }
                                     }?>
                                     <div class="col-lg-<?=$f_colum?> col-xs-12 col-md-12 total-column">
                                         <div class="panel_s">
                                             <div class="panel-body">
                                                 <h4 class="text-muted"><?=$true.'/'.$all?></h4>
                                                 <span class="text-info"><?php echo _l('Tổng Bất Động Sản '.$va['name']); ?></span>
                                             </div>
                                         </div>
                                     </div>

                                 <?php }?>
                             </div>
                             <div class="clearfix"></div>
                         </div>

                                         <style>
                                             .table-hover th input{min-width: 150px;}
                                         </style>
                                    <ul class="nav nav-tabs">
                                         <li class="active"><a data-toggle="tab" href="#tab-all">Tất cả</a></li>
                                         <?php foreach($exigency as $rom=> $value){?>
                                                <li><a data-toggle="tab" onclick="click_input('table_<?=$value['id']?>')" href="#tab-<?=$value['id']?>"><?=$value['name']?></a></li>
                                         <?php }?>
                                     </ul>

                                    <div class="tab-content">
                                         <style>
                                             .btn
                                             {
                                                 border:1px;
                                             }
                                         </style>
                                     <?php array_push($exigency,'')?>
                                         <?php foreach($exigency as $rom=> $value){?>

                                            <?php if($value['id']){?>
                                                    <div id="tab-<?=$value['id']?>" class="tab-pane">
                                             <?php }
                                                else
                                                 {?>
                                                     <div id="tab-all" class="tab-pane active">
                                                 <?php }?>
                                                        <h3 style="text-align: center"><?=$title?></h3>
                                                <div class="table-responsive no-dt">
                                                    <?php if($id)
                                                    {
                                                        if($value['id'])
                                                        {
                                                            $project=$this->newview_model->get_project_menu($id,$value['id']);
                                                        }
                                                        else
                                                        {
                                                            $project=$this->newview_model->get_project_menu($id);
                                                        }

                                                    }
                                                    ?>
                                                    <table id="table_<?=$value['id']?>" class="stripe table_<?=$value['id']?> row-border order-column" cellspacing="0" width="100%">

                                                        <?php if(!$order_colum){?>
                                                            <thead>
                                                            <tr>
                                                                 <th class="bold"><p class="text-center">Mã dự án</p><input class="form-control input-sm" id="code" placeholder="Mã dự án"></th>
                                                               <?php if($menu->province_table==1){?>
                                                                <th class="bold">
                                                                    <p class="text-center">Thành phố</p>
                                                                    <?php echo render_select('province_name', $province_name,array('name','name'),'','',array()); ?>
                                                                </th>
                                                                <?php }?>

                                                                <?php if($menu->district_table==1){?>
                                                                    <th class="bold">
                                                                        <p class="text-center">Quận/huyện</p>
                                                                        <?php echo render_select('district_name', $district_name,array('name','name'),'','',array()); ?>
                                                                    </th>
                                                                <?php }?>
                                                                <th class="bold"> <p class="text-center">Phòng ngủ</p><input class="form-control input-sm" id="type_pn" placeholder="Loại PN"></th>

                                                                <th class="bold">
                                                                    <p class="text-center">Hướng cửa</p>
                                                                    <?php echo render_select('door_direction_name', $door_direction_name,array('name','name'),'','',array()); ?>
                                                                </th>

                                                                <th class="bold">
                                                                    <p class="text-center">Nội thất</p>
                                                                    <?php echo render_select('furniture_name', $furniture,array('name','name'),'','',array()); ?>
                                                                </th>

                                                                <th class="bold"><p class="text-center">Tiện ích</p> <input class="form-control input-sm" id="convenient" placeholder="Tiện ích"></th>
                                                                <th class="bold"><p class="text-center">Đặc điểm sản phẩm</p> <input class="form-control input-sm" id="characteristics" placeholder="Đặc điểm sản phẩm"></th>
                                                                <th class="bold"><p class="text-center">Ngày lọc</p> <input class="form-control input-sm" id="date_update" placeholder="Ngày lọc"></th>
                                                                <th class="bold"><p class="text-center">Nhu cầu</p> <input class="form-control input-sm" id="exigency_name" placeholder="Nhu cầu"></th>
                                                                <th class="bold"><p class="text-center">Giá (VND)</p> <input class="form-control input-sm" id="price" placeholder="Giá"></th>
                                                                <th class="bold"><p class="text-center">Giá (USD)</p> <input class="form-control input-sm" id="cost" placeholder="Giá bán được"></th>
                                                                <th class="bold"> <p class="text-center">Tình trạng</p><input class="form-control input-sm" id="status" placeholder="Tình trạng"></th>
                                                                <th class="bold"> <p class="text-center">Giá gồm</p><input class="form-control input-sm" id="detail_price" placeholder="Giá gồm"></th>
                                                                <th class="bold"><p class="text-center">Thời gian thuê</p> <input class="form-control input-sm" id="deadline" placeholder="Thời gian hết HĐ"></th>
                                                                <th class="bold"><p class="text-center">Mã số thuế</p> <input class="form-control input-sm" id="code_tax" placeholder="Mã số thuế"></th>
                                                                <th class="bold"><p class="text-center">Người tạo sản phẩm</p> <input class="form-control input-sm" id="staff_id" placeholder="Người tạo sản phẩm"></th>
                                                                <th class="bold"><p class="text-center">Hoa hồng</p> <input class="form-control input-sm" id="bonus" placeholder="Hoa hồng"></th>
                                                                <th class="bold"><p class="text-center">Thẻ</p> <input class="form-control input-sm" id="tag" placeholder="Thẻ"></th>
                                                                <th class="bold"><p class="text-center">Ghi chú</p> <input class="form-control input-sm" id="note" placeholder="Ghi chú"></th>
                                                                <?php foreach($render_colum as $rcolum){?>
                                                                    <th class="bold">
                                                                        <p class="text-center"><?=$rcolum['name']?></p>
                                                                        <?=render_one_fields('menu_bds',false,'id='.$rcolum['id_field'])?>
                                                                    </th>
                                                                <?php }?>

                                                                <th class="bold view_people"><p class="text-center">Tên họ</p> <input class="form-control input-sm" id="fullname" placeholder="Tên họ"></th>
                                                                <th class="bold view_people"><p class="text-center">Số điện thoại</p> <input class="form-control input-sm" id="numberphone" placeholder="Số điện thoại"></th>
                                                                <th class="bold view_people"><p class="text-center">Email</p> <input class="form-control input-sm" id="email" placeholder="Email"></th>

                                                                <th class="bold"><p style="width: 100px;"><?=_l('options')?></p></th>
                                                            </tr>
                                                        </thead>
                                                        <?php }
                                                        else
                                                        {?>
                                                            <thead>
                                                                <tr>

                                                                    <?php $va= json_decode($order_colum->active) ?>
                                                                    <?php foreach($va as $ra=>$vi ){?>
                                                                        <?php if($vi->id=='province_name')
                                                                        {
                                                                            if($menu->province_table==1){?>
                                                                            <th class="bold">
                                                                                <p class="text-center">Thành phố</p>
                                                                                <?php echo render_select('province_name', $province_name,array('name','name'),'','',array()); ?>
                                                                            </th>
                                                                        <?php }}?>
                                                                        <?php if($vi->id=='district_name'){
                                                                            if($menu->district_table==1){?>
                                                                                <th class="bold">
                                                                                    <p class="text-center">Quận/huyện</p>
                                                                                    <?php echo render_select('district_name', $district_name,array('name','name'),'','',array()); ?>
                                                                                </th>
                                                                        <?php }}?>
                                                                        <?php if($vi->id=='door_direction_name'){?>
                                                                            <th class="bold">
                                                                                <p class="text-center">Hướng cửa</p>
                                                                                <?php echo render_select('door_direction_name', $door_direction_name,array('name','name'),'','',array()); ?>
                                                                            </th>
                                                                        <?php }?>

                                                                        <?php if($vi->id=='furniture_name'){?>
                                                                            <th class="bold">
                                                                                <p class="text-center">Nội thất</p>
                                                                                <?php echo render_select('furniture_name', $furniture,array('name','name'),'','',array()); ?>
                                                                            </th>
                                                                        <?php } ?>

                                                                            <?php if($vi->id!='province_name'&&$vi->id!='district_name'&&$vi->id!='door_direction_name'&&$vi->id!='furniture_name'){ ?>
                                                                            <th class="bold"><p class="text-center"><?=$vi->permission?></p><input class="form-control input-sm" id="<?=$vi->id?>" placeholder="<?=$vi->permission?>"></th>
                                                                            <?php }?>
                                                                        <?php }?>
                                                                    <th class="bold"><p style="width: 100px;"><?=_l('options')?></p></th>
                                                                </tr>
                                                            </thead>
                                                        <?php }?>
                                                        <?php if($order_colum){?>
                                                            <tbody>
                                                                <?php foreach($project as $r=> $rom){?>
                                                                        <tr class="sta-<?=$rom['status_project']?>">

                                                                            <?php foreach($va as $ra=>$v ){?>
                                                                                <?php
                                                                                if($v->id=='province_name'){
                                                                                            if($menu->province_table==1){
                                                                                                echo '<td class="province_name" title="'.$rom['province_name'].'" >'.$rom['province_name'].'</td>';
                                                                                            }
                                                                                        }
                                                                                else  if($v->id=='district_name'){
                                                                                                    if($menu->district_table==1){
                                                                                                        echo '<td class="district_name" title="'.$rom['district_name'].'">'.$rom['district_name'].'</td>';
                                                                                                    }
                                                                                            }
                                                                                else if($v->id=='tag')
                                                                                                {
                                                                                                   $view='';
                                                                                                   $view= '<td class="tag" title="'.prep_tags_input(get_tags_in($rom['id_project'],'project_bds')).'">';
                                                                                                        $tags = get_tags_in($rom['id_project'],'project_bds');
                                                                                                        if(count($tags) > 0){
                                                                                                            $view.= render_tags($tags);
                                                                                                            $view.= '<div class="clearfix"></div>';
                                                                                                        }
                                                                                                    $view.='</td>';
                                                                                                    echo $view;
                                                                                                }
                                                                                else if($v->id=='price'){
                                                                                        echo '<td class="price" title="'.$rom['price'].'">'.
                                                                                            number_format($rom['price'],0,".",".").
                                                                                            '</td>';
                                                                                        }
                                                                                else if($v->id=='code'){
                                                                                    echo '<td class="code" title="'.$rom['code'].'"><a href="'.admin_url().'newview/project/'.$rom['id_menu'].'/'.$rom['id_project'].'">'.$rom['code'].'</a></td>';

                                                                                }
                                                                                else if($v->id=='staff_id'){
                                                                                    echo '<td class="staff_id" title="'.get_staff_full_name($rom['staff_id']).'">'.
                                                                                            '<a data-toggle="tooltip" data-title="'.get_staff_full_name($rom['staff_id']).'" href="'.admin_url('profile/'.$rom['staff_id']).'">'.staff_profile_image($rom['staff_id'], array(
                                                                                        'staff-profile-image-small'
                                                                                    )) .' '.get_staff_full_name($rom['staff_id']).'</a>'.'</td>';

                                                                                }
                                                                                 else if($v->id=='cost'){
                                                                                    echo ' <td class="cost" title="'.$rom['cost'].'">'.number_format($rom['cost'],0,".",".").'</td>';
                                                                                 }
                                                                                else {
                                                                                    $_data="";
                                                                                    foreach($render_colum as $rcolum) {
                                                                                        if ($v->id == $rcolum['id_input'].'_'.$rcolum['id_field']) {
                                                                                            $data_value = get_field_value($rcolum['id_field'], $rom['id_project'], 'menu_bds', false);
                                                                                            if ($data_value)
                                                                                            {
                                                                                               $_data= '<td class="' . $rcolum['id_input'] . '_' . $rcolum['id_field'] . '" title="'.$data_value.'">' . $data_value . '</td>';
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    if($_data=="")
                                                                                    {
                                                                                        echo '<td class="'.$v->id.'" title="'.$rom[$v->id].'">
                                                                                                <a>'.$rom[$v->id].'</a>
                                                                                            </td>';
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        echo $_data;
                                                                                    }
                                                                                }
                                                                            }?>
                                                                            <td>
                                                                                <p>
                                                                                <div class="dropdown">
                                                                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i class="glyphicon glyphicon-check"></i>
                                                                                        <span class="caret"></span></button>
                                                                                    <ul class="dropdown-menu">
                                                                                        <?php $project_exigency= $this->newview_model->get_table_where('tblproject_exigency','id_project='.$rom['id_project']);?>
                                                                                        <?php foreach($exigency as $ex_value){ $co=0;?>
                                                                                            <?php foreach($project_exigency as $pe){?>
                                                                                                <?php if($pe['id_exigency']==$ex_value['id'])
                                                                                                {
                                                                                                    $co=1;
                                                                                                }?>
                                                                                            <?php }?>
                                                                                            <?php if($co==0){?>
                                                                                                <li><a href="javacript:void(0)" onclick="status_project(<?=$rom['id_project']?>,<?=$ex_value['id']?>)"><?= $ex_value['name'] ?></a></li>
                                                                                            <?php }?>
                                                                                        <?php } ?>
                                                                                    </ul>
                                                                                    <?=icon_btn('newview/delete_project/' . $rom['id_project'], 'remove', 'btn-danger _delete');?>

                                                                                </div>
                                                                                </p>
                                                                            </td>
                                                                    </tr>
                                                                <?php }?>
                                                            </tbody>
                                                        <?php } else {?>
                                                            <tbody>
                                                            <?php foreach($project as $rom){?>
                                                                <tr class="sta-<?=$rom['status_project']?>">
                                                                    <td class="code" title="<?=$rom['code']?>">
                                                                        <a href="<?=admin_url()?>newview/project/<?=$rom['id_menu'].'/'.$rom['id_project']?>">
                                                                            <?=$rom['code']?>
                                                                        </a>
                                                                    </td>
                                                                    <?php if($menu->province_table==1){?>
                                                                        <td class="province_name" title="<?=$rom['province_name']?>" >
                                                                            <?=$rom['province_name']?>
                                                                        </td>
                                                                    <?php }?>
                                                                    <?php if($menu->district_table==1){?>
                                                                        <td class="district_name" title="<?=$rom['district_name']?>">
                                                                            <?=$rom['district_name']?>
                                                                        </td>
                                                                    <?php }?>
                                                                    <td class="type_pn" title="<?=$rom['type_pn']?>">
                                                                        <?=$rom['type_pn']?>
                                                                    </td>
                                                                    <td class="door_direction_name" title="<?=$rom['door_direction_name']?>">
                                                                        <?=$rom['door_direction_name']?>
                                                                    </td>
                                                                    <td class="furniture" title="<?=$rom['furniture_name']?>">
                                                                        <?=$rom['furniture_name']?>
                                                                    </td>
                                                                    <td class="convenient" title="<?=$rom['convenient']?>">
                                                                        <?=$rom['convenient']?>
                                                                    </td>
                                                                    <td class="characteristics" title="<?=$rom['characteristics']?>">
                                                                        <?=$rom['characteristics']?>
                                                                    </td>
                                                                    <td class="date_update" title="<?=$rom['date_update']?>">
                                                                        <?=$rom['date_update']?>
                                                                    </td>
                                                                    <td class="exigency_name" title="<?=$rom['exigency_name']?>">
                                                                        <!--                                                                        --><?//=$rom['exigency_name']?>
                                                                    </td>
                                                                    <td class="price" title="<?=$rom['price']?>">
                                                                        <?=number_format($rom['price'],0,".",".");?>
                                                                    </td>
                                                                    <td class="cost" title="<?=$rom['cost']?>">
                                                                        <?=number_format($rom['cost'],0,".",".");?>
                                                                    </td>
                                                                    <td class="status" title="<?=$rom['status']?>">
                                                                        <?=$rom['status']?>
                                                                    </td>
                                                                    <td class="detail_price" title="<?=$rom['detail_price']?>">
                                                                        <?=$rom['detail_price']?></td>
                                                                    <td class="deadline" title="<?=$rom['deadline']?>"><?=$rom['deadline']?>
                                                                    </td>
                                                                    <td class="code_tax" title="<?=$rom['code_tax']?>">
                                                                        <?=$rom['code_tax']?>
                                                                    </td>
                                                                    <td class="staff_id" title="<?=get_staff_full_name($rom['staff_id'])?>">
                                                                        <?php  echo '<a data-toggle="tooltip" data-title="'.get_staff_full_name($rom['staff_id']).'" href="'.admin_url('profile/'.$rom['staff_id']).'">'.staff_profile_image($rom['staff_id'], array(
                                                                                'staff-profile-image-small'
                                                                            )) .' '.get_staff_full_name($rom['staff_id']).'</a>';
                                                                        ?>
                                                                    </td>
                                                                    <td class="bonus" title="<?=$rom['bonus']?>">
                                                                        <?=$rom['bonus']?>
                                                                    </td>
                                                                    <td class="tag" title="<?=prep_tags_input(get_tags_in($rom['id_project'],'project_bds'))?>">
                                                                        <?php
                                                                        $tags = get_tags_in($rom['id_project'],'project_bds');
                                                                        if(count($tags) > 0){
                                                                            echo render_tags($tags);
                                                                            echo '<div class="clearfix"></div>';
                                                                        } else {
                                                                            echo '-';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <td class="note" title="<?=$rom['note']?>">
                                                                        <?=$rom['note']?>
                                                                    </td>

                                                                    <?php foreach($render_colum as $rcolum){?>
                                                                        <?php
                                                                        $data_value=get_field_value($rcolum['id_field'],$rom['id_project'],'menu_bds',false);
                                                                        if(!$data_value)
                                                                        {
                                                                            $data_value="";
                                                                        }

                                                                        ?>
                                                                        <td class="<?=$rcolum['id_input']?>_<?=$rcolum['id_field']?>" title="<?=$data_value?>">
                                                                            <?=$data_value?>
                                                                        </td>
                                                                    <?php }?>

                                                                    <td class="fullname view_people" title="<?=$rom['name']?>">
                                                                        <?=$rom['name']?>
                                                                    </td>
                                                                    <td class="numberphone view_people" title="<?=$rom['phonenumber']?>">
                                                                        <?php $phone=explode(',',$rom['phonenumber']);
                                                                        $_data="";
                                                                        foreach($phone as $r)
                                                                        {
                                                                            $_data=$_data.'<span class="label label-default mleft5 inline-block">'.$r.'</span>';
                                                                        }?>
                                                                        <?=$_data?>
                                                                    </td>
                                                                    <td class="email view_people" title="<?=$rom['email_master']?>">
                                                                        <?=$rom['email_master']?>
                                                                    </td>
                                                                    <td>
                                                                        <p>
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i class="glyphicon glyphicon-check"></i>
                                                                                <span class="caret"></span></button>
                                                                            <ul class="dropdown-menu">
                                                                                <?php $project_exigency= $this->newview_model->get_table_where('tblproject_exigency','id_project='.$rom['id_project']);?>
                                                                                <?php foreach($exigency as $ex_value){ $co=0;?>
                                                                                    <?php foreach($project_exigency as $pe){?>
                                                                                        <?php if($pe['id_exigency']==$ex_value['id'])
                                                                                        {
                                                                                            $co=1;
                                                                                        }?>
                                                                                    <?php }?>
                                                                                    <?php if($co==0){?>
                                                                                        <li><a href="javacript:void(0)" onclick="status_project(<?=$rom['id_project']?>,<?=$ex_value['id']?>)"><?= $ex_value['name'] ?></a></li>
                                                                                    <?php }?>
                                                                                <?php } ?>
                                                                            </ul>
                                                                            <?=icon_btn('newview/delete_project/' . $rom['id_project'], 'remove', 'btn-danger _delete');?>

                                                                        </div>
                                                                        </p>
                                                                    </td>
                                                                </tr>
                                                            <?php }?>
                                                            </tbody>
                                                        <?php }?>
                                                    </table>
                                                 </div>
                                                     </div>
                                         <?php } ?>
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

    <?php init_tail(); ?>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
    <div id="script">
    <div id="content-script">
        <script>
            $(document).ready(function() {
                <?php foreach($exigency as $rom=> $value){?>
                    var table_<?=$value['id']?> = $('.stripe.table_<?=$value['id']?>').DataTable( {
                        ordering: false,
                        scrollY:        "500vh",
                        scrollX:        true,
                        scrollCollapse: true,
                        paging:         false,
                        fixedColumns:   {
                            leftColumns: 1
                        }
                    } );
                table_<?=$value['id']?>.columns().every( function () {
                        var that = this;
                        $( 'input,select', this.header() ).on( 'keyup change', function () {
                            if ( that.search() !== this.value ) {
                                that
                                    .search( this.value )
                                    .draw();
                            }
                        } );
                    } );
                <?php } ?>
                } )

        </script>

        <script>

            $( document ).ready(function() {
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
            });





        </script>
    </div>
</div>

    <script>
        function status_project(id_project,id)
        {
           var dataString={id_project:id_project,id:id};
            debugger;
            jQuery.ajax({
                type: "post",
                url: "<?=admin_url()?>newview/status_project",
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
        function click_input(class_table)
        {
            $('.table_1').reload();
            console.log($('.table_1').html());
//            console.log(class_table);
        }
    </script>

</body>

</html>