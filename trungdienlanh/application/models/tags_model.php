<?php

class Tags_model extends CI_Model {

    private $table = 'tags';

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

            $this->db->where ($this->table.'.url', $params['url']);
        }

        if (isset($params['not_id'])) {

            $this->db->where_not_in ($this->table.'.id', $params['not_id']);
        }

        if (isset($params['<'])) {

            $this->db->where($this->table.'.id < ', $params['<']);
        }


        $this->db->select($this->table.".*");
        $query = $this->db->get($this->table);
        return $query->result();

    }

    public function update ($params = [], $id) {

        $this->db->where($this->table.'.id', $id);
        return $this->db->update($this->table, $params);
    }

}