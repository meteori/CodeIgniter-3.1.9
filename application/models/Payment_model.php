<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Payment model.
* @author Vim Ji <vim.jxl@gmail.com>
* Date Created: 2018-10-28
*/


class Payment_model extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->db = $this->load->database('anlun', TRUE);
    $this->table_name = 'order_wx';

  }

  public function insert_new_order($data=array())
  {
    $query = $this->db->insert($this->table_name, $data);
    if($query){
      return $this->db->insert_id();
    }

    return 0;
  }

  public function search_order($crsNo)
  {
    $this->db->where('crsNo',$crsNo);
    $query = $this->db->get($this->table_name);
    return $query->result();
  }

  public function update_order($id, $update)
  {
    $this->db->where('id', $id);
    $this->db->update('order_status', $update);
    
    if ($this->db->affected_rows() > 0) {
        return true;
    }
    
    return false;
  }
}


/* End of file Payment_model.php */
/* Location: ./application/models/Payment_model.php */