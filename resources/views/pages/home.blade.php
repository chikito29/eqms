@extends('./layouts/super-admin')

@section('page-title')
    Home | eQMS
@endsection

@section('nav-home') active @endsection

@section('page-content')
<div class="page-content-wrap" style="margin-top: 50px;">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <br><br>
                    <h1 style="text-align: center;">Welcome to eQMS!</h1><br><br>
                    <div style="text-align: center; padding-left:50px; padding-right:50px; padding-bottom:50px;">
                        <h4>
                        This site is currently being developed in an attempt to convert NSCPI's Quality Manuals into electronic format. We are hoping that through this system, we will be able to maintain and enhance the center's documented Quality Policies and Procedures more dynamically.<br><br><br>We are really working hard to create a highly usable system but since this is a work in progress, we wish to apologize in advance for momentary errors that you might encounter. Nevertheless, we will highly appreciate if you can notify us by dropping an email to <span style="font-weight: bold;">info@newsim.ph</span> should you encounter any.
                    </h4>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="x-content" >
        <div class="x-content-inner" style="margin-top:-20px;">
            <div class="row">
                <div class="col-md-6">

                    <div class="x-block">
                        <div class="x-block-head">
                            <h3>REVISION REQUESTS</h3>
                            <div class="pull-right">
                                <button class="btn btn-default">ACTIONS <span class="fa fa-angle-down" style="margin-left: 20px;"></span></button>
                            </div>
                        </div>
                        <div class="x-block-content">
                            <table class="table x-table">
                                <tr>
                                    <th><label class="check"><input type="checkbox" name="checkall" class="icheckbox"></label></th>
                                    <th width="30%">AUTHOR</th>
                                    <th width="40%">COMMENT</th>
                                    <th width="30%">THEME</th>
                                </tr>
                                <tr>
                                    <td><label class="check"><input type="checkbox" class="icheckbox"></label></td>
                                    <td>
                                        <a href="#" class="x-user">
                                            <img src="assets/images/users/user2.jpg">
                                            <span>Roger Parker</span>
                                        </a>
                                        <span>16.09.2015 1:15 pm</span>
                                    </td>
                                    <td>Nice job with maecenas mi lorem, placerat eget dolor id, porta iaculis tortor. Nam suscipit tempus nisi, sed condimentum arcu. Vivamus elementum quam ut mattis porttitor.</td>
                                    <td>New design layout for ATLANT admin template</td>
                                </tr>
                                <tr>
                                    <td><label class="check"><input type="checkbox" class="icheckbox"></label></td>
                                    <td>
                                        <a href="#" class="x-user">
                                            <img src="assets/images/users/user3.jpg">
                                            <span>Maria Jackson</span>
                                        </a>
                                        <span>16.09.2015 1:15 pm</span>
                                    </td>
                                    <td>It looks like maecenas mi lorem, placerat eget dolor id, porta iaculis tortor. Nam suscipit tempus nisi, sed condimentum arcu. Vivamus elementum quam ut mattis porttitor.</td>
                                    <td>New design layout for ATLANT admin template</td>
                                </tr>
                                <tr>
                                    <td><label class="check"><input type="checkbox" class="icheckbox"></label></td>
                                    <td>
                                        <a href="#" class="x-user">
                                            <img src="assets/images/users/user4.jpg">
                                            <span>Douglas Cook</span>
                                        </a>
                                        <span>16.09.2015 1:15 pm</span>
                                    </td>
                                    <td>We need to add some praesent et erat ex. Maecenas mi lorem, placerat eget dolor id, porta iaculis tortor. Nam suscipit tempus nisi, sed condimentum arcu.</td>
                                    <td>New design layout for ATLANT admin template</td>
                                </tr>
                                <tr>
                                    <td><label class="check"><input type="checkbox" class="icheckbox"></label></td>
                                    <td>
                                        <a href="#" class="x-user">
                                            <img src="assets/images/users/user5.jpg">
                                            <span>Brian Dawson</span>
                                        </a>
                                        <span>16.09.2015 1:15 pm</span>
                                    </td>
                                    <td>I’ve chacked this template and maecenas mi lorem, placerat eget dolor id, porta iaculis tortor. Nam suscipit tempus nisi, sed condimentum arcu. Vivamus elementum quam ut mattis porttitor.</td>
                                    <td>New design layout for ATLANT admin template</td>
                                </tr>
                                <tr>
                                    <td><label class="check"><input type="checkbox" class="icheckbox"></label></td>
                                    <td>
                                        <a href="#" class="x-user">
                                            <img src="assets/images/users/user2.jpg">
                                            <span>Roger Parker</span>
                                        </a>
                                        <span>16.09.2015 1:15 pm</span>
                                    </td>
                                    <td>I’ve chacked this template and maecenas mi lorem, placerat eget dolor id, porta iaculis tortor. Nam suscipit tempus nisi, sed condimentum arcu. Vivamus elementum quam ut mattis porttitor.</td>
                                    <td>New design layout for ATLANT admin template</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <ul class="pagination pagination-sm push-up-20">
                        <li class="disabled"><a href="#">Previous</a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">Next</a></li>
                    </ul>

                </div>
                <div class="col-md-6">

                    <div class="x-block">
                        <div class="x-block-head">
                            <h3>REVISION LOGS</h3>
                            <div class="pull-right">
                                <button class="btn btn-default">ACTIONS <span class="fa fa-angle-down" style="margin-left: 20px;"></span></button>
                            </div>
                        </div>
                        <div class="x-block-content x-todo">
                            <div class="x-todo-header">
                                <label class="check"><input type="checkbox" class="icheckbox"></label>
                                <h3>7 NEW TASKS FOR TODAY</h3>
                                <button class="btn btn-default pull-right">TODAY: 14 SEP. 2015 <span class="fa fa-angle-down"></span></button>
                            </div>
                            <div class="x-todo-content scroll" style="height: 550px;">
                                <div class="item">
                                    <div class="head">
                                        <div class="pull-left"><span class="status status-high"></span> Priority: High</div>
                                        <div class="pull-left">Project: ATLANT Template</div>
                                        <div class="pull-right"><span class="fa fa-clock-o"></span> added few minutes ago</div>
                                    </div>
                                    <div class="title">
                                        <label class="check"><input type="checkbox" class="icheckbox"></label>
                                        <h4>MAKE NEW ATLANT DASHBOARD</h4>
                                    </div>
                                    <div class="content">
                                        Donec porta suscipit odio et luctus. Mauris vel velit dignissim, lobortis mauris non, ultricies sapien
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="head">
                                        <div class="pull-left"><span class="status status-low"></span> Priority: Low</div>
                                        <div class="pull-left">Project: New awesome projec</div>
                                        <div class="pull-right"><span class="fa fa-clock-o"></span> added 15 minutes ago</div>
                                    </div>
                                    <div class="title">
                                        <label class="check"><input type="checkbox" class="icheckbox"></label>
                                        <h4>CALL MARTIN PHILLIPS ABOUT NEW PROJECT </h4>
                                    </div>
                                    <div class="content">
                                        Fusce eu nunc nisl. Duis tincidunt dui lectus. Suspendisse urna dolor, venenatis eu bibendum ut, placerat id sem. Nulla iaculis augue in nulla rutrum
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="head">
                                        <div class="pull-left"><span class="status status-low"></span> Priority: Low</div>
                                        <div class="pull-left">Project: Imaginary Shop</div>
                                        <div class="pull-right"><span class="fa fa-clock-o"></span> added 3 hours ago</div>
                                    </div>
                                    <div class="title">
                                        <label class="check"><input type="checkbox" class="icheckbox"></label>
                                        <h4>PRINT THE INOVOISES FOR BRIAN DAWSON</h4>
                                    </div>
                                    <div class="content">
                                        Donec porta suscipit odio et luctus. Mauris vel velit dignissim, lobortis mauris non, ultricies sapien
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="head">
                                        <div class="pull-left"><span class="status status-medium"></span> Priority: Medium</div>
                                        <div class="pull-left">Project: Landing page for Themeforest</div>
                                        <div class="pull-right"><span class="fa fa-clock-o"></span> added 7 hours ago</div>
                                    </div>
                                    <div class="title">
                                        <label class="check"><input type="checkbox" class="icheckbox"></label>
                                        <h4>NEW ATLANT DASHBOARD</h4>
                                    </div>
                                    <div class="content">
                                        Donec porta suscipit odio et luctus. Mauris vel velit dignissim, lobortis mauris non, ultricies sapien
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="head">
                                        <div class="pull-left"><span class="status status-low"></span> Priority: Medium</div>
                                        <div class="pull-left">Project: Shop for Themeforest</div>
                                        <div class="pull-right"><span class="fa fa-clock-o"></span> added 8 hours ago</div>
                                    </div>
                                    <div class="title">
                                        <label class="check"><input type="checkbox" class="icheckbox"></label>
                                        <h4>OS-COMMERCE SHOP TEMPLATE</h4>
                                    </div>
                                    <div class="content">
                                        Donec porta suscipit odio et luctus. Mauris vel velit dignissim, lobortis mauris non, ultricies sapien
                                    </div>
                                </div>
                            </div>
                            <div class="x-todo-footer">
                                <div class="pull-right">
                                    <a href="#"><span class="fa fa-plus"></span> Add new task</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script type='text/javascript' src='/js/plugins/icheck/icheck.min.js'></script>
@endsection
