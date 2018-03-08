
    <div class="breadcrumbs" id="breadcrumbs">
        <style>
            .breadcrumb>li+li:before
            {
                content: ">\00a0";
            }
        </style>
        <script type="text/javascript">
            try {
                ace.settings.check('breadcrumbs', 'fixed')
            } catch (e) {
            }
        </script>

        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="<?php echo site_url('admin/Home/index') ?>">首页</a>
            </li>
            <?php if(!empty($current['ptitle'])): ?>
                <li>
                    <a><?= $current['ptitle'] ?></a>
                </li>
            <?php endif; ?>
            <li class="active"><?= $current['title'] ?></li>
        </ul><!-- /.breadcrumb -->
    </div>