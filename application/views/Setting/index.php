
<div class="wrapper">
	<div class="content-wrapper">
		<section class="content">
			<?php $this->load->view('Public/breadcrumbs'); ?>
			<div class="row">
				<div class="col-xs-12">
					<div class="box-body">
						<form id="form" class="form-horizontal form-data" action="<?php echo site_url('admin/Setting/update_pass') ?>" method="post">
							<div class="modal-body">
								<div class="form-group">
									<label class="col-sm-2 control-label"> 旧密码 </label>
									<div class="col-sm-4">
										<input type="password" id="oldPass" name="oldPass" class="form-control" placeholder="请输入旧密码" />
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label"> 新密码 </label>
									<div class="col-sm-4">
										<input type="password" id="newPass" name="newPass" class="form-control" placeholder="请输入新密码" />
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label"> 确认密码 </label>
									<div class="col-sm-4">
										<input type="password" id="confirmPass" name="confirmPass" class="form-control" placeholder="请输入确认密码" />
									</div>
								</div>

								<br>
								<br>
								<br>

								<div class="col-md-offset-2 col-md-4" style="text-align: center;">
									<button type="button" class="btn btn-success btn-longer submit-btn"><i class="fa fa-cloud-upload"></i>&nbsp;提&nbsp;交</button>&nbsp;&nbsp;&nbsp;
									<button type="reset" class="btn btn-info back-btn" data-dismiss="modal">重&nbsp;置</button>
								</div>

							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

<?php $this->load->view('Public/footer'); ?>

<script>
	$(document).ready(function(){

		// 提交
		$('.submit-btn').click(function(){

			var oldPass = $('#oldPass').val();
            var newPass = $('#newPass').val();
            var confirmPass = $('#confirmPass').val();

            if($.trim(oldPass) == '')
            {
                layer.tips('旧密码不能为空！', '#oldPass', {
	                tips : [1, '#3595CC'],
	                time : 2000
	            });
	            return;
            }
            else if($.trim(newPass) == '')
            {
                layer.tips('新密码不能为空！', '#newPass', {
	                tips : [1, '#3595CC'],
	                time : 2000
	            });
	            return;
            }
            else if($.trim(confirmPass) == '')
            {
                layer.tips('确认密码不能为空！', '#confirmPass', {
	                tips : [1, '#3595CC'],
	                time : 2000
	            });
	            return;
            }
            else if($.trim(newPass) != $.trim(confirmPass))
            {
                layer.tips('新密码与确认密码不一致！', '#confirmPass', {
	                tips : [1, '#3595CC'],
	                time : 2000
	            });
	            return;
            }
            else
            {
            	url = "<?php echo site_url('admin/setting/check_pass') ?>";

            	$.ajax({
	                url : url,
	                type : "POST",
	                data : 
	                {
	                    oldPass : oldPass,
	                    newPass : newPass,
	                    confirmPass : confirmPass,
	                },
	                dataType : "json",
	                success : function(data){
	                    //alert(data.status);
	                    if(data.status == 1)
	                    {
	                    	layer.tips('旧密码错误，请重试！', '#oldPass', {
				                tips : [1, '#3595CC'],
				                time : 2000
				            });
				            return;
	                    }
	                    else if(data.status == 2)
	                    {
	                    	layer.tips('新密码长度必须为8至16位！<br>必须包含：数字、字母！', '#newPass', {
				                tips : [1, '#3595CC'],
				                time : 4000
				            });
				            return;
	                    }
	                    else if(data.status == 3)
	                    {
	                    	$('#form').submit();
	                    }
	                }
	            });
            }
		})

	})
</script>

</body>
</html>