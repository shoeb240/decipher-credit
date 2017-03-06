<?php
class Credential_model extends CI_Model
{
    private $secured_db;
    
    public $credential_type;
    public $identity;
    public $password;
    
    public function __construct() {
        $this->secured_db = $this->load->database('secured', true);
    }
    
    public function getCredentialByType($credentialType)
    {
        $this->secured_db->select("credential_type, identity, AES_DECRYPT(password, UNHEX(SHA2('my_secret', 512))) as password");
        $this->secured_db->where('credential_type', $credentialType);
        $query = $this->secured_db->get('credential');
        
        return json_encode($query->row_array());
    }
    
    public function insertCredential()
    {
        $this->secured_db->set('credential_type', $this->credential_type);
        $this->secured_db->set('identity', $this->identity);
        $this->secured_db->set('password', "AES_ENCRYPT('" . $this->password . "', UNHEX(SHA2('my_secret', 512)))", FALSE);
        $sql = $this->secured_db->insert('credential');
    }
}

