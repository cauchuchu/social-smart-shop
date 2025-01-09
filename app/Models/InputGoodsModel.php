<?php

namespace App\Models;

use CodeIgniter\Model;

class InputGoodsModel extends Model
{
    protected $table = 'sb_income';

    protected $allowedFields = ['id_bill', 'date_in', 'detail', 'in_by', 'total', 'description','created_at','shop_id'];

    /**
     * Hàm lấy thông tin
     *
     * @param array
     * @return array các bản ghi có điều kiện thỏa mãn
     */

    public function getData(array $conditions = [])
    {
        
        $builder = $this->db->table($this->table);
        $builder->select($this->table . '.*, sb_employee.full_name');
        $where = '';
        $builder->join('sb_employee', 'sb_employee.id = ' . $this->table . '.in_by', 'left');

        if (!empty($conditions['shop_id'])) {
            $builder->where(' sb_income.shop_id', $conditions['shop_id']);
            $where .= ' sb_income.shop_id = ' . $conditions['shop_id'] . '';
        }
        if (!empty($conditions['in_by'])) {
            $builder->where('in_by', $conditions['in_by']);
            $where .= ' AND in_by = ' . $conditions['in_by'] . '';
        }

        if (!empty($conditions['from_date']) && !empty($conditions['to_date'])) {
            $builder->where('date_in >=', $conditions['from_date'])
            ->where('date_in <=', $conditions['to_date']);
            $where .= ' AND date_in >= "' . $conditions['from_date'] . '" AND date_in <= "' . $conditions['to_date'] . '"';
        } elseif (!empty($conditions['from_date'])) {
            $builder->where('date_in >=', $conditions['from_date']);
            $where .= ' AND date_in >= "' . $conditions['from_date'] . '"';
        } elseif (!empty($conditions['to_date'])) {
            $builder->where('date_in <=', $conditions['to_date']);
            $where .= ' AND date_in <= "' . $conditions['to_date'] . '"';
        }
        $builder->orderBy('date_in', 'DESC');
        $limit = isset($conditions['length']) ? $conditions['length'] : 20; 
        $start = isset($conditions['start']) ? $conditions['start'] : 0; 
        $offset = $start;
        $builder->limit($limit, $offset);
        // $sql = $builder->getCompiledSelect();
        // var_dump($sql);die;
        
        $results = $builder->get()->getResult();
       
        if($results){
            foreach($results as $result){
                $result->date_in = date('d-m-Y H-i', strtotime($result->date_in));
                $result->total =  number_format($result->total);
               
            }
        }
       
        // Lấy tổng số bản ghi để tính toán phân trang
        $total = $this->db->table($this->table)
            ->join('sb_employee', 'sb_employee.id = ' . $this->table . '.in_by', 'left')
            ->where($where)
            ->countAllResults();
        return [
            'draw' => isset($conditions['draw']) ? $conditions['draw'] : 1,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $results,
        ];
    }

    /**
     * Hàm thêm mới phieeus thu
     *
     * @param array $data 
     * @return int|bool Id 
     */
    public function createBill(array $data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($this->insert($data)) {
            return $this->getInsertID();
        }
        return false;
    }
}
