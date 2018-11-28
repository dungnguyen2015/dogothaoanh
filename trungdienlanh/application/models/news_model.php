<?php

class News_model extends CI_Model {

    private $table = 'news';

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

        if (isset($params['like_content'])) {

            $this->db->like('content', $params['like_content']);
        }

        if (isset($params['like_url'])) {

            $this->db->like($this->table.'.url', $params['like_url']);
        }

        if (isset($params['id'])) {

            $this->db->where ($this->table.'.id', $params['id']);
        }

        if (isset($params['order_by'])) {

            if (is_array($params['order_by'])) {

                foreach ($params['order_by'] as $k => $v) {

                    $this->db->order_by($k, $v);
                }
            }

        }

        if (isset($params['limit'])) {

            if(!isset($params['offset']))  { $params['offset'] = 0;}
            $this->db->limit($params['limit'], $params['offset']);
        }

        $this->db->select($this->table.".*, img_news.url as img_url");
        $this->db->join('img_news', "img_news.news_id = {$this->table}.id");
        $this->db->group_by("{$this->table}.id");

        $query = $this->db->get($this->table);
        return ['result' => $query->result(), 'num_rows' => $query->num_rows() ];

    }

    public function update ($params = [], $id) {

        $this->db->where($this->table.'.id', $id);
        return $this->db->update($this->table, $params);
    }

}