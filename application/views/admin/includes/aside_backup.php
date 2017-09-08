<aside id="menu" class="sidebar">
    <ul class="nav metis-menu" id="side-menu">
        <li class="dashboard_user">
            Xin chào admin <i class="fa fa-power-off top-left-logout pull-right" data-toggle="tooltip" data-title="Đăng xuất" data-placement="left" onclick="logout(); return false;"></i>
        </li>
        <li class="quick-links">
            <div class="dropdown dropdown-quick-links">
                <a href="#" class="dropdown-toggle" id="dropdownQuickLinks" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <i class="fa fa-gavel" aria-hidden="true"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownQuickLinks">
                    <li>
                        <a href="http://192.168.1.17/02317F/admin/invoices/invoice">Tạo hóa đơn</a>
                    </li>
                    <li>
                        <a href="http://192.168.1.17/02317F/admin/estimates/estimate">Tạo ước tính</a>
                    </li>
                    <li>
                        <a href="http://192.168.1.17/02317F/admin/expenses/expense">Record Chi phí</a>
                    </li>
                    <li>
                        <a href="http://192.168.1.17/02317F/admin/proposals/proposal">Đề xuất mới</a>
                    </li>
                    <li>
                        <a href="http://192.168.1.17/02317F/admin/projects/project">Dự án mới</a>
                    </li>
                    <li>
                        <a href="#" onclick="new_task();return false;">Tạo công việc</a>
                    </li>
                    <li>
                        <a href="http://192.168.1.17/02317F/admin/clients/client">Tạo khách hàng</a>
                    </li>
                    <li>
                        <a href="http://192.168.1.17/02317F/admin/contracts/contract">Tạo hợp đồng</a>
                    </li>
                    <li>
                        <a href="#" onclick="init_lead(); return false;">Tạo cuộc gọi</a>
                    </li>
                    <li>
                        <a href="http://192.168.1.17/02317F/admin/goals/goal">Thiết lập mục tiêu mới</a>
                    </li>
                    <li>
                        <a href="http://192.168.1.17/02317F/admin/knowledge_base/article">Tạo bài báo cơ sở kiến thức</a>
                    </li>
                    <li>
                        <a href="http://192.168.1.17/02317F/admin/surveys/survey">Tạo khảo sát</a>
                    </li>
                    <li>
                        <a href="http://192.168.1.17/02317F/admin/tickets/add">Mở vé</a>
                    </li>
                    <li>
                        <a href="http://192.168.1.17/02317F/admin/staff/member">Tạo nhân viên</a>
                    </li>
                    <li>
                        <a href="http://192.168.1.17/02317F/admin/utilities/calendar?new_event=true&amp;date=2017-08-15">Thêm sự kiện mới</a>
                    </li>
                </ul>
            </div>

        </li>

        <li class="menu-item-dashboard">
            <a href="http://192.168.1.17/02317F/admin/" aria-expanded="false"><i class="fa fa-tachometer menu-icon"></i>
                Bảng Điều Khiển    </a>
        </li>

        <li class="menu-item-customers">
            <a href="http://192.168.1.17/02317F/admin/clients" aria-expanded="false"><i class="fa fa-users menu-icon"></i>
                Khách Hàng    </a>
        </li>

        <li class="menu-item-partner">
            <a href="http://192.168.1.17/02317F/admin/partner" aria-expanded="false"><i class="glyphicon glyphicon-list-alt menu-icon"></i>
                Đối tác    </a>
        </li>
        <li><a href="http://192.168.1.17/02317F/admin/newview"><i class="fa fa-balance-scale menu-icon" aria-hidden="true"></i>Danh sách loại BĐS</a></li>
        <li class="menu-item-sales">
            <a href="#" aria-expanded="false"><i class="fa fa-balance-scale menu-icon"></i>
                Dạng bất động sản      <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                <li class="sub-menu-item-58"><a href="http://192.168.1.17/02317F/admin/newview/indexproject/58">
                        VILLA/HOUSE</a>
                </li>
                <li class="sub-menu-item-76"><a href="http://192.168.1.17/02317F/admin/newview/indexproject/76">
                        SERVICED APARTMENT</a>
                </li>
                <li class="sub-menu-item-130"><a href="http://192.168.1.17/02317F/admin/newview/indexproject/130">
                        Căn hộ mới</a>
                </li>
                <li class="sub-menu-item-141"><a href="http://192.168.1.17/02317F/admin/newview/indexproject/141">
                        Căn hộ vĩnh hạo</a>
                </li>
                <li class="sub-menu-item-142"><a href="http://192.168.1.17/02317F/admin/newview/indexproject/142">
                        CĂN HỘ/DỰ ÁN</a>
                </li>
            </ul>
        </li>

        <li class="menu-item-projects">
            <a href="http://192.168.1.17/02317F/admin/projects" aria-expanded="false"><i class="glyphicon glyphicon-list-alt menu-icon"></i>
                Dự án    </a>
        </li>

        <li class="menu-item-sales">
            <a href="#" aria-expanded="false"><i class="fa fa-balance-scale menu-icon"></i>
                Kế toán      <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse" aria-expanded="false">
                <li class="sub-menu-item-child-invoices"><a href="http://192.168.1.17/02317F/admin/invoices/list_invoices">
                        Hóa Đơn</a>
                </li>
                <li class="sub-menu-item-child-payments"><a href="http://192.168.1.17/02317F/admin/payments">
                        Thanh toán</a>
                </li>
            </ul>
        </li>

        <li class="menu-item-tasks">
            <a href="http://192.168.1.17/02317F/admin/tasks/list_tasks" aria-expanded="false"><i class="fa fa-tasks menu-icon"></i>
                Nhiệm Vụ    </a>
        </li>

        <li class="menu-item-staff">
            <a href="http://192.168.1.17/02317F/admin/staff" aria-expanded="false"><i class="glyphicon glyphicon-user menu-icon"></i>
                Nhân Viên    </a>
        </li>

        <li class="menu-item-reports">
            <a href="#" aria-expanded="false"><i class="fa fa-area-chart menu-icon"></i>
                Báo Cáo      <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse" aria-expanded="false">
                <li class="sub-menu-item-child-sales"><a href="http://192.168.1.17/02317F/admin/reports/sales">
                        Bán Hàng</a>
                </li>
                <li class="sub-menu-item-child-expenses"><a href="http://192.168.1.17/02317F/admin/reports/expenses">
                        Chi phí</a>
                </li>
                <li class="sub-menu-item-child-expenses-vs-income"><a href="http://192.168.1.17/02317F/admin/reports/expenses_vs_income">
                        Chi phí vs Thu nhập</a>
                </li>
                <li class="sub-menu-item-child-leads"><a href="http://192.168.1.17/02317F/admin/reports/leads">
                        cuộc gọi</a>
                </li>

                <style>
                    #side-menu li .nav-third-level li{
                        background-color: #ffffff!important;

                    }
                    #side-menu li .nav-third-level li.active a {
                        color: black!important;
                        /* border-radius: 0; */
                         background-color:aqua!important;
                        /* border-left: 0!important; */
                        display: inline-block!important;
                        padding: 5px 15px!important;
                        /*margin: 8px 0 8px 30px;*/
                    }
                    #side-menu li .nav-third-level li a{
                        color: black!important;
                        /* border-radius: 0; */
                        background-color:white!important;
                        /* border-left: 0!important; */
                        display: inline-block!important;
                        padding: 5px 15px!important;
                        margin: 8px 0px 8px 50px!important;

                    }
                    a.pa_menu_third {
                        width: 100%;
                        margin: 0px!important;
                        padding: 0px;
                        border-radius: 0px!important;
                    }
                    #side-menu li .pa_menu_third .nav-third-level li.active a {
                        color: black!important;
                         border-radius: 0px;
                        width: 100%;
                        background-color: #03a9f4;
                        border-left: 0!important;
                        display: inline-block;
                        /* padding: 5px 15px; */
                        /* margin: 8px 0 8px 30px; */
                    }
                    #side-menu li .nav-second-level li.active a li .nav-third-level li.active a {
                        color: black!important;
                    }
                    li.sub-menu-item-child-kb-articles.active a p {
                        margin: 0px!important;
                        padding: 7px 10px 7px 30px!important;
                    }

                </style>
                <li class="sub-menu-item-child-kb-articles">

                    <a href="#" class="pa_menu_third">
                        <p>Text <span class="fa arrow"></span></p>
                    </a>
                            <ul class="nav nav-third-level" aria-expanded="false">
                                <li><a href="#" style="color: #03a9f4!important">
                                        Bán Hàng</a>
                                </li>
                                <li><a href="#" style="color: #03a9f4!important">
                                        Chi phí</a>
                                </li>
                                <li><a href="#" style="color: #03a9f4!important">
                                        Chi phí vs Thu nhập</a>
                                </li>
                                <li ><a href="#" style="color: #03a9f4!important">
                                        cuộc gọi</a>
                                </li>
                                <li>

                                    <a href="#" style="color: #03a9f4!important">
                                        Thông Báo</a>
                                </li>
                            </ul>
                </li>
            </ul>
        </li>

        <li class="menu-item-utilities">
            <a href="#" aria-expanded="false"><i class="fa fa-cogs menu-icon"></i>
                Tiện ích      <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level collapse" aria-expanded="false">
                <li class="sub-menu-item-child-media"><a href="http://192.168.1.17/02317F/admin/utilities/media">
                        Phương tiện truyền thông</a>
                </li>
                <li class="sub-menu-item-child-bulk-pdf-exporter"><a href="http://192.168.1.17/02317F/admin/utilities/bulk_pdf_exporter">
                        Export hàng loạt tệp PDF</a>
                </li>
                <li class="sub-menu-item-child-calendar"><a href="http://192.168.1.17/02317F/admin/utilities/calendar">
                        Lịch</a>
                </li>
                <li class="sub-menu-item-child-announcements"><a href="http://192.168.1.17/02317F/admin/announcements">
                        Thông Báo</a>
                </li>
                <li class="sub-menu-item-child-database-backup"><a href="http://192.168.1.17/02317F/admin/utilities/backup">
                        Sao lưu cơ sở dữ liệu</a>
                </li>
                <li class="sub-menu-item-child-activity-log"><a href="http://192.168.1.17/02317F/admin/utilities/activity_log">
                        Hoạt động đăng nhập</a>
                </li>
                <li class="sub-menu-item-ticket-pipe-log"><a href="http://192.168.1.17/02317F/admin/utilities/pipe_log">
                        Đăng nhập</a>
                </li>
            </ul>
        </li>

        <li id="setup-menu-item">
            <a href="#" class="open-customizer"><i class="fa fa-cog menu-icon"></i>
                Cài đặt</a>
        </li>
    </ul>
</aside>