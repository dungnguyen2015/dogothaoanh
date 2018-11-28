<?php

class Product_model extends CI_Model {

    private $table = 'product';

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function save($params = [], $flag_get = false)
    {

        $this->db->insert($this->table, $params);

        if ($flag_get) {

            $id = $this->db->insert_id();
            $q = $this->db->get_where($this->table, array('id' => $id));
            return $q->row();
        }

        return $this->db->insert_id();
    }

    // Get all
    public function get ($params = []) {

        $str_select = '';
        if (isset($params['url'])) {

            $this->db->where ($this->table.'.url', $params['url']);
        }

       if (isset($params['not_sale_off'])) {

            $this->db->where ($this->table.'.sale_off', 0);

        }

        if (isset($params['pror_id'])) {

            $this->db->where ($this->table.'.pror_id', $params['pror_id']);
            $str_select .= ', producer.name as producer_name';
            $this->db->join('producer', "producer.id = {$this->table}.pror_id");
        }

        if (isset($params['colorArr'])) {

            $this->db->where ($this->table.'.colorArr', $params['colorArr']);
        }

        if (isset($params['product_id'])) {

            $this->db->where ($this->table.'.id', $params['product_id']);
        }

        if (isset($params['parent_id'])) {

            $this->db->where ($this->table.'.parent_id', $params['parent_id']);
            $str_select .= ', parent_menu.name as parent_menu_name';
            $this->db->join('parent_menu', "parent_menu.id = {$this->table}.parent_id");
        }

        if (isset($params['not_id'])) {

            $this->db->where_not_in ($this->table.'.id', $params['not_id']);
        }

        if (isset($params['tp_id']) && $params['tp_id'] != '') {

            $this->db->where ($this->table.'.tp_id', $params['tp_id']);
            $str_select .= ', type_product.name as type_name';
            $this->db->join('type_product', "type_product.id = {$this->table}.tp_id");
        }

        if (isset($params['id'])) {

            $this->db->where ($this->table.'.id', $params['id']);
        }

        if (isset($params['sale_off'])) {

            $this->db->where ('sale_off > ', $params['sale_off']);
        }

        if (isset($params['order_by'])) {

            if (is_array($params['order_by'])) {

                foreach ($params['order_by'] as $k => $v) {

                    $this->db->order_by($this->table.'.'.$k, $v);
                }
            }

        }

        if (isset($params['limit'])) {

            $this->db->limit ($params['limit'][0], $params['limit'][1]);
        } else {

          //  $this->db->limit (20, 0);
        }

        $this->db->select($this->table.".*, img_product.url as img_url".$str_select);
        $this->db->join('img_product', "img_product.product_id = {$this->table}.id");
        $this->db->group_by("{$this->table}.id");
        $query = $this->db->get($this->table);
        return $query->result();


    }

    public function update ($params = [], $id) {

        $this->db->where($this->table.'.id', $id);
        return $this->db->update($this->table, $params);
    }

}