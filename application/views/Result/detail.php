

<div class="wrapper">
	<div class="content-wrapper">
		<section class="content">
			<?php $this->load->view('Public/breadcrumbs'); ?>
			<div class="row" style="font-size: 12px;">
				<div class="col-xs-12">
					<!--搜索表单-->
                    <form class="form-inline" action="<?php echo site_url('admin/Result/detail'); ?>" method="get">
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

                        <a href="<?php echo site_url('admin/Result/export_detail') ?>?quarter_id=<?php if(isset($_GET['quarter_id'])) echo $_GET['quarter_id']; ?>"  class="btn btn-info" style="float:right;">
        					导出结果明细表
            			</a>
                    </form>
                    <br>
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">考核结果明细表</h3>&nbsp;&nbsp;&nbsp;&nbsp;
							
							<!--<button type="button" class="btn btn-primary btn-add">
								<i class="fa fa-plus"></i>&nbsp;导出
							</button>-->
						</div>

						<div class="box-body">
							<form id="form" method="post" action="">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>部门</th>
				                            <th>被考核人</th>
				                            <th>跨部门</th>
				                            <th>评分人</th>
				                            <th>效率分</th>
				                            <th>协作分</th>
				                            <th>创新分</th>
				                            <th>能力分</th>
				                            <th>管理分</th>
				                            <th>总分</th>
				                            <th width="150px;">优点</th>
				                            <th width="150px;">建议</th>
				                            <th>时间</th>
										</tr>
									</thead>

									<tbody>
										<?php foreach ($list as $key => $val): ?>
											<tr>
												<td><?= $val['u_dept'] ?></td>
												<td><?= $val['user'] ?></td>
                            					<td><?= $val['uu_dept'] ?></td>
                            					<td><?= $val['judger'] ?></td>
                            					<td><?= $val['score1'] ?></td>
                            					<td><?= $val['score2'] ?></td>
                            					<td><?= $val['score3'] ?></td>
                            					<td><?= $val['score4'] ?></td>
                            					<td><?= $val['score5'] ?></td>
                            					<td><?php if($val['total_score'] != 0) echo $val['total_score'];  ?></td>
                            					<td><?= $val['advantage'] ?></td>
                            					<td><?= $val['advise'] ?></td>
                            					<td><?= $val['create_time'] ?></td>
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