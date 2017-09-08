<div class="table-responsive no-dt">
    <table id="table_clients_care" class="table stripe table_all row-border order-column">
        <thead>
        <tr>
            <?php $order_menu=$this->clients_model->get_table('tblorder_table_clients','id=1');?>
            <?php $order_menu_ths=(array)json_decode($order_menu->value);?>
            <?php
                foreach($order_menu_ths as $rom_order_menu_th =>$order_menu_th){?>
                    <?php if(count((array)$order_menu_th->permission)>1){?>
                        <th colspan="<?php echo count((array)$order_menu_th->permission)-1;?>" >

                            <p class="text-center">
                               <?php $value_th=(array)$order_menu_th->permission;?>
                               <?php echo $value_th['title_th'];?>
                            </p>
<!--                            <input class="form-control input-sm" name="" id=""  value="">-->
                        </th>
                    <?php }
                    else {?>
                        <th rowspan="2" >

                            <p class="text-center">
                                <?=$order_menu_th->permission;?>
                            </p>
                            <input class="form-control input-sm" name="" id=""  value="">
                        </th>
                    <?php }
                    ?>
            <?php }?>
        </tr>

        <tr>
            <!--Đối tác-->
            <?php
                foreach($order_menu_ths as $rom_order_menu_th_2 =>$order_menu_th_2){?>
                    <?php if(count((array)$order_menu_th_2->permission)>1){?>
                        <?php $value_th_array=(array)$order_menu_th_2->permission;?>
                        <?php foreach($value_th_array as $rom_order_2=>$order_th_2){?>
                            <?php if($rom_order_2!='title_th'){?>
                                <th>
                                    <p class="text-center"><?=$order_th_2;?></p>
                                    <input class="form-control input-sm" name="" id=""  value="">
                                </th>
                            <?php }?>
                        <?php }?>
                <?php }?>
            <?php }?>
        </tr>
        </thead>
        <tbody>
        <?php foreach($clients_care as $rom){?>
            <tr>
            <?php
                foreach($order_menu_ths as $rom_order_menu_tr =>$order_menu_tr){?>
                    <?php if(count((array)$order_menu_tr->permission)>1){?>
                        <?php $value_th_array=(array)$order_menu_tr->permission;?>
                        <?php foreach($value_th_array as $rom_order_tr=>$order_tr){?>
                            <?php if($rom_order_tr!='title_th'){?>
                                <td>
                                    <?php if($rom_order_tr=='id_partner'){?>
                                            <?=render_tags(get_tags_partner_in($rom[$rom_order_tr]))?>
                                    <?php } else {?>
                                        <p class="text-center">
                                            <?=$rom[$rom_order_tr]?>
                                        </p>
                                    <?php }?>
                                </td>
                            <?php }?>
                        <?php }?>
                    <?php } else {?>
                        <?php if($order_menu_tr->id=='nvgd'||$order_menu_tr->id=='dksp'||$order_menu_tr->id=='dkkh'){?>
                                <td>
                                    <a data-toggle="tooltip" data-title="<?=get_staff_full_name($rom[$order_menu_tr->id])?>" href="<?=admin_url($rom[$order_menu_tr->id])?>"><?=staff_profile_image($rom[$order_menu_tr->id], array(
                                            'staff-profile-image-small'
                                        ))?> <?=get_staff_full_name($rom[$order_menu_tr->id])?></a>
                                </td>
<!--                            --><?php //}?>
<!--                            --><?php //if($order_menu_tr->id=='id_partner'){?>

                            <?php } else {?>
                                <td> <?=$rom[$order_menu_tr->id];?></td>
                            <?php }?>
                    <?php }?>
            <?php }?>
            </tr>
<!--            <tr>-->
<!--                <td>--><?//=$rom['date_contact']?><!--</td>-->
<!--                <td>--><?//=$rom['source_name']?><!--</td>-->
<!--                <td>--><?//=render_tags(get_tags_partner_in($rom['id_partner']))?><!--</td>-->
<!---->
<!--                <td>--><?//=$rom['name_partner']?><!--</td>-->
<!--                <td>--><?//=$rom['phone_partner']?><!--</td>-->
<!--                <td>--><?//=$rom['email_partner']?><!--</td>-->
<!---->
<!--                <td>--><?//=$rom['company']?><!--</td>-->
<!--                <td>--><?//=$rom['phonenumber']?><!--</td>-->
<!--                <td>--><?//=$rom['email']?><!--</td>-->
<!--                <td>--><?//=$rom['name_country']?><!--</td>-->
<!--                <td>--><?//=$rom['class_client_name']?><!--</td>-->
<!--                <td>--><?//=$rom['name_exigency']?><!--</td>-->
<!--                <td>--><?//=$rom['name_purpose']?><!--</td>-->
<!--                <td>--><?//=$rom['name_menu_bds']?><!--</td>-->
<!--                <td>--><?//=$rom['province_name']?><!--/--><?//=$rom['district_name']?><!--</td>-->
<!---->
<!--                <td>--><?//=$rom['name_bds']?><!--</td>-->
<!--                <td>--><?//=$rom['pn']?><!--</td>-->
<!--                <td>--><?//=$rom['area']?><!--</td>-->
<!--                <td>--><?//=$rom['budget']?><!--</td>-->
<!---->
<!---->
<!--                <td>--><?//=$rom['date_movein']?><!--</td>-->
<!--                <td>--><?//=$rom['date_tax']?><!--</td>-->
<!--                <td>--><?//=$rom['requirements']?><!--</td>-->
<!--                <td>--><?//=$rom['name_status']?><!--</td>-->
<!--                <td>-->
<!--                    <a data-toggle="tooltip" data-title="--><?//=get_staff_full_name($rom['nvgd'])?><!--" href="--><?//=admin_url($rom['nvgd'])?><!--">--><?//=staff_profile_image($rom['nvgd'], array(
//                            'staff-profile-image-small'
//                        ))?><!-- --><?//=get_staff_full_name($rom['nvgd'])?><!--</a>-->
<!--                </td>-->
<!--                <td>-->
<!--                    <a data-toggle="tooltip" data-title="--><?//=get_staff_full_name($rom['dksp'])?><!--" href="--><?//=admin_url($rom['dksp'])?><!--">--><?//=staff_profile_image($rom['dksp'], array(
//                            'staff-profile-image-small'
//                        ))?><!-- --><?//=get_staff_full_name($rom['dksp'])?><!--</a>-->
<!--                </td>-->
<!--                <td>-->
<!--                    <a data-toggle="tooltip" data-title="--><?//=get_staff_full_name($rom['dkkh'])?><!--" href="--><?//=admin_url($rom['dkkh'])?><!--">--><?//=staff_profile_image($rom['dkkh'], array(
//                            'staff-profile-image-small'
//                        ))?><!-- --><?//=get_staff_full_name($rom['dkkh'])?><!--</a>-->
<!--                </td>-->
<!--            </tr>-->
        <?php }?>
        </tbody>
    </table>
</div>