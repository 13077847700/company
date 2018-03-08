

<div class="wrapper">
	<div class="content-wrapper">
		<section class="content">
			<?php $this->load->view('Public/breadcrumbs'); ?>
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">规则管理</h3>&nbsp;&nbsp;&nbsp;&nbsp;
							
							<button type="button" class="btn btn-primary btn-add" rel='0'>
								<i class="fa fa-plus"></i>&nbsp;添加规则
							</button>
						</div>

						<div class="box-body">
							<form id="form" method="post" action="">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th style="text-align: center;">ID</th>
					                        <th>规则名称</th>
					                        <th>链接</th>
					                        <th>ICON</th>
					                        <th>状态</th>
					                        <th>排序</th>
					                        <th>操作</th>
										</tr>
									</thead>

									<tbody>
										<?php foreach ($option as $key => $val): ?>
											<tr>
												<td style="text-align: center;">
													<?= $val['id'] ?>
												</td>
												<td><?= $val['title'] ?></td>
                            					<td><?= $val['name'] ?></td>
                            					<td><i class="<?= $val['icon'] ?>"></i></td>
                            					<td>
                            						<?php
                            							if($val['is_show'] == 1)
                            								echo "显示";
                            							else
                            								echo "隐藏";
                            						?>
                            					</td>
                            					<td><?= $val['o'] ?></td>
                            					<td>
                            						<a href="javascript:;" class="btn btn-default btn-edit" rel="<?= $val['id'] ?>" > <i class="fa fa-pencil-square-o"></i>&nbsp;编辑</a>&nbsp;
                            						<a href="javascript:;" class="btn btn-danger btn-del" rel="<?= $val['id'] ?>"><i class="fa fa-trash"></i>&nbsp;删除</a>
                            					</td>
											</tr>

											<?php if(isset($val['children'])): ?>
												<?php foreach($val['children'] as $k=>$v): ?>
													<tr>
														<td style="text-align: center;">
															<?= $v['id'] ?>
														</td>
														<td><span style="font-size:12px;">┗━━</span>&nbsp;<?= $v['title'] ?></td>
					                                    <td><?= $v['name'] ?></td>
					                                    <td><i class="<?= $v['icon'] ?>"></i></td>
					                                    <td>
					                                    	<?php
		                            							if($v['is_show'] == 1)
		                            								echo "显示";
		                            							else
		                            								echo "隐藏";
		                            						?>
					                                    </td>
					                                    <td><?= $v['o'] ?></td>
		                            					<td>
		                            						<a href="javascript:;" class="btn btn-default btn-edit" rel="<?= $v['id'] ?>" > <i class="fa fa-pencil-square-o"></i>&nbsp;编辑</a>&nbsp;
		                            						<a href="javascript:;" class="btn btn-danger btn-del" rel="<?= $v['id'] ?>"><i class="fa fa-trash"></i>&nbsp;删除</a>
		                            					</td>
													</tr>

													<?php if(isset($v['children'])): ?>
														<?php foreach($v['children'] as $vv): ?>
															<tr>
																<td style="text-align: center;">
																	<?= $vv['id'] ?>
																</td>
																<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:12px;">┗━━</span>&nbsp;<?= $vv['title'] ?></td>
							                                    <td><?= $vv['name'] ?></td>
							                                    <td><i class="<?= $vv['icon'] ?>"></i></td>
							                                    <td>
							                                    	<?php
				                            							if($vv['is_show'] == 1)
				                            								echo "显示";
				                            							else
				                            								echo "隐藏";
				                            						?>
							                                    </td>
							                                    <td><?= $vv['o'] ?></td>
				                            					<td>
				                            						<a href="javascript:;" class="btn btn-default btn-edit" rel="<?= $vv['id'] ?>" > <i class="fa fa-pencil-square-o"></i>&nbsp;编辑</a>&nbsp;
				                            						<a href="javascript:;" class="btn btn-danger btn-del" rel="<?= $vv['id'] ?>"><i class="fa fa-trash"></i>&nbsp;删除</a>
				                            					</td>
															</tr>
														<?php endforeach; ?>
													<?php endif; ?>	
												<?php endforeach; ?>
											<?php endif; ?>
										<?php endforeach; ?>
									</tbody>
								</table>
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
                <h4 class="modal-title">规则管理</h4>
            </div>

            <form id="menu-form" class="form-horizontal form-data" action="<?php echo site_url('admin/Rule/add_or_update') ?>" method="post">
				<div class="modal-body">
					<input type="hidden" id="menu_id" name="id" value="">

					<div class="form-group">
						<label class="col-sm-4 control-label"> 上级规则 </label>
						<div class="col-sm-6">
							<select id="pid" name="pid" class="form-control">
								<option value="0" > 顶级规则 </option>
								<?php foreach ($option as $v): ?>
									<option value="<?= $v['id'] ?>" ><?= $v['title'] ?></option>

									<?php foreach ($v['children'] as $vv): ?>
										<option value="<?= $vv['id'] ?>" > &nbsp;&nbsp;┗━&nbsp;<?= $vv['title'] ?> </option>
									<?php endforeach; ?>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 规则名称 </label>
						<div class="col-sm-6">
							<input type="text" id="title" name="title" class="form-control" placeholder="请输入规则名" value='' />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 链接 </label>
						<div class="col-sm-6">
							<input type="text" id="name" name="name" class="form-control" placeholder="链接, 如 : Index/index" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> ICON图标 </label>
						<div class="col-sm-6">
							<input type="text" id="icon" name="icon" class="form-control" placeholder="ICON图标" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 排序 </label>
						<div class="col-sm-6">
							<input type="text" id="o" name="o" class="form-control" placeholder="越小越靠前" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 显示状态 </label>
						<div class="col-sm-6">
							<select id="is_show" name="is_show" class="form-control">
								<option value="1" > 显示 </option>
								<option value="0" > 隐藏 </option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 是否为菜单 </label>
						<div class="col-sm-6">
							<select id="is_menu" name="is_menu" class="form-control">
								<option value="1" > 是 </option>
								<option value="0" > 否 </option>
							</select>
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
		
		$('.btn-add').click(function(){

			url = "<?php echo site_url('admin/Rule/add') ?>";
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
						$('#pid').find('option[value="0"]').attr('selected', true);
						$('#menu_id').attr('value', '');
						$('#title').attr('value', '');
						$('#name').attr('value', '');
						$('#icon').attr('value', '');
						$('#o').attr('value', '');

						$('#is_show').val(1);
						$('#is_menu').val(1);

						$('#myModal').modal();
					}				
				}
			});	
		})
		
		$('.btn-edit').click(function(){

			url = "<?php echo site_url('admin/Rule/edit') ?>";

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
						$('#pid').val(data.pid);  // select下拉框默认选中！！！

						$('#menu_id').attr('value', data.id);
						$('#title').attr('value', data.title);
						$('#name').attr('value', data.name);
						$('#icon').attr('value', data.icon);
						$('#o').attr('value', data.o);
						
						$('#is_show').val(data.is_show);
						$('#is_menu').val(data.is_menu);

						$('#myModal').modal();
					}
				}
			});
		})

		$('.btn-del').click(function(){

			var me = $(this);

			url = "<?php echo site_url('admin/Rule/del') ?>"

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
								window.location.href = "<?php echo site_url('admin/Rule/index') ?>";
							})

							layer.msg('已删除！');
						}
					}

				})

			}, function(){
				
			})
		})

		$('.submit-btn').click(function(){
			var title = $('#title').val();

			if($.trim(title) == '')
			{
				layer.msg('规则名称不能为空！');
			}
			else
			{
				$('#menu-form').submit();
			}
		})
	})
</script>

</body>
</html>