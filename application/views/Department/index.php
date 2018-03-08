
<div class="wrapper">
	<div class="content-wrapper">
		<section class="content">
			<?php $this->load->view('Public/breadcrumbs'); ?>
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">部门列表</h3>&nbsp;&nbsp;&nbsp;&nbsp;
							
							<button type="button" class="btn btn-primary btn-add">
								<i class="fa fa-plus"></i>&nbsp;添加部门
							</button>

						</div>

						<div class="box-body">
							<form id="form" method="post" action="">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th width="30%">部门名称</th>
				                            <th width="30%">备注</th>
				                            <th width="40%">操作</th>
										</tr>
									</thead>

									<tbody>
										<?php foreach ($list as $key => $val): ?>
											<tr>
												<td><?= $val['dept_name'] ?></td>
                            					<td><?= $val['remark'] ?></td>

                            					<td class="center">
                            						<a href="javascript:;" class="btn btn-default btn-edit" rel="<?= $val['id'] ?>" > <i class="fa fa-pencil-square-o"></i>&nbsp;编辑</a>&nbsp;
                            						<a href="javascript:;" class="btn btn-danger btn-del" rel="<?= $val['id'] ?>"><i class="fa fa-trash"></i>&nbsp;删除</a>
                            					</td>
											</tr>
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
                <h4 class="modal-title">部门管理</h4>
            </div>

            <form id="menu-form" class="form-horizontal form-data" action="<?php echo site_url('admin/Department/add_or_update') ?>" method="post">
				<div class="modal-body">
					<input type="hidden" id="id" name="id" value="">

					<div class="form-group">
						<label class="col-sm-4 control-label"> 部门名称 </label>
						<div class="col-sm-6">
							<input type="text" id="dept_name" name="dept_name" class="form-control" placeholder="请输入部门名称" />
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

		// 新增
		$('.btn-add').click(function(){

			url = "<?php echo site_url('admin/Department/add') ?>";
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
						$('#dept_name').attr('value', '');
						$('#remark').val('');

						$('#myModal').modal();
					}				
				}
			});	
		})
		
		// 编辑
		$('.btn-edit').click(function(){

			url = "<?php echo site_url('admin/Department/edit') ?>";

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
						$('#dept_name').attr('value', data.dept_name);
						$('#remark').val(data.remark);

						$('#myModal').modal();
					}	
				}
			});	
		})

		// 删除
		$('.btn-del').click(function(){

			var me = $(this);

			url = "<?php echo site_url('admin/Department/del') ?>"

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

			var dept_name = $('#dept_name').val();

            if($.trim(dept_name) == '')
            {
                layer.msg('部门名称不能为空！');
                return;
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