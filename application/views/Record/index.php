

<div class="wrapper">
	<div class="content-wrapper">
		<section class="content">
			<?php $this->load->view('Public/breadcrumbs'); ?>
			<div class="row" style="font-size: 14px;">
				<div class="col-xs-12">
					<?php if(isset($title) && $title == '超级管理员'): ?>
						<!--搜索表单-->
	                    <form class="form-inline" action="<?php echo site_url('admin/Record/index'); ?>" method="get">

	                        <input type="text" name="name" placeholder="请输入姓名" class="form-control" value="<?php if(isset($_GET['name'])) echo $_GET['name']; ?>">

	                        <select id="dept_id" name="dept_id" class="form-control">
	                            <option value="">请选择部门</option>
	                            <?php foreach ($dept_name as $v): ?>
	                                <option value="<?= $v['id'] ?>" <?php if(isset($_GET['dept_id']) && $_GET['dept_id'] == $v['id']) echo 'selected'; ?> >
	                                	<?= $v['dept_name'] ?>
	                                </option>
	                        	<?php endforeach; ?>
	                        </select>

	                        <select id="year" name="year" class="form-control select2" style="width:110px;">
		                    <?php
		                        for($i = 2015; $i < date('Y'); $i++) 
		                        {
		                            if($i == $select_year)
		                            {
		                                 $select = "selected";
		                            }
		                            else
		                            {
		                                $select = "";
		                            }

		                            echo '<option value="'.$i.'"'.$select.'>'.$i.'年'.'</option>';
		                        }

		                    ?>
		                </select>

	                        <button type="submit" class="btn btn-primary">
	                            <span class="fa fa-search"></span>
	                            搜索
	                        </button>
	                    </form>
                	<?php endif; ?>

                	<input type="hidden" name="detail" value="0" >
                    <button class="btn btn-info detail" style="float:right;margin-right:0px;margin-top:-16px;margin-left:30px;">
                    	<span class="fa fa-hand-pointer-o"></span>
                        明细
                    </button>

	                <br>
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">年假列表</h3>
						</div>

						<div class="box-body">
							<form id="form" method="post" action="">
								<table id="table"
						               data-toggle="table"
						               data-show-export="true" 
						               class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
					                        <th>姓名</th>
			                                <th>部门</th>
			                                <th>职位</th>
			                                <th>入职日期</th>
			                                <th><?php echo $select_year;?>年<br>标准年假</th>
			                                <th><?php echo $select_year;?>年<br>可休年假</th>
			                                <th><?php echo $select_year;?>年<br>已休年假</th>
			                                <th><?php echo $select_year;?>年<br>剩余年假</th>
			                                <!--<th>查看详情</th>-->
			                                <!--超级管理员 id-->
			                                
				                                <span style="display:none;">
				                                    <th class="hidd">1</th>
				                                    <th class="hidd">2</th>
				                                    <th class="hidd">3</th>
				                                    <th class="hidd">4</th>
				                                    <th class="hidd">5</th>
				                                    <th class="hidd">6</th>
				                                    <th class="hidd">7</th>
				                                    <th class="hidd">8</th>
				                                    <th class="hidd">9</th>
				                                    <th class="hidd">10</th>
				                                    <th class="hidd">11</th>
				                                    <th class="hidd">12</th>
				                                    <!--<th class="hidd">已休年假调整</th>-->
				                                </span>
			                            	
										</tr>
									</thead>

									<tbody>
										<?php foreach ($list as $key => $val): ?>
											<tr>
												<td><?= $val['name'] ?></td>
												<td><?= $val['dept_name'] ?></td>
												<td><?= $val['position'] ?></td>
												<td><?= $val['entry_date'] ?></td>
												<td><?= $val['standard'] ?></td>
												<td><?= $val['real_vacation'] ?></td>
												<td><?= $val['have_vacation'] ?></td>
												<td><?= $val['left_vacation'] ?></td>
                            				
													<td><?= $val['jan'] ?></td>
													<td><?= $val['feb'] ?></td>
													<td><?= $val['mar'] ?></td>
													<td><?= $val['apr'] ?></td>
													<td><?= $val['may'] ?></td>
													<td><?= $val['jun'] ?></td>
													<td><?= $val['jul'] ?></td>
													<td><?= $val['aug'] ?></td>
													<td><?= $val['sep'] ?></td>
													<td><?= $val['oct'] ?></td>
													<td><?= $val['nov'] ?></td>
													<td><?= $val['dec'] ?></td>
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

<?php $this->load->view('Public/footer'); ?>

<script>
	$(document).ready(function(){ 

		// 明细
		$(".detail").click(function(){            
            $(".hidd").toggle();
            if(!$.cookie('detail') || $.cookie('detail') == '0')
            {
                $.cookie('detail', '1', {path:'/'});
            }
            else
            {   
                $.cookie('detail', '0', {path:'/'});
            } 
        })

        if($.cookie('detail') == '1')
        {
            $(".hidd").show();           
        }
        else
        {
            $(".hidd").hide();
        }
	})
</script>

</body>
</html>