<?php

class Main_menu_model extends CI_Model {

    private $table = 'main_menu';

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

          //  $this->db->limit (20, 0);
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