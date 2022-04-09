<aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                             <?php
								$profile = $this->session->userdata['profile_pic'];
								if(empty($profile)) {
									$profile = 'avatar5.png';
								}
                            ?>
                            <img src="<?php echo base_url('assets/users/'.$profile)?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $this->session->userdata['username'];?></p>

                            <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
                        </div>
                    </div>
                    <!-- search form -->
                    
                    <!-- search form -->
                    
                    <form target="_blank" action="<?php echo base_url();?>user/old_search" method="post" class="sidebar-form">
                        <div class="input-group">
                        <?php
                        $q = $this->input->post('q');
                        ?>
                            <input type="text" name="old_q" value="<?php echo $q;?>" class="form-control" placeholder="Old Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <form target="_blank" action="<?php echo base_url();?>user/search_job" method="post" class="sidebar-form">
                        <div class="input-group">
                        <?php
                        $q = $this->input->post('job_number');
                        ?>
                            <input type="text" name="job_number" value="<?php echo $q;?>" class="form-control" placeholder="Search by Job Number"/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <form target="_blank" action="<?php echo base_url();?>user/search" method="post" class="sidebar-form">
                        <div class="input-group">
                        <?php
                        $q = $this->input->post('q');
                        ?>
                            <input type="text" name="q" value="<?php echo $q;?>" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <form action="<?php echo base_url();?>master/search_master" method="post" class="sidebar-form">
                        <div class="input-group">
                        <?php
                        $q = $this->input->post('q');
                        ?>
                            <input type="text" name="q" value="<?php echo $q;?>" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="<?php echo base_url();?>">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>


                        <li class="active">
                            <a target="_blank" href="<?php echo base_url();?>jobs/edit">
                                <i class="fa fa-dashboard"></i> <span>New Job</span>
                            </a>
                        </li>
                        <li class="active">
                            <a target="_blank" href="<?php echo base_url();?>diwali">
                                <i class="fa fa-dashboard"></i> <span>Diwali 2021</span>
                            </a>
                        </li>

                        <li>
                            <a target="_blank" href="<?php echo base_url();?>account/quick">
                                <i class="fa fa-envelope"></i> <span>Quick Account</span>
                            </a>
                        </li>
                        
                        <li class="active">
                            <a href="<?php echo base_url();?>master/unverifyjobs">
                                <i class="fa fa-dashboard"></i> <span>Job Unverify</span>
                            </a>
                        </li>

                        <li class="active">
                            <a target="_blank" href="<?php echo base_url();?>expense">
                                <i class="fa fa-dashboard"></i> <span>Expense List</span>
                            </a>
                        </li>
                        
                        <li class="active">
                            <a target="_blank" href="<?php echo base_url();?>customer/special_rates">
                                <i class="fa fa-dashboard"></i> <span>Special Rates</span>
                            </a>
                        </li>

                        <li class="active">
                            <a target="_blank" href="<?php echo base_url();?>dealer/edit">
                                <i class="fa fa-dashboard"></i> <span>Add New Dealer</span>
                            </a>
                        </li>

                        <li class="active">
                            <a href="#sms_address" class="fancybox">
                                <i class="fa fa-dashboard"></i> <span>Send Address</span>
                            </a>
                        </li>

                        <li class="active">
                            <a href="javascript:void(0);" class="" id="popupBoxRestuarant" onclick="openPopupBoxRestuarant();">
                                <i class="fa fa-dashboard"></i> <span>Restaurant Menu</span>
                            </a>
                        </li>

                        <li class="active">
                            <a href="javascript:void(0);" class="" id="openPopupBoxPEstimate" onclick="openPopupBoxPEstimate();">
                                <i class="fa fa-dashboard"></i> <span>Sticker Estimate</span>
                            </a>
                        </li>
                        
                        <li class="active">
                            <a href="javascript:void(0);" class="" id="popupBoxGEstimate" onclick="openPopupBoxGEstimate();">
                                <i class="fa fa-dashboard"></i> <span>Estimate</span>
                            </a>
                        </li>

                        <li class="active">
                            <a href="<?php echo base_url();?>wa" class="">
                                <i class="fa fa-dashboard"></i> <span>Estimate List</span>
                            </a>
                        </li>

                        <li class="active">
                            <a href="<?php echo base_url();?>menu" class="">
                                <i class="fa fa-dashboard"></i> <span>Manage Menu</span>
                            </a>
                        </li>

                        
                        <li>
                            <a href="<?php echo base_url();?>master/all">
                                <i class="fa fa-envelope"></i> <span>All Jobs</span>
                            </a>
                        </li>

                        <li>
                            <a target="_blank" href="<?php echo base_url();?>mask">
                                <i class="fa fa-dashboard"></i> <span>Manage Masks</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo base_url();?>master/dealercustomerunverify">
                                <i class="fa fa-envelope"></i> <span>Unverify Dealer/Customer</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>master/customer_job">
                                <i class="fa fa-envelope"></i> <span>All Customer Unverified Jobs</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>master/dealer_job">
                                <i class="fa fa-envelope"></i> <span>All Dealer Unverified Jobs</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>master/voucher_job">
                                <i class="fa fa-envelope"></i> <span>All Voucher Unverified Jobs</span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url();?>master/verifyjobs">
                                <i class="fa fa-envelope"></i> <span>All Verified Jobs</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>master/unverifyjobs">
                                <i class="fa fa-envelope"></i> <span>All Unverified Jobs</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>master/manage_users">
                                <i class="fa fa-envelope"></i> <span>All Users</span>
                            </a>
                        </li>
                        
                        <li class="active">
                            <a href="<?php echo base_url();?>/etransaction">
                                <i class="fa fa-dashboard"></i> <span>Employee Walet</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo base_url();?>master/job_category">
                                <i class="fa fa-envelope"></i> <span>Job Categories</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>master/attendance">
                                <i class="fa fa-envelope"></i> <span>Attendance</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-envelope"></i> <span>Tasks Alloted</span>
                                <small class="badge pull-right bg-yellow">5</small>
                            </a>
                        </li>
                        <li>
                            <a target="_blank" href="<?php echo base_url();?>book">
                                <i class="fa fa-calendar"></i> <span>Sample Books</span>
                            </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
<script>
jQuery("document").ready(function(){
	/*
	$.ajax({
         type: "POST",
         url: "<?php echo site_url();?>/user/get_leftbar_status/", 
          dataType: 'json',
         success: 
            function(data){
				jQuery("#show_jobs").html(data.jobs);
				jQuery("#show_dealers").html(data.dealers);
				jQuery("#show_customers").html(data.customers);
				
			}
          });*/
});
</script>