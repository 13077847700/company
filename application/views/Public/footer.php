<!-- jQuery -->
<script src="public/Resources/js/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="public/Resources/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="public/Resources/dist/js/app.min.js"></script>
<!-- iCheck -->
<!--<script src="public/Resources/plugins/iCheck/icheck.min.js"></script>-->
<script src="public/Resources/plugins/ICheck/icheck.min.js"></script>
<!-- layer -->
<script src="public/layer/layer.js"></script>

<!-- jquery.cookie.js -->
<script src="public/Resources/js/jquery.cookie.js"></script>

<!-- 日期插件 -->
<script src="public/daterangepicker/moment.min.js"></script>
<script src="public/daterangepicker/daterangepicker.js"></script>

<!-- bootstrap-table -->
<script src="public/Resources/js/bootstrap-table.js"></script>
<script src="public/editable/bootstrap-table-editable.js"></script>
<script src="public/editable/bootstrap-editable.js"></script>

<script>
		var op = {
	        "autoApply": true,
	        "singleDatePicker": true,
	        "showDropdowns": true,
	        "locale":{
	            'format': 'YYYY-MM-DD',
	             "separator": "至",
	             "daysOfWeek": [
	                "周日",
	                "周一",
	                "周二",
	                "周三",
	                "周四",
	                "周五",
	                "周六"
	            ],
	            "monthNames": [
	                "一月",
	                "二月",
	                "三月",
	                "四月",
	                "五月",
	                "六月",
	                "七月",
	                "八月",
	                "九月",
	                "十月",
	                "十一月",
	                "十二月"
	            ],
	            "applyLabel": '确定',
	            "cancelLabel": '取消'
	            },   
        };

        $('.clear-date').click(function(e) 
        {
            $(this).siblings('input').val('');
        });

        // 360 按钮延迟解决办法
        layer.config({
		  	anim: 5, //动画
		});
</script>


