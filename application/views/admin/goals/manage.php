<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <?php if(has_permission('goals','','create')){ ?>
                <div class="panel_s">
                    <div class="panel-body _buttons">
                        <a href="<?php echo admin_url('goals/goal'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new_goal'); ?></a>
                    </div>
                </div>
                <?php } ?>
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="clearfix"></div>
                        <?php render_datatable(array(
                            _l('goal_subject'),
                            _l('goal_achievement'),
                            _l('goal_start_date'),
                            _l('goal_end_date'),
                            _l('goal_type'),
                            _l('goal_progress'),
                            _l('options')
                            ),'goals'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function(){
        initDataTable('.table-goals', window.location.href, [5, 6], [5, 6]);
        $('.table-goals').DataTable().on('draw', function() {
            var rows = $('.table-goals').find('tr');
            $.each(rows, function() {
                var td = $(this).find('td').eq(5);
                var percent = $(td).find('input[name="percent"]').val();
                $(td).find('.goal-progress').circleProgress({
                    value: percent,
                    size: 45,
                    animation: false,
                    fill: {
                        gradient: ["#28b8da", "#059DC1"]
                    }
                })
            })
        })
    })
</script>
</body>
</html>
