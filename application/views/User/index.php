

<div class="wrapper">
	<div class="content-wrapper">
		<section class="content">
			<?php $this->load->view('Public/breadcrumbs'); ?>
			<div class="row">
				<div class="col-xs-12">
					<!--搜索表单-->
                    <form class="form-inline" action="<?php echo site_url('admin/User/index'); ?>" method="get">

                        <input type="text" name="name" placeholder="请输入姓名" class="form-control" value="<?php if(isset($_GET['name'])) echo $_GET['name']; ?>">

                        <select id="s_gid" name="s_gid" class="form-control">
                            <option value="">请选择分组</option>
                            <?php foreach ($group as $v): ?>
                                <option value="<?= $v['id'] ?>" <?php if(isset($_GET['s_gid']) && $_GET['s_gid'] == $v['id']) echo 'selected'; ?> >
                                	<?= $v['title'] ?>
                                </option>
                        	<?php endforeach; ?>
                        </select>

                        <select id="dept_id" name="dept_id" class="form-control">
                            <option value="">请选择部门</option>
                            <?php foreach ($dept_name as $v): ?>
                                <option value="<?= $v['id'] ?>" <?php if(isset($_GET['dept_id']) && $_GET['dept_id'] == $v['id']) echo 'selected'; ?> >
                                	<?= $v['dept_name'] ?>
                                </option>
                        	<?php endforeach; ?>
                        </select>

                        <select id="job_id" name="job_id" class="form-control">
							<option value="0" <?php if(isset($_GET['job_id']) && $_GET['job_id'] == 0) echo 'selected'; ?> > 在职 </option>
							<option value="1" <?php if(isset($_GET['job_id']) && $_GET['job_id'] == 1) echo 'selected'; ?> > 离职 </option>
						</select>

                        <button type="submit" class="btn btn-primary">
                            <span class="fa fa-search"></span>
                            搜索
                        </button>
                    </form>

	                <br>

					<div class="box">
						<div class="box-header">
							<h3 class="box-title">用户列表</h3>&nbsp;&nbsp;&nbsp;&nbsp;
							
							<button type="button" class="btn btn-primary btn-add">
								<i class="fa fa-plus"></i>&nbsp;添加用户
							</button>
						</div>

						<div class="box-body">
							<form id="form" method="post" action="">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
					                        <th>用户名</th>
					                        <th>姓名</th>
					                        <th>角色</th>
					                        <th>分组</th>
					                        <th>部门名称</th>
					                        <th>职位</th>
					                        <th>入职日期</th>
					                        <th>联系电话</th>
					                        <th>登陆时间</th>
					                        <th>状态</th>
					                        <th>操作</th>
										</tr>
									</thead>

									<tbody>
										<?php foreach ($list as $key => $val): ?>
											<tr>
												<td><?= $val['username'] ?></td>
												<td><?= $val['name'] ?></td>
                            					<td>
                            					<?php foreach ($val['title'] as $v) 
                            					{
                            						echo $v . '&nbsp;&nbsp;&nbsp;';
                            					} 
                            					?>
                            					</td>
                            					<td><?= $val['gtitle'] ?></td>
                            					<td><?= $val['dept_name'] ?></td>
                            					<td><?= $val['position'] ?></td>
                            					<td><?= $val['entry_date'] ?></td>
                            					<td><?= $val['phone'] ?></td>
                            					<td><?= $val['login_time'] ?></td>
                            					<td>
                            						<a href="javascript:;" class="disable" title="点击禁用" rel="<?= $val['id'] ?>" ><?php if($val['status'] == 0): ?>启用<?php endif; ?></a>
                            						
                            						<a href="javascript:;" class="enable" title="点击启用" rel="<?= $val['id'] ?>" ><?php if($val['status'] == 1): ?>禁用<?php endif; ?></a>
                            					</td>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="margin-top:70px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">用户管理</h4>
            </div>

            <form id="menu-form" class="form-horizontal form-data" action="<?php echo site_url('admin/User/add_or_update') ?>" method="post">
				<div class="modal-body">
					<input type="hidden" id="id" name="id" value="">

					<div class="form-group">
						<label class="col-sm-4 control-label"> 用户名 </label>
						<div class="col-sm-6">
							<input type="text" id="username" name="username" class="form-control" placeholder="请输入用户名" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 姓名 </label>
						<div class="col-sm-6">
							<input type="text" id="name" name="name" class="form-control" placeholder="请输入用户名" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 密码 </label>
						<div class="col-sm-6">
							<input type="password" id="password" name="password" class="form-control" placeholder="" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 分组 </label>
						<div class="col-sm-6">
							<select id="gid" name="gid" class="form-control">
								
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 部门 </label>
						<div class="col-sm-6">
							<select id="department_id" name="department_id" class="form-control">
								
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 职位 </label>
						<div class="col-sm-6">
							<input type="text" id="position" name="position" class="form-control" placeholder="请输入职位" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 入职日期 </label>
						<div class="col-sm-6">
							<div class="input-group">
						      	<input type="text" name="entry_date" id="entry_date" class="form-control" placeholder="请选择日期" value="">
						      	<span class="help-inline input-group-addon clear-date"><i class='fa fa-remove'></i></span>
						    </div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 联系电话 </label>
						<div class="col-sm-6">
							<input type="text" id="phone" name="phone" class="form-control" placeholder="请输入联系电话" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 电子邮箱 </label>
						<div class="col-sm-6">
							<input type="text" id="email" name="email" class="form-control" placeholder="请输入电子邮箱" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label"> 状态 </label>
						<div class="col-sm-6">
							<select id="status" name="status" class="form-control">
								<option value="0" > 启用 </option>
								<option value="1" > 禁用 </option>
							</select>
						</div>
					</div>

					<hr />

					<div class="form-group">
						<label class="col-sm-4 control-label"> 角色 </label>
						<div class="col-sm-6">
							<div class="row">
								<?php foreach ($role as $v): ?>
									<div class="col-sm-6">
										<input type="checkbox" id="title<?= $v['id'] ?>" name="title[]" class="role-check flat" value="<?= $v['id'] ?>" style="margin-top:10px;margin-left:13px;" />&nbsp;&nbsp;<?= $v['title'] ?>
									</div>
								<?php endforeach; ?>
							</div>
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

		$('#entry_date').daterangepicker(op, function(start, end, label) {}); 

		$('input.flat').iCheck({
			checkboxClass: 'icheckbox_flat-purple',
			radioClass: 'iradio_flat-purple'
		});

		// 新增
		$('.btn-add').click(function(){

			// 清空下拉框的值
			$('#gid').empty();
			$('#department_id').empty();
			$('#gid, #department_id').append(("<option value=''>请选择</option>"));

			url = "<?php echo site_url('admin/User/add') ?>";

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
						$('#id').val('');
						$('#username').val('');
						$('#name').val('')
						$('#password').attr('placeholder', '请输入密码');

						// 动态分配分组信息 data.group 二维数组
						var obj = data.group;
	                    $.each(obj, function(key, val) {   
	                        var option = $("<option>").val(obj[key]['id']).text(obj[key]['title']);
 							$('#gid').append(option);
	                    }); 

	                    // 动态分配部门信息 data.dept 二维数组
	                    var obj = data.dept;
	                    $.each(obj, function(key, val) {   
	                        var option = $("<option>").val(obj[key]['id']).text(obj[key]['dept_name']);
 							$('#department_id').append(option);
	                    });

						$('#position').val('');
						$('#entry_date').val('');
						$('#phone').val('');
						$('#email').val('');
						$('#login_time').val('');

						$('#status').val(0);
						$('input').iCheck('uncheck');

						$('#myModal').modal();
					}				
				}
			});	
		})
		
		// 编辑
		$('.btn-edit').click(function(){

			// 记下当前网址，存入cookie，后台跳转用到的地址
			page_url = window.location.href;
            $.cookie('page_url', page_url, {path:'/'});

			// 清空下拉框的值
			$('#gid').empty();
			$('#department_id').empty();
			$('#gid, #department_id').append(("<option value='0'>请选择</option>"));

			url = "<?php echo site_url('admin/User/edit') ?>";

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
						$('#id').val(data.user.id);
						$('#username').val(data.user.username);
						$('#name').val(data.user.name);
						$('#password').attr('placeholder', '密码留空则不修改');

						// 动态分配分组信息 data.group 对象数组
						var obj = data.group;
	                    $.each(obj, function(key, val) {  
	                        var option = $("<option>").val(obj[key]['id']).text(obj[key]['title']);
 							$('#gid').append(option);
	                    }); 

	                    // 动态分配部门信息 data.dept 对象数组
	                    var obj = data.dept;
	                    $.each(obj, function(key, val) {   
	                        var option = $("<option>").val(obj[key]['id']).text(obj[key]['dept_name']);
 							$('#department_id').append(option);
	                    });


	                    $('#gid').val(data.user.gid);
						$('#department_id').val(data.user.department_id);

						$('#position').val(data.user.position);
						$('#phone').val(data.user.phone);
						$('#entry_date').val(data.user.entry_date);
						$('#email').val(data.user.email);
						$('#login_time').val(data.user.login_time);

						$('#status').val(data.user.status);

						$('input').iCheck('uncheck');
						if(data.user.group_id)
						{
							$.each(data.user.group_id, function(i, value){
								$('#title' + data.user.group_id[i]).iCheck('check');
							})
						}

						$('#myModal').modal();
					}	
				}
			});	
		})

		// 删除
		$('.btn-del').click(function(){

			var me = $(this);

			url = "<?php echo site_url('admin/User/del') ?>"

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
			var id = $('#id').val();
			var username = $('#username').val();
			var password = $('#password').val();

            if($.trim(username) == '')
            {
                layer.msg('用户名不能为空！');
                return;
            }
            else if(id == '' && $.trim(password) == '')
            {
            	layer.msg('密码不能为空！');
            	return;
            }
            else
            {
            	$('#menu-form').submit();
            }
		})

		// 禁用/启用
		$('.disable, .enable').click(function(){
			url = "<?php echo site_url('admin/User/status') ?>";
			me = $(this);

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
					else if(data.status == 1)
					{
						layer.msg('该用户不能更改状态！');
						return;
					}
					else if(data.status == 2)
					{						
						layer.msg('启用成功！');
						me.text('启用');
						return;
					}	
					else if(data.status == 3)
					{
						layer.msg('禁用成功！');
						me.text('禁用');
						return;
					}
				}
			});	
		})
	})
</script>

</body>
</html>