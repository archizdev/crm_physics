<div class="row">
	<div class="col-lg-12 ">
		<?php
		if($suc = $this->session->flashdata('SUCCESSMSG'))
			echo '<div class="alert alert-success">'.$suc.'</div>';
		?>
		<form action="" method="post">
		<div class="panel panel-default">
			<div class="panel-heading">Add Festival</div>
			<div class="panel-body">
				<div class="form-group">
					<label>Festival Name</label>
					<input type="text" name="festival_name" class="form-control" required="required">
				</div>
			</div>
			<div class="panel-footer">
				<button class="btn btn-success"><i class="fa fa-plus"></i> Add</button>
			</div>
		</div>
		</form>
	</div>

	<div class="col-lg-12">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>SR.</th>
					<th>Festival Name</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
				if(!empty($festivals))
				{	$i=1;
					foreach ($festivals->result_array() as $res)
					{
					echo'<tr><td>'.$i++.'</td><td>'.$res['festival_name'].'</td><td>
						<a href="'.base_url('holiday/edit-festival/').$res['id'].'"><i class="fa fa-edit"></i></a> &nbsp; 
						<a onclick="delete_festival('.$res['id'].')"><i class="fa fa-trash"></i></a>
						</td></tr>';
					}
				}
			?>
			</tbody>
			
		</table>
	</div>
</div>
<script type="text/javascript">
	function delete_festival(id)
	{
		if(confirm("Delete ?"))
		{
			location.href="<?=base_url('holiday/delete_festival/')?>"+id;
		}
	}
</script>