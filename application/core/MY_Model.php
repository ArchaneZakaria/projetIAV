<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function read ($fields = 'all', $conditions = array(), $order_by = '', $from = NULL, $to = '', $group_by = array()) {
        if (empty($fields) || $fields === 'all' || $fields === '*')
            $fields = '*';
        $this->db->select($fields);
        if (!empty($conditions))
            $this->db->where($conditions);
        if ((empty($from) && !empty($to)) || $from !== NULL)
            $this->db->limit($from, $to);
        if (!empty($order_by))
            $this->db->order_by($order_by);
        if (!empty($group_by))
            $this->db->group_by($group_by);
        return $this->db->get($this->table)->result();
    }

    public function create ($options, $created_on_field = NULL) {
        if (empty($options))
            return false;
        if ($created_on_field)
            $options[$created_on_field] = date(DATE_TIME_FORMAT);
        $this->db->insert($this->table, $options);
        return ($id = $this->db->insert_id()) ? $id : false;
    }

    public function update ($options, $conditions = array(), $modified_on_field = NULL) {
        if (!is_array($conditions) && intval($conditions))
            $conditions = array('id' => intval($conditions));
        // Trying an update massive in all elements of table
        if (empty($conditions))
            return false;
        if ($modified_on_field)
            $options[$modified_on_field] = date(DATE_TIME_FORMAT);
        return $this->db->update($this->table, $options, $conditions);
    }

    public function delete($conditions) {
        if (!is_array($conditions) && intval($conditions))
            $conditions = array('id' => intval($conditions));
        return (bool) $this->db->delete($this->table, $conditions);
    }

    public function truncate () {
        return $this->db->truncate($this->table);
    }

    // Si $champ est un array, la variable $valeur sera ignorée par la méthode where()
    public function count ($champ = array(), $valeur = null) {
        return (int) $this->db->where($champ, $valeur)
                        ->from($this->table)
                        ->count_all_results();
    }



    public function updateiav ($options, $conditions = array(), $modified_on_field = NULL,$dTitle) {
      if (!is_array($conditions) && intval($conditions))
          $conditions = array($dTitle => intval($conditions));
      // Trying an update massive in all elements of table
      if (empty($conditions))
          return false;
      if ($modified_on_field)
          $options[$modified_on_field] = date(DATE_TIME_FORMAT);
      return $this->db->update($this->table, $options, $conditions);
  }

  public function deleteiav($conditions,$idtitle) {
      if (!is_array($conditions) && intval($conditions))
          $conditions = array($idtitle => intval($conditions));
      return (bool) $this->db->delete($this->table, $conditions);
  }



}

/* End of file MY_Model.php */
/* Location: ./system/application/core/MY_Model.php */
