

<div class="wrapper">
	<div class="content-wrapper">
		<section class="content">
			<?php $this->load->view('Public/breadcrumbs'); ?>
			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">日志内容</h3>
						</div>

						<div class="box-body">
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
				                        <th style="text-align: center;">#</th>
				                        <th style="text-align: center;">用户</th>
				                        <th style="text-align: center;">时间</th>
				                        <th style="text-align: center;">IP</th>
				                        <th style="text-align: center;">日志内容</th>
									</tr>
								</thead>

								<tbody>
									<?php foreach ($list as $v): ?>
										<tr>
											<td style="text-align: center;"><?= $v['id'] ?></td>
											<td style="text-align: center;"><?= $v['username'] ?></td>
											<td style="text-align: center;"><?= date("Y-m-d H:i:s", $v['time']) ?></td>
											<td style="text-align: center;"><?= $v['ip'] ?></td>
											<td style="text-align: center;"><?= $v['log'] ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
							<div style="text-align:center;"><?= $links ?></div>
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