<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * excel导入导出控制器
 */

class File extends My_Controller 
{
	public function __construct()
	{
		parent::__construct();
		
		// 加载PHPExcel的类
		$this->load->library('Excel/PHPExcel');
		$this->load->library('Excel/PHPExcel/IOFactory');

		// 加载Excel
		$this->load->library('Excel/Excel');
	}

	public function index()
	{
		$this->load->view('File/index');
	}

	/* 上传 */
	public function upload()
	{
		header("Content-Type:text/html;charset=utf-8");

		$config['upload_path']      = './uploads/';
        $config['allowed_types']    = 'xls|xlsx|csv';
        $config['max_size']     = 314572813456;
        $config ['file_name'] = date( 'Ymdhis', time () );
        
        $this->load->library('upload', $config);

        if ( !$this->upload->do_upload('files'))
        {
            $error = array('error' => $this->upload->display_errors());
            echo $error['error'];die;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $info = $data['upload_data'];
        }

        //dump($info);

        $filename = './uploads/'.$info['file_name'];

        //dump($filename);

        $exts = $info['file_ext'];

        //dump($exts);

        if($info)
        {
        	$phpexcel =new \phpexcel();
          	if ($exts == ".xls") 
          	{
				$this->import_excelxls($filename);
            }
            elseif ($exts == ".xlsx") 
            {
				$this->import_excelxlsx($filename);
            }
            elseif ($exts == ".csv") 
            {
				$this->import_excelcsv($filename);
            }
        }
	}

	/* 导入xls */
	public function import_excelxls($filename)
	{
		if(!file_exists($filename))
		{
			exit("文件内容不能为空!");
		}
		else
		{
			//vendor("PHPExcel.Reader.Excel5");
			$this->load->library('Excel/PHPExcel/Reader/PHPExcel_Reader_Excel5');

			$phpexcelReader = new \PHPExcel_Reader_Excel5();

			$phpexcel = $phpexcelReader->load($filename);
			// 获取工作表(及当前活动的sheet)
			$currentSheet=$phpexcel->getSheet(0);
			// 获取总列数
			$allColumn=$currentSheet->getHighestColumn();
			$allColumn="T";
			// 获取总行数
			$allRow=$currentSheet->getHighestRow();
			//循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
			for($currentRow=1;$currentRow<=$allRow;$currentRow++)
			{
				$address1 = 'B'.$currentRow;
				$arr[$currentRow]['B']=$currentSheet->getCell($address1)->getValue();
				//从哪列开始，A表示第一列
				for($currentColumn='P';$currentColumn<=$allColumn;$currentColumn++)
				{
					//数据坐标
					$address=$currentColumn.$currentRow;
					//读取到的数据，保存到数组$arr中
					$arr[$currentRow][$currentColumn]=$currentSheet->getCell($address)->getValue();
				}
			}
			dump($arr);die;
			$count = count($arr);

			for ($i = 2; $i < $count + 1; $i++) 
			{ 

				//$temp = explode('@', $arr[$i]['H']);
				//dump($temp);die;

				//$data['username'] = $temp[0];
				//$data['password'] = password('123456');
				//$data['position'] = $arr[$i]['B'];
				//$data['phone'] = $arr[$i]['G'];
				/*if($arr[$i]['A'] == "管理团队")
				{
					$arr[$i]['A'] = 1;
				}
				if($arr[$i]['A'] == "事业部")
				{
					$arr[$i]['A'] = 2;
				}
				if($arr[$i]['A'] == "事业部（CQ）")
				{
					$arr[$i]['A'] = 3;
				}
				if($arr[$i]['A'] == "广州办")
				{
					$arr[$i]['A'] = 4;
				}
				if($arr[$i]['A'] == "媒介部")
				{
					$arr[$i]['A'] = 5;
				}
				if($arr[$i]['A'] == "策划部")
				{
					$arr[$i]['A'] = 6;
				}
				if($arr[$i]['A'] == "创意部")
				{
					$arr[$i]['A'] = 7;
				}
				if($arr[$i]['A'] == "技术部")
				{
					$arr[$i]['A'] = 8;
				}
				if($arr[$i]['A'] == "行政部")
				{
					$arr[$i]['A'] = 9;
				}
				$data['department_id'] = $arr[$i]['A'];*/

				//dump($data);


				//$this->db->where(array('name' => $arr[$i]['C']))->update('user', $data);
 				//$data['name'] = $arr[$i]['C'];

				//dump($data);
				//$this->db->insert('user', $data);
				/*if($arr[$i]['D'] == '女')
				{
					$data['username'] = $arr[$i]['C'];
					$data['sex'] = 1;
					//$data['now_department_id'] = 6;
					$where['username'] = $data['username'];
					$row = $table->data($data)->where($where)->save();
				}*/
				

				//$data['username'] = $arr[$i]['B'];

				//$t = intval(($arr[$i]['C'] - 25569) * 3600 * 24);
				//$data['entry_date'] = date("Y-m-d", $t);
				//dump($data);
				//$row = $table->data($data)->add();
				//$where['username'] = $data['username'];

				$data['jan'] = $arr[$i]['BJ'];
				$data['feb'] = $arr[$i]['BK'];
				$data['mar'] = $arr[$i]['BL'];
				$data['apr'] = $arr[$i]['BM'];
				$data['may'] = $arr[$i]['BN'];
				$data['jun'] = $arr[$i]['BO'];


				//dump($data);die;

				//$temp = $this->db->select('id, name')->where(array('name' => $arr[$i]['B']))->get('user')->row_array();
				//dump($temp['id']);die;

				//$this->db->where(array('uid' => $temp['id']))->update('vacation', $data);
		  	}
		  	//die;
		}		
	}
	
	/* 导入xlsx */
	public function import_excelxlsx($filename)
	{
		if(file_exists($filename))
		{
			//vendor("PHPExcel.Reader.Excel2007");
			$this->load->library('Excel/PHPExcel/Reader/PHPExcel_Reader_Excel2007');

			$phpexcelReader = new \PHPExcel_Reader_Excel2007();
			$phpexcel = $phpexcelReader->load($filename);
			// 获取工作表(及当前活动的sheet)
			$currentSheet=$phpexcel->getSheet(0);
			// 获取总列数
			$allColumn=$currentSheet->getHighestColumn();
			$allColumn="E";
			// 获取总行数
			$allRow=$currentSheet->getHighestRow();
			//循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
			//dump($currentSheet);
			//dump($allColumn);
			//dump($allRow);
			for($currentRow=1;$currentRow<=$allRow;$currentRow++)
			{
				//从哪列开始，A表示第一列
				for($currentColumn='A';$currentColumn<=$allColumn;$currentColumn++)
				{
					//数据坐标
				  	$address=$currentColumn.$currentRow;
					//读取到的数据，保存到数组$arr中
				  	$arr[$currentRow][$currentColumn]=$currentSheet->getCell($address)->getValue();
				}
			}

			/*$array = M('Member')->field('id, username')->select();
			dump($array);
			foreach ($array as $key => $value) 
			{
				$data['username'] = $value['username'];
				M('vacation')->where(array('uid'=>$value['id']))->save($data);
			}die('a');*/
			//M('vacation')->where(array('uid'=>))->save($data);

			dump($arr);die;
			$count = count($arr);
			$table = M("media");
			for ($i=3; $i < $count+1; $i++) 
			{ 
				$data['media_short_name'] = $arr[$i]['A'];
				$data['media_full_name'] = $arr[$i]['B'];

				//dump($data);die;
				//$where['username'] = $data['username'];
				//$row = $table->data($data)->where($where)->save();
				$row = $table->data($data)->add();
			}
			$this->success('导入成功', U('index'));
		}
		else
		{
			exit("文件不存在");
		}		
	}

	/* 导入csv 但是中文读取不了 需要更改字符串格式 GBK */
	public function import_excelcsv($filename)
	{
		if(file_exists($filename))
		{
			//vendor("PHPExcel.Reader.CSV");
			$this->load->library('Excel/PHPExcel/Reader/PHPExcel_Reader_CSV');

			$phpexcelReader = new \PHPExcel_Reader_CSV();
			$phpexcel = $phpexcelReader->load($filename);
			// 获取工作表(及当前活动的sheet)
			$currentSheet=$phpexcel->getSheet(0);
			// 获取总列数
			$allColumn=$currentSheet->getHighestColumn();
			$allColumn="T";
			// 获取总行数
			$allRow=$currentSheet->getHighestRow();
			//循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
			//dump($currentSheet);
			//dump($allColumn);
			//dump($allRow);
			for($currentRow=1;$currentRow<=$allRow;$currentRow++)
			{
				//从哪列开始，A表示第一列
				for($currentColumn='A';$currentColumn<=$allColumn;$currentColumn++)
				{
					//数据坐标
				  	$address=$currentColumn.$currentRow;

					//读取到的数据，保存到数组$arr中
				  	$arr[$currentRow][$currentColumn]=$currentSheet->getCell($address)->getValue();
				}
			}
			//dump($arr);die;
			$count = count($arr);
			//$table = M("Member");
			$data['pre_vacation'] = 0;
			for ($i=2; $i < $count+1; $i++) 
			{ 
				/*$data['company_email'] = $arr[$i]['G'];

				$data['join_date'] = strtotime($arr[$i]['M']);
				$data['sign_date'] = strtotime($arr[$i]['N']);
				$data['full_time'] = strtotime($arr[$i]['O']);
				$data['probation_half'] = strtotime($arr[$i]['P']);
				$data['probation_full'] = strtotime($arr[$i]['Q']);*/

				$data1 = $arr[$i]['P'];
				$data2 = $arr[$i]['T'];
				//$data['name'] = $arr[$i]['B'];
				
				if($data2 - $data1 > 0)
				{
					$data['pre_vacation'] = $arr[$i]['M'] - $arr[$i]['T'] + $data2 - $data1;
				}
				else
				{
					$data['pre_vacation'] = $arr[$i]['M'] - $arr[$i]['T'] - ($data1 - $data2);
				}

				//$temp = $this->db->select('id, name')->where(array('name' => $arr[$i]['B']))->get('user')->row_array();
				//dump($temp['id']);

				//$this->db->where(array('uid' => $temp['id']))->update('vacation', $data);

				//dump($data['join_date']);

				//$where['company_email'] = $data['company_email'];
				//$row = $table->data($data)->where($where)->save();	
			}//die;
		}
		else
		{
			exit("文件不存在");
		}		
	}

	/* 导出例子 */
	public function export()
	{
		$this->load->model('admin/check_model');

		$where = array('group_id' => 1);

		$list = $this->check_model->get_check_list($where);
		//dump($list);die;

		$row = array();
		$row[0]=array('编号','考核标题',"权重");
		$i = 1;
		foreach($list as $v) 
		{
			$row[$i]['i'] = $i;
			$row[$i]['title'] = $v['title'];
			$row[$i]['proportion'] = $v['proportion'];

			$i++;
		}
		
		$xls = new \Excel('UTF-8', false, 'datalist');
    	$xls->addArray($row);
    	$xls->generateXML("employee");
	}
}
