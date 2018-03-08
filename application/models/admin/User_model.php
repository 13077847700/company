<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');

class User_model extends CI_Model
{
	/**
	 * 通过用户名，密码找出该用户
	 */
	public function get_user()
	{
		$data = array(
			'username' => $this->input->post('username'),
			'password' => password($this->input->post('password')),
			'is_delete' => 0
		);
		
		return $this->db->select('id, username, status')->where($data)->get('user')->row_array();
	}

	/**
	 * 获取用户列表
	 */
	public function get_user_list($where, $offset, $page_size)
	{
		$data = $this->db->select('u.id, u.username, u.name, group.title as gtitle, d.dept_name, u.position, u.entry_date, u.phone, u.login_time, u.status, g.title')
						->from('user as u')
						->join('auth_group_access as ga', 'u.id = ga.uid', 'left')
						->join('auth_group as g', 'g.id = ga.group_id', 'left')
						->join('group', 'group.id = u.gid', 'left')
						->join('department as d', 'd.id = u.department_id', 'left')
						->where($where)
						->limit($page_size, $offset)
						->order_by('u.department_id', 'ASC')
						->get()
						->result_array();
		//echo $this->db->last_query();die;
		$res = array();
		foreach($data as &$v)
		{
			$name = $v['title'];
			unset($v['title']);
			$res[$v['id']]['title'][] = $name;	
			$res[$v['id']]['item'] = $v;
		}

		foreach ($res as &$v) 
		{
			$v = array_merge($v, $v['item']);
			unset($v['item']);
		}

		return $res;
	}

	/**
	 * 获取角色
	 */
	public function get_role()
	{
		$data = $this->db->select('id, title')->order_by('id', 'ASC')->get('auth_group')->result_array();
		return $data;
	}

	/**
	 * 获取要编辑用户的信息
	 * $id int 用户id
	 */
	public function get_user_info($id)
	{
		if($id)
		{
			$user = $this->db->where(array('id' => $id))->get('user')->row_array();

			$title = $this->db->select('group_id')->where(array('uid' => $id))->get('auth_group_access')->result_array();

			foreach ($title as $key => $val) 
			{
				$user['group_id'][] = $val['group_id'];
			}

			return $user;
		}
	}

	/**
	 * 新增或更新用户
	 */
	public function add_or_update($data)
	{	
		if($data['id'])
		{
			if(empty($data['password']))
			{
				unset($data['password']);
			}
			else
			{
				$data['password'] = password($data['password']);
			}

			$this->db->where(array('uid' => $data['id']))->delete('auth_group_access');

			if(is_array($data['title_id']))
			{
				foreach ($data['title_id'] as $val)
				{
					$arr['uid'] = $data['id'];
					$arr['group_id'] = $val;
					$this->db->insert('auth_group_access', $arr);
				}
			}

			unset($data['title_id']);
			$this->db->where(array('id' => $data['id']))->update('user', $data);

			// 获取前端js存入的网址
			$page_url = $_COOKIE['page_url'];
			setcookie('page_url', '', time()-100, '/'); //清除建立的cookie

			addlog('用户更新成功！用户名 : ' . $data['username'] . ' , id : ' . $data['id']);
			redirect("$page_url");
		}
		else
		{
			$time = time();
			$data['create_time'] = date("Y-m-d H:i:s",$time);
			$data['password'] = password($data['password']);

			$title_id = $data['title_id'];
			unset($data['title_id']);

			$this->db->insert('user', $data);
			$uid = $this->db->insert_id();

			if($uid)
			{
				if(is_array($title_id))
				{
					foreach ($title_id as $val)
					{
						$arr['uid'] = $uid;
						$arr['group_id'] = $val;
						$this->db->insert('auth_group_access', $arr);
					}
				}

				//$this->db->insert('vacation', array('uid' => $uid));  // 用户id插入年假表

				addlog('新增用户成功！用户名 : ' . $data['username'] . ' , id : ' . $uid);
				redirect('admin/User/index');
			}
			else
			{
				showmessage('参数错误', 'back', 1);
			}
		}
	}

	/**
	 * 删除用户
	 * $id 被删除用户的id
	 */
	public function del($id)
	{
		if($id)
		{
			//$bool = $this->db->where(array('id' => $id))->delete('user');
			$bool = $this->db->where(array('id' => $id))->update('user', array('is_delete' => 1));
			$this->db->where(array('uid' => $id))->delete('vacation');  // 删除年假表数据

			if($bool)
			{
				$this->db->where(array('uid' => $id))->delete('auth_group_access');
				addlog('删除用户, ID: ' . $id);
				return true;
			}
			else
			{
				showmessage('参数错误', 'back', 1);
				return false;
			}			
		}
	}

	/**
	 * 修改状态
	 */
	public function change_status($id)
	{
		if($id == 1)
		{
			return 1;
		}

		$user = $this->db->where(array('id' => $id))->get('user')->row_array();
		$status = $user['status'];

		if($status == 1)
		{
			$bool = $this->db->where(array('id' => $id))->update('user', array('status' => 0));
			if($bool)
			{
				return 2;
			}
		}

		if($status != 1)
		{
			$bool = $this->db->where(array('id' => $id))->update('user', array('status' => 1));
			if($bool)
			{
				return 3;
			}
		}
	}
}