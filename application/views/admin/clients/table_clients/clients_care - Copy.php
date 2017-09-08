<div class="table-responsive no-dt">
    <table id="table_clients_care" class="table stripe table_all row-border order-column">
        <thead>
        <tr>
            <?php $order_menu=$this->clients_model->get_table('tblorder_table_clients','id=1');?>
            <?php $order_menu_th=(array)json_decode($order_menu->value);?>
            <th rowspan="2" >

                <p class="text-center">
                    Ngày liên hệ
                </p>
                <input class="form-control input-sm" name="" id=""  value="">
            </th>
            <th rowspan="2" >Nguồn</th>
            <!--Đối tác-->
            <th colspan="4" class="bg-success">Đối tác</th>
            <!--Đối tác-->

            <!--Khách hàng-->

            <th colspan="4" class="bg-warning">khách hàng</th>
            <!--Khách hàng-->

            <th rowspan="2">Loại khách hàng</th>
            <th rowspan="2">Nhu cầu</th>
            <th rowspan="2">Mục đích</th>

            <!--Yêu cầu khu vực-->
            <th colspan="3" class="bg-info">Yêu cầu khu vực/DA</th>

            <!--Yêu cầu chi tiết-->
            <th colspan="3" class="bg-danger">Yêu cầu chi tiết sản phẩm</th>
            <th colspan="2" class="bg-success">Thời gian</th>
            <!--End Yêu cầu chi tiết-->


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
        <?php foreach($clients_care as $rom){?>
            <tr>
                <td><?=$rom['date_contact']?></td>
                <td><?=$rom['source_name']?></td>
                <td><?=render_tags(get_tags_partner_in($rom['id_partner']))?></td>

                <td><?=$rom['name_partner']?></td>
                <td><?=$rom['phone_partner']?></td>
                <td><?=$rom['email_partner']?></td>

                <td><?=$rom['company']?></td>
                <td><?=$rom['phonenumber']?></td>
                <td><?=$rom['email']?></td>
                <td><?=$rom['name_country']?></td>
                <td><?=$rom['class_client_name']?></td>
                <td><?=$rom['name_exigency']?></td>
                <td><?=$rom['name_purpose']?></td>
                <td><?=$rom['name_menu_bds']?></td>
                <td><?=$rom['province_name']?>/<?=$rom['district_name']?></td>

                <td><?=$rom['name_bds']?></td>
                <td><?=$rom['pn']?></td>
                <td><?=$rom['area']?></td>
                <td><?=$rom['budget']?></td>


                <td><?=$rom['date_movein']?></td>
                <td><?=$rom['date_tax']?></td>
                <td><?=$rom['requirements']?></td>
                <td><?=$rom['name_status']?></td>
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