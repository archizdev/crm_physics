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
      
      </div>
      <div class="panel-body">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>S No.</th>
              <th>Type</th>
              <th>Title</th>
              <th>Created At</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $sl = 1;
            foreach ($list as $docList) { ?>
              <tr>
                <td><?php echo $sl; ?></td>
                <td><?php if($docList->doc_type==1){ echo'Quotation'; }?></td>
                <td width=""><?= $docList->title ?></td>
                <td width=""><?= $docList->created_date ?></td>
                <td class="center">
            <?php if (user_access('e33')) { ?>
                  <a href="<?= base_url('setting/createdocument_templates/' . $docList->id . '') ?>"  class="btn btn-xs  btn-primary"><i class="fa fa-pencil"></i></a>
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
