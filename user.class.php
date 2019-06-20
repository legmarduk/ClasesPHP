<?php
require_once('utils.class.php');

class User{

    public $id = null; 
    public $name_user = null;
    public $lastname_1 = null;
    public $lastname_2 = null;
    public $rut_user = null;
    public $mail = null;
    public $phone = null;
    public $position = null;
    public $date_birth = null;
    public $active = null;
    public $pass = null;
    public $whatsapp = null;

    
	/**
	 * Public constructor
	 *
	 * @param int $ID if is null, instance a generic object otherwise tries to create the object from the data base
	 * @return bool true if the object was instanced correctly
	 * @return bool false if the object was not instanced correctly
	*/

    public function __construct($id=null){
        $DB = new DB();

        if($id !=NULL){
            $res=$DB->select("SELECT * FROM users WHERE id='{$id}'");

            if(count($res)>0){
                $this->id          = $res[0]->id;
                $this->name_user   = $res[0]->name_user;
                $this->lastname_1  = $res[0]->lastname_1;
                $this->lastname_2  = $res[0]->lastname_2;
                $this->rut_user    = $res[0]->rut_user;
                $this->mail        = $res[0]->mail;
                $this->phone       = $res[0]->phone;
                $this->position    = $res[0]->position;
                $this->date_birth  = $res[0]->date_birth;
                $this->active      = $res[0]->active;
                $this->pass        = $res[0]->pass;
                $this->whatsapp    = $res[0]->whatsapp;
    
                return true;
            }else{
                return false;
            }
        }else{
            return true; //empty user
        }
    }
    

    private function ValidateAtributes(){
        $DB = new DB();

        if( !preg_match('/[a-z\s]{3,}/mis',$this->name_user) ){
			return false;	
        }
        return true;
    }

	 /************* CREATE ***********/
	private function ValidateAtributesOnCreate(){
		$DB  = new DB();

		// Validate there is no other user whit the same email address
		$res = $DB->select("SELECT * FROM users WHERE mail='{$this->mail}' LIMIT 1");
		if(count($res)>0){
			return false;
		}
 
		return true;
	}
    /**
	 * Method to create a new register in the database in the "LIGTH_CONFIG" table
	 * @return int return the ID of the new record
	 * @return bool false if the object was not inserted correctly
	*/

    public function create(){

        if($this->id !=null){
			return false;
        }	
        if( !$this->ValidateAtributes() ||  !$this->ValidateAtributesOnCreate()){
			return false;
        }
        $DB =new DB();

        $result = $DB->insert("users", array(
			'id'		        => null,
			'name_user'			=> $this->name_user,
			'lastname_1'    	=> $this->lastname_1,
			'lastname_2'	    => $this->lastname_2,
			'rut_user'          => $this->rut_user,
			'mail'			    => $this->mail,
			'phone'			    => $this->phone,
			'position'			=> $this->position,
			'date_birth'	    => $this->date_birth,
			'active'			=> $this->active,
			'pass'				=> $this->pass,
			'whatsapp'			=> $this->whatsapp,
        ));
        if($result>0){
			return $result;
		}
		return false;
    }

    /*************** UPDATE  ****************/

	private function ValidateAtributesOnUpdate(){
		$DB  = new DB();		
		// Validate there is no other user whit the same email address
		$res = $DB->select("SELECT * FROM users WHERE mail='{$this->mail}' AND id!='{$this->id}' LIMIT 1");
		if(count($res)>0){
			return false;
		}
		return true;
    }

    public function update(){
		//Unable to create a new register if object is already instanced
		if($this->id==null){
			return false;
		}	
		//Validate the fields
		if( !$this->ValidateAtributes() ||  !$this->ValidateAtributesOnUpdate()){
			return false;
		}

		$DB  = new DB();

		$result = $DB->update("users", array(
			'name_user'			=> $this->name_user,
			'lastname_1'    	=> $this->lastname_1,
			'lastname_2'	    => $this->lastname_2,
			'rut_user'          => $this->rut_user,
			'mail'			    => $this->mail,
			'phone'			    => $this->phone,
			'position'			=> $this->position,
			'date_birth'	    => $this->date_birth,
			'active'			=> $this->active,
			'pass'				=> $this->pass,
			'whatsapp'			=> $this->whatsapp,
		), "id={$this->id}");

		return true;
	}
	

	/****** DELETE***********/
    
    /**
	 * Method to create a new update an existing register in the "USER" table
	 *
    */
	public function delete(){
		//Unable to create a new register if object is already instanced
		if($this->id==null){
			return false;
		}
		$this->active=0;
	    $this->update();
	}


	/********** OTHERS ************/
    public function getUserByMail($mail){
		$DB  = new DB();		

		// Validate there is no other user whit the same email address
		$res = $DB->select("SELECT * FROM users WHERE mail='{$mail}' LIMIT 1");
		if(count($res)<0){
			return false;
		}

		return $res[0]->id;
	}

}

?>