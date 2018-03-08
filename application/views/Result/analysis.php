

<div class="wrapper">
	<div class="content-wrapper">
		<section class="content">
			<?php $this->load->view('Public/breadcrumbs'); ?>
			<div class="row" style="font-size: 12px;">
				<div class="col-xs-12">
					<!--搜索表单-->
                    <form class="form-inline" action="<?php echo site_url('admin/Result/analysis'); ?>" method="get">
                        <select id="quarter_id" name="quarter_id" class="form-control">
                            <!--<option value="">时间段选择</option>-->
                            <?php foreach ($quarter as $v): ?>
                                <option value="<?= $v['id'] ?>" <?php if(isset($_GET['quarter_id']) && $_GET['quarter_id'] == $v['id']) echo 'selected'; ?> >
                                	<?php echo $v['year'] . '年' . $v['quarter']; ?>
                                </option>
                        	<?php endforeach; ?>
                        </select>

                        <button type="submit" class="btn btn-primary">
                            <span class="fa fa-search"></span>
                            搜索
                        </button>

                        <a href="<?php echo site_url('admin/Result/export_analysis') ?>?quarter_id=<?php if(isset($_GET['quarter_id'])) echo $_GET['quarter_id']; ?>"  class="btn btn-info" style="float:right;">
        					导出结果分析表
            			</a>
                    </form>
                    <br>
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">考核结果分析表</h3>
						</div>

						<div class="box-body">
							<form id="form" method="post" action="">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
					                        <th>部门</th>
				                            <th>被考核人</th>
				                            <th>考核数</th>
				                            <th>效率平均分</th>
				                            <th>协作平均分</th>
				                            <th>创新平均分</th>
				                            <th>能力平均分</th>
				                            <th>管理平均分</th>
				                            <th>总分平均分</th>
										</tr>
									</thead>

									<tbody>
										<?php foreach ($list as $key => $val): ?>
											<tr>
												<td><?= $val['u_dept'] ?></td>
												<td><?= $val['user'] ?></td>
												<td><?= $val['check_num'] ?></td>
                            					<td><?= number_format($val['score'][0], 2) ?></td>
                            					<td><?= number_format($val['score'][1], 2) ?></td>
                            					<td><?= number_format($val['score'][2], 2) ?></td>
                            					<td><?= number_format($val['score'][3], 2) ?></td>
                            					<td><?= number_format($val['score'][4], 2) ?></td>
                            					<td><?= number_format($val['total_score'], 2) ?></td>
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

	})
</script>

</body>
</html>