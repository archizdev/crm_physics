<div class="container-fluid" style="padding: 20px;">
	<div class="col-lg-4 goal">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Add Goal
			</div>
			<div class="panel-body">
				<form id="goal_form">
				<div class="form-group">
					<label>Target Value</label>
					<input type="number" name="value" class="form-control">
				</div>
				<div class="form-group">
					<label>Period For</label>
					<select class="form-control" name="period">
						<option value="quarterly">Quarterly</option>
						<option value="year">Year</option>
					</select>
				</div>
				<div class="form-group">
					<label>Goal for</label>
					<select class="form-control" name="goal_for" onchange="xyz(this.value)">
						<option value="role">Role</option>
						<option value="user">User</option>
					</select>
				</div>
				<div class="form-group roles">
					<label>Select Role</label>
					<select class="form-control" name="roles">
						<?php
						if(!empty($roles))
						{
							foreach ($roles as  $row)
							{
								echo'<option value="'.$row->use_id.'">'.$row->user_role.'</option>';
							}
						}
						?>
					</select>
				</div>
				<div class="form-group users" style="display: none;">
					<label>Select User</label>
					<select class="form-control" name="users">
						<?php
						if(!empty($users))
						{
							foreach ($users as $row)
							{
								echo'<option value="'.$row->pk_i_admin_id.'">'.$row->s_display_name.'</option>';
							}
						}
						?>
					</select>
				</div>
				<button type="button" class="btn btn-success set_goal">Set</button>
			</div>
		</div>
	</div>

	<div class="col-lg-12 viewbox" style="display: none;">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Divide Goal
			</div>
			<div class="panel-body" style="overflow:auto;">

			</div>
		</div>
	</div>

</div>
<script type="text/javascript">
	$(document).on('click','.set_goal',function(){

		$.ajax({
			url:'<?=base_url('target/divide_target')?>',
			type:'post',
			data:$("#goal_form").serialize(),
			success:function(res){
				console.log(res);
				$(".goal").hide();
				$(".viewbox").show();
				$(".viewbox .panel-body").html(res);
			}
		});
		

	});

// $(document).ready(function(){

		function xyz(x)
		{ //alert(x);
			if(x=='user')
			{
				$(".users").show();
				$(".roles").hide();
			}
			else if(x=='role')
			{
				$(".users").hide();
				$(".roles").show();
			}
		}
// });
	
</script>