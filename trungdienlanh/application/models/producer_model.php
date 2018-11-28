<?php

class Producer_model extends CI_Model {

    private $table = 'producer';

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

        if (isset($params['url'])) {

            $this->db->where ('url', $params['url']);
        }
        if (isset($params['id'])) {

            $this->db->where ('id', $params['id']);
        }

        if (isset($params['parent_id']))  {

            $this->db->where ('parent_id', $params['parent_id']);
        }
        
        $query = $this->db->get($this->table);
        return $query->result();

    }

}