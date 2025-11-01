<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>
     In Scan List
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Booking</a></li> 
    <li class="active">In Scan List</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
  <!-- Default box -->
   
  <div class="box">
    <div class="box-header with-border"> &nbsp;
       <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body table-responsive no-padding">
       
       <table class="table table-hover table-bordered table-striped table-responsive">
        <thead>
            <tr>
                <th class="text-center">S.No</th>
                <th>Date</th>  
                <th>AWB No</th>  
                <th>Origin</th>  
                <th>Destination</th>  
                <th>Status</th>  
                <th colspan="2" class="text-center">Action</th>  
            </tr>
        </thead>
          <tbody>
               <?php
                   foreach($record_list as $j=> $ls){
                ?> 
                <tr> 
                    <td class="text-center"><?php echo ($j + 1 + $sno);?></td> 
                    <td><?php echo date('d-m-Y h:i a', strtotime($ls['booking_date'] . '' . $ls['booking_time'])); ?></td> 
                    <td><?php echo $ls['awbno']?></td>   
                    <td><?php echo $ls['origin_pincode'] .'<br>' . $ls['origin_state_code']. ' - ' . $ls['origin_city_code']; ?></td>   
                    <td><?php echo $ls['dest_pincode'] .'<br>' . $ls['dest_state_code']. ' - ' . $ls['dest_city_code']; ?></td>    
                    <td><?php echo $ls['status']?> - <?php echo $ls['status_city_code']?></td> 
                    <td class="text-center">
                        <a href="<?php echo site_url('in-scan-edit').'/'. $ls['booking_id']?>" class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
                    </td>                                  
                    <td class="text-center">
                        <button value="<?php echo $ls['booking_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                    </td>                                      
                </tr>
                <?php
                    }
                ?>                                 
            </tbody>
      </table> 
        
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <div class="form-group col-sm-6">
            <label>Total Records : <?php echo $total_records;?></label>
        </div>
        <div class="form-group col-sm-6">
            <?php echo $pagination; ?>
        </div>
    </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
