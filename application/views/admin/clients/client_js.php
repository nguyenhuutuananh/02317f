 <script>
 
 $(document).ready(function() {
        // let table_care = $('#table_clients_care').DataTable();
        // let table_buy = $('#table_clients_buy').DataTable();
        // let table_fail = $('#table_clients_fail').DataTable();

        
        // $('a[href="#take_care"]').on('click', (e) => {
            // initTable(e.currentTarget);
        // });

        let initTable = (tableInit) => {
            let objAttributes = {
                destroy: true,
                ordering: false,
                scrollY:        true,
                scrollX:        true,
                scrollCollapse: true,
                paging:         true,
                fixedColumns:   {
                    leftColumns: 2,
                    rightColumns: 1,
                }
            };
            
            let eachTable = $(tableInit).DataTable(objAttributes);
            eachTable.columns().every( function () {
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

        initTable($('#table_clients_care'));
        initTable($('#table_clients_buy'));
        initTable($('#table_clients_fail'));

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
        
 });
 </script>