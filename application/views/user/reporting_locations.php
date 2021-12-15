<style>
  .morecontent span {
    display: none;
  }

  .morelink {
    display: block;
  }

  a:hover,
  a:focus {
    text-decoration: none;
    outline: none;
    color: #37a000;
    font-weight: 900;
  }
</style>
<div class="row">

  <!--  table area -->

  <div class="col-sm-12">

    <div class="panel panel-default thumbnail">
      <div class="panel-heading no-print">
      <?php if (user_access('e35')) { ?>

        <div class="btn-group">
          <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#AddLocation" href="javascript:void(0)"> <i class="fa fa-plus"></i> Add <?=display('reporting_location')?></a>
        </div>
        <?php } ?>
      </div>
      <div class="panel-body">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>S No.</th>
              <th>Branch</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $sl = 1;
            foreach ($reporting_location as $reporting_location) { ?>
              <tr>
                <td><?php echo $sl; ?></td>
                <td width=""><?= $reporting_location->title ?></td>
                <td><?php echo (($reporting_location->status == 0) ? display('active') : display('inactive')); ?></td>
                <td width=""><?= $reporting_location->created_at ?></td>
                <td class="center">
                <?php 
if (user_access('e36')) { ?>

                <a data-toggle="modal" data-target="#editLocation" id="<?php echo $reporting_location->id ?>" href="javascript:void(0)" class="btn btn-xs  btn-primary view_data"><i class="fa fa-edit"></i></a>
                  <?php 
} if (user_access('e38')) { ?>
                   
                  <a href="<?= base_url('users/reportingLocation_delete/' . $reporting_location->id . '') ?>" onclick="return confirm('Are You Sure ? ')" class="btn btn-xs  btn-danger"><i class="fa fa-trash"></i></a>
               <?php } ?>
                </td>

                </td>

              </tr>

              <?php $sl++; ?>

            <?php } ?>

          </tbody>

        </table>
      </div>

      <!-- /.card-body -->

    </div>

    <!-- /.card -->

  </div>

  <!-- /.col -->

</div>
<?php if (user_access('e35')) { ?>

<div class="modal fade" id="AddLocation" tabindex="-1" role="dialog" aria-labelledby="course_upload_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Add Location</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url() . 'users/addReportingLocation' ?>" enctype="multipart/form-data" method='post'>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <label>Location Name </label>
              <input type="text" name="reploc" class="form-control">
            </div>
            <div class="col-md-12">
              <label>Status </label>
              <div class="form-check">
                <label class="radio-inline">
                  <input type="radio" name="status" value="0" checked="checked">Active</label>
                <label class="radio-inline">
                  <input type="radio" name="status" value="1">Inactive</label>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php }
if (user_access('e36')) { ?>
<div class="modal fade" id="editLocation" tabindex="-1" role="dialog" aria-labelledby="course_upload_label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h5 class="modal-title" id="">Edit Location</h5>
        </button>
      </div>
      <form action="<?= base_url() . 'users/addReportingLocation' ?>" enctype="multipart/form-data" method='post'>
        <div class="modal-body">
          <div class="row" id="location_data">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php } ?>
<script>  
  $(document).on('click', '.view_data', function() {
    var location_id = $(this).attr("id");
    if (location_id != '') {
      $.ajax({
        url: "<?= base_url('users/editlocation/') ?>",
        method: "POST",
        data: {
            location_id: location_id
        },
        success: function(data) {
          $('#location_data').html(data);

        }
      });
    }
  });
</script>