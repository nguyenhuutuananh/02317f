
<div class="">
    <ul class="nav nav-tabs">
        <li  class="active"><a data-toggle="tab" href="#profile">Cá nhân</a></li>
        <li><a data-toggle="tab" href="#company">Công ty</a></li>
    </ul>
    <div class="tab-content mtop20">
        <div id="profile" class="tab-pane fade in active">
            <div class="_buttons" style="margin-bottom: 10px;">
                <a class="btn btn-info mright5" onclick="view_update_or_add(0,0)" data-toggle="modal" data-target="#view_master">Thêm chủ sở hữu</a>
                <a class="btn btn-danger mright5 test" onclick="_delete_all('table-master_bds','master_bds')" >Xóa số lượng lớn</a>
                <div class="clearfix"></div>
            </div>
            <?php
            $table_data = array();
            $table_data = array(
                _l('Mã chủ sở hữu'),
                _l('Họ Tên'),
                _l('Quan hệ'),
                _l('Quốc tịch'),
                _l('Xưng hô'),
                _l('Ngày sinh'),
                _l('CMND'),
                _l('Số điện thoại'),
                _l('Email'),
                _l('Thuế TNCN'),
                _l('Địa chỉ'),
                _l('Địa chỉ thường trú'),
                _l('Công ty'),
                _l('Chức vụ'),
                _l('Nghề nghiệp'),
                _l('Sở thích'),
                _l('Facebook'),
                _l('options')
            );
            array_unshift($table_data,'<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="master_bds"><label></label></div>');

            render_datatable($table_data,'master_bds_profile');
            ?>

        </div>
        <div id="company" class="tab-pane fade">

            <?php $company_pri=$this->newview_model->get_master_where('tblmaster_bds','type_master=2 and idproject='.$id_bds); ?>

                <div  class="_buttons btn-company" style="margin-bottom: 10px;<?php if(!$company_pri){?>display:none;<?php } ?>">
                    <a class="btn btn-info mright5" onclick="view_update_or_add(0,1)" data-toggle="modal" data-target="#view_master">Thêm nhân viên Công ty</a>
                    <a class="btn btn-danger mright5 test" onclick="_delete_all('table-master_bds','master_bds')" >Xóa số lượng lớn</a>
                    <div class="clearfix"></div>
                </div>
            <style>
                .input-md{
                    border:0px;
                    background-color: inherit;
                    box-shadow: none;
                }
            </style>
            <div class="col-md-12 well">
                <div class="company-well">
                    <button class="btn btn-default pull-right" data-toggle="modal" data-target="#view_master_company" data-id="<?=$company_pri->id?>" onclick="view_update_or_add_company(<?php if(isset($company_pri->id)) echo $company_pri->id; else echo '0'?>,2)"><i class="fa fa-pencil-square-o"></i></button>
                    <?php if($company_pri){?>
                        <div class="col-md-6 col-md-offset-4"><h3>Tên công ty:<?=$company_pri->name?> (<?=$company_pri->code_master?>)</h3></div>
                        <div class="col-md-4 col-md-offset-2"><h5>Số điện thoại: <?=$company_pri->phonenumber?></div>

                        <div class="col-md-4"><h5>Email:<?=$company_pri->email?></h5></div>

                        <div class="col-md-4  col-md-offset-2"><h5>Địa chỉ công ty:<?=$company_pri->address?></h5></div>
                        <div class="col-md-3 "><h5>Mã số thuế:<?=$company_pri->tax?></h5></div>

                        <div class="col-md-4 col-md-offset-2"><h5>Lĩnh vực kinh doanh:<?=$company_pri->hear?></h5></div>
                        <div class="col-md-4"><h5>Website: <?=$company_pri->website?></h5></div>
                    <?php }?>
                </div>
            </div>
            <?php
            $table_data = array();
            $table_data = array(
                _l('Mã chủ sở hữu'),
                _l('Họ Tên'),
                _l('Quan hệ'),
                _l('Quốc tịch'),
                _l('Xưng hô'),
                _l('Ngày sinh'),
                _l('CMND'),
                _l('Số điện thoại'),
                _l('Email'),
                _l('Thuế TNCN'),
                _l('Địa chỉ'),
                _l('Địa chỉ thường trú'),
                _l('Công ty'),
                _l('Chức vụ'),
                _l('Nghề nghiệp'),
                _l('Sở thích'),
                _l('Facebook'),
                _l('options')
            );
            array_unshift($table_data,'<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="master_bds"><label></label></div>');

            render_datatable($table_data,'master_bds_company', 'pageResize');
            ?>
        </div>
    </div>
</div>

