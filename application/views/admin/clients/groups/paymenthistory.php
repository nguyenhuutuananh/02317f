<?php if(isset($client)){ ?>
<h4 class="no-mtop bold"><?php echo _l('client_payments_tab'); ?></h4>
<hr />
<?php
    $table_data = array(
        _l('STT'),
        _l('Dự án'),
        _l('Ngày thanh toán'),
        _l('Số tiền'),
        _l('Thanh toán bằng'),
        _l('actions'),
        );
    render_datatable($table_data,'payment-history');
}
?>