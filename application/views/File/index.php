<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form role="form" method="post" action="<?php echo site_url('admin/File/upload') ?>" enctype="multipart/form-data">
		<div class="form-group">
			<input type="file" id="exampleInputFile" name="files">
		</div>
		<br>
		<button type="submit" class="btn btn-default">提交</button>
	</form>
</body>
</html>