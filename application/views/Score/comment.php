
<div class="wrapper">
	<div class="content-wrapper">
		<section class="content">
			<?php $this->load->view('Public/breadcrumbs'); ?>
			<div class="row">
				<div class="col-xs-10 col-xs-offset-1">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title"></h3>&nbsp;&nbsp;&nbsp;&nbsp;
						</div>

						<div class="box-body">
							<form id="form" method="post" action="<?php echo site_url('admin/Score/mark'); ?>">
								<div style="margin-top: -30px;margin-bottom: 10px;font-size: 18px;">被考核人：<?= $info['user'] ?></div>
								<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
			                    <table class="table table-striped table-bordered table-hover table-condensed">			     
			                        <thead>
			                        <tr>
			                            <th>考核标题</th>
			                            <th width="55%">考核标准</th>
			                            <th>分值范围</th>
			                            <th width="170px">单项总分</th>
			                        </tr>
			                        </thead>
			                        <tbody>

									<?php $i = 1; ?>
			                        <?php foreach($list as $val): ?>
			                            <tr>
			                                <td rowspan="6">
			                                    <?= $val['title'] ?>
			                                </td>
			                                <td>
			                                    <?= $val['content1'] ?>
			                                </td>
			                                <td>
			                                    <?= $val['score1'] ?>
			                                </td>
			                                <td rowspan="5">
			                                    
			                                </td>
			                            </tr>
			                            <tr>
			                                <td>
			                                    <?= $val['content2'] ?>
			                                </td>
			                                <td>
			                                    <?= $val['score2'] ?>
			                                </td>
			                            </tr>
			                            <tr>
			                                <td>
			                                    <?= $val['content3'] ?>
			                                </td>
			                                <td>
			                                    <?= $val['score3'] ?>
			                                </td>
			                            </tr>
			                            <tr>
			                                <td>
			                                    <?= $val['content4'] ?>
			                                </td>
			                                <td>
			                                    <?= $val['score4'] ?>
			                                </td>
			                            </tr>
			                            <tr>
			                                <td>
			                                    <?= $val['content5'] ?><span style="color:rgb(249, 249, 249);">.</span>
			                                </td>
			                                <td style="vertical-align: middle;">
			                                    <?= $val['score5'] ?>
			                                </td>
			                            </tr>
			                            <tr>
			                                <td>
			                                    <b>权重:</b>
			                                </td>
			                                <td>
			                                    <?= $val['proportion'] ?>%
			                                </td>
			                                <td>
			                                	<input class="score form-control" type="text" name="score[]" value="<?php if(isset($info["score{$i}"])) { echo $info["score{$i}"]; $i++; } ?>">
			                                </td>
			                            </tr>
			                        </tbody>

			                    	<?php endforeach; ?>

			                        <tr>
			                            <td>
			                                优点
			                            </td>
			                            <td colspan="3">
			                                <textarea name="advantage" id="advantage" rows="4" placeholder="请输入..."
                                          class="form-control"><?php if(isset($info['advantage'])) echo $info['advantage']; ?></textarea>
			                            </td>
			                        </tr>
			                        <tr>
			                            <td>
			                                建议
			                            </td>
			                            <td colspan="3">
			                            	<textarea name="advise" id="advise" rows="4" placeholder="请输入..."
                                          class="form-control"><?php if(isset($info['advise'])) echo $info['advise']; ?></textarea>
			                            </td>
			                        </tr>
			                    </table>

			                    <div class="text-center" >
									<button type="button" class="btn btn-success btn-longer submit-btn"><i class="fa fa-cloud-upload"></i>&nbsp;提&nbsp;交</button>&nbsp;&nbsp;&nbsp;
									<button type="button" class="btn btn-default back-btn" data-dismiss="modal">返&nbsp;回</button>
								</div>
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

		// 提交
		$('.submit-btn').click(function(){

			var obj = document.getElementsByName("score[]");
			
			for(var i = 0; i < obj.length; i++)
			{
				if(obj[i].value.length == 0)  // 判断是否为空
				{
					layer.msg('单项评分不能为空!');
                	return;
				}
				else if(obj[i].value < 0 || obj[i].value > 100)
				{
					layer.msg('分数范围必须在 0 - 100 !');
                	return;
				}
				else if(isNaN(obj[i].value))
				{
					layer.msg('只能填数字!');
                	return;
				}
			}

			$('#form').submit();
		})

		// 返回
		$('.back-btn').click(function(){
            window.history.back();
        })

	})
</script>

</body>
</html>