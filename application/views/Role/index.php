

<div class="wrapper">
	<div class="content-wrapper">
		<section class="content">
			<?php $this->load->view('Public/breadcrumbs'); ?>
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">角色列表</h3>&nbsp;&nbsp;&nbsp;&nbsp;
							
							<a href="<?php echo site_url('admin/Role/add'); ?>" type="button" class="btn btn-primary btn-edit" rel='0'>
								<i class="fa fa-plus"></i>&nbsp;添加角色
							</a>
						</div>

						<div class="box-body">
							<form id="form" method="post" action="">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>角色名称</th>
					                        <th>创建时间</th>
					                        <th>备注</th>
					                        <th class="center">操作</th>
										</tr>
									</thead>

									<tbody>
										<?php foreach ($list as $key => $val): ?>
											<tr>
												<td>
													<?= $val['title'] ?>
												</td>
												<td><?= $val['add_time'] ?></td>
                            					<td><?= $val['remark'] ?></td>
                            					<td class="center">
                            						<a href="<?php echo site_url('admin/Role/edit/' . $val['id']);?>" class="btn btn-default" rel="<?= $val['id'] ?>" > <i class="fa fa-pencil-square-o"></i>&nbsp;编辑</a>&nbsp;
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

<?php $this->load->view('Public/footer'); ?>

<script>
	$(document).ready(function(){
		
		$('.btn-del').click(function(){

			var me = $(this);

			url = "<?php echo site_url('admin/Role/del') ?>"

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

		$('.submit-btn').click(function(){
			$('#menu-form').submit();
		})
	})
</script>

</body>
</html>