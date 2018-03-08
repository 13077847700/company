
<style>
    .clear-date
    {
        cursor:pointer;
    }
</style>

<div class="wrapper">
	<div class="content-wrapper">
		<section class="content">
			<?php $this->load->view('Public/breadcrumbs'); ?>
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">时间段列表</h3>&nbsp;&nbsp;&nbsp;&nbsp;
							
							<button type="button" class="btn btn-primary btn-add">
								<i class="fa fa-plus"></i>&nbsp;添加时间段
							</button>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

							<?php 	foreach ($list as $val) 
									{
										if($val['status'] == 1)
										{
											$status = 1;
											break;
										}
									}
							?>

							<?php if(isset($status) && $status == 1): ?>
								<a href="javascript:;" class="btn btn-default end-check"> <i class="fa fa-pencil-square-o"></i>&nbsp;结束考核</a>
							<?php else: ?>
								<a href="javascript:;" class="btn btn-info start-check"> <i class="fa fa-pencil-square-o"></i>&nbsp;开始考核</a>
							<?php endif; ?>

						</div>

						<div class="box-body">
							<form id="form" method="" action="">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>选择</th>
					                        <th>编号</th>
				                            <th>年份</th>
				                            <th>季度</th>
				                            <th>开始时间</th>
				                            <th>结束时间</th>
				                            <th>状态</th>
				                            <th>说明</th>
				                            <th>操作</th>
										</tr>
									</thead>

									<tbody>
										<?php foreach ($list as $key => $val): ?>
											<tr>
												<td><input class="ids" type="checkbox" name="ids[]" value="<?= $val['id'] ?>"></td>

												<td><?= $val['id'] ?></td>
                            					<td><?= $val['year'] ?></td>
                            					<td><?= $val['quarter'] ?></td>
                            					<td><?= $val['startdate'] ?></td>
                            					<td><?= $val['enddate'] ?></td>

                            					<td>
                            						<?php   if($val['status'] == 0) echo "未考核";
                            								else if($val['status'] == 1) echo "考核中...";
                            								else echo "考核结束"; ?>
                            					</td>

                            					<td><?= $val['remark'] ?></td>

                            					<td class="center">
                            						<a href="javascript:;" class="btn btn-default btn-edit" rel="<?= $val['id'] ?>" > <i class="fa fa-pencil-square-o"></i>&nbsp;编辑</a>&nbsp;
                            						<a href="javascript:;" class="btn btn-danger btn-del" rel="<?= $val['id'] ?>"><i class="fa fa-trash"></i>&nbsp;删除</a>
                            					</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
								<div style="text-align:center;"><?= $links ?></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

<!--模态框-->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content" style="margin-top:70px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">时间段管理</h4>
            </div>

            <form id="menu-form" class="form-horizontal form-data" action="<?php echo site_url('admin/Quarter/add_or_update') ?>" method="post">
				<div class="modal-body">
					<input type="hidden" id="id" name="id" value="">

					<div class="form-group">
						<label class="col-sm-4 control-label"> 年份 </label>
						<div class="col-sm-6">
							<input type="text" id="year" name="year" class="form-control" placeholder="请输入年份，如：2010" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 考核季度 </label>
						<div class="col-sm-6">
							<select id="quarter" name="quarter" class="form-control">
	                            <option value="">请选择</option>
	                            <option value="第一季度">第一季度</option>
	                            <option value="第二季度">第二季度</option>
	                            <option value="第三季度">第三季度</option>
	                            <option value="第四季度">第四季度</option>
	                            <option value="上半年">上半年</option>
	                            <option value="下半年">下半年</option>
	                            <option value="年度">年度</option>
	                        </select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 开始时间 </label>
						<div class="col-sm-6">
                            <div class="input-group">
						      	<input type="text" name="startDate" id="startDate" class="form-control" placeholder="请选择日期" value="">
						      	<span class="help-inline input-group-addon clear-date"><i class='fa fa-remove'></i></span>
						    </div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 结束时间 </label>
						<div class="col-sm-6">
							<div class="input-group">
						      	<input type="text" name="endDate" id="endDate" class="form-control" placeholder="请选择日期" value="">
						      	<span class="help-inline input-group-addon clear-date"><i class='fa fa-remove'></i></span>
						    </div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 备注 </label>
						<div class="col-sm-6">
							<textarea name="remark" id="remark" rows="3" placeholder="请输入备注"
                                          class="form-control"></textarea>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="button" class="btn btn-success btn-longer submit-btn"><i class="fa fa-cloud-upload"></i>&nbsp;确&nbsp;定</button>
					</div>
				</div>
            </form>
		</div>
	</div>
</div>

<?php $this->load->view('Public/footer'); ?>

<script>
	$(document).ready(function(){

        $('#startDate, #endDate').daterangepicker(op, function(start, end, label) {}); 

		// 新增
		$('.btn-add').click(function(){

			url = "<?php echo site_url('admin/Quarter/add') ?>";
			$.ajax({
				url : url,
				type : "POST",
				data : 
				{
					
				},
				dataType : "json",
				success : function(data){	

					if(typeof(data.auth) != "undefined")
					{
						layer.msg('没有权限！');
						return;
					}
					else
					{
						$('#id').attr('value', '');
						$('#year').attr('value', '');
						$('#quarter').val('');
						$('#startDate').val('');
						$('#endDate').val('');
						$('#remark').val('');

						$('#myModal').modal();
					}				
				}
			});	
		})
		
		// 编辑
		$('.btn-edit').click(function(){

			url = "<?php echo site_url('admin/Quarter/edit') ?>";

			var id = $(this).attr('rel');
			$.ajax({
				url : url,
				type : "POST",
				data : 
				{
					id : id,
				},
				dataType : "json",
				success : function(data){

					if(typeof(data.auth) != "undefined")
					{
						layer.msg('没有权限！');
						return;
					}
					else
					{
						$('#id').attr('value', data.id);
						$('#year').attr('value', data.year);
						$('#quarter').val(data.quarter);
						$('#startDate').val(data.startdate);
						$('#endDate').val(data.enddate);
						$('#remark').val(data.remark);

						$('#myModal').modal();
					}	
				}
			});	
		})

		// 删除
		$('.btn-del').click(function(){

			var me = $(this);

			url = "<?php echo site_url('admin/Quarter/del') ?>"

			var id = $(this).attr('rel');

			layer.confirm('确定要删除所选项？', {
				btn : ['确定','取消']
			}, function(){

				$.ajax({
					url : url,
					type : "POST",
					data : 
					{
						id : id,
					},
					dataType : "json",
					success : function(data)
					{
						if(typeof(data.auth) != "undefined")
						{
							layer.msg('没有权限！');
							return;
						}
						else if(data.status == 1)
						{
							me.parents('tr').fadeOut("slow", function(){
								me.parents('tr').remove();
							})

							layer.msg('已删除！');
						}
					}

				})

			}, function(){
				
			})
		})

		// 提交
		$('.submit-btn').click(function(){

			var year = $('#year').val();
			var quarter = $('#quarter').val();
			var startDate = $('#startDate').val();
			var endDate = $('#endDate').val();

            if($.trim(year) == '')
            {
                layer.msg('年份不能为空！');
                return;
            }
            else if($.trim(quarter) == '')
            {
            	layer.msg('考核季度不能为空！');
            	return;
            }
            else if($.trim(startDate) == '')
            {
            	layer.msg('开始时间不能为空！');
            	return;
            }
            else if($.trim(endDate) == '')
            {
            	layer.msg('结束时间不能为空！');
            	return;
            }
            else
            {
            	$('#menu-form').submit();
            }
		})

		// 开始考核, 分配名单
		$('.start-check').click(function(){

			var obj = document.getElementsByName("ids[]");

			var count = 0;
			for(var i = 0; i < obj.length; i++)
			{
				if(obj[i].checked)
				{
					count++;
					var id = obj[i].value;
				}
			}

			if(count == 0)
			{
				layer.msg('请选择考核季度!');
				return;
			}
			else if(count == 1)
			{
				layer.confirm('确定开始考核？', {
				  	btn: ['确定','取消'] //按钮
				}, function(){

				  	url = "<?php echo site_url('admin/Quarter/start_check') ?>"

				  	$.ajax({
						url : url,
						type : "POST",
						data : 
						{
							id : id,
						},
						dataType : "json",
						success : function(data)
						{
							if(typeof(data.auth) != "undefined")
							{
								layer.msg('没有权限！');
								return;
							}
							else if(data.status == 2)
							{
								layer.msg('该考核季度已结束!');
								return;
							}
							else if(data.status == 3)
							{
								layer.msg('名单已分配, 考核中...');
								setTimeout(function(){window.location.href = "<?php echo site_url('admin/Quarter/index') ?>";	},2000);
							}
							else if(data.status == 4)
							{
								layer.msg('请重试或者重新调整分组名单!');
							}
						}

					})

				}, function(){
				
				});
			}
			else
			{
				layer.msg('不能进行多选!');
				return;
			}
			
		})

		// 结束考核
		$('.end-check').click(function(){

			var obj = document.getElementsByName("ids[]");

			var count = 0;
			for(var i = 0; i < obj.length; i++)
			{
				if(obj[i].checked)
				{
					count++;
					var id = obj[i].value;
				}
			}

			if(count == 0)
			{
				layer.msg('请选择结束季度!');
				return;
			}
			else if(count == 1)
			{
				layer.confirm('确定结束考核？', {
				  	btn: ['确定','取消'] //按钮
				}, function(){

					url = "<?php echo site_url('admin/Quarter/end_check') ?>"

				  	$.ajax({
						url : url,
						type : "POST",
						data : 
						{
							id : id,
						},
						dataType : "json",
						success : function(data)
						{
							if(typeof(data.auth) != "undefined")
							{
								layer.msg('没有权限！');
								return;
							}
							else if(data.status == 1)
							{
								layer.msg('请选择正确的季度!');
								return;
							}
							else
							{
								layer.msg('考核结束!');
								setTimeout(function(){window.location.href = "<?php echo site_url('admin/Quarter/index') ?>";	},2000);
							}
						}

					})

				}, function(){
				
				});
			}
			else
			{
				layer.msg('不能进行多选!');
				return;
			}
			
		})

	})
</script>

</body>
</html>