<?php 

$config['first_link'] = '首页';
$config['last_link'] = '末页';
$config['prev_link'] = '上一页';
$config['next_link'] = '下一页';
$config['uri_segment'] = 4; // 分页的数据查询偏移量在哪一段上
$config['num_links'] = 2;
$config['reuse_query_string'] = TRUE;  // 将会将查询字符串参数添加到 URI 分段的后面 以及 URL 后缀的前面。

$config['full_tag_open'] = '<ul class="pagination">';  
$config['full_tag_close'] = '</ul>';  
$config['first_tag_open'] = '<li>';  
$config['first_tag_close'] = '</li>';  
$config['prev_tag_open'] = '<li>';  
$config['prev_tag_close'] = '</li>';  
$config['next_tag_open'] = '<li>';  
$config['next_tag_close'] = '</li>';  
$config['cur_tag_open'] = '<li class="active"><a>';  
$config['cur_tag_close'] = '</a></li>';  
$config['last_tag_open'] = '<li>';  
$config['last_tag_close'] = '</li>';  
$config['num_tag_open'] = '<li>';  
$config['num_tag_close'] = '</li>';