<aside class="main-sidebar"> 
    <section class="sidebar">   
        <ul class="sidebar-menu">    
            <?php foreach($menu as $k => $v): ?>
                <li  
                    <?php if($v['id'] == $current['id'] or ($v['id'] == $current['pid']) OR ($v['id'] == $current['ppid'])): ?>
                        class="treeview active"
                    	<?php else: ?>
                        class="treeview"
                    <?php endif; ?>
                >

                	<?php $v_url = 'admin/' . $v['name'];?>
                    <a href="<?php echo site_url($v_url); ?>">
                    	<!--<i class="fa fa-circle-o"></i>-->
                        <i class="<?= $v['icon'] ?>"></i> 
                        <span > <?= $v['title'] ?> </span>

                        <?php if(isset($v['children'])): ?>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                    	<?php endif; ?>
                    </a>
                    
                    <?php if(isset($v['children'])): ?>
                        <ul class="treeview-menu">
                            <?php foreach($v['children'] as $vv): ?>
                                <li
                                    <?php if(($vv['id'] == $current['id']) OR ($vv['id'] == $current['pid'])): ?>
                                        class="active"
                                	<?php endif; ?>
                                    >

                                    <?php $vv_url = 'admin/' . $vv['name'];?>
                                    <a href="<?php echo site_url($vv_url); ?>">
                                    	<i class="<?= $vv['icon'] ?>"></i> 
                                        <?= $vv['title'] ?>

                                        <?php if(isset($vv['children'])): ?>
                                            <span class="pull-right-container">
                                                <i class="fa fa-angle-left pull-right"></i>
                                            </span>
                                        <?php endif; ?>
                                    </a>
                                    
                                    <?php if(isset($vv['children'])): ?>
                                    	<ul class="treeview-menu">
                                        	<?php foreach ($vv['children'] as $vvv): ?>
                                            	<li
                                                    <?php if(($vvv['id'] == $current['id'])): ?>
                                                        class="active"
                                                    <?php endif; ?>
                                                    >

                                                    <?php $vvv_url = 'admin/' . $vvv['name'];?>
                                                    <a href="<?php echo site_url($vvv_url); ?>">
                                                        <i class="<?= $vvv['icon'] ?>"></i> 
                                                        <?=$vvv['title']?>

                                                        <?php if(isset($vvv['children'])): ?>
                                                            <span class="pull-right-container">
                                                                <i class="fa fa-angle-left pull-right"></i>
                                                            </span>
                                                    	<?php endif; ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li> 
        	<?php endforeach; ?>
        </ul>
    </section>
</aside>