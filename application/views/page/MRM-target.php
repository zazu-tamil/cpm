<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>ISO Label List</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Master</a></li> 
    <li class="active">ISO Label List</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
  <!-- Default box -->
   <form method="post" action="">
  <div class="box">
    <div class="box-header with-border">
      <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#add_modal"><span class="fa fa-plus-circle"></span> Add New </button>
        
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body"> 
        
            <input type="hidden" name="mode" value="Add" />
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Description</th>
                    <th>Target</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach($record_list as $k => $info) { ?>
                <tr>
                    <td><?php echo ($k+1) ?></td>
                    <td><?php echo $info['mrm_target_name'] ?></td>
                    <td>
                    <input type="hidden" name="mrm_target_name[]" value='<?php echo $info['mrm_target_name'] ?>' class="form-control" />
                    <input type="text" name="mrm_target_value[]"  value="<?php echo $info['mrm_target_value'] ?>" class="form-control" />
                    </td> 
                </tr>
                <?php } ?>
                 
            </tbody>
        </table>
             
                 
        
        
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <div class="form-group col-sm-12 text-right">
             <input type="submit" name="Save" value="Save"  class="btn btn-primary" />
        </div> 
    </div>
    <!-- /.box-footer-->
     
  </div>
  <!-- /.box -->
   </form>   
 
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
