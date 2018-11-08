<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Payment model.
* @author Vim Ji <vim.jxl@gmail.com>
* Date Created: 2018-11-06
*/


class XXXProducts extends CI_Model {

  function __construct()
  {
    parent::__construct();
    $this->db = $this->load->database('anlun', TRUE);
    $this->table_name = 'xxx_products';

  }

  public function insert_new_order($data=array())
  {
    $query = $this->db->insert($this->table_name, $data);
    if($query){
      return $this->db->insert_id();
    }

    return 0;
  }

  public function get_products_by_filename($filename)
  {
    $this->db->where('file_name',$filename);
    $query = $this->db->get($this->table_name);
    // return $query->result();
    if ($query->num_rows() >= 1) return $query->row();
      return NULL;
  }

  public function update_order_status($id, $order_status)
  {
    $this->db->set('order_status', $order_status, TRUE);
    $this->db->where('id', $id);
    $this->db->update($this->table_name);
    
    if ($this->db->affected_rows() > 0) {
        return true;
    }
    
    return false;
  }

  function update($id, $update_data)
  {    
    $this->db->where('id', $id);
    $this->db->update($this->table_name, $update_data);
    // return $this->db->affected_rows();
    if ($this->db->affected_rows() > 0) {
        return true;
    }
    
    return false;
  }  

  function delete($id)
  {    
    $this->db->where('id', $id);
    $this->db->delete($this->table_name);
    if ($this->db->affected_rows() > 0) {
        return true;
    }
    
    return false;
  }   
}


/* End of file Payment_model.php */
/* Location: ./application/models/Payment_model.php */