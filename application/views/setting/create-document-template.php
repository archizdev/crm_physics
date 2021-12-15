<br>
<?php foreach ($docList as $key => $value) { ?>

<div  class="panel panel-default thumbnail">

      <div class="panel-body panel-form">

                          <div class="row ">

                              <div class="col-md-12">  <a class="btn btn-primary" href="<?php echo base_url() ?>setting/document-templates"> <i class="fa fa-list"></i> Template List</a> </div>

                                  <div class="col-md-12 col-sm-12">

                                  <form   action='<?= base_url('setting/Insert_templates') ?>' method="post" enctype="multipart/form-data">
                                   <input value="<?=  $this->uri->segment(3); ?>" name="docId" hidden >
                                      <div class="row"><br>

                                          <div class="col-md-12">

                                             <div class="col-md-12">

                                                      <div class="form-group ">

                                                           <label for="name" class="col-form-label">Title</label>
                                                          <input type="text" class="form-control br_25  m-0 icon_left_input" name="title" required placeholder="title" value="<?= $value->title; ?>" >
                                                      </div>

                                                  </div>

                                                  

                                                  <div class="col-md-12">

                                                      <div class="form-group ">

                                                           <label for="name" class="col-form-label">Content</label>
                                                           <!-- <textarea name="content" class="form-control" required></textarea> -->
                                    <textarea name="content" class="tinymce form-control" placeholder="" id="degree" maxlength="140" rows="7"><?= $value->content; ?></textarea>

                                                           <!-- <textarea name="content" class="form-control" id="summernote" required><?= $value->content; ?></textarea> -->


                                                      </div>

                                                  </div>
                                          </div>
                                                  <div class="col-md-6">
                                                      <button class="btn btn-primary" type="submit" >
                                                          <i class="ti-user"></i>
                                                          <?php echo display("save"); ?>
                                                      </button>
                                                      <button class="btn btn-warning" type="reset" id="clear">
                                                          <i class="ti-reload"></i>
                                                          <?php echo display("reset"); ?>
                                                      </button>
                                                  </div>

                                      </div>

                                  </form>
                                           </div>
                            </div>
              </div>
</div>
<?php } ?>
  <script>
    // tinymce.init({
    //   selector: 'textarea',
    //   plugins: 'quickbars,lists advlist',
    //   toolbar: 'true',
    //   toolbar_mode: 'floating',
    //   });
      
      

//     tinymce.init({
//   selector: 'textarea',
//   plugins: 'image code',
//   toolbar: 'undo redo | link image | code',
//   /* enable title field in the Image dialog*/
//   image_title: true,
//   /* enable automatic uploads of images represented by blob or data URIs*/
//   automatic_uploads: true,
//   /*
//     URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
//     images_upload_url: 'postAcceptor.php',
//     here we add custom filepicker only to Image dialog
//   */
//   file_picker_types: 'image',
//   /* and here's our custom image picker*/
//   file_picker_callback: function (cb, value, meta) {
//     var input = document.createElement('input');
//     input.setAttribute('type', 'file');
//     input.setAttribute('accept', 'image/*');

//     /*
//       Note: In modern browsers input[type="file"] is functional without
//       even adding it to the DOM, but that might not be the case in some older
//       or quirky browsers like IE, so you might want to add it to the DOM
//       just in case, and visually hide it. And do not forget do remove it
//       once you do not need it anymore.
//     */

//     input.onchange = function () {
//       var file = this.files[0];

//       var reader = new FileReader();
//       reader.onload = function () {
//         /*
//           Note: Now we need to register the blob in TinyMCEs image blob
//           registry. In the next release this part hopefully won't be
//           necessary, as we are looking to handle it internally.
//         */
//         var id = 'blobid' + (new Date()).getTime();
//         var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
//         var base64 = reader.result.split(',')[1];
//         var blobInfo = blobCache.create(id, file, base64);
//         blobCache.add(blobInfo);

//         /* call the callback and populate the Title field with the file name */
//         cb(blobInfo.blobUri(), { title: file.name });
//       };
//       reader.readAsDataURL(file);
//     };

//     input.click();
//   },
//   content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
// });

  </script>