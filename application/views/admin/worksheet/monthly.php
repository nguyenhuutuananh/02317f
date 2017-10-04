<?php init_head(); ?>
<!-- Custom Timesheet plugin -->
<link rel="stylesheet" href="<?=base_url('assets/plugins/timesheet/css/')?>TimeSheet.css">
<!-- END Custom Timesheet plugin -->
<div id="wrapper">
	<div class="content">
		<div class="row">

            <hr />
            <table>
                <thead></thead>
                <tbody id="J_timedSheet">
                </tbody>
            </table>

        </div>
    </div>
</div>
<?php init_tail(); ?>
<!-- Custom Timesheet plugin -->
<script src="<?=base_url('assets/plugins/timesheet/js/')?>TimeSheet.js"></script>
<!-- END Custom Timesheet plugin -->
<script>
	$(function(){
        <?php
        $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        ?>
		var dimensions = [<?=count($staffsWorksheet)?>, <?=$days?>];

        var hourList = [
            <?php
            foreach($staffsWorksheet as $member) {
            ?>
            {id:"<?=$member->current[0]->staffid?>",name:"<?=$member->current[0]->firstname?> <?=$member->current[0]->lastname?>"},
            <?php
            }
            ?>
        ];

        var dayList = [
            <?php
            for($i=1;$i<=$days;$i++) {
                ?>
                {name:"Ngày <?=$i?>",title:"Ngày <?=$i?>"},
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
                
                for($i=1;$i<=$days;$i++) {
                    
                    if($i!==$days) echo ",";
                }
            ?>
            ],
            <?php
            }
            ?>
        ];
        const sheet = $("#J_timedSheet").TimeSheet({
            data: {
                dimensions : dimensions,
                colHead : dayList,
                rowHead : hourList,
                sheetHead : {name:"Nhân viên\\Ngày làm"},
                sheetData : sheetData
            },
            remarks : {
                title : "Description",
                default : "N/A"
            }
        });
        console.log(sheet);


	});
	
</script>
</body>
</html>