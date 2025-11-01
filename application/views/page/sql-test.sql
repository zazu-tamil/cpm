ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION

SET GLOBAL sql_mode="STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION";

select 
a.customer_id,
a.pattern_id,   
e.company_name as customer,
a.pattern_item as item,
f.core_item_name as core_item,
ifnull(b.stock_qty,0) as op_qty,
b.floor_stock_date,
ifnull(b.floor_stock_date,'2020-12-01') as floor_stock_date,
ifnull(sum(c.produced_qty),0) as produced_qty ,
(ifnull(d.pouring_box,0) * a.no_of_core_per_box) as used_qty,
((ifnull(b.stock_qty,0) + ifnull(sum(c.produced_qty),0)) - (ifnull(d.pouring_box,0) * a.no_of_core_per_box)) as core_stock
from pattern_info as a 
left join (
    select 
	a.floor_stock_date,
	a.customer_id,
	a.pattern_id, 
    a.core_item_id,
	sum(a.stock_qty) as  stock_qty
	from core_floor_stock_info as a 
	left join ( 
	SELECT max(`floor_stock_date`) as floor_stock_date, `customer_id`,`pattern_id`,`core_item_id` FROM `core_floor_stock_info` WHERE 1 group by `customer_id`, `pattern_id`, `core_item_id`) as b on b.floor_stock_date = a.floor_stock_date and b.customer_id = a.customer_id and b.pattern_id = a.pattern_id and b.core_item_id = a.core_item_id
	where 1 
    group by a.customer_id, a.pattern_id  , a.core_item_id
	order by a.customer_id, a.pattern_id  ) 
 as b on b.customer_id = a.customer_id and b.pattern_id = a.pattern_id  

left join (
    select 
    a1.planning_date,
    a3.customer_id,
    a3.pattern_id,
    sum(a2.pouring_box) as pouring_box
    from melting_heat_log_info as a1
    left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
    where a1.`status` = 'Active'
    group by a3.customer_id, a3.pattern_id, a1.planning_date
    order by a3.customer_id, a3.pattern_id, a1.planning_date
    ) as d on d.customer_id = a.customer_id and d.pattern_id = a.pattern_id
left join customer_info as e on e.customer_id = a.customer_id    
left join core_item_info as f on f.pattern_id = a.pattern_id
left join core_plan_info as c on c.pattern_id = a.pattern_id and c.core_item_id = f.core_item_id and c.core_plan_date >= ifnull(b.floor_stock_date,'2020-12-01')
where a.`status` = 'Active' and a.pattern_type = 'Core'
group by a.customer_id, a.pattern_id ,f.core_item_id  
order by a.customer_id, a.pattern_item asc 



 select  
 a.core_item_id,
 b.company_name as customer,
 c.pattern_item,
 a.core_item_name as core_item,
 d.floor_stock_date,
 ifnull(d.stock_qty,0) as stock_qty, 
 ifnull(f.produced_qty,0) as produced_qty,
 ifnull(e.pouring_box,0) as pouring_box  ,
 ifnull(g.core_count,0) as core_count,
 (ifnull(e.pouring_box,0) * ifnull(g.core_count,0)) as used_core,
 ((ifnull(d.stock_qty,0) + ifnull(f.produced_qty,0)) - (ifnull(e.pouring_box,0) * ifnull(g.core_count,0))) as core_stock
 from core_item_info as a
 left join customer_info as b on b.customer_id = a.customer_id
 left join pattern_info as c on c.pattern_id = a.pattern_id
 left join (
	select 
	a.floor_stock_date,
	a.customer_id,
	a.pattern_id, 
	a.core_item_id,
	sum(a.stock_qty) as  stock_qty
	from core_floor_stock_info as a 
	left join ( 
	SELECT max(`floor_stock_date`) as floor_stock_date, `customer_id`,`pattern_id`,`core_item_id` FROM `core_floor_stock_info` WHERE 1 group by `customer_id`, `pattern_id`, `core_item_id`) as b on b.floor_stock_date = a.floor_stock_date and b.customer_id = a.customer_id and b.pattern_id = a.pattern_id and b.core_item_id = a.core_item_id
	where 1 
	group by a.customer_id, a.pattern_id  , a.core_item_id
	order by a.customer_id, a.pattern_id  ) 
 as d on d.customer_id = a.customer_id and d.pattern_id = a.pattern_id and d.core_item_id = a.core_item_id
 left join (
    select 
    a1.planning_date,
    a3.customer_id,
    a3.pattern_id,
    sum(a2.pouring_box) as pouring_box 
    from melting_heat_log_info as a1
    left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
    where a1.`status` = 'Active'
    group by a3.customer_id, a3.pattern_id, a1.planning_date
    order by a3.customer_id, a3.pattern_id, a1.planning_date
    ) as e on e.customer_id = a.customer_id and e.pattern_id = a.pattern_id
 left join core_plan_info as f on f.pattern_id = a.pattern_id and f.core_item_id = a.core_item_id and f.core_plan_date >= ifnull(d.floor_stock_date,'2020-12-01')   
 left join (select z.pattern_id , z.customer_id , count(z.core_item_id) as core_count from core_item_info as z where z.status = 'Active' group by z.pattern_id , z.customer_id) as g on g.pattern_id = a.pattern_id and g.customer_id = a.customer_id
 where a.`status` = 'Active'
 order by  b.company_name , c.pattern_item, a.core_item_name asc
 
 


select  
 a.core_item_id,
 b.company_name as customer,
 c.pattern_item,
 a.core_item_name as core_item,
 d.floor_stock_date,
 ifnull(d.stock_qty,0) as stock_qty, 
 sum(ifnull(f.produced_qty,0)) as produced_qty,
 ifnull(e.pouring_box,0) as pouring_box  ,
 ifnull(g.core_count,0) as core_count,
 (sum(ifnull(e.pouring_box,0)) * ifnull(g.core_count,0)) as used_core,
 ((ifnull(d.stock_qty,0) + sum(ifnull(f.produced_qty,0))) - ( sum(ifnull(e.pouring_box,0)) * ifnull(g.core_count,0))) as core_stock
 from core_item_info as a
 left join customer_info as b on b.customer_id = a.customer_id
 left join pattern_info as c on c.pattern_id = a.pattern_id
 left join (
	select 
	a.floor_stock_date,
	a.customer_id,
	a.pattern_id, 
	a.core_item_id,
	sum(a.stock_qty) as  stock_qty
	from core_floor_stock_info as a 
	left join ( 
	SELECT max(`floor_stock_date`) as floor_stock_date, `customer_id`,`pattern_id`,`core_item_id` FROM `core_floor_stock_info` WHERE floor_stock_date <= '2020-12-03' group by `customer_id`, `pattern_id`, `core_item_id`) as b on b.floor_stock_date = a.floor_stock_date and b.customer_id = a.customer_id and b.pattern_id = a.pattern_id and b.core_item_id = a.core_item_id
	where 1
	group by a.customer_id, a.pattern_id  , a.core_item_id
	order by a.customer_id, a.pattern_id  ) 
 as d on d.customer_id = a.customer_id and d.pattern_id = a.pattern_id and d.core_item_id = a.core_item_id
 left join (
    select 
    a1.planning_date,
    a3.customer_id,
    a3.pattern_id,
    sum(a2.pouring_box) as pouring_box 
    from melting_heat_log_info as a1
    left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
    left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
    where a1.`status` = 'Active' and a1.planning_date <= '2020-12-03'
    group by a3.customer_id, a3.pattern_id, a1.planning_date
    order by a3.customer_id, a3.pattern_id, a1.planning_date
    ) as e on e.customer_id = a.customer_id and e.pattern_id = a.pattern_id
 left join core_plan_info as f on f.pattern_id = a.pattern_id and f.core_item_id = a.core_item_id and f.core_plan_date >= ifnull(d.floor_stock_date,'2020-12-01')  and f.core_plan_date <= '2020-12-03' 
 left join (select z.pattern_id , z.customer_id , count(z.core_item_id) as core_count from core_item_info as z where z.status = 'Active' group by z.pattern_id , z.customer_id) as g on g.pattern_id = a.pattern_id and g.customer_id = a.customer_id
 where a.`status` = 'Active'
 group by a.customer_id, a.pattern_id  , a.core_item_id 
 order by  b.company_name , c.pattern_item, a.core_item_name asc
  
---------------------------

sele 
 
 
 
 
 
 
/// Pattern Stock  
 
select 
a.customer_id,
a.pattern_id , 
ifnull(b.floor_stock_date,'2020-12-01') as  open_stock_date,
ifnull(b.stock_qty,0) as stock_qty,
ifnull(sum(c.produced_qty),0) as produced_qty,
ifnull(sum(d.despatch_qty),0) as despatch_qty ,
((ifnull(b.stock_qty,0) + ifnull(sum(c.produced_qty),0)) - ifnull(sum(d.despatch_qty),0)) as openning_stock
from pattern_info as a  
left join (
select 
a.customer_id,
a.pattern_id,
a.stock_qty,
w.floor_stock_date
from floor_stock_info as a  
left join (select max(z.floor_stock_date) as floor_stock_date , z.customer_id ,z.pattern_id from floor_stock_info as z where z.floor_stock_date <= '2020-12-01' group by z.customer_id ,z.pattern_id order by z.customer_id ,z.pattern_id , z.floor_stock_date desc  ) as w on w.customer_id = a.customer_id and  w.pattern_id = a.pattern_id  
where  1 
group by a.customer_id , a.pattern_id  
) as b on b.customer_id = a.customer_id and b.pattern_id = a.pattern_id
left join (
	select 
	a.melting_date as m_date,
	c.customer_id,
	c.pattern_id ,
	(sum(b.produced_qty) - ifnull(d.closed_mould_qty,0)) as produced_qty 
	from melting_heat_log_info as a  
	left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
	left join work_planning_info as c on c.work_planning_id = b.work_planning_id
	left join ( select q.work_planning_id , sum(q.closed_mould_qty) as closed_mould_qty from moulding_log_item_info as q where q.`status` = 'Active' group by q.work_planning_id) as d on d.work_planning_id = b.work_planning_id 
	where a.`status` = 'Active' 
	and c.`status` !='Delete' 
	and a.melting_date < '2020-12-01'  
	group by a.melting_date ,c.customer_id , c.pattern_id
	order by a.melting_date ,c.customer_id , c.pattern_id
	) as c on c.m_date between ifnull(b.floor_stock_date,'2020-12-01') and DATE_SUB('2020-12-01',INTERVAL 1 day) and  c.customer_id = a.customer_id and c.pattern_id = a.pattern_id 
left join (
  select 
  a.despatch_date as d_date,
  a.customer_id,
  b.pattern_id, 
  sum(b.qty) as despatch_qty
  from customer_despatch_info as a 
  left join customer_despatch_item_info as b on b.customer_despatch_id = a.customer_despatch_id
  where a.despatch_date < '2020-12-01'
  group by a.despatch_date,a.customer_id,b.pattern_id
  order by a.despatch_date asc
) as d on d.customer_id = a.customer_id and d.pattern_id = a.pattern_id and d.d_date between ifnull(b.floor_stock_date,'2020-12-01') and DATE_SUB('2020-12-01',INTERVAL 1 day) 	
where a.`status` = 'Active'  
group by a.customer_id , a.pattern_id 
order by a.customer_id , a.pattern_id 
 
 
 
------------

select 
            a.customer_id,
            a.pattern_id,
            a.pattern_item,
            p6.company_name as customer ,
            a.piece_weight_per_kg,
            ifnull(b.floor_stock_date, '2020-12-01') as op_floor_stock_date ,
            ifnull(c.stock_qty,0) as op_stock_qty,
            ifnull(sum(p4.produced_qty),0) as produced_qty,
            ifnull(sum(w.rejection_qty),0) as rejection_qty, 
            ifnull(sum(k.despatch_qty),0) as rejection_qty ,
            ((ifnull(c.stock_qty,0) + ifnull(sum(p4.produced_qty),0)) - (ifnull(sum(w.rejection_qty),0) + ifnull(sum(k.despatch_qty),0))) as opening_stock, 
            ifnull(qa.curr_produced_qty,0) as curr_produced_qty,
            ifnull(qb.curr_rejection_qty,0) as curr_rejection_qty,
            ifnull(qc.curr_despatch_qty,0) as curr_despatch_qty ,
            (
              (  
                ((ifnull(c.stock_qty,0) + ifnull(sum(p4.produced_qty),0)) - (ifnull(sum(w.rejection_qty),0) + ifnull(sum(k.despatch_qty),0)))
                +
                (ifnull(qa.curr_produced_qty,0))
               )
               - 
               (
                (ifnull(qb.curr_rejection_qty,0))
                 +
                (ifnull(qc.curr_despatch_qty,0))
               ) 
            ) as closing_stock
            from pattern_info as a
            left join (
                select 
                z.customer_id,
                z.pattern_id,
                max(z.floor_stock_date)  as floor_stock_date
                from floor_stock_info as z  
                where z.floor_stock_date = '2020-12-20'
                order by z.customer_id, z.pattern_id 
            ) as b on b.customer_id = a.customer_id and b.pattern_id = a.pattern_id
            left join  floor_stock_info as c on c.customer_id = a.customer_id and c.pattern_id = a.pattern_id and c.floor_stock_date = ifnull(b.floor_stock_date, '2020-12-01') 
            left join (
                select 
                a1.planning_date,
                a3.customer_id,
                a3.pattern_id, 
                (sum(a2.produced_qty) - ifnull(a4.closed_mould_qty,0)) as produced_qty
                from melting_heat_log_info as a1
                left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                left join ( select q.work_planning_id , sum(q.closed_mould_qty) as closed_mould_qty from moulding_log_item_info as q where q.`status` = 'Active' group by q.work_planning_id) as a4 on a4.work_planning_id = a2.work_planning_id
                where a1.`status` = 'Active'  and a1.planning_date <= DATE_SUB('2020-12-20',INTERVAL 1 day)
                group by a3.customer_id, a3.pattern_id, a1.planning_date
                order by a3.customer_id, a3.pattern_id, a1.planning_date 
            ) as p4 on p4.customer_id = a.customer_id and p4.pattern_id = a.pattern_id and p4.planning_date between ifnull(b.floor_stock_date, '2020-12-01') and DATE_SUB('2020-12-20',INTERVAL 1 day) 
            left join (
                select
                b.planning_date as m_date,
                b.customer_id,
                b.pattern_id,
                sum(a.rejection_qty) as rejection_qty 
                from qc_inspection_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                where a.status = 'Active' and b.status != 'Delete'  and b.planning_date <= DATE_SUB('2020-12-20',INTERVAL 1 day)
                group by b.customer_id, b.pattern_id,b.planning_date
            ) as w on w.customer_id = a.customer_id and w.pattern_id = a.pattern_id and w.m_date between ifnull(b.floor_stock_date, '2020-12-01') and DATE_SUB('2020-12-20',INTERVAL 1 day) 
            left join(
                select 
                t.despatch_date,
                t.customer_id,
                r.pattern_id,
                sum(r.qty) as despatch_qty
                from customer_despatch_info as t 
                left join customer_despatch_item_info as r on r.customer_despatch_id = t.customer_despatch_id
                where t.status = 'Active' and t.despatch_date <= DATE_SUB('2020-12-20',INTERVAL 1 day)
                group by t.despatch_date , t.customer_id , r.pattern_id
            ) as k on k.customer_id = a.customer_id and k.pattern_id = a.pattern_id and k.despatch_date between ifnull(b.floor_stock_date, '2020-12-01') and DATE_SUB('2020-12-20',INTERVAL 1 day)
            left join (
                select 
                a3.customer_id,
                a3.pattern_id, 
                (sum(a2.produced_qty) - ifnull(a4.closed_mould_qty,0)) as curr_produced_qty
                from melting_heat_log_info as a1
                left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
                left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
                left join ( select q.work_planning_id , sum(q.closed_mould_qty) as closed_mould_qty from moulding_log_item_info as q where q.`status` = 'Active' group by q.work_planning_id) as a4 on a4.work_planning_id = a2.work_planning_id
                where a1.`status` = 'Active'  and a1.planning_date <= '2020-12-20'
                group by a3.customer_id, a3.pattern_id 
                order by a3.customer_id, a3.pattern_id 
            ) as qa on qa.customer_id = a.customer_id and qa.pattern_id = a.pattern_id
            left join (
                select 
                b.customer_id,
                b.pattern_id,
                sum(a.rejection_qty) as curr_rejection_qty 
                from qc_inspection_info as a
                left join work_planning_info as b on b.work_planning_id = a.work_planning_id 
                where a.status = 'Active' and b.status != 'Delete'  and b.planning_date <= '2020-12-20' 
                group by b.customer_id, b.pattern_id,b.planning_date
            ) as qb on qb.customer_id = a.customer_id and qb.pattern_id = a.pattern_id
            left join (
                select  
                t.customer_id,
                r.pattern_id,
                sum(r.qty) as curr_despatch_qty
                from customer_despatch_info as t 
                left join customer_despatch_item_info as r on r.customer_despatch_id = t.customer_despatch_id
                where t.status = 'Active' and t.despatch_date <= '2020-12-20' 
                group by  t.customer_id , r.pattern_id
            ) as qc on qc.customer_id = a.customer_id and qc.pattern_id = a.pattern_id
            left join customer_info as p6 on p6.customer_id = a.customer_id 
            where a.`status` = 'Active'
            and a.customer_id = '3'
             group by a.pattern_id , a.customer_id 
             order by customer , pattern_item  


 -------------------
 
select  
a3.customer_id,
a3.pattern_id, 
(sum(a2.produced_qty) - ifnull(a4.closed_mould_qty,0)) as produced_qty
from melting_heat_log_info as a1
left join melting_item_info as a2 on a1.melting_heat_log_id = a2.melting_heat_log_id 
left join work_planning_info as a3 on a3.work_planning_id = a2.work_planning_id
left join ( select q.work_planning_id , sum(q.closed_mould_qty) as closed_mould_qty from moulding_log_item_info as q where q.`status` = 'Active' group by q.work_planning_id) as a4 on a4.work_planning_id = a2.work_planning_id
where a1.`status` = 'Active'  and a1.planning_date  between select ifnull((select max(q.floor_stock_date) from floor_stock_info as q where q.pattern_id = a3.pattern_id ), '2020-12-01') and '2020-12-20'
group by a3.customer_id, a3.pattern_id 
order by a3.customer_id, a3.pattern_id 

--------------

select 
a.melting_date,   
sum((e.bunch_weight * b.pouring_box) - ((if(b.pouring_box > 0 ,(ifnull(g.closed_mould_qty,0)),0)) * e.piece_weight_per_kg)) as liq_metal ,
sum((e.casting_weight * b.pouring_box ) - ((if(b.pouring_box > 0 ,(ifnull(g.closed_mould_qty,0)),0)) * e.piece_weight_per_kg)) as poured_casting_wt  
from melting_heat_log_info as a 
left join melting_item_info as b on b.melting_heat_log_id = a.melting_heat_log_id
left join work_planning_info as c on c.work_planning_id = b.work_planning_id
left join customer_info as d on d.customer_id = c.customer_id
left join pattern_info as e on e.pattern_id = c.pattern_id
left join grade_info as f on f.grade_id = e.grade
left join ( select q.work_planning_id , sum(q.closed_mould_qty) as closed_mould_qty from moulding_log_item_info as q where q.`status` = 'Active' group by q.work_planning_id) as g on g.work_planning_id = b.work_planning_id
where a.`status` = 'Active' and b.status != 'Delete' 
and a.melting_date between '2020-12-01' and '2020-12-01'
group by a.melting_date

--------------------------------------------------

SELECT
    a.customer_id,
    a.pattern_id,
    a.pattern_item,
    p6.company_name AS customer,
    a.piece_weight_per_kg,
    IFNULL(ORD.cf_ord_qty,0) as cf_ord_qty,
    IFNULL(ORD.curr_order_qty,0) as curr_order_qty,
    (
        (
            IFNULL(c.stock_qty, 0) + IFNULL(SUM(p4.produced_qty),
            0)
        ) -(
            IFNULL(SUM(w.rejection_qty),
            0) + IFNULL(SUM(k.despatch_qty),
            0)
        )
    ) AS opening_stock,
    IFNULL(qa.curr_produced_qty, 0) AS curr_produced_qty,
    IFNULL(qb.curr_rejection_qty, 0) AS curr_rejection_qty,
    IFNULL(qc.curr_despatch_qty, 0) AS curr_despatch_qty,
    (
        (
            (
                (
                    IFNULL(c.stock_qty, 0) + IFNULL(SUM(p4.produced_qty),
                    0)
                ) -(
                    IFNULL(SUM(w.rejection_qty),
                    0) + IFNULL(SUM(k.despatch_qty),
                    0)
                )
            ) +(
                IFNULL(qa.curr_produced_qty, 0)
            )
        ) -(
            (
                IFNULL(qb.curr_rejection_qty, 0)
            ) +(
                IFNULL(qc.curr_despatch_qty, 0)
            )
        )
    ) AS closing_stock
FROM
    pattern_info AS a
LEFT JOIN(
    SELECT
        z.customer_id,
        z.pattern_id,
        MAX(z.floor_stock_date) AS floor_stock_date
    FROM
        floor_stock_info AS z
    WHERE
        z.floor_stock_date <= '2021-01-01'
    GROUP BY
        z.customer_id,
        z.pattern_id
    ORDER BY
        z.customer_id,
        z.pattern_id
) AS b
ON
    b.customer_id = a.customer_id AND b.pattern_id = a.pattern_id
LEFT JOIN floor_stock_info AS c
ON
    c.customer_id = a.customer_id AND c.pattern_id = a.pattern_id AND c.floor_stock_date = IFNULL(
        (
        SELECT
            MAX(z.floor_stock_date)
        FROM
            floor_stock_info AS z
        WHERE
            z.pattern_id = a.pattern_id AND z.floor_stock_date <= '2021-01-01'
    ),
    '2020-12-01'
    )
LEFT JOIN(
    SELECT
        r.customer_id,
        r.pattern_id,
        SUM(r.produced_qty) AS produced_qty
    FROM
        (
            (
            SELECT
                a3.customer_id,
                a3.pattern_id,
                SUM(
                    (a2.produced_qty) - IFNULL(a4.closed_mould_qty, 0)
                ) AS produced_qty
            FROM
                melting_heat_log_info AS a1
            LEFT JOIN melting_item_info AS a2
            ON
                a1.melting_heat_log_id = a2.melting_heat_log_id
            LEFT JOIN work_planning_info AS a3
            ON
                a3.work_planning_id = a2.work_planning_id
            LEFT JOIN(
                SELECT
                    q.work_planning_id,
                    SUM(q.closed_mould_qty) AS closed_mould_qty
                FROM
                    moulding_log_item_info AS q
                WHERE
                    q.`status` = 'Active'
                GROUP BY
                    q.work_planning_id
            ) AS a4
        ON
            a4.work_planning_id = a2.work_planning_id
        WHERE
            a1.`status` = 'Active' AND a1.planning_date BETWEEN IFNULL(
                (
                SELECT
                    MAX(z.floor_stock_date)
                FROM
                    floor_stock_info AS z
                WHERE
                    z.pattern_id = a3.pattern_id AND z.floor_stock_date <= '2021-01-01'
            ),
            '2020-12-01'
            ) AND DATE_SUB('2021-01-01', INTERVAL 1 DAY)
        GROUP BY
            a3.customer_id,
            a3.pattern_id
        ORDER BY
            a3.customer_id,
            a3.pattern_id
        )
    UNION ALL
        (
        SELECT
            a3.customer_id,
            a3.pattern_id,
            SUM(
                (a2.produced_qty) - IFNULL(a4.closed_mould_qty, 0)
            ) AS produced_qty
        FROM
            melting_heat_log_info AS a1
        LEFT JOIN melting_child_item_info AS a2
        ON
            a1.melting_heat_log_id = a2.melting_heat_log_id
        LEFT JOIN work_planning_info AS a3
        ON
            a3.prt_work_plan_id = a2.work_planning_id
        LEFT JOIN(
            SELECT
                q.work_planning_id,
                SUM(q.closed_mould_qty) AS closed_mould_qty
            FROM
                moulding_log_item_info AS q
            WHERE
                q.`status` = 'Active'
            GROUP BY
                q.work_planning_id
        ) AS a4
    ON
        a4.work_planning_id = a2.work_planning_id
    WHERE
        a1.`status` = 'Active' AND a3.customer_id != '' AND a1.planning_date BETWEEN IFNULL(
            (
            SELECT
                MAX(z.floor_stock_date)
            FROM
                floor_stock_info AS z
            WHERE
                z.pattern_id = a3.pattern_id AND z.floor_stock_date <= '2021-01-01'
        ),
        '2020-12-01'
        ) AND DATE_SUB('2021-01-01', INTERVAL 1 DAY)
    GROUP BY
        a3.customer_id,
        a3.pattern_id
    ORDER BY
        a3.customer_id,
        a3.pattern_id
    )
        ) AS r
    WHERE
        1
    GROUP BY
        r.customer_id,
        r.pattern_id
) AS p4
ON
    p4.customer_id = a.customer_id AND p4.pattern_id = a.pattern_id
LEFT JOIN(
    SELECT
        b.planning_date AS m_date,
        b.customer_id,
        b.pattern_id,
        SUM(a.rejection_qty) AS rejection_qty
    FROM
        qc_inspection_info AS a
    LEFT JOIN work_planning_info AS b
    ON
        b.work_planning_id = a.work_planning_id
    WHERE
        a.status = 'Active' AND b.status != 'Delete' AND a.qc_date BETWEEN IFNULL(
            (
            SELECT
                MAX(z.floor_stock_date)
            FROM
                floor_stock_info AS z
            WHERE
                z.pattern_id = b.pattern_id AND z.floor_stock_date <= '2021-01-01'
        ),
        '2020-12-01'
        ) AND DATE_SUB('2021-01-01', INTERVAL 1 DAY)
    GROUP BY
        b.customer_id,
        b.pattern_id
) AS w
ON
    w.customer_id = a.customer_id AND w.pattern_id = a.pattern_id
LEFT JOIN(
    SELECT
        t.despatch_date,
        t.customer_id,
        r.pattern_id,
        SUM(r.qty) AS despatch_qty
    FROM
        customer_despatch_info AS t
    LEFT JOIN customer_despatch_item_info AS r
    ON
        r.customer_despatch_id = t.customer_despatch_id
    WHERE
        t.status = 'Active' AND t.despatch_date BETWEEN IFNULL(
            (
            SELECT
                MAX(z.floor_stock_date)
            FROM
                floor_stock_info AS z
            WHERE
                z.pattern_id = r.pattern_id AND z.floor_stock_date <= '2021-01-01'
        ),
        '2020-12-01'
        ) AND DATE_SUB('2021-01-01', INTERVAL 1 DAY)
    GROUP BY
        t.customer_id,
        r.pattern_id
) AS k
ON
    k.customer_id = a.customer_id AND k.pattern_id = a.pattern_id
LEFT JOIN(
    SELECT
        w.customer_id,
        w.pattern_id,
        SUM(w.curr_produced_qty) AS curr_produced_qty
    FROM
        (
            (
            SELECT
                a3.customer_id,
                a3.pattern_id,
                SUM(
                    (a2.produced_qty) - IFNULL(a4.closed_mould_qty, 0)
                ) AS curr_produced_qty
            FROM
                melting_heat_log_info AS a1
            LEFT JOIN melting_item_info AS a2
            ON
                a1.melting_heat_log_id = a2.melting_heat_log_id
            LEFT JOIN work_planning_info AS a3
            ON
                a3.work_planning_id = a2.work_planning_id
            LEFT JOIN(
                SELECT
                    q.work_planning_id,
                    SUM(q.closed_mould_qty) AS closed_mould_qty
                FROM
                    moulding_log_item_info AS q
                WHERE
                    q.`status` = 'Active'
                GROUP BY
                    q.work_planning_id
            ) AS a4
        ON
            a4.work_planning_id = a2.work_planning_id
        WHERE
            a1.`status` = 'Active' AND a1.planning_date BETWEEN '2021-01-01' AND '2021-01-09'
        GROUP BY
            a3.customer_id,
            a3.pattern_id
        ORDER BY
            a3.customer_id,
            a3.pattern_id
        )
    UNION ALL
        (
        SELECT
            a3.customer_id,
            a3.pattern_id,
            SUM(
                (a2.produced_qty) - IFNULL(a4.closed_mould_qty, 0)
            ) AS curr_produced_qty
        FROM
            melting_heat_log_info AS a1
        LEFT JOIN melting_child_item_info AS a2
        ON
            a1.melting_heat_log_id = a2.melting_heat_log_id
        LEFT JOIN work_planning_info AS a3
        ON
            a3.prt_work_plan_id = a2.work_planning_id
        LEFT JOIN(
            SELECT
                q.work_planning_id,
                SUM(q.closed_mould_qty) AS closed_mould_qty
            FROM
                moulding_log_item_info AS q
            WHERE
                q.`status` = 'Active'
            GROUP BY
                q.work_planning_id
        ) AS a4
    ON
        a4.work_planning_id = a2.work_planning_id
    WHERE
        a1.`status` = 'Active' AND a3.customer_id != '' AND a1.planning_date BETWEEN '2021-01-01' AND '2021-01-09'
    GROUP BY
        a3.customer_id,
        a3.pattern_id
    ORDER BY
        a3.customer_id,
        a3.pattern_id
    )
        ) AS w
    WHERE
        1
    GROUP BY
        w.customer_id,
        w.pattern_id
) AS qa
ON
    qa.customer_id = a.customer_id AND qa.pattern_id = a.pattern_id
LEFT JOIN(
    SELECT
        b.customer_id,
        b.pattern_id,
        SUM(a.rejection_qty) AS curr_rejection_qty
    FROM
        qc_inspection_info AS a
    LEFT JOIN work_planning_info AS b
    ON
        b.work_planning_id = a.work_planning_id
    WHERE
        a.status = 'Active' AND b.status != 'Delete' AND a.qc_date BETWEEN '2021-01-01' AND '2021-01-09'
    GROUP BY
        b.customer_id,
        b.pattern_id
) AS qb
ON
    qb.customer_id = a.customer_id AND qb.pattern_id = a.pattern_id
LEFT JOIN(
    SELECT
        t.customer_id,
        r.pattern_id,
        SUM(r.qty) AS curr_despatch_qty
    FROM
        customer_despatch_info AS t
    LEFT JOIN customer_despatch_item_info AS r
    ON
        r.customer_despatch_id = t.customer_despatch_id
    WHERE
        t.status = 'Active' AND t.despatch_date BETWEEN '2021-01-01' AND '2021-01-09'
    GROUP BY
        t.customer_id,
        r.pattern_id
) AS qc
ON
    qc.customer_id = a.customer_id AND qc.pattern_id = a.pattern_id
LEFT JOIN customer_info AS p6
ON
    p6.customer_id = a.customer_id
LEFT JOIN(
    SELECT p.pattern_id,
        SUM(p.cf_ord_qty) AS cf_ord_qty,
        SUM(p.curr_order_qty) AS curr_order_qty
    FROM
        (
            (
            SELECT
                b.pattern_id,
                0 AS cf_ord_qty,
                SUM(b.qty) AS curr_order_qty
            FROM
                work_order_info AS a
            LEFT JOIN work_order_items_info AS b
            ON
                b.work_order_id = a.work_order_id
            WHERE
                a.`status` != 'Delete' AND a.order_date BETWEEN '2021-01-01' AND '2021-01-09'
            GROUP BY
                b.pattern_id
            ORDER BY
                b.pattern_id ASC
        )
    UNION ALL
        (
        SELECT
            b.pattern_id,
            (
                SUM(b.qty) -(IFNULL(c.despatch_qty, 0))
            ) AS cf_ord_qty,
            0 AS curr_order_qty
        FROM
            work_order_info AS a
        LEFT JOIN work_order_items_info AS b
        ON
            b.work_order_id = a.work_order_id
        LEFT JOIN(
            SELECT
                w.work_order_id,
                w.pattern_id,
                SUM(w.qty) AS despatch_qty
            FROM
                customer_despatch_info AS q
            LEFT JOIN customer_despatch_item_info AS w
            ON
                w.customer_despatch_id = q.customer_despatch_id
            WHERE
                q.despatch_date < '2021-01-01' AND q.status = 'Active' AND w.status = 'Active'
            GROUP BY
                w.work_order_id,
                w.pattern_id
        ) AS c
    ON
        c.work_order_id = a.work_order_id AND c.pattern_id = b.pattern_id
    WHERE
        a.`status` != 'Delete' AND a.`status` != 'Close' AND a.order_date < '2021-01-01'
    GROUP BY
        b.pattern_id
    ORDER BY
        b.pattern_id ASC
    )
        ) AS p
    WHERE
        1
    GROUP BY
        p.pattern_id
    ORDER BY
        p.pattern_id ASC
) AS ORD
ON
    ORD.pattern_id = a.pattern_id
WHERE
    a.`status` = 'Active'
GROUP BY
    a.pattern_id,
    a.customer_id
ORDER BY
    customer,
    pattern_item
    
    
    
 =============
 
BEGIN
declare cavity int ;
select 
b.no_of_cavity into cavity
from work_planning_info as a 
left join pattern_info as b on b.pattern_id = a.pattern_id 
where a.work_planning_id = new.work_planning_id;  
set new.produced_qty = (new.pouring_box * cavity); 

if(new.pouring_box != old.pouring_box) then
delete from melting_child_item_info where melting_heat_log_id = new.melting_heat_log_id and  work_planning_id = new.work_planning_id ;

insert into melting_child_item_info (melting_heat_log_id,work_planning_id,produced_qty) (
select
new.melting_heat_log_id,
a1.work_planning_id, 
(b1.no_of_cavity * new.pouring_box) as produced_qty
from work_planning_info as a1 
left join pattern_info as b1 on b1.pattern_id = a1.pattern_id 
where a1.`status`!= 'Delete' and a1.prt_work_plan_id = new.work_planning_id 
); 
end if;
END   


EGIN
/*declare cavity int ;
select 
b.no_of_cavity into cavity
from work_planning_info as a 
left join pattern_info as b on b.pattern_id = a.pattern_id 
where a.work_planning_id = new.work_planning_id;  
set new.produced_qty = (new.pouring_box * cavity); 

if(new.pouring_box != old.pouring_box) then
delete from melting_child_item_info where melting_heat_log_id = new.melting_heat_log_id and  work_planning_id = new.work_planning_id ;
*/
insert into melting_child_item_info (melting_heat_log_id,work_planning_id,produced_qty) (
select
new.melting_heat_log_id,
a1.work_planning_id, 
(b1.no_of_cavity * new.pouring_box) as produced_qty
from work_planning_info as a1 
left join pattern_info as b1 on b1.pattern_id = a1.pattern_id 
where a1.`status`!= 'Delete' and a1.prt_work_plan_id = new.work_planning_id 
); 
/*end if;*/
END  

graphite coke