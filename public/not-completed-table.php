<section class="content-header">
    <h1>Users /<small><a href="home.php"><i class="fa fa-home"></i> Home</a></small></h1>
            <ol class="breadcrumb">
                <a class="btn btn-block btn-default" href="add-user.php"><i class="fa fa-plus-square"></i> Add New User</a>
            </ol>

</section>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-12">
                <div class="box">
                  
                    
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id='users_table' class="table table-hover" data-toggle="table" data-url="api-firebase/get-bootstrap-table-data.php?table=not-completed" data-page-list="[5, 10, 20, 50, 100, 200]" data-show-refresh="true" data-show-columns="true" data-side-pagination="server" data-pagination="true" data-search="true" data-trim-on-search="false" data-filter-control="true" data-query-params="queryParams" data-sort-name="id" data-sort-order="desc" data-show-export="true" data-export-types='["txt","csv"]' data-export-options='{
                            "fileName": "yellow app-users-list-<?= date('d-m-Y') ?>",
                            "ignoreColumn": ["operate"] 
                        }'>
                            <thead>
                                <tr>
                                    <th data-field="id" data-sortable="true">ID</th>
                                    <th data-field="name" data-sortable="true">Name</th>
                                    <th data-field="mobile" data-sortable="true">Mobile Number</th>
                                    <th data-field="email" data-sortable="true">Email</th>
                                    <th data-field="password" data-sortable="true">Password</th>
                                    <th data-field="place" data-sortable="true">Place</th>
                                    <th data-field="skills" data-sortable="true">Skills</th>
                                    <th data-field="working_experience" data-sortable="true">Working Experience</th>
                                    <th data-field="status" data-sortable="true">Status</th>
                                    <th data-field="chat" data-sortable="true">chat</th>
                                    <th data-field="register_date" data-sortable="true">Register Date</th>
                                    <th data-field="register_time" data-sortable="true">Register Time</th>
                                    <th data-field="plan_start_date" data-sortable="true">Plan Start Date</th>
                                    <th data-field="plan_end_date" data-sortable="true">Plan End Date</th>
                                    <th data-field="remaining_days" data-sortable="true">remaining_days</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="separator"> </div>
        </div>
        <!-- /.row (main row) -->
    </section>

    <script>
    // $('#seller_id').on('change', function() {
    //     $('#products_table').bootstrapTable('refresh');
    // });
    $('#status').on('change', function() {
            idf = $('#status').val();
            $('#users_table').bootstrapTable('refresh');
    });

    function queryParams(p) {
        return {
            "status": $('#status').val(),
            // "seller_id": $('#seller_id').val(),
            // "community": $('#community').val(),
            limit: p.limit,
            sort: p.sort,
            order: p.order,
            offset: p.offset,
            search: p.search
        };
    }
</script>


