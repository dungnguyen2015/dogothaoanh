<?php

class Img_product_model extends CI_Model {

    private $table = 'img_product';

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

    public function delete($params = [])
    {
        
        if (isset($params['product_id'])) {

            $this->db->where ('product_id', $params['product_id']);
        }
        if (isset($params['url'])) {

            $this->db->where ('url', $params['url']);
        }

        return $this->db->delete($this->table);
    }

    // Get all
    public function get ($params = []) {

        if (isset($params['product_id'])) {

            $this->db->where ('product_id', $params['product_id']);
        }
        
        $query = $this->db->get($this->table);
        return $query->result();

    }

}