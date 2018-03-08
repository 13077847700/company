<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('prc');

class Vacation_model extends CI_Model
{

	/**
	 * 年假列表数据
	 */

	public function get_vacation_list($field = '', $where = '1 = 1', $offset, $page_size)
	{
		$data = $this->db->select($field)
							->from('user as u')
							->join('department as d', 'd.id = u.department_id', 'left')
							->join('vacation as v', 'v.uid = u.id', 'left')
							->where($where)
							->limit($page_size, $offset)
							->get()
							->result_array();
		//echo $this->db->last_query();
		//dump($data);die;

		return $data;
	}

	public function get_count($where = '1 = 1')
	{
		$count = $this->db->from('user as u')
						->join('department as d', 'd.id = u.department_id', 'left')
						->join('vacation as v', 'v.uid = u.id', 'left')
						->where($where)
						->count_all_results();
		return $count;
	}

	/**
	 * 	对每个月的请假天数进行初始化
	 * @author: 江南烟雨 <773157920@qq.com>
	 */
	public function initDetailVacation()
	{
		//$where['uid'] = array('gt', 0);
		$data['jan'] = 0;
		$data['feb'] = 0;
		$data['mar'] = 0;
		$data['apr'] = 0;
		$data['may'] = 0;
		$data['jun'] = 0;
		$data['jul'] = 0;
		$data['aug'] = 0;
		$data['sep'] = 0;
		$data['oct'] = 0;
		$data['nov'] = 0;
		$data['dec'] = 0;
		$this->db->where(array('uid > ' => 0))->update('vacation', $data);
	}

	/**
	 *  年假计算
	 *  $join_date  入职日期(时间戳)
	 *  返回 array  $vacation[$last_year, $now_year]  
	 */
	public function count_vacation($join_date = '')
	{
	    $now = time();   //当前时间戳
	    //$now = strtotime("2018-01-30");
	    $nowYear = date('Y', $now);    //今年的年份  
	    $middle = strtotime("$nowYear-7-1 0:0:0");    //今年7月1日的时间戳

	    //$join_date = strtotime("2016-4-25");   //入职日期时间戳
	    //$year = floor(($now - $join_date)/86400/365);   //入职到现在满多少年

	    $now_join_date = $nowYear . date('-m-d', $join_date);  //如 2012-3-25入职 会转换成 2016-3-25   
	    if(strtotime($now_join_date) <= $now)
	    {
	    	$year = $nowYear - date("Y", $join_date);     //入职到现在满多少年
	        $now_join_date = strtotime("$now_join_date");    //入职日期在今年的月份日<今年的月份日
	    }
	    else
	    {
	    	$year = $nowYear - date("Y", $join_date) - 1;    //入职到现在满多少年
	        $now_join_date = strtotime("$now_join_date, -1 year");    //时间戳
	    }
	    //dump(date('Y-m-d', $now_join_date));die;
	    $str = date('Y-m-d', $join_date);
	    $turn = strtotime("$str +6 month");  //转正后的时间戳

	    if($now < $turn)
	    {
	        $vacation = array(0, 0);
	        return $vacation;
	    }
	    else
	    {
	        // 去年可休年假
	        if($year == 0)
	        {
	            if($now_join_date < strtotime("$nowYear-1-1"))
	            {
	                $last_year = round(7*(strtotime("$nowYear-1-1") - $now_join_date)/86400/365, 1);
	            }
	            else
	            {
	                $last_year = 0;
	            }
	        }
	        else if($year >= 14)
	        {
	            $last_year = 20;
	        }
	        else if($year == 1)
	        {
	            if($now_join_date < strtotime("$nowYear-1-1"))
	            {
	                $last_year = round((6 + $year)*($now_join_date - strtotime("$nowYear-1-1 -1 year"))/86400/365 + (7 + $year)*(strtotime("$nowYear-1-1") - $now_join_date)/86400/365, 1);
	            }
	            else
	            {
	                $last_year = round((6 + $year)*(strtotime("$nowYear-1-1 +1 year")-$now_join_date)/86400/365, 1);
	            }
	        }
	        else
	        {
	            //dump(date("Y-m-d",$now_join_date));
	            if($now_join_date < strtotime("$nowYear-1-1"))
	            {
	                $last_year = round((6 + $year)*($now_join_date - strtotime("$nowYear-1-1 -1 year"))/86400/365 + (7 + $year)*(strtotime("$nowYear-1-1") - $now_join_date)/86400/365, 1);
	                //dump($last_year);
	            }
	            else
	            {
	                $last_join_date = date("Y-m-d", $now_join_date);      // 2015-1-1 到 2015-3-1 到 2016-1-1  若今天是2016-3-25
	                $last_join_date = strtotime("$last_join_date -1 year");     
	                $last_year = round((5 + $year)*($last_join_date - strtotime("$nowYear-1-1 -1 year"))/86400/365 + (6 + $year)*(strtotime("$nowYear-1-1") - $last_join_date)/86400/365, 1);
	                //dump($last_year);
	            }
	        }

	        if($now < $middle)   //上半年
	        {
	            if($year == 0)
	            {   
	                //$last_year = round(7*(strtotime("$nowYear-1-1") - $now_join_date)/86400/365, 1);
	                $now_year = round(7*($now - strtotime("$nowYear-1-1"))/86400/365, 1);
	            }
	            else if($year >= 14)
	            {
	                //$last_year = 20;
	                $now_year = round(20*($now - strtotime("$nowYear-1-1"))/86400/365, 1);
	            }
	            else if($year == 1)
	            {
	                if($now_join_date < strtotime("$nowYear-1-1"))
	                {           
	                    //$last_year = round((6 + $year)*($now_join_date - strtotime("$nowYear-1-1 -1 year"))/86400/365 + (7 + $year)*(strtotime("$nowYear-1-1") - $now_join_date)/86400/365, 1);
	                    $now_year = round((7 + $year)*($now - strtotime("$nowYear-1-1"))/86400/365, 1);
	                }
	                else
	                {   
	                    //$last_year = round((6 + $year)*(strtotime("$nowYear-1-1 +1 year")-$now_join_date)/86400/365, 1);

	                    $now_year = round((6 + $year)*($now_join_date-strtotime("$nowYear-1-1"))/86400/365 + (7 + $year)*($now-$now_join_date)/86400/365, 1);
	                }
	            }
	            else
	            {
	                if($now_join_date < strtotime("$nowYear-1-1"))
	                {
	                    //$last_year = round((6 + $year)*($now_join_date - strtotime("$nowYear-1-1 -1 year"))/86400/365 + (7 + $year)*(strtotime("$nowYear-1-1") - $now_join_date)/86400/365, 1);           
	                    $now_year = round((7 + $year)*($now - strtotime("$nowYear-1-1"))/86400/365, 1);
	                }
	                else
	                {  
	                    $now_year = round((6 + $year)*($now_join_date-strtotime("$nowYear-1-1"))/86400/365 + (7 + $year)*($now-$now_join_date)/86400/365, 1);

	                    //$last_join_date = date("Y-m-d", $now_join_date);    // 2015-1-1 到 2015-3-1 到 2016-1-1  若今天是2016-3-25
	                    //$last_join_date = strtotime("$last_join_date -1 year");       
	                    //$last_year = round((5 + $year)*($last_join_date - strtotime("$nowYear-1-1 -1 year"))/86400/365 + (6 + $year)*(strtotime("$nowYear-1-1") - $last_join_date)/86400/365, 1);

	                }
	                //$last_year = round((6 + $year)*($now_join_date - strtotime("$nowYear-1-1 -1 year"))/86400/365 + (7 + $year)*(strtotime("$nowYear-1-1") - $now_join_date)/86400/365, 1);
	            }
	        }
	        else    //下半年
	        {
	            if($year == 0)
	            {
	                if($now_join_date < strtotime("$nowYear-1-1"))      
	                {
	                    $now_year = round(7*($now - strtotime("$nowYear-1-1"))/86400/365, 1);
	                }
	                else
	                {
	                    $now_year = round(7*($now - $join_date)/86400/365, 1);
	                }
	            }
	            else if($year >= 13)
	            {
	                $now_year = round(20*($now - strtotime("$nowYear-1-1"))/86400/365, 1);
	            }   
	            else
	            {
	                if($now_join_date < $now)
	                {   
	                    $now_year = round((6 + $year)*($now_join_date - strtotime("$nowYear-1-1"))/86400/365 +
	                        (7 + $year)*($now - $now_join_date)/86400/365, 1);
	                }
	                else
	                {   
	                    $now_year = round((7 + $year)*($now - strtotime("$nowYear-1-1"))/86400/365, 1);
	                    //dump($now_year);
	                }
	            }
	        }
	        $vacation[] = $last_year;
	        $vacation[] = $now_year;
	        //dump($vacation);
	        return $vacation;
	    }
	}
}