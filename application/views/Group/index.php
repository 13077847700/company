

<div class="wrapper">
	<div class="content-wrapper">
		<section class="content">
			<?php $this->load->view('Public/breadcrumbs'); ?>
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">分组列表</h3>&nbsp;&nbsp;&nbsp;&nbsp;
							
							<button type="button" class="btn btn-primary btn-add">
								<i class="fa fa-plus"></i>&nbsp;添加分组
							</button>
						</div>

						<div class="box-body">
							<form id="form" method="post" action="">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
					                        <th>ID</th>
					                        <th>组名</th>
					                        <th>互评数</th>
					                        <th>备注</th>
					                        <th>操作</th>
										</tr>
									</thead>

									<tbody>
										<?php foreach ($list as $key => $val): ?>
											<tr>
												<td><?= $val['id'] ?></td>
                            					<td><?= $val['title'] ?></td>
                            					<td><?= $val['assess_num'] ?></td>
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
                <h4 class="modal-title">分组管理</h4>
            </div>

            <form id="menu-form" class="form-horizontal form-data" action="<?php echo site_url('admin/Group/add_or_update') ?>" method="post">
				<div class="modal-body">
					<input type="hidden" id="id" name="id" value="">

					<div class="form-group">
						<label class="col-sm-4 control-label"> 组名 </label>
						<div class="col-sm-6">
							<input type="text" id="title" name="title" class="form-control" placeholder="请输入组名" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 互评数 </label>
						<div class="col-sm-6">
							<input type="text" id="assess_num" name="assess_num" class="form-control" placeholder="请输入互评数" />
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

			url = "<?php echo site_url('admin/Group/add') ?>";
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
						$('#title').attr('value', '');
						$('#assess_num').attr('value', '');
						$('#remark').attr('value', '');

						$('#myModal').modal();
					}				
				}
			});	
		})
		
		// 编辑
		$('.btn-edit').click(function(){

			url = "<?php echo site_url('admin/Group/edit') ?>";

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
						$('#title').attr('value', data.title);
						$('#assess_num').attr('value', data.assess_num);
						$('#remark').attr('value', data.remark);

						$('#myModal').modal();
					}	
				}
			});	
		})

		// 删除
		$('.btn-del').click(function(){

			var me = $(this);

			url = "<?php echo site_url('admin/Group/del') ?>"

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

			var title = $('#title').val();
			var assess_num = $('#assess_num').val();

            if($.trim(title) == '')
            {
                layer.msg('组名不能为空！');
                return;
            }
            else if($.trim(assess_num) == '')
            {
            	layer.msg('互评数不能为空！');
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