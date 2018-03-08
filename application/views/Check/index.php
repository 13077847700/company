

<div class="wrapper">
	<div class="content-wrapper">
		<section class="content">
			<?php $this->load->view('Public/breadcrumbs'); ?>
			<div class="row">
				<div class="col-xs-12">
					<!--搜索表单-->
                    <form id="search" class="form-inline" method="get" action="<?php echo site_url('admin/Check/index') ?> ">
                        <select id="level" name="level" class="form-control" onchange="changeLevel()">
                            <option value="1" <?php if($level == 1) echo "selected"; ?> >员工级</option>
                            <option value="2" <?php if($level == 2) echo "selected"; ?> >总监级</option>
                        </select>

                        <!--<button type="submit" class="btn btn-primary">
                            <span class="fa fa-search"></span>
                            搜索
                        </button>-->
                    </form>
                    <br>
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">考核结果分析表</h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<button type="button" class="btn btn-primary btn-add">
								<i class="fa fa-plus"></i>&nbsp;添加考核内容
							</button>
						</div>

						<div class="box-body">
							<form id="form" method="post" action="">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
					                        <th>编号</th>
				                            <th>考核标题</th>
				                            <th>权重</th>
				                            <th width="40%">考核标准1</th>
				                            <th>操作</th>
										</tr>
									</thead>

									<tbody>
										<?php foreach ($list as $key => $val): ?>
											<tr>
												<td><?= $val['id'] ?></td>
                            					<td><?= $val['title'] ?></td>
                            					<td><?= $val['proportion'] . "%" ?></td>
                            					<td><?= $val['content1'] ?></td>

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
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="margin-top:70px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">考核内容添加</h4>
            </div>

            <form id="menu-form" class="form-horizontal form-data" action="<?php echo site_url('admin/Check/add_or_update') ?>" method="post">
				<div class="modal-body">
					<input type="hidden" id="id" name="id" value="">

					<div class="form-group">
						<label class="col-sm-2 control-label"> 考核级别 </label>
						<div class="col-sm-5">
							<select id="group_id" name="group_id" class="form-control">
	                            <option value="">请选择</option>
	                            <option value="1">员工级</option>
	                            <option value="2">总监级</option>
	                        </select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label"> 考核标题 </label>
						<div class="col-sm-5">
							<input type="text" id="title" name="title" class="form-control" placeholder="请输入标题" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label"> 考核权重 </label>
						<div class="col-sm-5">
							<input type="text" id="proportion" name="proportion" class="form-control" placeholder="请输入比例" />
						</div>
						<label class="control-label"> % </label>
					</div>

					<br>
					<div class="form-group">
                        <label class="col-sm-2 control-label"> 序号 </label>
                        <div class="col-sm-8 text-center">
                            考核标准内容
                        </div>
                        <div class="col-sm-2">
                            分值范围如:90-81
                        </div>
                    </div>

					<div class="form-group">
						<label class="col-sm-2 control-label"> 1 </label>
						<div class="col-sm-8">
							<textarea name="content1" id="content1" rows="2" placeholder=""
                                          class="form-control"></textarea>
						</div>
						<div class="col-sm-2">
                            <input type="text" name="score1" id="score1" class="form-control"
                                   value="" style="margin-top:9px;">
                        </div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label"> 2 </label>
						<div class="col-sm-8">
							<textarea name="content2" id="content2" rows="2" placeholder=""
                                          class="form-control"></textarea>
						</div>
						<div class="col-sm-2">
                            <input type="text" name="score2" id="score2" class="form-control"
                                   value="" style="margin-top:9px;">
                        </div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label"> 3 </label>
						<div class="col-sm-8">
							<textarea name="content3" id="content3" rows="2" placeholder=""
                                          class="form-control"></textarea>
						</div>
						<div class="col-sm-2">
                            <input type="text" name="score3" id="score3" class="form-control"
                                   value="" style="margin-top:9px;">
                        </div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label"> 4 </label>
						<div class="col-sm-8">
							<textarea name="content4" id="content4" rows="2" placeholder=""
                                          class="form-control"></textarea>
						</div>
						<div class="col-sm-2">
                            <input type="text" name="score4" id="score4" class="form-control"
                                   value="" style="margin-top:9px;">
                        </div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label"> 5 </label>
						<div class="col-sm-8">
							<textarea name="content5" id="content5" rows="2" placeholder=""
                                          class="form-control"></textarea>
						</div>
						<div class="col-sm-2">
                            <input type="text" name="score5" id="score5" class="form-control"
                                   value="" style="margin-top:9px;">
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

	function changeLevel()
	{
		var level = $('#level').val();
		$('#search').submit();
		$('#level').val(level);
	}

	$(document).ready(function(){

        $('#startDate, #endDate').daterangepicker(op, function(start, end, label) {}); 

		// 新增
		$('.btn-add').click(function(){

			url = "<?php echo site_url('admin/Check/add') ?>";
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
						$('#group_id').val('');
						$('#title').val('');
						$('#proportion').val('');

						for(var i = 1; i < 6; i++)
						{
							$('#content' + i).val('');
							$('#score' + i).val('');
						}

						$('#myModal').modal();
					}				
				}
			});	
		})
		
		// 编辑
		$('.btn-edit').click(function(){

			url = "<?php echo site_url('admin/Check/edit') ?>";

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
						$('#group_id').val(data.group_id);
						$('#title').val(data.title);
						$('#proportion').val(data.proportion);

						$('#content1').val(data.content1);
						$('#content2').val(data.content2);
						$('#content3').val(data.content3);
						$('#content4').val(data.content4);
						$('#content5').val(data.content5);

						$('#score1').val(data.score1);
						$('#score2').val(data.score2);
						$('#score3').val(data.score3);
						$('#score4').val(data.score4);
						$('#score5').val(data.score5);

						$('#myModal').modal();
					}	
				}
			});	
		})

		// 删除
		$('.btn-del').click(function(){

			var me = $(this);

			url = "<?php echo site_url('admin/Check/del') ?>"

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

			var group_id = $('#group_id').val();
			var title = $('#title').val();
			var proportion = $('#proportion').val();

            if($.trim(group_id) == '')
            {
                layer.msg('考核级别不能为空！');
                return;
            }
            else if($.trim(title) == '')
            {
            	layer.msg('考核标题不能为空！');
            	return;
            }
            else if($.trim(proportion) == '')
            {
            	layer.msg('考核权重不能为空！');
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