<?php
require_once('utils.class.php');

class Request{

    public $id = null;                 
    public $date_requests = null;
    public $comment_supervisor = null; 
    public $comment_panol = null;
    public $id_user = null;

    /**
	 * Public constructor
	 *
	 * @param int $ID if is null, instance a generic object otherwise tries to create the object from the data base
	 * @return bool true if the object was instanced correctly
	 * @return bool false if the object was not instanced correctly
	*/

    public function __construct($id=null){
        $DB = new DB();

        if($id != NULL){
            $res = $DB->select("SELECT * FROM requests WHERE id='{$id}'");
            if(count($res)>0){
               $this->id                    =$res[0]->id;
               $this->date_requests         =$res[0]->date_requests;
               $this->comment_supervisor    =$res[0]->comment_supervisor;
               $this->comment_panol         =$res[0]->comment_panol;
               $this->id_user               =$res[0]->id_user;
            
                return true;
            }else{
                return false;
            }
        }else{
            return true; //empty request
        }
    }

    
/********************* CREATE **********************/

    private function ValidateAtributesOnCreate(){
		$DB  = new DB();
		// Validate who exists user 
		$res = $DB->select("SELECT * FROM users WHERE id='{$this->id}' LIMIT 1");
		if(count($res)>0){
			return true;  
		}
		return false;
	}

    public function create(){
        if($this->id != null){
            return false;
        }
        if($this->id_user != null || $this->ValidateAtributesOnCreate()){ //ver aqui
            $DB = new DB();
            $result= $DB->insert("requests", array(
                'id'                    => null,
                'date_requests'         => $this->date_requests, //problemas con la fecha solo genera 000000
                'comment_supervisor'    => $this->comment_supervisor,
                'comment_panol'         => $this->comment_panol,
                'id_user'               => $this->id_user,
            ));
            if($result>0){
                return $result;
            }
        }else{
            return false;
        }
    }

/********************* UPDATE  ****************************/
    private function ValidateAtributesOnUpdate(){
		$DB  = new DB();		
		// Validate there is no other user whit the same email address
		$res = $DB->select("SELECT * FROM requests WHERE id_user='{$this->id_user}' AND id='{$this->id}' LIMIT 1");
		if(count($res)>0){
			return true;
		}
		return false;
    }

    public function update(){
        if($this->id ==null){
            return false;
        }
        if(!$this->ValidateAtributesOnUpdate()){
            return false;
        }
        $DB = new DB();

        $result = $DB->update("requests", array(
            'date_requests'         => $this->date_requests, //problemas con la fecha solo genera 000000
            'comment_supervisor'    => $this->comment_supervisor,
            'comment_panol'         => $this->comment_panol,
            'id_user'               => $this->id_user,
        ), "id={$this->id}" );
        return true;
    }

    /******************* DELETE *******************/

    public function delete(){
        if($this->id == null){
            return false;
        }
        $DB = new DB();
        $result = $DB->delete("requests","id={$this->id}");
        return true;
    }

    /**************** OTHERS ***************/

    
    
}

?>
