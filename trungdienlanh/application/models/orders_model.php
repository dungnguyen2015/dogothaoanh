<?php

class Orders_model extends CI_Model {

    private $table = 'orders';

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function save($params = [], $flag_get = false)
    {

        $this->db->insert($this->table, $params);
        $id = $this->db->insert_id();
        
        if ($flag_get) {

            $q = $this->db->get_where($this->table, array('id' => $id));
            return $q->row();
        }

        return $id;
    }

    // Get all
    public function get ($params = []) {
        
        if (isset($params['url'])) {

            $this->db->where ($this->table.'.url', $params['url']);
        }

        if (isset($params['pror_id'])) {

            $this->db->where ($this->table.'.pror_id', $params['pror_id']);
        }

        if (isset($params['product_id'])) {

            $this->db->where ($this->table.'.id', $params['product_id']);
        }

        if (isset($params['tp_id'])) {

            $this->db->where ($this->table.'.tp_id', $params['tp_id']);
        }

        if (isset($params['sale_off'])) {

            $this->db->where ('sale_off > ', $params['sale_off']);
        }

        if (isset($params['id'])) {

            $this->db->where ('id', $params['id']);
        }

        if (isset($params['order_by'])) {

            if (is_array($params['order_by'])) {

                foreach ($params['order_by'] as $k => $v) {

                    $this->db->order_by($k, $v);
                }
            }

        }

        if (isset($params['limit'])) {

            $this->db->limit ($params['limit'][0], $params['limit'][1]);
        } else {

            $this->db->limit (20, 0);
        }

        $query = $this->db->get($this->table);
        return $query->result();

    }

    public function update ($params = [], $id) {

        $this->db->where($this->table.'.id', $id);
        return $this->db->update($this->table, $params);
    }

}