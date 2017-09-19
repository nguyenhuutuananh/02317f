<script>
 
 $(document).ready(function() {
        
    var initTable = (tableInit) => {
        if($.fn.DataTable.isDataTable(tableInit)) {
            return;
        }
        let objAttributes = {
            ordering: false,
            scrollY:        "300px",
            scrollX:        true,
            scrollCollapse: true,
            paging:         true,
            fixedColumns: {
                leftColumns: 2,
                rightColumns: 1,
            }
        };
        let tableVariable = $(tableInit).DataTable(objAttributes);
        tableVariable.columns().every( function () {
            var that = this;
                $( 'input', this.header() ).on( 'keyup change', function () {
                    console.log(this.value);
                if ( that.search() !== this.value ) {
                    that
                        .search(this.value)
                        .draw();
                }
            } );
        });
    }; 
    
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var idPanel = $(e.target).attr('href');
        let tableX = $(idPanel+'').find('table');
        var target = initTable($(tableX));
    });
    initTable($('#table_clients_care'));
    
    

    var fouces_input=$('th input');
    $.each($(fouces_input), function( index, value ) {
        if(value.value!="") {
            $(value).focus();
        }
    });
        
    $('table').removeClass('dataTable');
    const parentDiv = $('.dataTables_scrollHeadInner');
    const parentDivOver = parentDiv.parents('.dataTables_scroll').next();
    let stt = 1;
    parentDiv.find('table thead th input:lt(2)').each( (index, v) => {
        $(v).prop('name', 'fixedColumn_' + stt++);
    });
    stt = 1;
    parentDivOver.find('table thead th input').each( (index, v) => {
        $(v).prop('name', 'fixedColumn_' + stt++);
    });

    parentDivOver.find('table thead th input').on('change keyup', (e) => {
        let currentTarget = $(e.currentTarget);
        parentDiv.find('input[name="' + currentTarget.attr('name') + '"]').val(currentTarget.val());
        parentDiv.find('input[name="' + currentTarget.attr('name') + '"]').change();
    });
    $('body').on('click', '.delete-reminder-client', function() {
        var r = confirm(confirm_action_prompt);
        const thisButton = $(this);
        if (r == false) {
            return false;
        } else {
            $.get($(this).attr('href'), function(response) {
                alert_float(response.alert_type, response.message);
                if(response.alert_type != 'danger') {
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
                
            }, 'json');
        }
        return false;
    });
 });
 </script>