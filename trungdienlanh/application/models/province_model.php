<?php

class Province_model extends CI_Model {

    private $table = 'province';

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
        
        if (isset($params['limit'])) {

            $this->db->limit ($params['limit'][0], $params['limit'][1]);
        } else {

            //$this->db->limit (20, 0);
        }

        if (isset($params['id'])) {

            $this->db->where ('id', $params['id']);
        }

        $query = $this->db->get($this->table);
        return $query->result();

    }

}