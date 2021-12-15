<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<br><br>
<style type="text/css">
	#graph1,#graph2
	{
		height: 500px;
	}
</style>
<form id="filter">
<div class="row" style="padding: 0px 0px 20px 0px;">
	<div class="col-sm-3 col-sm-offset-2">
		<div class="form-group">
			<label>For User</label>
			<select class="form-control" name="user_for">
				<option value="">Select</option>
				<?php
				if(!empty($users))
				{
					$rol = json_decode($users);
					foreach ($rol as $row)
					{
						echo'<option value="'.$row->id.'" '.($row->id==$this->session->user_id?'selected':'').'>'.$row->user_name.'</option>';
					}
				}
				?>
			</select>
		</div>
	</div>
	<div class="col-sm-3">
		<div class="form-group">
			<label>Fetch</label>
			<div>
				<span style="float: left;">
					<input type="radio" name="fetch_type" value="1"> Individual
				</span>
				<span style="float: right;">
					<input type="radio" name="fetch_type" value="2" checked> Hierarchy
				</span>
			</div>
		</div>
	</div>
</div>
</form>
<div class="row">
	<div class="col-sm-6">
		<div id="graph1"></div>
	</div>
	<div class="col-sm-6">
		<div id="graph2"></div>
	</div>
</div>

<script>
$("#filter").on('change',function(){
gen_graph();
});

gen_graph();
function gen_graph()
{
var str = $("#filter").serialize();
$.ajax({
	url:'<?=base_url('target/target_graph')?>',
	type:'post',
	data:str,
	beforeSend:function()
	{
		$("#graph1,#graph2").html('Loading..');
	},
	success:function(res)
	{	//alert(res);
		 res = JSON.parse(res);
		// alert(JSON.stringify(res));
		
	}
});

}
</script>