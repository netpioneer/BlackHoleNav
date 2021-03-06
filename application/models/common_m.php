<?php

/**
 * Description of url_m
 *
 * @author HacRi <linleqi@gmail.com>
 */
class Common_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_by_id($commonid) {

        $condictions = array('id' => $commonid);

        $this->db->where($condictions);

        $fields = array('url', 'name', 'is_static');
        $this->db->select($fields);

        $query = $this->db->get('common');

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function get_all() {
        $this->db->select('*');
        $this->db->order_by('rank', 'asc');
        $query = $this->db->get('common');

        return $query->result();
    }

    function get_by_status($status, &$count = 0) {
        $this->db->where('status', $status);
        $this->db->select('*');
        $this->db->order_by('rank', 'asc');
        if ($count != 0)
            $this->db->limit($count);
        $query = $this->db->get('common');
        $count = $query->num_rows();

        return $query->result();
    }

    function insert_url($url_a) {
        $this->db->where('url', $url_a['url']);
        $this->db->select('status');
        $query = $this->db->get('common');

        if ($query->num_rows() != 0) {
            $this->db->where('url', $url_a['url']);
            $this->db->set('rank', $url_a['rank']);
            $this->db->update('common');
            return $query->row()->status; // 返回已存在链接的分类
        } else {
            $data = array(
                'url' => $url_a['url'],
                'name' => $url_a['name'],
                'rank' => $url_a['rank'],
                'status' => 4
            );
            $this->db->insert('common', $data);
        }
    }

    //
    function clean($status) {
        $this->db->where('status', $status);
        $this->db->delete('common');
    }

}

?>
