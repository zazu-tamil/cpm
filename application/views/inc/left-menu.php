<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url() ?>/asset/images/user.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('cr_name')  ;?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
       
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree"> 
        <li <?php if($this->uri->segment(1, 0) === 'dash') echo 'class="active"'; ?>><a href="<?php echo site_url('dash') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <?php if(($this->session->userdata('cr_is_admin') == 1) || ($this->session->userdata('cr_is_admin') == 2 )) { ?> 
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('pattern-list','pattern-in-out-list-v2'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Pattern Shop</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(($this->session->userdata('cr_is_admin') == 1) ) { ?>
            <li <?php if($this->uri->segment(1, 0) === 'pattern-list') echo 'class="active"'; ?>><a href="<?php echo site_url('pattern-list') ?>"><i class="fa fa-circle-o"></i> List of Patterns </a></li>
            <?php } ?>
            <li <?php if($this->uri->segment(1, 0) === 'pattern-in-out-list-v2') echo 'class="active"'; ?>><a href="<?php echo site_url('pattern-in-out-list-v2') ?>"><i class="fa fa-circle-o"></i> Pattern Incoming & Outgoing List</a></li>
            
             
          </ul>
        </li> 
        <?php } ?>
        <?php if(($this->session->userdata('cr_is_admin') == 1) ) { ?>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('work-order-entry','work-order-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Work Order</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'work-order-entry') echo 'class="active"'; ?>><a href="<?php echo site_url('work-order-entry') ?>"><i class="fa fa-circle-o"></i> Work Order Entry</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'work-order-list') echo 'class="active"'; ?>><a href="<?php echo site_url('work-order-list') ?>"><i class="fa fa-circle-o"></i> Order Register List</a></li> 
          </ul>
        </li>
        <?php } ?>
        <?php if(($this->session->userdata('cr_is_admin') == 1) || ($this->session->userdata('cr_is_admin') == 2 )) { ?> 
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('core-planning','core-floor-stock','core-production','core-item-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Core Shop</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if(($this->session->userdata('cr_is_admin') == 1) ) { ?>
            <li <?php if($this->uri->segment(1, 0) === 'core-item-list') echo 'class="active"'; ?>><a href="<?php echo site_url('core-item-list') ?>"><i class="fa fa-circle-o"></i> Core Master</a></li>
            <?php } ?>
            <!--<li <?php if($this->uri->segment(1, 0) === 'core-planning') echo 'class="active"'; ?>><a href="<?php echo site_url('core-planning') ?>"><i class="fa fa-circle-o"></i> Core Planning</a></li>-->
            <li <?php if($this->uri->segment(1, 0) === 'core-production') echo 'class="active"'; ?>><a href="<?php echo site_url('core-production') ?>"><i class="fa fa-circle-o"></i> Core Production Sheet</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'core-floor-stock') echo 'class="active"'; ?>><a href="<?php echo site_url('core-floor-stock') ?>"><i class="fa fa-circle-o"></i> Core Openning Stock</a></li>
              
          </ul>
        </li>  
        
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('work-planning','work-planning-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Planning</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'work-planning') echo 'class="active"'; ?>><a href="<?php echo site_url('work-planning') ?>"><i class="fa fa-circle-o"></i> Production Planning</a></li> 
             <li <?php if($this->uri->segment(1, 0) === 'work-planning-list') echo 'class="active"'; ?>><a href="<?php echo site_url('work-planning-list') ?>"><i class="fa fa-circle-o"></i> Daily Planning List</a></li> 
           </ul>
        </li>  
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('moulding-material','moulding-heatcode-log'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Meterial Consumption</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'moulding-material') echo 'class="active"'; ?>><a href="<?php echo site_url('moulding-material') ?>"><i class="fa fa-circle-o"></i>Material Consumed</a></li> 
            <li <?php if($this->uri->segment(1, 0) === 'moulding-heatcode-log') echo 'class="active"'; ?>><a href="<?php echo site_url('moulding-heatcode-log') ?>"><i class="fa fa-circle-o"></i><strong>Moulding Log Sheet
</strong></a></li> 
           </ul>
        </li> 
        <?php } ?> 
        
        <?php if(($this->session->userdata('cr_is_admin') == 1) || ($this->session->userdata('cr_is_admin') == 3 )) { ?> 
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('melting-log'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Melting Log Sheet</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'melting-log') echo 'class="active"'; ?>><a href="<?php echo site_url('melting-log') ?>"><i class="fa fa-circle-o"></i> Melting Log</a></li> 
           </ul>
        </li>
        <?php } ?> 
        <?php if(($this->session->userdata('cr_is_admin') == 1) ) { ?> 
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('sand-test'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>LAB</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'sand-test') echo 'class="active"'; ?>><a href="<?php echo site_url('sand-test') ?>"><i class="fa fa-circle-o"></i> System Sand Register</a></li> 
           </ul>
        </li>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('quality-check','inward-testing-entry'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>QC - Inspection</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'quality-check') echo 'class="active"'; ?>><a href="<?php echo site_url('quality-check') ?>"><i class="fa fa-circle-o"></i> Internal Rejection</a></li> 
            <li <?php if($this->uri->segment(1, 0) === 'inward-testing-entry') echo 'class="active"'; ?>><a href="<?php echo site_url('inward-testing-entry') ?>"><i class="fa fa-circle-o"></i> <!--Inward QC Testing-->Incoming Material Test Register</a></li> 
           </ul>
        </li>
        <?php } ?> 
        <?php if(($this->session->userdata('cr_is_admin') == 1) || ($this->session->userdata('cr_is_admin') == 4 )) { ?> 
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('customer-despatch-v2','customer-despatch','sub-contractor-despatch','customer-despatch-edit','sub-contractor-despatch-edit','customer-despatch-restore'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Despatch [ DC ]</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'customer-despatch') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-despatch') ?>"><i class="fa fa-circle-o"></i> Despatch Advice Register</a></li> 
            <li <?php if($this->uri->segment(1, 0) === 'sub-contractor-despatch') echo 'class="active"'; ?>><a href="<?php echo site_url('sub-contractor-despatch') ?>"><i class="fa fa-circle-o"></i> Sub-Contractor DC</a></li> 
            <?php if(($this->session->userdata('cr_is_admin') == 1) ) { ?>
            <hr />
            <li <?php if($this->uri->segment(1, 0) === 'customer-despatch-restore') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-despatch-restore') ?>"><i class="fa fa-circle-o"></i> Despatch Restore</a></li>
            <?php } ?> 
           </ul>
        </li>
        <?php } ?> 
        <?php if(($this->session->userdata('cr_is_admin') == 1) || ($this->session->userdata('cr_is_admin') == 6)) { ?> 
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('customer-rejection-list','ms-despatch-list','ms-floor-stock','rework-inward-list','rework-outward-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Machine Shop</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'ms-despatch-list') echo 'class="active"'; ?>><a href="<?php echo site_url('ms-despatch-list') ?>"><i class="fa fa-circle-o"></i> MS Despatch List</a></li> 
            <li <?php if($this->uri->segment(1, 0) === 'customer-rejection-list') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-rejection-list') ?>"><i class="fa fa-circle-o"></i> Customer Rejection List</a></li> 
            <li <?php if($this->uri->segment(1, 0) === 'ms-floor-stock') echo 'class="active"'; ?>><a href="<?php echo site_url('ms-floor-stock') ?>"><i class="fa fa-circle-o"></i> MS Openning Stock</a></li>
             
            <li <?php if($this->uri->segment(1, 0) === 'rework-inward-list') echo 'class="active"'; ?>><a href="<?php echo site_url('rework-inward-list') ?>"><i class="fa fa-circle-o"></i> Rework Inward List</a></li>
            <li></li>
            <li <?php if($this->uri->segment(1, 0) === 'rework-outward-list') echo 'class="active"'; ?>><a href="<?php echo site_url('rework-outward-list') ?>"><i class="fa fa-circle-o"></i> Rework Outward List</a></li>
          </ul>
        </li>
        <?php } ?> 
        <?php if(($this->session->userdata('cr_is_admin') == 1) || ($this->session->userdata('cr_is_admin') == 5 )) { ?> 
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('purchase-item-list','material-inward','inward-register','material-issue-slip','opening-stock-item-list','stock-report','inward-testing','adj-stock-item-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Purchase</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'material-inward') echo 'class="active"'; ?>><a href="<?php echo site_url('material-inward') ?>"><i class="fa fa-circle-o"></i> Material Inward</a></li> 
            <li <?php if($this->uri->segment(1, 0) === 'opening-stock-item-list') echo 'class="active"'; ?>><a href="<?php echo site_url('opening-stock-item-list') ?>"><i class="fa fa-circle-o"></i> Openning Stock Item List</a></li> 
            <li <?php if($this->uri->segment(1, 0) === 'adj-stock-item-list') echo 'class="active"'; ?>><a href="<?php echo site_url('adj-stock-item-list') ?>"><i class="fa fa-circle-o"></i> Stock Adjustment Item List</a></li> 
            <li <?php if($this->uri->segment(1, 0) === 'purchase-item-list') echo 'class="active"'; ?>><a href="<?php echo site_url('purchase-item-list') ?>"><i class="fa fa-circle-o"></i> Item List</a></li> 
            <hr />
            <li <?php if($this->uri->segment(1, 0) === 'inward-register') echo 'class="active"'; ?>><a href="<?php echo site_url('inward-register') ?>"><i class="fa fa-circle-o"></i> Inward Register</a></li> 
            <li <?php if($this->uri->segment(1, 0) === 'inward-testing') echo 'class="active"'; ?>><a href="<?php echo site_url('inward-testing') ?>"><i class="fa fa-circle-o"></i> Material Testing Register</a></li> 
            <li <?php if($this->uri->segment(1, 0) === 'material-request-slip') echo 'class="active"'; ?>><a href="<?php echo site_url('material-request-slip') ?>"><i class="fa fa-circle-o"></i> Material Request Slip</a></li> 
            <li <?php if($this->uri->segment(1, 0) === 'material-issue-slip') echo 'class="active"'; ?>><a href="<?php echo site_url('material-issue-slip') ?>"><i class="fa fa-circle-o"></i> Material Issue Slip</a></li> 
            <li <?php if($this->uri->segment(1, 0) === 'stock-report') echo 'class="active"'; ?>><a href="<?php echo site_url('stock-report') ?>"><i class="fa fa-circle-o"></i> Stock Report</a></li> 
           </ul>
        </li>
        <?php } ?> 
        <li class="header">Reports</li>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('headcode-wise-stock-report','mis-report','pattern-history-report','heatcode-wise-production-report','work-order-planning-statement', 'work-order-wise-despatch-report','day-production-report','core-stock-reports','production-note','production-summary-report','date-wise-production-report','core-maker-reports','date-wise-planning-report','date-wise-rejection-report','customer-wise-planning-report','customer-wise-production-report','date-wise-melting-report','customer-wise-melting-report','customer-wise-rejection-report','moulding-consumption-report','melting-consumption-report','customer-wise-despatch-report','customer-wise-despatch-summary','grinding-report','rejection-summary-report','work-order-wise-despatch-summary','ms-stock-report','customer-rejection-report'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-print"></i> <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>  
          </a>
          <ul class="treeview-menu"> 
           
            <li <?php if($this->uri->segment(1, 0) === 'mis-report') echo 'class="active"'; ?>><a href="<?php echo site_url('mis-report') ?>"><i class="fa fa-circle-o"></i> MIS Report</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'day-production-report') echo 'class="active"'; ?>><a href="<?php echo site_url('day-production-report') ?>"><i class="fa fa-circle-o"></i> Day Production</a></li>
            <!--<li <?php if($this->uri->segment(1, 0) === 'production-summary-report') echo 'class="active"'; ?>><a href="<?php echo site_url('production-summary-report') ?>"><i class="fa fa-circle-o"></i> Date Wise Summary</a></li>-->
            <li <?php if($this->uri->segment(1, 0) === 'production-note') echo 'class="active"'; ?>><a href="<?php echo site_url('production-note') ?>"><i class="fa fa-circle-o"></i> Production Report</a></li>
            
            <li <?php if($this->uri->segment(1, 0) === 'pattern-history-report') echo 'class="active"'; ?>><a href="<?php echo site_url('pattern-history-report') ?>"><i class="fa fa-circle-o"></i>Pattern History Card</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'headcode-wise-stock-report') echo 'class="active"'; ?>><a href="<?php echo site_url('headcode-wise-stock-report') ?>"><i class="fa fa-circle-o"></i>Headcode Wise Stock Report</a></li>
			<hr />
            <?php if(($this->session->userdata('cr_is_admin') == 1) || ($this->session->userdata('cr_is_admin') == 2) || ($this->session->userdata('cr_is_admin') == 4 )) { ?>  
            <li <?php if($this->uri->segment(1, 0) === 'work-order-planning-statement') echo 'class="active"'; ?>><a href="<?php echo site_url('work-order-planning-statement') ?>"><i class="fa fa-circle-o"></i> PO Planning Statement</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'date-wise-planning-report') echo 'class="active"'; ?>><a href="<?php echo site_url('date-wise-planning-report') ?>"><i class="fa fa-circle-o"></i> Cumulative Planning</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'customer-wise-planning-report') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-wise-planning-report') ?>"><i class="fa fa-circle-o"></i> Customer Wise Planning</a></li>
            <?php } ?>    
            <hr />      
             <?php if($this->session->userdata('cr_is_admin') != 3 && $this->session->userdata('cr_is_admin') != 4 ) { ?>        
            <li <?php if($this->uri->segment(1, 0) === 'date-wise-production-report') echo 'class="active"'; ?>><a href="<?php echo site_url('date-wise-production-report') ?>"><i class="fa fa-circle-o"></i> Cumulative Moulding</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'customer-wise-production-report') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-wise-production-report') ?>"><i class="fa fa-circle-o"></i> Customer Wise Moulding</a></li>
            <hr />  
             <?php } ?>  
             <?php if($this->session->userdata('cr_is_admin') != 2 && $this->session->userdata('cr_is_admin') != 4 ) { ?>
            <li <?php if($this->uri->segment(1, 0) === 'date-wise-melting-report') echo 'class="active"'; ?>><a href="<?php echo site_url('date-wise-melting-report') ?>"><i class="fa fa-circle-o"></i> Cumulative Melting</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'customer-wise-melting-report') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-wise-melting-report') ?>"><i class="fa fa-circle-o"></i> Customer Wise Melting</a></li> 
            <hr />
            <?php } ?>
            <?php if($this->session->userdata('cr_is_admin') != 4 ) { ?>  
             <li <?php if($this->uri->segment(1, 0) === 'heatcode-wise-rejection-report') echo 'class="active"'; ?>><a href="<?php echo site_url('heatcode-wise-rejection-report') ?>"><i class="fa fa-circle-o"></i>Heatcode Wise Rejection</a></li>                  
             <li <?php if($this->uri->segment(1, 0) === 'heatcode-wise-production-report') echo 'class="active"'; ?>><a href="<?php echo site_url('heatcode-wise-production-report') ?>"><i class="fa fa-circle-o"></i>HC Wise Prod & Rejection</a></li>                  
             <li <?php if($this->uri->segment(1, 0) === 'date-wise-rejection-report') echo 'class="active"'; ?>><a href="<?php echo site_url('date-wise-rejection-report') ?>"><i class="fa fa-circle-o"></i> Date Wise Rejection</a></li>
             <li <?php if($this->uri->segment(1, 0) === 'rejection-summary-report') echo 'class="active"'; ?>><a href="<?php echo site_url('rejection-summary-report') ?>"><i class="fa fa-circle-o"></i> Rejection Type Wise Summary</a></li>
             <li <?php if($this->uri->segment(1, 0) === 'customer-wise-rejection-report-v2') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-wise-rejection-report-v2') ?>"><i class="fa fa-circle-o"></i> Internal Rejection</a></li>
            <hr />
            <?php } ?> 
            <?php if($this->session->userdata('cr_is_admin') != 3  && $this->session->userdata('cr_is_admin') != 2 ) { ?> 
            <li <?php if($this->uri->segment(1, 0) === 'customer-wise-despatch-report') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-wise-despatch-report') ?>"><i class="fa fa-circle-o"></i> Customer Wise Despatch</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'customer-wise-despatch-summary') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-wise-despatch-summary') ?>"><i class="fa fa-circle-o"></i> Despatch Summary</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'work-order-wise-despatch-report') echo 'class="active"'; ?>><a href="<?php echo site_url('work-order-wise-despatch-report') ?>"><i class="fa fa-circle-o"></i> Work Order Wise Despatch</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'work-order-wise-despatch-summary') echo 'class="active"'; ?>><a href="<?php echo site_url('work-order-wise-despatch-summary') ?>"><i class="fa fa-circle-o"></i> PO Based Despatch Summary</a></li>
           <hr /> 
           <?php } ?> 
           <?php if($this->session->userdata('cr_is_admin') != 2  ) { ?>
            <li <?php if($this->uri->segment(1, 0) === 'grinding-report') echo 'class="active"'; ?>><a href="<?php echo site_url('grinding-report') ?>"><i class="fa fa-circle-o"></i> Grinding Reports</a></li>
            <?php } ?>
            <?php if($this->session->userdata('cr_is_admin') != 3 && $this->session->userdata('cr_is_admin') != 4 ) { ?>
            <li <?php if($this->uri->segment(1, 0) === 'core-maker-reports') echo 'class="active"'; ?>><a href="<?php echo site_url('core-maker-reports') ?>"><i class="fa fa-circle-o"></i> Core Maker Reports</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'core-stock-reports') echo 'class="active"'; ?>><a href="<?php echo site_url('core-stock-reports') ?>"><i class="fa fa-circle-o"></i> Core Stock Reports</a></li>
            <?php } ?>
           <hr />
           
           <li class="text-fuchsia">Material Consumption</li>
           <?php if($this->session->userdata('cr_is_admin') != 3 && $this->session->userdata('cr_is_admin') != 4) { ?>
           <li <?php if($this->uri->segment(1, 0) === 'moulding-consumption-report') echo 'class="active"'; ?>><a href="<?php echo site_url('moulding-consumption-report') ?>"><i class="fa fa-circle-o"></i> Moulding Consumption</a></li> 
           <?php } ?>
           <?php if($this->session->userdata('cr_is_admin') != 2 && $this->session->userdata('cr_is_admin') != 4 ) { ?>
           <li <?php if($this->uri->segment(1, 0) === 'melting-consumption-report') echo 'class="active"'; ?>><a href="<?php echo site_url('melting-consumption-report') ?>"><i class="fa fa-circle-o"></i> Melting Consumption</a></li> 
            <?php } ?>   
            <?php if($this->session->userdata('cr_is_admin') == 1  || ($this->session->userdata('cr_is_admin') == 6)) { ?>
            <li class="text-fuchsia">Machine Shop</li>
            <li <?php if($this->uri->segment(1, 0) === 'ms-stock-report') echo 'class="active"'; ?>><a href="<?php echo site_url('ms-stock-report') ?>"><i class="fa fa-circle-o"></i> MS Stock Report</a></li> 
            <li <?php if($this->uri->segment(1, 0) === 'customer-rejection-report') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-rejection-report') ?>"><i class="fa fa-circle-o"></i> Customer Rejection Report</a></li> 
            <?php } ?>
          </ul>
        </li>
        <?php if(($this->session->userdata('cr_is_admin') == 1) ) { ?>
        <li class="header">Masters</li>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('core-maker-rate-list','customer-list','uom-list','grade-list','rejection-type-list','pattern-maker-list','core-maker-list','sub-contractor-list','employee-list', 'user-list','iso-label-list','MRM-target','MRM-target-v2','transporter-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-cubes"></i> <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'floor-stock') echo 'class="active"'; ?>><a href="<?php echo site_url('floor-stock') ?>"><i class="fa fa-circle-o"></i> Opening Floor Stock</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'sub-contractor-list') echo 'class="active"'; ?>><a href="<?php echo site_url('sub-contractor-list') ?>"><i class="fa fa-circle-o"></i> Sub-Contractor List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'pattern-maker-list') echo 'class="active"'; ?>><a href="<?php echo site_url('pattern-maker-list') ?>"><i class="fa fa-circle-o"></i> Pattern Maker List</a></li>
            
            <li <?php if($this->uri->segment(1, 0) === 'core-maker-list') echo 'class="active"'; ?>><a href="<?php echo site_url('core-maker-list') ?>"><i class="fa fa-circle-o"></i> Core Maker List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'core-maker-rate-list') echo 'class="active"'; ?>><a href="<?php echo site_url('core-maker-rate-list') ?>"><i class="fa fa-circle-o"></i> Core Maker Rate List</a></li>
            <hr />
            <li <?php if($this->uri->segment(1, 0) === 'customer-list') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-list') ?>"><i class="fa fa-circle-o"></i> List of Customers</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'transporter-list') echo 'class="active"'; ?>><a href="<?php echo site_url('transporter-list') ?>"><i class="fa fa-circle-o"></i> Transporter List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'uom-list') echo 'class="active"'; ?>><a href="<?php echo site_url('uom-list') ?>"><i class="fa fa-circle-o"></i> UOM List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'grade-list') echo 'class="active"'; ?>><a href="<?php echo site_url('grade-list') ?>"><i class="fa fa-circle-o"></i> Grade List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'rejection-type-list') echo 'class="active"'; ?>><a href="<?php echo site_url('rejection-type-list') ?>"><i class="fa fa-circle-o"></i> Rejection Type  List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'employee-list') echo 'class="active"'; ?>><a href="<?php echo site_url('employee-list') ?>"><i class="fa fa-circle-o"></i> Employee List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'user-list') echo 'class="active"'; ?>><a href="<?php echo site_url('user-list') ?>"><i class="fa fa-circle-o"></i> Login User List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'iso-label-list') echo 'class="active"'; ?>><a href="<?php echo site_url('iso-label-list') ?>"><i class="fa fa-circle-o"></i> ISO Label List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'MRM-target-v2') echo 'class="active"'; ?>><a href="<?php echo site_url('MRM-target-v2') ?>"><i class="fa fa-circle-o"></i> MRM Target</a></li>
              
          </ul>
        </li>
        <?php } ?>
        <li class="header">Masters Specification</li> 
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('grinding-master-rate-list','core-maker-master-rate','customer-wise-pattern-report','moulding-spec-generate','melting-master-list-v1','moulding-master-list','customer-pattern-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-cubes"></i> <span>Master Specification</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if($this->session->userdata('cr_is_admin') != 3 && $this->session->userdata('cr_is_admin') != 2 && $this->session->userdata('cr_is_admin') != 4 ) { ?>
            <li <?php if($this->uri->segment(1, 0) === 'core-maker-master-rate') echo 'class="active"'; ?>><a href="<?php echo site_url('core-maker-master-rate') ?>"><i class="fa fa-circle-o"></i> Core Maker Master Rate</a></li>
            <?php } ?>
            <?php if($this->session->userdata('cr_is_admin') != 3 && $this->session->userdata('cr_is_admin') != 2  ) { ?>
            <li <?php if($this->uri->segment(1, 0) === 'grinding-master-rate-list') echo 'class="active"'; ?>><a href="<?php echo site_url('grinding-master-rate-list') ?>"><i class="fa fa-circle-o"></i> Grinding Master Rate</a></li>
            <?php } ?>
            <?php if($this->session->userdata('cr_is_admin') != 2 && $this->session->userdata('cr_is_admin') != 4 ) { ?>
            <li <?php if($this->uri->segment(1, 0) === 'customer-wise-pattern-report') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-wise-pattern-report') ?>"><i class="fa fa-circle-o"></i> Master Pattern List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'customer-pattern-list') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-pattern-list') ?>"><i class="fa fa-circle-o"></i> Customer Pattern List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'melting-master-list-v1') echo 'class="active"'; ?>><a href="<?php echo site_url('melting-master-list-v1') ?>"><i class="fa fa-circle-o"></i> Melting Master List</a></li>
            
            <?php } ?>
            <?php if($this->session->userdata('cr_is_admin') != 3 && $this->session->userdata('cr_is_admin') != 4 ) { ?>
            <!--<li <?php if($this->uri->segment(1, 0) === 'moulding-spec-generate') echo 'class="active"'; ?>><a href="<?php echo site_url('moulding-spec-generate') ?>"><i class="fa fa-circle-o"></i> Moulding Spec Generate</a></li>-->
            <li <?php if($this->uri->segment(1, 0) === 'moulding-master-list') echo 'class="active"'; ?>><a href="<?php echo site_url('moulding-master-list') ?>"><i class="fa fa-circle-o"></i> Moulding Master List</a></li>
            
            <?php } ?>
          </ul>
        </li>
       
        <li class="header">Charts</li>  
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('chart-internal-rejection','mrm-report','chart-internal-rejection-total','chart-internal-rejection-dept','chart-internal-rejection-dept-wt','chart-internal-rejection-dev-qty','chart-internal-rejection-based'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-pie-chart"></i> <span>Charts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('chart-internal-rejection-total','chart-internal-rejection-dept','chart-internal-rejection-dept-wt','chart-internal-rejection-dev-qty','chart-internal-rejection-based'))) echo 'active'; ?>">
              <a href="#">
                <i class="fa fa-pie-chart"></i> <span>Internal Rejection</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li <?php if($this->uri->segment(1, 0) === 'chart-internal-rejection-total') echo 'class="active"'; ?>><a href="<?php echo site_url('chart-internal-rejection-total') ?>"><i class="fa fa-circle-o"></i> Production Vs Rejection</a></li> 
                
                <li <?php if($this->uri->segment(1, 0) === 'chart-internal-rejection-dept') echo 'class="active"'; ?>><a href="<?php echo site_url('chart-internal-rejection-dept') ?>"><i class="fa fa-circle-o"></i> Dept Wise Rejection Qty</a></li> 
                <li <?php if($this->uri->segment(1, 0) === 'chart-internal-rejection-dept-wt') echo 'class="active"'; ?>><a href="<?php echo site_url('chart-internal-rejection-dept-wt') ?>"><i class="fa fa-circle-o"></i> Dept Wise Rejection Weight</a></li> 
                
                <li <?php if($this->uri->segment(1, 0) === 'chart-internal-rejection-based') echo 'class="active"'; ?>><a href="<?php echo site_url('chart-internal-rejection-based/1') ?>"><i class="fa fa-circle-o"></i> Rejection Type - Qty Basis</a></li> 
                <li <?php if($this->uri->segment(1, 0) === 'chart-internal-rejection-based') echo 'class="active"'; ?>><a href="<?php echo site_url('chart-internal-rejection-based/2') ?>"><i class="fa fa-circle-o"></i> Rejection Type - Weight Basis</a></li> 
             
                </ul>
            </li>
           
            <!--<li <?php if($this->uri->segment(1, 0) === 'chart-internal-rejection') echo 'class="active"'; ?>><a href="<?php echo site_url('chart-internal-rejection') ?>"><i class="fa fa-pie-chart"></i> Internal Rejection</a></li> -->
            <li <?php if($this->uri->segment(1, 0) === 'mrm-report') echo 'class="active"'; ?>><a href="<?php echo site_url('mrm-report') ?>"><i class="fa fa-pie-chart"></i> MRM</a></li> 
           </ul>
        </li>
        
        <li><a href="<?php echo site_url('logout') ?>"><i class="fa fa-circle-o"></i> Logout</a></li> 
         
         
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  