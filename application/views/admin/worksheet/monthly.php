<?php init_head(); ?>
<!-- Custom Timesheet plugin -->
<link rel="stylesheet" href="<?=base_url('assets/plugins/timesheet/css/')?>TimeSheet.css">
<!-- END Custom Timesheet plugin -->
<div id="wrapper">
	<div class="content">
		<div class="row">
            <button type="button" id="btnCreateWorkSheet" class="btn btn-info" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Load dữ liệu">Tạo lịch làm việc cho nhân viên</button>
            <hr />

            <hr />
            <table>
                <thead></thead>
                <tbody id="J_timedSheet">
                </tbody>
            </table>

        </div>
    </div>
</div>

<div class="modal fade lead-modal" id="createWorksheet" tabindex="-1" role="dialog"  >
    <div class="modal-dialog" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title">Tạo lịch làm việc cho nhân viên</span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-submit-virtual" class="btn btn-info"><?php echo _l('submit'); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php init_tail(); ?>
<!-- Custom Timesheet plugin -->
<script src="<?=base_url('assets/plugins/timesheet/js/')?>TimeSheet.js"></script>
<!-- END Custom Timesheet plugin -->
<script>
    // 
    let sheetModal;
    
    // TimedSheet
	$(function(){
        //$('#createWorksheet').modal('show');
        <?php
        $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        ?>
		var dimensions = [<?=count($staffsWorksheet)?>, <?=$days?>];

        var hourList = [
            <?php
            foreach($staffsWorksheet as $member) {
            ?>
            {id:"<?=$member->info->staffid?>",name:"<?=$member->info->firstname?> <?=$member->info->lastname?>"},
            <?php
            }
            ?>
        ];

        var dayList = [
            <?php
            for($i=1;$i<=$days;$i++) {
                $dayofweek = date('w', strtotime("$yearWorksheet-$monthWorksheet-$i"));
                $dayStr = "";
                if($dayofweek == 0) {
                    $dayStr = "Chủ nhật";
                }
                else {
                    $dayStr = "Thứ " . ($dayofweek+1);
                }
                ?>
                {name: "<b><?=$dayStr?></b><br /><?=$i?>", title: "<?=$dayStr?> ngày <?=$i?>"},
                <?php
            }
            ?>
        ];

        var sheetData = [
            <?php
            
            foreach($staffsWorksheet as $member) {
                $lastMonthDays = [];
                if($member->lastMonth) {
                    $lastMonthDays = $member->lastMonth->workingDays;
                }
            ?>
            [
            <?php
                $currentMilestone = 0;
                $milestones = array();
                // Lấy các mốc thời gian và id
                foreach($member->current as $key=>$worksheet) {
                    $milestones[] = array(date('d', strtotime($worksheet->dateStartWork)), $key);
                }
                
                // Chạy ngày làm ở < tháng này
                for($i=1; count($milestones) > 0 && $i<$milestones[0][0] || (count($milestones) == 0 && $i <= $days);$i++) {
                    if(count($lastMonthDays) > 0) {
                        $temp = json_decode($lastMonthDays);
                        $dayofweek = date('w', strtotime("$yearWorksheet-$monthWorksheet-$i"));
                        $dayofweek--;
                        if($dayofweek == -1 ) $dayofweek = 6;
                        if($temp[0][$dayofweek] == 1 || ( count($temp) > 1 && $temp[1][$dayofweek] == 1 ) ) {
                            echo "1";
                        }
                        else {
                            echo "0";
                        }
                    }
                    else {
                        echo "0";
                    }
                    if($i!=$milestones[0][0]) echo ",";
                }
                for($i=$milestones[0][0];$i<=$days;$i++) {
                    if(isset($milestones[$currentMilestone+1]) && $i >= $milestones[$currentMilestone+1][0])
                        $currentMilestone++;
                    $temp = json_decode($member->current[$currentMilestone]->workingDays);
                    $dayofweek = date('w', strtotime("$yearWorksheet-$monthWorksheet-$i"));
                    $dayofweek--;
                    if($dayofweek == -1 ) $dayofweek = 6;
                    
                    if($temp[0][$dayofweek] == 1 || ( count($temp) > 1 && $temp[1][$dayofweek] == 1 ) ) {
                        echo "1";
                    }
                    else {
                        echo "0";
                    }
                    if($i!==$days) echo ",";
                }
            ?>
            ],
            <?php
            }
            ?>
        ];
        <?php
        if(count($staffsWorksheet) > 0) {
            ?>
        const sheet = $("#J_timedSheet").TimeSheet({
            data: {
                dimensions : dimensions,
                colHead : dayList,
                rowHead : hourList,
                sheetHead : {name:"<p style='text-align:right;'> Ngày làm &nbsp;</p><br /><p style='text-align:left;'>&nbsp; Nhân viên </p>"},
                sheetData : sheetData
            },
            remarks : {
                title : "Description",
                default : "N/A"
            }
        });
        sheet.disable();
            <?php
        }
        ?>

        // Modal
        var dimensionsModal = [1, 7];
        var selectListModal = [
            {id:"0",name:"Chọn"},
        ];
        var dayListModal = [
            {name:"Thứ 2",title:"Thứ 2"},
            {name:"Thứ 3",title:"Thứ 3"},
            {name:"Thứ 4",title:"Thứ 4"},
            {name:"Thứ 5",title:"Thứ 5"},
            {name:"Thứ 6",title:"Thứ 6"},
            {name:"Thứ 7",title:"Thứ 7"},
            {name:"Chủ nhật",title:"Chủ nhật"},
        ];
        var sheetDataModal = [
            [0,0,0,0,0,0,0]
        ];
        var sheetHourDataModal = [
            [0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0],
        ];
        let initSheet = (SheetData) => {
            return $("#J_workSheet").TimeSheet({
                data: {
                    dimensions : dimensionsModal,
                    colHead : dayListModal,
                    rowHead : selectListModal,
                    sheetHead : {name:"Ngày làm việc"},
                    sheetData : SheetData,
                    removeSelector: $('#jobType').val() == 3,
                },
                remarks : {
                    title : "Chuột trái chọn, chuột phải bỏ chọn",
                    default : "<button type=\"button\" class=\"btn\" id=\"unSelectAll\">Bỏ chọn hết</button>"
                },
                end : function(ev,selectedArea){
                    updateWorkingDays();
                }
            });
        };
        let updateWorkingDays = () => {
            let rowArray = [];
            sheetDataModal.forEach((r, index) => {
                rowArray.push(`[${sheetModal.getRowStates(index)}]`);
            });
            $('#createWorksheet #workingDays').val(`[${rowArray.toString()}]`);
        };

        $(document).on('change', '#createWorksheet #jobType', function() {
            let jobType = $(this).val();
            if(jobType != 3) {
                sheetHourDataModal = [
                    [0,0,0,0,0,0,0],
                    [0,0,0,0,0,0,0],
                ];
                $('#createWorksheet #workingHours').val(`[${sheetHourDataModal.toString()}]`);
            }
            if(jobType == 1) {
                dimensionsModal[0] = 1;
                selectListModal[0].name = "Chọn";
                if(selectListModal.length > 1) {
                    selectListModal = selectListModal.slice(0,1);
                }
                if(sheetDataModal.length > 1) {
                    sheetDataModal = sheetDataModal.slice(0,1);
                }
            }
            else {
                dimensionsModal[0] = 2;
                selectListModal[0].name = "Sáng";
                if(typeof selectListModal[1] == 'undefined') {
                    selectListModal.push({id: "1", name:"Chiều"});
                }
                if(typeof sheetDataModal[1] == 'undefined') {
                    sheetDataModal.push([0,0,0,0,0,0,0]);
                }
            }
            sheetModal = initSheet(sheetDataModal);
            updateWorkingDays();
        });
        
        $(document).on('click', '#createWorksheet #unSelectAll', function() {
            let indexRow = $('.TimeSheet-remark .btn').index(this);
            sheetDataModal[indexRow] = sheetDataModal[indexRow].map(x => 0);
            sheetDataModal = initSheet(sheetDataModal);
            updateWorkingDays();
        });
        
        $(document).on('click', '#createWorksheet .TimeSheet-rowHead', function() {
            if($('#jobType').val() == 3) return;
            let indexRow = $('.TimeSheet-rowHead').index(this);
            sheetDataModal[indexRow] = sheetDataModal[indexRow].map(x => 1);
            sheetModal = initSheet(sheetDataModal);
            updateWorkingDays();
        });

        $(document).on('mousedown', '#createWorksheet .TimeSheet-cell', function(e) {
            if($('#jobType').val() != 3) return;

            if(e.button === 0) {
                let hour = prompt('Nhập số giờ làm trong buổi này: ');
                while(isNaN(hour) || hour == '' || (hour > 24 || hour <= 0 && hour != null && hour != '')) {
                    hour = prompt('Nhập không hợp lệ. Nhập số giờ làm trong buổi này: ');
                }
                if(!hour) return;
                $(this).html('');
                $(this).append(hour + ' giờ');
                sheetHourDataModal[$(this).attr('data-row')][$(this).attr('data-col')] = hour;
                $('#workingHours').val(`[${sheetHourDataModal.toString()}]`);
            }
            else if(e.button === 2) {
                $(this).html('');
                sheetHourDataModal[$(this).attr('data-row')][$(this).attr('data-col')] = 0;
                $('#workingHours').val(`[${sheetHourDataModal.toString()}]`);
            }
        });
	
        // ALL
        $('#btnCreateWorkSheet').click(function() {
            let buttonCreate = $(this).button('loading');
            $('#createWorksheet .modal-body .row').html('');
            $.get(admin_url + 'worksheet/modal_create/', function(data) {
                $('#createWorksheet .modal-body .row').html(data);

                // Init data
                init_selectpicker();
                init_datepicker();
                sheetModal = initSheet(sheetDataModal);
                
                _validate_form($('#createWorksheet #form-create-worksheet'),{
                    'staffid': 'required',
                    'workingDays': 'required',
                    'dateStartWork': 'required',
                },send_data_form);
                
                $('#createWorksheet').modal('show');
                buttonCreate.button('reset');
            })
            .fail(function(data) {
                buttonCreate.button('reset');
            });
        });

        function send_data_form(form) {
            var data = $(form).serialize();
            var url = form.action;
            $.post(url, data).done(function(response) {
                response = JSON.parse(response);
                if(response.success){
                    alert_float('success',response.message);
                    location.reload();
                }
                else {
                    alert_float('danger',response.message);
                }
                // $(form)[0].reset();
                
                // $('.selectpicker').val('');
                // $('.selectpicker').change();
                // $('.selectpicker').selectpicker('refresh');

                // $(form).find('.datepicker').val('<?= date('Y-m-d') ?>');
                // $('#createWorksheet').modal('show');
            });
            return false;
        }
        $('#btn-submit-virtual').click(function() {
            console.log($('#createWorksheet #form-create-worksheet'));
            $('#createWorksheet #form-create-worksheet').submit();
        });
    });
</script>
</body>
</html>