<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Customertemplates_model extends CI_Model {

       public function __construct(){
          $this->load->database();
        }

       public function get_rendered_template($cust, $template) {
           $query = $this->db->query("call fetchTemplate($template)");
           return $query->result();

        }

        public function get_rendered_application($cust, $template) {

        	// Just to test locally as SP is not wroking due to weird reason.
           /* $query = $this->db->query("SELECT jx.templatekey, jx.sectionKey, ff.id, ff.uid, ff.content FROM `customerQuestions` ff
							inner join customerSectionsQuestionsXref sx on sx.objID = ff.uid   inner join
        					customerTemplatesSectionsXref jx on jx.sectionKey  = sx.secID where jx.templateKey=
        					(select uuid from customerTemplates where custid=".$cust." and id=".$template.")  order by jx.order, sx.order"); */

        	$query = "SELECT  ct.TemplateName, jx.templatekey, cs.description as sectionname , jx.sectionKey, ff.id, ff.uid, ff.content FROM `customerQuestions` ff  
					inner join customerSectionsQuestionsXref sx on sx.objID = ff.uid   inner join customerTemplatesSectionsXref 
					jx on jx.sectionKey  = sx.secID inner Join customerTemplates ct on ct.uuid=jx.templateKey 
					inner join customerSections cs on cs.uid = sx.secID  
					and  ct.custid=".$cust." and ct.id=".$template." and ct.status = 1  order by jx.order, sx.order";

        	//echo $query;

        	$out = $this->db->query($query);
        	$res = $out->result();

        	/*$query = $this->db->query("call fetchCustApplication($cust,$template)");
        	$res = $query->result();
        	$query->next_result(); // Dump the extra resultset.
        	$query->free_result(); // Does what it says.*/

        	return $res;

        }

        public function getSavedApplication($application_id)
        {
        	$query = "select aq.*, sq.SecID, aseq.description as sectionname, ct.TemplateName  from applicationQuestions aq
        	inner join applicationSectionQuestionXref sq on sq.applicationID = aq.applicationID
        	and sq.id = aq.id inner join applicationSections aseq
        	on sq.SecID = aseq.uid 
        	inner join applicationTemplatesSectionsXref ts on ts.applicationID = aq.applicationID
        	inner Join customerTemplates ct on ct.uuid=ts.templateKey
        	and ts.id = sq.secID where aq.applicationID = ".$application_id."
        	order by ts.order, sq.order";
        	$out = $this->db->query($query);
	       	$result = $out->result();
        	return $result;

        }


    public function get_customer_template_by_id($id)
    {
        return $this->db->select('*')->from('customerTemplates')->where('id', $id)->limit(1)->get()->row();
    }

	public function get_customertemplates($customer_id){

		$this->db->where("custid",$customer_id);
		$query = $this->db->get('customerTemplates');
		return json_encode($query->result_array());
	}

	public function get_customertemplate_byorig_id($id,$customer_id)
	{
		$this->db->where("id",$id);
		$this->db->where("custid",$customer_id);
		$query = $this->db->get('customerTemplates');
		return json_encode($query->result_array());
	}

	public function get_customertemplate_byid($id)
	{
		$this->db->where("uuid",$id);

		$query = $this->db->get('customerTemplates');
		return json_encode($query->result_array());
	}


	public function set_customertemplate($templ_data) {

		$this->db->insert('customerTemplates', $templ_data);
		return $this->db->insert_id();

	}

	public function update_customertemplate($data,$template_id)
	{
		$this->db->set($data);
		$this->db->where('uuid', $template_id);
		$this->db->update('customerTemplates');
	}

    public function get_encryption_key()
    {
        return 'd3c1ph3rCr3d1t$2ud&6';
    }

    public function get_embed_code($template_id)
    {
        if (!$template_id) {
            return false;
        }

        $this->load->library('encrypt');

        $hash = base64_encode($this->encrypt->encode($template_id, $this->get_encryption_key()));

        return '<div data-hash="' . $hash . '"></div> <script src="' . site_url() . '/widget.js?hash=' . $hash . '"></script>';
    }

}