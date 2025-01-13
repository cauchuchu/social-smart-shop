<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'sb_orders';

    protected $allowedFields = ['order_name', 'customer_id', 'status_delivery','status_payment','total_price','discount','final_price','created_by','assigned','created_at','status','description','shop_id'];

    // public function get($slug = false)
    // {
    //     if ($slug === false) {
    //         return $this->findAll();
    //     }

    //     return $this->where(['slug' => $slug])->first();
    // }

    public function getData(array $conditions = [])
    {
        
        $builder = $this->db->table($this->table);
        $builder->select($this->table . '.*, sb_customers.id as customer_id, sb_customers.customer_name, sb_customers.address,sb_employee.full_name as employee_name');
        $where = ' 1 = 1 ';

        if (!empty($conditions['shop_id'])) {
            $builder->where(' sb_orders.shop_id', $conditions['shop_id']);
            $where .= ' AND sb_orders.shop_id = ' . $conditions['shop_id'] . '';
        }

        if (!empty($conditions['from_date']) && !empty($conditions['to_date'])) {
            $builder->where('date_order >=', $conditions['from_date'])
            ->where('date_order <=', $conditions['to_date']);
            $where .= ' AND date_order >= "' . $conditions['from_date'] . '" AND date_order <= "' . $conditions['to_date'] . '"';
        } elseif (!empty($conditions['from_date'])) {
            $builder->where('date_order >=', $conditions['from_date']);
            $where .= ' AND date_order >= "' . $conditions['from_date'] . '"';
        } elseif (!empty($conditions['to_date'])) {
            $builder->where('date_order <=', $conditions['to_date']);
            $where .= ' AND date_order <= "' . $conditions['to_date'] . '"';
        }
        // if (!empty($conditions['status'])) {
        //     $builder->where(' sb_orders.status', $conditions['status']);
        //     $where .= ' sb_orders.status = ' . $conditions['status'] . '';
        // }
        if (!empty($conditions['assigned_to'])) {
            $builder->where(' sb_orders.assigned_to', $conditions['assigned_to']);
            $where .= ' AND sb_orders.assigned_to = ' . $conditions['assigned_to'] . '';
        }
        $builder->where('sb_orders.status', $conditions['status']);
        $where .= ' AND sb_orders.status = ' . $conditions['status'] . '';

        $builder->join('sb_customers', 'sb_customers.id = sb_orders.customer_id', 'left');
        $builder->join('sb_employee', 'sb_employee.id = sb_orders.assigned', 'left');

        $builder->orderBy('id', 'DESC');
        $limit = isset($conditions['length']) ? $conditions['length'] : 20; 
        $start = isset($conditions['start']) ? $conditions['start'] : 0; 
        $offset = $start;
        $builder->limit($limit, $offset);
        // $sql = $builder->getCompiledSelect();
        // var_dump($sql);die;
        
        $results = $builder->get()->getResult();
        $delivery = '';
        if($results){
            foreach($results as $result){
                $result->total_price =  number_format($result->total_price);
                $result->discount =  number_format($result->discount);
                $result->final_price =  number_format($result->final_price);
                //
                $result->status_delivery_value = getOrderStatusDeliveryValue($result->status_delivery);
                $result->status_payment_value = getOrderStatusPaymentValue($result->status_payment);
                if($result->date_order ){
                    $result->date_order = date('d-m-Y H:i', strtotime($result->date_order));
                }
                
            }
        }
      
        // Lấy tổng số bản ghi để tính toán phân trang
        $total = $this->db->table($this->table)
            ->where($where)
            ->countAllResults();
        return [
            'draw' => isset($conditions['draw']) ? $conditions['draw'] : 1,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $results,
        ];
    }
 

    public function updateAssignedEmpDelete($EmpId){
       
        $shop_id = $_SESSION['shop_id'];
        $db = \Config\Database::connect();
        $query = $db->query("SELECT * FROM sb_employee WHERE shop_id = ? AND role_id = ?", [$shop_id, 1]);
        $shop_admin = $query->getRow();
        if($this->where(['assigned' => $EmpId])->first()){
            // update assgined to null
            $data = [
                'assigned' =>  $shop_admin->id,  
            ];
            
            $builder = $this->builder();

            $updated = $builder->where('shop_id', $shop_id)
            ->where('assigned', $EmpId)
            ->set($data)
            ->update();
            if ($updated) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getLastIdOrder(){
        $builder = $this->db->table('sb_orders'); 
        $builder->orderBy('id', 'DESC');
        $builder->limit(1);
        $query = $builder->get();
        $result = $query->getRow(); 
        if ($result) {
            return $result->id;
        }
        return null;
    }
    public function createOrder(array $data)
    {
        $data['created_at'] = date("Y-m-d H:i:s");
        // Kiểm tra dữ liệu hợp lệ
        if ($this->insert($data)) {
            return $this->getInsertID();
        }
        return false;
    }

    public function findOrderById($id){
        $builder = $this->db->table('sb_orders'); 
        $builder->where('id', $id);
        $query = $builder->get();
        $result = $query->getRow(); 
        if ($result) {
            return (array) $result;
        }
        return null;
    }


}
