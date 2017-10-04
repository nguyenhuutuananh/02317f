<?php init_head(); ?>
<!-- Custom Timesheet plugin -->
<link rel="stylesheet" href="<?=base_url('assets/plugins/timesheet/css/')?>TimeSheet.css">
<!-- END Custom Timesheet plugin -->
<div id="wrapper">
	<div class="content">
		<div class="row">
            <div class="panel_s">
                <div class="panel-body">
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <h2 class="bold no-margin font-medium">
                            <?php echo $title; ?>
                        </h2>
                        <hr />
                        <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'staff_profile_table','autocomplete'=>'off')); ?>
                        <?php
                            $options = array(
                                array(
                                    'id' => 1,
                                    'name' => 'Tính theo ngày',
                                ),
                                array(
                                    'id' => 2,
                                    'name' => 'Tính theo buổi',
                                ),
                                array(
                                    'id' => 3,
                                    'name' => 'Tính theo giờ',
                                ),
                            );
                            echo render_select('jobType', $options, array('id', 'name'), 'Làm việc tính theo', '', array(), array(), '', '', false);
                        ?>
                        <div class="form-group">
                            <label for="workingHours" class="control-label ">Ngày làm việc</label>
                            <table class="table">
                                <thead></thead>
                                <tbody style="width: 600px;" id="J_timedSheet">
                                </tbody>
                            </table>
                            <input type="hidden" name="workingDays" id="workingDays">
                            <input type="hidden" name="workingHours" id="workingHours">
                        </div>
                        <?php
                            echo render_date_input('dateStartWork', 'Ngày bắt đầu làm việc', date('Y-m-d'));
                        ?>
                        <?php
                            echo render_textarea('note', 'Ghi chú');
                        ?>
                        <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                        <?php echo form_close(); ?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<!-- Custom Timesheet plugin -->
<script src="<?=base_url('assets/plugins/timesheet/js/')?>TimeSheet.js"></script>
<!-- END Custom Timesheet plugin -->
<script>
	$(function(){
        var dimensions = [1, 7];

        var selectList = [
            {id:"0",name:"Chọn"},
        ];

        var dayList = [
            {name:"Thứ 2",title:"Thứ 2"},
            {name:"Thứ 3",title:"Thứ 3"},
            {name:"Thứ 4",title:"Thứ 4"},
            {name:"Thứ 5",title:"Thứ 5"},
            {name:"Thứ 6",title:"Thứ 6"},
            {name:"Thứ 7",title:"Thứ 7"},
            {name:"Chủ nhật",title:"Chủ nhật"},
        ];

        var sheetData = [
            [0,0,0,0,0,0,0]
        ];
        var sheetHourData = [
            [0,0,0,0,0,0,0],
            [0,0,0,0,0,0,0],
        ];


        let initSheet = (SheetData) => {
            return $("#J_timedSheet").TimeSheet({
                data: {
                    dimensions : dimensions,
                    colHead : dayList,
                    rowHead : selectList,
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
            sheetData.forEach((r, index) => {
                rowArray.push(`[${sheet.getRowStates(index)}]`);
            });
            $('#workingDays').val(`[${rowArray.toString()}]`);
        };
        let sheet = initSheet(sheetData);

        $('#jobType').change(function() {
            let jobType = $(this).val();
            if(jobType != 3) {
                sheetHourData = [
                    [0,0,0,0,0,0,0],
                    [0,0,0,0,0,0,0],
                ];
                $('#workingHours').val(`[${sheetHourData.toString()}]`);
            }
            if(jobType == 1) {
                dimensions[0] = 1;
                selectList[0].name = "Chọn";
                if(selectList.length > 1) {
                    selectList = selectList.slice(0,1);
                }
                if(sheetData.length > 1) {
                    sheetData = sheetData.slice(0,1);
                }
            }
            else {
                dimensions[0] = 2;
                selectList[0].name = "Sáng";
                if(typeof selectList[1] == 'undefined') {
                    selectList.push({id: "1", name:"Chiều"});
                }
                if(typeof sheetData[1] == 'undefined') {
                    sheetData.push([0,0,0,0,0,0,0]);
                }
            }
            sheet = initSheet(sheetData);
            updateWorkingDays();
        });
        
		
        
        
        $(document).on('click', '#unSelectAll', function() {
            let indexRow = $('.TimeSheet-remark .btn').index(this);
            sheetData[indexRow] = sheetData[indexRow].map(x => 0);
            sheet = initSheet(sheetData);
            updateWorkingDays();
        });
        
        $(document).on('click', '.TimeSheet-rowHead', function() {
            if($('#jobType').val() == 3) return;
            let indexRow = $('.TimeSheet-rowHead').index(this);
            sheetData[indexRow] = sheetData[indexRow].map(x => 1);
            sheet = initSheet(sheetData);
            updateWorkingDays();
        });

        $(document).on('mousedown', '.TimeSheet-cell', function(e) {
            if($('#jobType').val() != 3) return;

            if(e.button === 0) {
                let hour = prompt('Nhập số giờ làm trong buổi này: ');
                while(isNaN(hour) || hour == '' || (hour > 24 || hour <= 0 && hour != null && hour != '')) {
                    hour = prompt('Nhập không hợp lệ. Nhập số giờ làm trong buổi này: ');
                }
                if(!hour) return;
                $(this).html('');
                $(this).append(hour + ' giờ');
                sheetHourData[$(this).attr('data-row')][$(this).attr('data-col')] = hour;
                $('#workingHours').val(`[${sheetHourData.toString()}]`);
            }
            else if(e.button === 2) {
                $(this).html('');
                sheetHourData[$(this).attr('data-row')][$(this).attr('data-col')] = 0;
                $('#workingHours').val(`[${sheetHourData.toString()}]`);
            }
        });

	});
	
</script>
</body>
</html>