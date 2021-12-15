<div class="row">
	<?php
	if($suc = $this->session->flashdata('SUCCESSMSG'))
	{
		echo'<div class="alert alert-success">'.$suc.'</div>';
	}
	$old_data = (object)array('type'=>'','name'=>'');
	if(!empty($data))
		$old_data = $data[0];
	//print_r($old_data); exit();

	if(user_access('5210'))
	{
	?>
	<div class="col-lg-12" style="padding:10px;">
		<div class="panel panel-default">
			<div class="panel-heading"><?=$header?></div>
			<div class="panel-body">
			<?=form_open('/ticket/referred_by/'.$this->uri->segment(3),'class="abc"')?>
				<!-- <div class="col-lg-4">
					<div class="form-group">
						<label>Type</label>
						<select name="type" class="form-control">
							<option value="1" <?=$old_data->type=='1'?'selected':''?>>Consignee</option>
							<option value="2" <?=$old_data->type=='2'?'selected':''?>>Consigner</option>
							<option value="3" <?=$old_data->type=='3'?'selected':''?>>Internal</option>
						</select>
					</div>
				</div> -->
				<div class="col-lg-4">
					<div class="form-group">
						<label>Title</label>
						<input type="text" name="name" class="form-control" value="<?=$old_data->name?>" required>
					
					</div>
				</div>
				<div class="col-lg-4">
					<br>
					<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
				</div>
				<?=form_close()?>
			</div>
			<div class="panel-footer">
			</div>
		</div>
	</div>
	<?php
	}
	?>
	<div class="col-lg-12">
		<table class="table table-responsive table-bordered datatable1">
			<tr>
				<th>SR</th>
				<th>Name</th>
				<th>Action</th>
			</tr>
			<?php
			if(!empty($table))
			{	$i=1;
				foreach ($table as $res)
				{
					echo'<tr>
						<td>'.$i++.'</td>
						<td>'.$res->name.'</td>
						<td>';
						if(user_access('5211'))
						{
						echo'<a href="'.base_url('ticket/referred_by/').$res->id.'"><i class="fa fa-edit"></i></a> &nbsp;';
						}
						if(user_access('5212'))
						{
						echo' <a onclick="delete_refer('.$res->id.')"><i class="fa fa-trash text-danger"></i></a>';
						}
						echo'</td>
						</tr>';
				}
			}
			?>
		</table>
	</div>

</div>
<script type="text/javascript">
	function delete_refer(id)
	{
		if(confirm("Delete?"))
		{
			location.href="<?=base_url('ticket/delete_referred_by/')?>"+id;
		}
	}
</script>