

<div class="wrapper">
	<div class="content-wrapper">
		<section class="content">
			<?php $this->load->view('Public/breadcrumbs'); ?>
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">待考核部门员工</h3>&nbsp;&nbsp;&nbsp;&nbsp;
						</div>

						<div class="box-body">
							<form id="form" method="post" action="">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
					                        <th>部门</th>
					                        <th>职位</th>
				                            <th>姓名</th>
				                            <th>效率平均分</th>
				                            <th>协作平均分</th>
				                            <th>创新平均分</th>
				                            <th>能力平均分</th>
				                            <!--<th>管理平均分</th>-->
				                            <th width="10%">优点</th>
				                            <th width="10%">建议</th>
				                            <th>操作</th>
										</tr>
									</thead>

									<tbody>
										<?php foreach ($list as $key => $val): ?>
											<tr>
												<td><?= $val['u_dept'] ?></td>
												<td><?= $val['position'] ?></td>
												<td><?= $val['user'] ?></td>
                            					<td><?= $val['score1'] ?></td>
                            					<td><?= $val['score2'] ?></td>
                            					<td><?= $val['score3'] ?></td>
                            					<td><?= $val['score4'] ?></td>
                            					<!--<td></td>-->
                            					<td><?= $val['advantage'] ?></td>
                            					<td><?= $val['advise'] ?></td>

                            					<td class="center">
                            						<a href="<?php echo site_url('admin/Score/comment') ?>?id=<?= $val['id'] ?>" class="btn btn-default comment" rel="<?= $val['id'] ?>" > <i class="fa fa-pencil-square-o"></i>&nbsp;评价</a>&nbsp;
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

	})
</script>

</body>
</html>