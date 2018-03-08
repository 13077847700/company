

<div class="wrapper">
	<div class="content-wrapper">
		<section class="content">
			<div class="row">
				<div class="col-xs-12">
					<form id="role-form" class="form-horizontal form-data" action="<?php echo site_url('admin/Role/add_or_update') ?>" method="post">
						<div class="modal-body">
							<div class="form-group">
								<label class="col-sm-2 control-label"> 角色名称 </label>
								<div class="col-sm-8">
									<input type="text" id="title" name="title" class="form-control" placeholder="请输入角色名称" value='<?php if(isset($group['title'])) echo $group['title']; ?>' />
                                    <input type="hidden" name="id" id="id" value="<?php if(isset($group['id'])) echo $group['id']; ?>">
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label"> 备注 </label>
								<div class="col-sm-8">
									<input type="text" id="remark" name="remark" class="form-control" placeholder="请输入备注" value='<?php if(isset($group['remark'])) echo $group['remark']; ?>' />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-2 control-label"> 权限选择 </label>
								<div class="col-sm-8">
									<?php foreach ($rule as $v): ?>
                                        <div class="widget-box">
                                            <div class="widget-header">
                                                <h4 class="widget-title">
                                                    <label>
                                                        <input name="rules[]"
                                                               class="ace ace-checkbox-2 father" <?php if(isset($group['rules']) && in_array($v['id'],$group['rules'])){echo 'checked="checked"';};?>
                                                        type="checkbox" value="<?= $v['id'] ?>"/>
                                                        <span class="lbl"> <?= $v['title'] ?> </span>
                                                    </label>
                                                </h4>
                                                <div class="widget-toolbar">
                                                	<?php if(isset($v['children'])): ?>
                                                        <a>
                                                            <i class="ace-icon fa fa-chevron-up"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php if(isset($v['children'])): ?>
                                                <div class="widget-body">
                                                    <div class="widget-main row">
                                                        <?php foreach ($v['children'] as $vv): ?> 
                                                            <label class="col-xs-2" style="width:160px;">
                                                                <input name="rules[]"
                                                                       class="ace ace-checkbox-2 children" <?php if(isset($group['rules']) && in_array($vv['id'],$group['rules'])){echo 'checked="checked"';};?>
                                                                type="checkbox" value="<?= $vv['id'] ?>"/>
                                                                <span class="lbl"> <?= $vv['title'] ?> </span>
                                                            </label>
                                                            <?php if(isset($vv['children'])): ?>
                                                                <?php foreach ($vv['children'] as $vvv): ?>
                                                                    <label class="col-xs-2"
                                                                           style="width:160px;">
                                                                        <input name="rules[]"
                                                                               class="ace ace-checkbox-2 children" <?php if(isset($group['rules']) && in_array($vvv['id'],$group['rules'])){echo 'checked="checked"';};?> 
                                                                        type="checkbox" value="<?= $vvv['id'] ?>"/>
                                                                        <span class="lbl"> <?= $vvv['title'] ?> </span>
                                                                    </label>
                                                            	<?php endforeach;?>
                                                        	<?php endif; ?>
                                                    	<?php endforeach; ?>
                                                    </div>
                                                </div>
                                        	<?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
								</div>
							</div>

							<div class="col-md-offset-5 col-md-9">
								<button type="button" class="btn btn-success btn-longer submit-btn"><i class="fa fa-cloud-upload"></i>&nbsp;确&nbsp;定</button>&nbsp;&nbsp;&nbsp;
								<button type="button" class="btn btn-default back-btn" data-dismiss="modal">返&nbsp;回</button>
							</div>
						</div>
		            </form>
				</div>
			</div>
		</section>
	</div>
</div>

<?php $this->load->view('Public/footer'); ?>

<script>
	$(document).ready(function(){

		$('.widget-toolbar').click(function(){
			var self = $(this);
			self.parent().siblings().slideToggle();
		})

        $(".children").click(function () {
            $(this).parent().parent().parent().parent().find(".father").prop("checked", true);
        })

        $(".father").click(function () {
            if (this.checked) {
                $(this).parent().parent().parent().parent().find(".children").prop("checked", true);
            } else {
                $(this).parent().parent().parent().parent().find(".children").prop("checked", false);
            }
        })

		$('.submit-btn').click(function(){
            var title = $('#title').val();
            if($.trim(title) == '')
            {
                layer.msg('角色名称不能为空！');
                return;
            }
			$('#role-form').submit();
		})

        $('.back-btn').click(function(){
            window.history.back();
        })
	})
</script>

</body>
</html>