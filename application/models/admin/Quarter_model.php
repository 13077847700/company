<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');

class Quarter_model extends CI_Model
{

	/**
	 * 获取时间段列表
	 */
	public function get_quarter_list($where = '1 = 1', $offset = null, $page_size = null)
	{
		$data = $this->db->order_by('id', 'DESC')
						->where($where)
						->limit($page_size, $offset)
						->get('quarter')
						->result_array();
		return $data;
	}

	/**
	 * 获取要编辑时间段的信息
	 */
	public function get_quarter_info($id)
	{
		if($id)
		{
			$quarter = $this->db->where(array('id' => $id))->get('quarter')->row_array();
			return $quarter;
		}
	}

	/**
	 * 新增或更新时间段
	 */
	public function add_or_update($data)
	{
		if($data['id'])
		{
			$bool = $this->db->where(array('id' => $data['id']))->update('quarter', $data);
			if($bool)
			{
				addlog('更新时间段成功！名称 : ' . $data['year'] . '年' . $data['quarter']);
				redirect('admin/Quarter/index');
			}
			else
			{
				showmessage('参数错误', 'back', 1);
			}			
		}
		else
		{
			unset($data['id']);
			$bool = $this->db->insert('quarter', $data);

			if($bool)
			{
				addlog('新增时间段成功！名称 : ' . $data['year'] . '年' . $data['quarter']);
				redirect('admin/Quarter/index');
			}
			else
			{
				showmessage('参数错误', 'back', 1);
			}
		}
	}

	/**
	 * 删除
	 */
	public function del($id)
	{
		if($id)
		{
			$bool = $this->db->where(array('id' => $id))->delete('quarter');

			if($bool)
			{
				addlog('删除时间段, ID: ' . $id);
				return true;
			}
			else
			{
				showmessage('参数错误', 'back', 1);
				return false;
			}			
		}
	}
}