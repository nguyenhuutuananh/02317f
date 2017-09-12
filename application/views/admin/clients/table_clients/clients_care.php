<?php
$table_heads = $table_heads_clients_care;
$clients = $clients_care;
?>
<div class="table-responsive no-dt">
    <table id="table_clients_care" class="table display stripe table_all row-border order-column" style="margin-bottom: 0px !important;">
        <thead>
        <tr>
            <!-- Row 2-->
            <?php
            if(isset($table_heads)) {
                foreach($table_heads as $table_head) {
                    if(count($table_head->childs) > 0) {
                    ?>
            <th colspan="<?php echo count($table_head->childs); ?>" >

                <p class="text-center">
                    <?php echo $table_head->title_th; ?>
                </p>
            </th>
                    <?php
                    }
                    else {
                    ?>
            <th rowspan="2" >
                <p class="text-center">
                    <?=$table_head->title_th;?>
                </p>
                <input class="form-control input-sm" name="" id=""  value="">
            </th>
                    <?php
                    }
                }
                ?>
                <th rowspan="2">
                    <p class="text-center"><?=_l('actions')?></p>
                </th>
                <?php
            }
        ?>
        </tr>
        <tr>
            <!-- Row 2-->
            <?php
            if(isset($table_heads)) {
                foreach($table_heads as $table_head) {
                    foreach($table_head->childs as $child) {
                        ?>
            <th>
                <p class="text-center"><?=$child->title_th;?></p>
                <input class="form-control input-sm" name="" id=""  value="">
            </th>
                        <?php
                    }
                }
            }
            ?>
        </tr>
        </thead>

        <tbody>
        <?php foreach($clients as $rowItem){?>
            <tr>
            <?php
                if(isset($table_heads)) {
                    $thuTuCot = 1;
                    foreach($table_heads as $table_head) {
                        $object_check = array();
                        if(count($table_head->childs) == 0) {
                            $object_check[] = $table_head;
                        }
                        else {
                            $object_check = $table_head->childs;
                        }
                        
                        foreach($object_check as $objectTableHeading) {
                        ?>
                        <td>
                        <?php
                            if($thuTuCot <= 2) {
                                ?>
                                <a href="<?=admin_url('clients/client/' . $rowItem['userid'] . '?type_client=1')?>">
                                <?php
                            }
                            switch ($objectTableHeading->id) {
                                case 'id_partner':
                                    echo render_tags(get_tags_partner_in($rowItem[$objectTableHeading->id]));
                                    break;
                                case 'province_name':
                                    ?>
                                    <?=$rowItem['province_name']?>/<?=$rowItem['district_name']?>
                                    <?php
                                    break;
                                case 'nvgd':
                                case 'dksp':
                                case 'dkkh':
                                        ?>
                                                <a data-toggle="tooltip" data-title="<?=get_staff_full_name($rowItem[$objectTableHeading->id])?>" href="<?=admin_url($rowItem[$objectTableHeading->id])?>"><?=staff_profile_image($rowItem[$objectTableHeading->id], array(
                                                        'staff-profile-image-small'
                                                    ))?> <?=get_staff_full_name($rowItem[$objectTableHeading->id])?></a>
                                        <?php
                                    break;
                                    default:
                                        ?>
                                                <p class="text-center">
                                                <?=$rowItem[$objectTableHeading->id]?>
                                                </p>
                                        <?php
                                    break;
                            }
                            if($thuTuCot <= 2) {
                                ?>
                                </a>
                                <?php
                            }
                            $thuTuCot++;
                        ?>
                        </td>
                        <?php
                        }
                    }
                    ?>
                    <td>
                        <a href="<?=admin_url('clients/client/' . $rowItem['userid'] . '?type_client=1')?>" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                    </td>
                    <?php
                }
            ?>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>