<div class="table-responsive no-dt">
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th rowspan="2" class="bold"><p class="text-center">Ngày liên hệ</p> <input class="form-control input-sm" id="type_area" placeholder="Ngày liên hệ"></th>
            <th rowspan="2" class="bold"><p class="text-center">Nguồn</p> <input class="form-control input-sm" id="type_area" placeholder="Nguồn"></th>
            <!--Đối tác-->
            <th colspan="4" class="bg-success">Đối tác</th>
            <!--Đối tác-->

            <!--Khách hàng-->

            <th colspan="4" class="bg-warning">khách hàng</th>
            <!--Khách hàng-->

            <th rowspan="2"><p class="text-center">Loại khách hàng</p> <input class="form-control input-sm" id="type_area" placeholder="Loại khách hàng"></th>
            <th rowspan="2"><p class="text-center">Nhu cầu</p> <input class="form-control input-sm" id="type_area" placeholder="Nhu cầu"></th>
            <th rowspan="2"><p class="text-center">Mục đích</p> <input class="form-control input-sm" id="type_area" placeholder="Mục đích"></th>

            <!--Yêu cầu khu vực-->
            <th colspan="3" class="bg-info"><p class="text-center">Yêu cầu khu vực/dự án</p> <input class="form-control input-sm" id="type_area" placeholder="Yêu cầu khu vực/dự án"></th>

            <!--Yêu cầu chi tiết-->
            <th colspan="3" class="bg-danger">Yêu cầu chi tiết sản phẩm</th>
            <th colspan="2" class="bg-success">Thời gian</th>
            <!--End Yêu cầu chi tiết-->
            
            
            <th rowspan="2" class="bg-info">Thanh toán</th>
            <th rowspan="2">Yêu cầu khác</th>
            <th rowspan="2">Trạng thái</th>
            <th rowspan="2">NV GD</th>
            <th rowspan="2">DK SP</th>
            <th rowspan="2">ĐK Khách khàng</th>
        </tr>

        <tr>
            <!--Đối tác-->

            <th>Phân loại Đối tác</th>
            <th>Họ Tên(Đối tác)</th>
            <th>Số điện thoại(Đối tác)</th>
            <th>Email(Đối tác)</th>
            <!--Đối tác-->

            <!--Khách hàng-->

            <th>Tên khách hàng</th>
            <th>Số điện thoại(Khách hàng)</th>
            <th>Email(Khách hàng)</th>
            <th>Quốc tịch</th>
            <!--Khách hàng-->


            <!--Yêu cầu khu vực-->
            <th>Loại bds</th>
            <th>Quận khu vực</th>
            <th>DA</th>

            <!--Yêu cầu chi tiết-->
            <th>PN</th>
            <th>DT</th>
            <th>Ngân sách khoản</th>
            <!--End Yêu cầu chi tiết-->

            <th>Ngày move in</th>
            <th>Thời gian thuê</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($clients_buy as $rom_b){?>
            <tr>
                <td><?=$rom_b['date_contact']?></td>
                <td><?=$rom_b['source_name']?></td>
                <td><?=render_tags(get_tags_partner_in($rom_b['id_partner']))?></td>

                <td><?=$rom_b['name_partner']?></td>
                <td><?=$rom_b['phone_partner']?></td>
                <td><?=$rom_b['email_partner']?></td>

                <td><?=$rom_b['company']?></td>
                <td><?=$rom_b['phonenumber']?></td>
                <td><?=$rom_b['email']?></td>
                <td><?=$rom_b['name_country']?></td>
                <td><?=$rom_b['class_client_name']?></td>
                <td><?=$rom_b['name_exigency']?></td>
                <td><?=$rom_b['purpose']?></td>
                <td><?=$rom_b['name_menu_bds']?></td>
                <td><?=$rom_b['province_name']?>/<?=$rom['district_name']?></td>

                <td><?=$rom_b['name_bds']?></td>
                <td><?=$rom_b['pn']?></td>
                <td><?=$rom_b['area']?></td>
                <td><?=$rom_b['budget']?></td>
                <td><?=$rom_b['date_movein']?></td>
                <td><?=$rom_b['date_tax']?></td>
                <td>
                    <?php $time_bonus=explode(',',$rom_b['time_bonus'])?>
                    <?php $num_bonus=explode(',',$rom_b['num_bonus'])?>
                    <div class="tags-labels">
                        <?php foreach($time_bonus as $n=> $r){?>
                            <span class="label label-tag tag-id-<?=$n?>">
                                                                        <span class="tag"><?=$r?> : <?=$num_bonus[$n]?></span>
                                                                        <span class="hide">, </span>
                                                                    </span>
                        <?php }?>
                    </div>
                </td>
                <!--                                                            <td>--><?//=$rom_b['num_bonus']?><!--</td>-->
                <td><?=$rom_b['requirements']?></td>
                <td><?=$rom_b['status']?></td>
                <td>
                    <a data-toggle="tooltip" data-title="<?=get_staff_full_name($rom['nvgd'])?>" href="<?=admin_url($rom['nvgd'])?>"><?=staff_profile_image($rom['nvgd'], array(
                            'staff-profile-image-small'
                        ))?> <?=get_staff_full_name($rom['nvgd'])?></a>
                </td>
                <td>
                    <a data-toggle="tooltip" data-title="<?=get_staff_full_name($rom['dksp'])?>" href="<?=admin_url($rom['dksp'])?>"><?=staff_profile_image($rom['dksp'], array(
                            'staff-profile-image-small'
                        ))?> <?=get_staff_full_name($rom['dksp'])?></a>
                </td>
                <td>
                    <a data-toggle="tooltip" data-title="<?=get_staff_full_name($rom['dkkh'])?>" href="<?=admin_url($rom['dkkh'])?>"><?=staff_profile_image($rom['dkkh'], array(
                            'staff-profile-image-small'
                        ))?> <?=get_staff_full_name($rom['dkkh'])?></a>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>