<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 考核结果控制器
 */

class Result extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/check_model');
		$this->load->model('admin/result_model');
		$this->load->model('admin/quarter_model');

		// 加载PHPExcel的类
		$this->load->library('Excel/PHPExcel');
		$this->load->library('Excel/PHPExcel/IOFactory');

		// 加载Excel
		$this->load->library('Excel/Excel');
	}

	// 考核结果明细表
	public function detail()
	{
		$where = $this->get_where();

		$info = $this->result_model->get_detail_list($where);  // 考核结果明细表

		$data['list'] = $this->count_every_score($info);

		$data['quarter'] = $this->quarter_model->get_quarter_list();  // 搜索表单列表
		//dump($data);die;
		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('Result/detail', $data);
	}

	// 考核结果分析表
	public function analysis()
	{
		$where = $this->get_where();

		$info = $this->result_model->get_analysit_list($where);  // 获取考核结果分析表数据

		$data['list'] = $this->count_score($info);

		$data['quarter'] = $this->quarter_model->get_quarter_list();  // 搜索表单列表

		//dump($data);die;
		$this->load->view('Public/header');
		$this->load->view('Public/sidebar');
		$this->load->view('Result/analysis', $data);
	}

	// 搜索条件
	private function get_where()
	{
		if(isset($_GET['quarter_id']) && $_GET['quarter_id'] != null)
		{
			$where = array('quarter_id' => $_GET['quarter_id']);
		}
		else
		{
			$max_id = $this->db->select_max('id')->get('quarter')->row_array();  // 找出id最大的时间段记录
			$where = array('quarter_id' => intval($max_id['id']));
		}

		return $where;
	}

	/**
	 * 计算每个人的总分
	 */
	private function count_every_score($data)
	{	
		$proportion = $this->get_proportion();  // 获取占比

		foreach($data as $k => $v)
		{
			$score = array(0, 0, 0, 0, 0);
			for($i = 0; $i < 5; $i++)
			{
				$j = $i + 1;
				$score[$i] = $v["score{$j}"] * (isset($proportion[$i]) ? $proportion[$i] : 0)/100;		
			}

			$data[$k]['total_score'] = array_sum($score);
		}		

		return $data;
	}

	/**
	 * 计算平均分，总分
	 */
	private function count_score($data)
	{
		$proportion = $this->get_proportion();  // 获取占比

		$temp = array();
		foreach($data as $v)
		{
			if(isset($_GET['quarter_id']) && $_GET['quarter_id'] != null)
			{
				$where = array(
					'quarter_id' => $_GET['quarter_id'], 
					'user_id' => $v['uid'], 
					'score1 != ' => null,
					'score2 != ' => null,
					'score3 != ' => null,
					'score4 != ' => null,
					'score5 != ' => null
					);
			}
			else
			{
				$max_id = $this->db->select_max('id')->get('quarter')->row_array();  // 找出id最大的时间段记录
				$where = array(
					'quarter_id' => intval($max_id['id']), 
					'user_id' => $v['uid'],
					'score1 != ' => null,
					'score2 != ' => null,
					'score3 != ' => null,
					'score4 != ' => null,
					'score5 != ' => null
					);
			}

			$everyone = $this->result_model->get_detail_list($where);  // 每个被评员工的考核结果明细表(8个)
			$count = count($everyone);			

			if($count != 0)
			{
				$score = array(0, 0, 0, 0, 0);
				for($j = 0; $j < 5; $j++)
				{
					$k = $j + 1;
					for($i = 0; $i < $count; $i++)
					{
						$score[$j] += $everyone[$i]["score{$k}"];
					}
					$score[$j] = $score[$j]/$count * (isset($proportion[$j]) ? $proportion[$j] : 0)/100;				
				}

				$result['uid'] = $v['uid'];
				//$result['position'] = $v['position'];
				$result['u_dept'] = $v['u_dept'];
				$result['check_num'] = $count;
				$result['user'] = $v['user'];
				$result['score'] = $score;
				$result['total_score'] = array_sum($score);
				
				$temp[] = $result;
			}
		}

		return $temp;
	}

	/**
	 * 获取占比
	 * return array => (40,40,20)
	 */
	private function get_proportion()
	{
		$level = $this->input->get('level');

		$level = isset($level) ? $level : 1;

		$where = array('group_id' => $level);

		$data = $this->check_model->get_check_list($where);  // 列表
		
		foreach ($data as $v) 
		{
			$proportion[] = $v['proportion'];
		}

		return $proportion;
	}

	/* 导出结果明细表 */
	public function export_detail()
	{
		$where = $this->get_where();

		$info = $this->result_model->get_detail_list($where);  // 考核结果明细表

		$list = $this->count_every_score($info);

		//dump($list);die;

		$row = array();
		$row[0]=array('编号','部门','被考核人','跨部门','评分人','效率分','协作分','创新分','能力分','管理分','总分','优点','建议','时间');
		$i = 1;
		foreach($list as $v) 
		{
			$row[$i]['i'] = $i;
			$row[$i]['u_dept'] = $v['u_dept'];
			$row[$i]['user'] = $v['user'];
			$row[$i]['uu_dept'] = $v['uu_dept'];
			$row[$i]['judger'] = $v['judger'];
			$row[$i]['score1'] = number_format($v['score1'], 2);
			$row[$i]['score2'] = number_format($v['score2'], 2);
			$row[$i]['score3'] = number_format($v['score3'], 2);
			$row[$i]['score4'] = number_format($v['score4'], 2);
			$row[$i]['score5'] = number_format($v['score5'], 2);
			$row[$i]['total_score'] = number_format($v['total_score'], 2);
			$row[$i]['advantage'] = $v['advantage'];
			$row[$i]['advise'] = $v['advise'];
			$row[$i]['create_time'] = $v['create_time'];

			$i++;
		}
		//dump($row);die;
		$xls = new \Excel('UTF-8', false, 'datalist');
    	$xls->addArray($row);
    	$xls->generateXML("detail");
	}

	/* 导出结果分析表 */
	public function export_analysis()
	{
		$where = $this->get_where();

		$info = $this->result_model->get_analysit_list($where);  // 获取考核结果分析表数据

		$list = $this->count_score($info);

		//dump($list);die;

		$row = array();
		$row[0]=array('编号','部门','被考核人','考核数','效率平均分','协作平均分','创新平均分','能力平均分','管理平均分','总平均分');
		$i = 1;
		foreach($list as $v) 
		{
			$row[$i]['i'] = $i;
			$row[$i]['u_dept'] = $v['u_dept'];
			$row[$i]['user'] = $v['user'];
			$row[$i]['check_num'] = $v['check_num'];
			$row[$i]['score_0'] = number_format($v['score'][0], 2);
			$row[$i]['score_1'] = number_format($v['score'][1], 2);
			$row[$i]['score_2'] = number_format($v['score'][2], 2);
			$row[$i]['score_3'] = number_format($v['score'][3], 2);
			$row[$i]['score_4'] = number_format($v['score'][4], 2);
			$row[$i]['total_score'] = number_format($v['total_score'], 2);

			$i++;
		}
		//dump($row);die;
		$xls = new \Excel('UTF-8', false, 'datalist');
    	$xls->addArray($row);
    	$xls->generateXML("analysis");
	}
}
