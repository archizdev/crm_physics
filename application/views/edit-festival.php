<div class="row">
	<div class="col-lg-12 ">
		<?php
		if($suc = $this->session->flashdata('SUCCESSMSG'))
			echo '<div class="alert alert-success">'.$suc.'</div>';
		?>
		<form action="" method="post">
		<div class="panel panel-default">
			<div class="panel-heading">Edit Festival</div>
			<div class="panel-body">
				<div class="form-group">
					<label>Festival Name</label>
					<input type="text" name="festival_name" class="form-control" required="required" value="<?=$festival->festival_name?>">
				</div>
			</div>
			<div class="panel-footer">
				<button class="btn btn-success"><i class="fa fa-save"></i> Save</button>
			</div>
		</div>
		</form>
	</div>

</div>