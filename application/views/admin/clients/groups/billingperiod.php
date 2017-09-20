
<h4 class="no-mtop bold"><?php echo _l('Đợt thanh toán'); ?></h4>
<hr />

<?php
    if(has_permission('projects','','view')){
?>
    <a href="#" onclick="new_period(); return false;" class="btn btn-info mbot25">Thêm đợt thanh toán</a>
<?php
    }
?>

<div class="row">

</div>
<?php
$table_data = array(
    _l('Đợt'),
    _l('Hạn thanh toán'),
    _l('Số tiền'),
    _l('Trạng thái'),
    _l('actions'),
    );
    render_datatable($table_data,'billing-period');
?>

<div class="modal fade lead-modal" id="addPeriod" tabindex="-1" role="dialog"  >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title">Thêm đợt thanh toán</span>
                </h4>
            </div>
            <?php echo form_open('#' ,array('id'=>'formAddPeriod', 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
            <div class="modal-body">
                <?php
                    echo render_inline_date_input('datePay', 'Hạn thanh toán');
                ?>
                <?php
                    echo render_inline_input('value', 'Số tiền', '', 'text');
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade lead-modal" id="addPayment" tabindex="-1" role="dialog"  >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title">Thanh toán đợt</span>
                </h4>
            </div>
            <?php echo form_open('#' ,array('id'=>'formAddPay', 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
            <div class="modal-body">
                <?php
                    echo render_inline_date_input('datePay', 'Ngày thanh toán');
                ?>
                <?php
                    $methods = customGetPaymentMethods();
                    echo render_inline_select('idPaymentMethod', $methods, array('id', 'name'), 'Phương thức thanh toán');
                ?>
                <?php
                    echo render_inline_input('realValue', 'Số tiền', '', 'text');
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade lead-modal" id="viewPaymentList" tabindex="-1" role="dialog"  >
    <div class="modal-dialog" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title">Danh sách thanh toán đợt</span>
                </h4>
            </div>
            <?php echo form_open('#' ,array('id'=>'', 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
            <div class="modal-body">
            <?php
            $table_data = array(
                _l('STT'),
                _l('Ngày thanh toán'),
                _l('Số tiền'),
                _l('Thanh toán bằng'),
                _l('actions'),
                );
                render_datatable($table_data,'billing-payment');
            ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->