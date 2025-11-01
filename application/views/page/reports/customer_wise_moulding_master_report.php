<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Customer Wise Moulding Master List</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Report</a></li> 
    <li class="active">Customer Wise Moulding Master List</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
  
        <div class="box box-info noprint"> 
            <div class="box-header with-border">
              <h3 class="box-title text-white">Customer List</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <td>S.No</td>
                        <td>Customer</td>
                        <td>Action</td>
                    </tr>
                    <?php $i=1; foreach($customer_opt as $id => $company){ ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $company?></td>
                            <td><a class="btn btn-info" href="<?php echo site_url('print-moulding-master/' . $id); ?>" target="_blank"><i class="fa fa-eye"></i></a></td>
                        </tr>
                    <?php $i++; } ?>
                </table>
            </div> 
        </div> 
         
        
            
           
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
