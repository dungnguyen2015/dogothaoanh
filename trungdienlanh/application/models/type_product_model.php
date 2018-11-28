<?php

class Type_product_model extends CI_Model {

    private $table = 'type_product';

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

        if (isset($params['pror_id']))  {

            $this->db->where ('pror_id', $params['pror_id']);
        }
        if (isset($params['id']))  {

            $this->db->where ('id', $params['id']);
        }

        if (isset($params['url']))  {

            $this->db->where ('url', $params['url']);
        }
        
        $query = $this->db->get($this->table);
        return $query->result();

    }

}