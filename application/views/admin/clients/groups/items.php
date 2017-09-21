
<h4 class="no-mtop bold"><?php echo _l('Lịch sử mua hàng'); ?></h4>
<hr />

<?php
    if(has_permission('projects','','view')){
?>
    <a href="#" onclick="new_product(); return false;" class="btn btn-info mbot25">Thêm sản phẩm</a>
<?php
    }
?>

<div class="row">
    <div class="col-md-3 col-xs-6 border-right text-center">
        <h3 class="bold"><?=number_format($total_item)?></h3>
        <span class="text-info">TỔNG SẢN PHẨM</span>
    </div>
    <div class="col-md-3 col-xs-6 border-right text-center">
        <h3 class="bold"><?=number_format($total_value)?></h3>
        <span class="text-warning">TỔNG CÔNG NỢ</span>
    </div>
    <div class="col-md-3 col-xs-6 border-right text-center">
        <h3 class="bold"><?=number_format($total_value_paid)?></h3>
        <span class="text-success">ĐÃ THANH TOÁN</span>
    </div>
    <div class="col-md-3 col-xs-6 border-right text-center">
        <h3 class="bold"><?=number_format($total_value-$total_value_paid)?></h3>
        <span class="text-danger">CHƯA THANH TOÁN</span>
    </div>
</div>
<div class="clearfix">
    <br />
</div>

<?php
$table_data = array(
    '#',
    _l('Dự án'),
    _l('Hình thức'),
    _l('Giá'),
    _l('Thời hạn thuê'),
    _l('Ngày mua/thuê'),
    _l('actions'),
    );
    render_datatable($table_data,'client-items');
?>

<div class="modal fade lead-modal" id="newProduct" tabindex="-1" role="dialog"  >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title">Khách hàng mua/thuê</span>
                </h4>
            </div>
            <?php echo form_open(admin_url('clients/addProduct/' . (isset($client) ? $client->userid : "")) ,array('id'=>'id_type', 'class' => 'form-item form-horizontal')); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php
                    echo render_inline_select('items[0][city]', $province, array('provinceid', 'name', 'type'), 'Tỉnh/Thành phố', '', array('onchange' => 'get_district_client(this)')); 
                    ?>
                    
                    <?php
                    echo render_inline_select('items[0][district]', $district, array('districtid', 'name', 'type'), 'Quận/huyện', '', array()); 
                    ?>

                    <?php
                    echo render_inline_select('items[0][menuBdsId]', $menu_project, array('id', 'menu_name'), 'Loại bất động sản', '', array('onchange' => 'get_project(this)'));
                    ?>

                    <?php echo render_inline_select('items[0][projectBdsId]', $id_project_bds, array('id', 'project_name', 'code'), 'Dự án', '', array()); ?>
                    <?php
                    $type_options = array(
                        array(
                            'id' => 1,
                            'value' => 'Mua'
                        ),
                        array(
                            'id' => 2,
                            'value' => 'Thuê'
                        ),
                    );
                    echo render_inline_select('items[0][type]', $type_options, array('id', 'value'), 'Hình thức', '', array(), array(), '', '', false);
                    ?>

                    <?php
                    echo render_inline_input('items[0][price]', 'Giá');
                    ?>

                    <?php
                    $period_options = array(
                        array(
                            'id' => 1,
                            'value' => '1 tháng'
                        ),
                        array(
                            'id' => 2,
                            'value' => '2 tháng'
                        ),
                        array(
                            'id' => 3,
                            'value' => '3 tháng'
                        ),
                        array(
                            'id' => 4,
                            'value' => '4 tháng'
                        ),
                        array(
                            'id' => 5,
                            'value' => '5 tháng'
                        ),
                        array(
                            'id' => 6,
                            'value' => '6 tháng'
                        ),
                        array(
                            'id' => 7,
                            'value' => '7 tháng'
                        ),
                        array(
                            'id' => 8,
                            'value' => '8 tháng'
                        ),
                        array(
                            'id' => 9,
                            'value' => '9 tháng'
                        ),
                        array(
                            'id' => 10,
                            'value' => '10 tháng'
                        ),
                        array(
                            'id' => 11,
                            'value' => '11 tháng'
                        ),
                        array(
                            'id' => 12,
                            'value' => '12 tháng'
                        ),
                    );
                    echo render_inline_select('items[0][rentalPeriod]', $period_options, array('id', 'value'), 'Thời hạn thuê');
                    ?>
                    <?php
                    echo render_inline_date_input('items[0][dateStart]', 'Ngày mua/thuê', date('Y-m-d'));
                    ?>
                    
                    </div> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->

