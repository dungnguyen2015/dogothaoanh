<?php

class Parent_menu_model extends CI_Model {

    private $table = 'parent_menu';

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

            $this->db->limit (20, 0);
        }

        if (isset($params['active'])) {

            $this->db->where ('active', $params['active']);
        }

        if (isset($params['url'])) {

            $this->db->where ('url', $params['url']);
        }

        $query = $this->db->get($this->table);
        return $query->result();

    }

}