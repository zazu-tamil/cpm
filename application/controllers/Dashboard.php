<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	 
	public function index()
	{
	   
       
        
        $sql = "update melting_item_info as c left join work_planning_info as a on c.work_planning_id = a.work_planning_id left join pattern_info as b on b.pattern_id = a.pattern_id set c.produced_qty = (c.pouring_box * b.no_of_cavity) where a.status != 'Delete' and ((c.pouring_box * b.no_of_cavity) !=  c.produced_qty )";
        $this->db->query($sql);
        
        
        $sql = "update work_order_info as a set a.`status` = 'Close' where a.`status` != 'Delete' and DATEDIFF(now(),a.order_date) >= 90";
        $this->db->query($sql);
        
        $data = array();   
      /*  
      $sql = "
         select 
         z.melting_date,
         sum(z.liq_metal) as liq_metal,
         sum(z.poured_casting_wt) as poured_casting_wt
         from (
            select 
            a.melting_heat_log_id,
            a.melting_date,   
            round(sum((e.bunch_weight * b.pouring_box) - ((if(b.pouring_box > 0 ,(ifnull(g.closed_mould_qty,0)),0)) * e.piece_weight_per_kg)),2) as liq_metal ,
            round(sum((e.casting_weight * b.pouring_box ) - ((if(b.pouring_box > 0 ,(ifnull(g.closed_mould_qty,0)),0)) * e.piece_weight_per_kg)),2) as poured_casting_wt  
            from melting_heat_log_info as a 
            left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
            left join work_planning_info as c on c.work_planning_id = b.work_planning_id
            left join customer_info as d on d.customer_id = c.customer_id
            left join pattern_info as e on e.pattern_id = c.pattern_id 
            left join ( select q.work_planning_id , sum(q.closed_mould_qty) as closed_mould_qty from moulding_log_item_info as q where q.`status` = 'Active' group by q.work_planning_id) as g on g.work_planning_id = b.work_planning_id
            where a.`status` = 'Active' and b.status != 'Delete' 
            and date_format(a.melting_date,'%Y%m') = '". date('Ym') ."'  
            group by a.melting_heat_log_id , a.melting_date
            order by a.melting_date desc
         ) as z 
         group by z.melting_date 
        "; */ 
		
		
		
	  $sql = "
            select 
            z.melting_date,            
            sum(z.liq_metal) as liq_metal  ,
            sum(z.poured_casting_wt) as poured_casting_wt   
            from (
                select 
                a.melting_date, 
                round(sum( b.pouring_box * (c.planned_box_wt / c.planned_box )),3) as liq_metal ,
                round(sum(e.casting_weight * b.pouring_box),3) as poured_casting_wt
                from melting_heat_log_info as a
                left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
                left join work_planning_info as c on c.work_planning_id = b.work_planning_id 
                left join pattern_info as e on e.pattern_id = c.pattern_id
                where date_format(a.melting_date,'%Y%m') = '". date('Ym') ."' 
                and a.`status` = 'Active' and b.status != 'Delete' and c.`status` != 'Delete'
                group by a.melting_date 
                ) as z
			group by z.melting_date	
			order by z.melting_date	
            ";
        
        $query = $this->db->query($sql);
        $data['liq_metal'] = array();
        $data['poured_casting_wt'] = array();
        
        foreach ($query->result_array() as $row)
        {
            $data['liq_metal'][$row['melting_date']] = $row['liq_metal'];   
            $data['poured_casting_wt'][$row['melting_date']] = $row['poured_casting_wt'];   
        } 
        
        $sql = "
        
        select 
        a.despatch_date,
        sum(b.qty * e.piece_weight_per_kg) as tot_despatch_wt 
        from customer_despatch_info as a 
        left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
        left join pattern_info as e on e.pattern_id = b.pattern_id
        where a.status != 'Delete' and date_format(a.despatch_date,'%Y%m') = '". date('Ym') ."'  
        group by a.despatch_date 
        order by a.despatch_date desc 
        
        ";
        
        $query = $this->db->query($sql);
        $data['despatch'] = array();
        
        foreach ($query->result_array() as $row)
        {
            $data['despatch'][$row['despatch_date']] = $row['tot_despatch_wt'];   
        } 
        
        
        $sql = "
        
        select 
        a.qc_date,   
        sum(a.rejection_qty * c.piece_weight_per_kg) as rej_wt
        from qc_inspection_info as a 
        left join work_planning_info as b on b.work_planning_id = a.work_planning_id and a.`status` != 'Delete'
        left join pattern_info as c on c.pattern_id = b.pattern_id
        where a.`status` = 'Active' and date_format(a.qc_date,'%Y%m') = '". date('Ym') ."'         
        group by a.qc_date
        order by a.qc_date desc  
        
        ";
		//and a.rejection_type_id != '32'
        
        $query = $this->db->query($sql);
        $data['rejection'] = array();
        
        foreach ($query->result_array() as $row)
        {
            $data['rejection'][$row['qc_date']] = $row['rej_wt'];   
        } 
        
        $sql = "
        select 
        q.planning_date,  
        sum(q.tot_wt) as production_wt
        from ( 
        select
        w.planning_date,
        w.customer_id,
        w.pattern_id, 
        sum(w.curr_produced_qty) as curr_produced_qty,
        sum(ifnull(cm.closed_mould_qty,0)) as closed_mould_qty,
        r.piece_weight_per_kg,
        (sum(w.curr_produced_qty) - sum(ifnull(cm.closed_mould_qty,0))) as tot_qty,
        round(((sum(w.curr_produced_qty) - sum(ifnull(cm.closed_mould_qty,0))) * r.piece_weight_per_kg),3) as tot_wt
        from
        (
          (
          select 
          a3.customer_id,
          a3.pattern_id, 
          a1.planning_date,
          sum((a2.produced_qty)) as curr_produced_qty
          from melting_heat_log_info as a1
          left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
          left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
          where a1.`status` = 'Active' and date_format(a1.planning_date,'%Y%m') = '". date('Ym') ."'  
          group by a3.customer_id, a3.pattern_id ,a1.planning_date
          order by a3.customer_id, a3.pattern_id 
          ) union all (
          select 
          a3.customer_id,
          a3.pattern_id, 
          a3.planning_date,
          sum((a2.produced_qty)) as curr_produced_qty
          from melting_heat_log_info as a1
          left join melting_child_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
          left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
          where a1.`status` = 'Active' and a3.customer_id != ''  and date_format(a3.planning_date,'%Y%m') = '". date('Ym') ."'
          group by a3.customer_id, a3.pattern_id ,a3.planning_date
          order by a3.customer_id, a3.pattern_id
          )
        ) as w 
        left join (
                     select  
                     q1.pattern_id,
                     q1.customer_id,
                     q1.planning_date,
                     sum(q.closed_mould_qty) as closed_mould_qty 
                     from moulding_log_item_info as q
                     left join work_planning_info as q1 on q1.work_planning_id = q.work_planning_id  
                     where q.`status` = 'Active'  and date_format(q1.planning_date,'%Y%m') = '". date('Ym') ."'
                     group by q1.pattern_id ,q1.customer_id, q1.planning_date
                    ) as cm on cm.pattern_id = w.pattern_id and cm.customer_id = w.customer_id and cm.planning_date = w.planning_date
        left join pattern_info as r on r.pattern_id = w.pattern_id             
        where 1 
        group by w.customer_id,w.pattern_id , w.planning_date
        ) as q
        group by q.planning_date 
        order by q.planning_date desc         
        ";
        
        $query = $this->db->query($sql);
        $data['production'] = array();
        
        foreach ($query->result_array() as $row)
        {
            $data['production'][$row['planning_date']] = $row['production_wt'];   
        } 
        
        
        /* 
        $sql = "
        SELECT
            z.m_date,
            SUM(z.planned_box) AS planned_box, 
            SUM(z.produced_box) AS produced_box,
            ROUND(AVG(z.eff), 2) AS efficiency
        FROM
            (
            SELECT
                a.work_planning_id,
                b.planning_date AS m_date,
                b.customer_id,
                b.pattern_id,
                d.company_name AS customer,
                e.pattern_item,
                SUM(b.planned_box) AS planned_box,
                (
                    SUM(b.planned_box) * e.no_of_cavity
                ) AS planned_qty,
                SUM(b.planned_box_wt) AS planned_box_wt,
                SUM(a.produced_box) AS produced_box,
                (
                    SUM(a.produced_box) * e.no_of_cavity
                ) AS produced_qty,
                e.piece_weight_per_kg,
                SEC_TO_TIME(
                    (
                        TIME_TO_SEC(
                            TIMEDIFF(
                                a.pattern_prod_to_time,
                                a.pattern_prod_from_time
                            )
                        ) - TIME_TO_SEC(
                            TIMEDIFF(
                                a.breakdown_to_time,
                                a.breakdown_from_time
                            )
                        )
                    ) * a.manpower_comsumption
                ) AS man_hr,
                (
                    a.produced_box /(
                        (
                            TIME_TO_SEC(
                                TIMEDIFF(
                                    a.pattern_prod_to_time,
                                    a.pattern_prod_from_time
                                )
                            ) - TIME_TO_SEC(
                                TIMEDIFF(
                                    a.breakdown_to_time,
                                    a.breakdown_from_time
                                )
                            )
                        ) * a.manpower_comsumption
                    ) *(3600)
                ) AS eff
            FROM
                moulding_log_item_info AS a
            LEFT JOIN work_planning_info AS b
            ON
                b.work_planning_id = a.work_planning_id
            LEFT JOIN customer_info AS d
            ON
                d.customer_id = b.customer_id
            LEFT JOIN pattern_info AS e
            ON
                e.pattern_id = b.pattern_id
            WHERE
                b.`status` != 'Delete' AND a.`status` != 'Delete' AND  
                date_format(b.planning_date,'%Y%m') = '". date('Ym') ."'
            GROUP BY
                a.work_planning_id,
                b.customer_id,
                b.pattern_id
        ) AS z
        GROUP BY
            z.m_date
        ORDER BY
            z.m_date desc
        "; */

        $sql= "
        select 
        a.planning_date as m_date,
        sum(a.planned_box) as planned_box, 
        sum(b.produced_box) as produced_box ,
        round(avg(b.eff),2) as efficiency
        from work_planning_info as a
        left join (
        select 
        q.work_planning_id,
        sum(q.produced_box) as produced_box,
        avg(
            q.produced_box /(
                (
                    TIME_TO_SEC(
                        TIMEDIFF(
                            q.pattern_prod_to_time,
                            q.pattern_prod_from_time
                        )
                    ) - TIME_TO_SEC(
                        TIMEDIFF(
                            q.breakdown_to_time,
                            q.breakdown_from_time
                        )
                    )
                ) * q.manpower_comsumption
            ) *(3600)
        ) AS eff
        from moulding_log_item_info as q 
        where q.`status` = 'Active'
        group by q.work_planning_id
        ) as b on b.work_planning_id = a.work_planning_id 
        where date_format(a.planning_date,'%Y%m') = '". date('Ym') ."'
        and a.`status` != 'Delete' 
        group by a.planning_date
        order by a.planning_date asc
        
        ";
        
        $query = $this->db->query($sql);
        $data['moulding'] = array();
        
        foreach ($query->result_array() as $row)
        {
            $data['moulding'][$row['m_date']] = $row;   
        } 
        
        
        $sql ="
            SELECT
            DATE_FORMAT(z.m_date, '%Y-%m') as m_date,
            SUM(z.planned_box) AS planned_box, 
            SUM(z.produced_box) AS produced_box,
            ROUND(AVG(z.eff), 2) AS efficiency
        FROM
            (
            SELECT
                a.work_planning_id,
                b.planning_date AS m_date,
                b.customer_id,
                b.pattern_id,
                d.company_name AS customer,
                e.pattern_item,
                SUM(b.planned_box) AS planned_box,
                (
                    SUM(b.planned_box) * e.no_of_cavity
                ) AS planned_qty,
                SUM(b.planned_box_wt) AS planned_box_wt,
                SUM(a.produced_box) AS produced_box,
                (
                    SUM(a.produced_box) * e.no_of_cavity
                ) AS produced_qty,
                e.piece_weight_per_kg,
                SEC_TO_TIME(
                    (
                        TIME_TO_SEC(
                            TIMEDIFF(
                                a.pattern_prod_to_time,
                                a.pattern_prod_from_time
                            )
                        ) - TIME_TO_SEC(
                            TIMEDIFF(
                                a.breakdown_to_time,
                                a.breakdown_from_time
                            )
                        )
                    ) * a.manpower_comsumption
                ) AS man_hr,
                (
                    a.produced_box /(
                        (
                            TIME_TO_SEC(
                                TIMEDIFF(
                                    a.pattern_prod_to_time,
                                    a.pattern_prod_from_time
                                )
                            ) - TIME_TO_SEC(
                                TIMEDIFF(
                                    a.breakdown_to_time,
                                    a.breakdown_from_time
                                )
                            )
                        ) * a.manpower_comsumption
                    ) *(3600)
                ) AS eff
            FROM
                moulding_log_item_info AS a
            LEFT JOIN work_planning_info AS b
            ON
                b.work_planning_id = a.work_planning_id
            LEFT JOIN customer_info AS d
            ON
                d.customer_id = b.customer_id
            LEFT JOIN pattern_info AS e
            ON
                e.pattern_id = b.pattern_id
            WHERE
                b.`status` != 'Delete' AND a.`status` != 'Delete' AND   
                (b.planning_date between (DATE_FORMAT(CURDATE(), '%Y-%m-01') - INTERVAL 2 MONTH) and  CURDATE() )
            GROUP BY
                a.work_planning_id,
                b.customer_id,
                b.pattern_id
        ) AS z
        GROUP BY
            DATE_FORMAT(z.m_date, '%Y-%m') 
        ORDER BY
            z.m_date desc
        
        ";
        
        $query = $this->db->query($sql);
        $data['last_month_moulding'] = array();
        
        foreach ($query->result_array() as $row)
        {
            $data['last_month_moulding'][] = $row;   
        } 
        
        
        $sql = "
            select
            z.num_mon, 
            z.alp_mon,
            sum(z.int_rej) as int_rej,
            sum(z.cust_rej) as cust_rej 
            from
            (
              (
                   select 
                   DATE_FORMAT(a.rej_date,'%Y%m')  as num_mon,
                   DATE_FORMAT(a.rej_date,'%b-%Y')  as alp_mon,
                   b.pattern_id,
                   0 as int_rej,
                   round((sum(b.qty) * c.piece_weight_per_kg),2) as cust_rej
                   from customer_rejection_info as a
                   left join customer_rejection_itm_info as b on b.customer_rejection_id = a.customer_rejection_id
                   left join pattern_info as c on c.pattern_id = b.pattern_id
                   where a.`status` = 'Active' and b.`status` = 'Active' 
                   and a.rej_date >= '2024-04-01'
                   group by b.pattern_id , DATE_FORMAT(a.rej_date,'%Y%m') 
                   order by b.pattern_id
              ) union all (
                   select  
                   DATE_FORMAT(a.qc_date,'%Y%m')  as num_mon,
                   DATE_FORMAT(a.qc_date,'%b-%Y')  as alp_mon,
                   b.pattern_id,
                   round((sum(a.rejection_qty) * c.piece_weight_per_kg),2) as int_rej,
                   0 as  cust_rej 
                   from qc_inspection_info as a
                   left join work_planning_info as b on b.work_planning_id = a.work_planning_id
                   left join pattern_info as c on c.pattern_id =b.pattern_id
                   where a.`status`='Active' and b.`status` = 'Planned' 
                   and a.qc_date >= '2024-04-01'
                   group by b.pattern_id , DATE_FORMAT(a.qc_date,'%Y%m') 
                   order by b.pattern_id
              )
            ) as z
            group by z.num_mon
            order by z.num_mon desc
            limit 12
        
        ";
        
        $query = $this->db->query($sql);
        $data['last_12_month_rejection'] = array();
        
        foreach ($query->result_array() as $row)
        {
            $data['last_12_month_rejection'][] = $row;   
        } 
        
        
        $sql = "
            select 
            date_format(z.melting_date,'%Y-%m') as months, 
            DATE_FORMAT(z.melting_date,'%b-%Y')  as alp_mon,           
            round(sum(z.liq_metal)/1000,2) as liq_metal  ,
            round(sum(z.poured_casting_wt)/1000,2) as poured_casting_wt   
            from (
            select 
            a.melting_date, 
            round(sum( b.pouring_box * (c.planned_box_wt / c.planned_box )),3) as liq_metal ,
            round(sum(e.casting_weight * b.pouring_box),3) as poured_casting_wt
            from melting_heat_log_info as a
            left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
            left join work_planning_info as c on c.work_planning_id = b.work_planning_id 
            left join pattern_info as e on e.pattern_id = c.pattern_id
            where 1=1 
            and a.`status` = 'Active' and b.status != 'Delete' and c.`status` != 'Delete'
            group by a.melting_date 
            ) as z
            group by date_format(z.melting_date,'%Y%m')
            order by date_format(z.melting_date,'%Y%m') desc
            limit 12
        
        ";
        
        $query = $this->db->query($sql);
        $data['last_12_month_production'] = array();
        
        foreach ($query->result_array() as $row)
        {
            $data['last_12_month_production'][] = $row;   
        } 
        
        
        
        $this->load->view('page/dashboard', $data);
	}
    
    
    
    
    
}
