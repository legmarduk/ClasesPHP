<?php 

require_once('utils.class.php');

class state_request{

    public $id                  =null;
    public $date_change_state   =null;
    public $id_state            =null;
    public $id_request          =null;
    public $id_user             =null;


	/**
	 * Public constructor
	 *
	 * @param int $ID if is null, instance a generic object otherwise tries to create the object from the data base
	 * @return bool true if the object was instanced correctly
	 * @return bool false if the object was not instanced correctly
	*/

    public function __construct($id = null){

        $DB = new DB();
    
        if($id != null){
        $res = $DB->select("SELECT * FROM state_request WHERE id='{$id}'");


            if(count($res)>0){
                $this->id                   =$res[0]->id;
                $this->date_change_state    = $res[0]->date_change_state;
                $this->id_state             =$res[0]->id_state;
                $this->id_request           =$res[0]->id_request;
                $this->id_user              =$res[0]->id_user;
            
                return true;
            }else{
                return false;
            }

        }else{
            return true;
        }
    }

/************* CREATE  ******************/

    private function validateAtributes(){
        $DB = new DB();

        $res = $DB->select("SELECT * FROM users where id='{$this->id}'"); //validate if exists this id_user
        if(count($res)<0){
            return false;
        }
        $res = $DB->select("SELECT * FROM requests where id='{$this->id}'");//validate if exists this id_request
        if(count($res)<0){
            return false;
        }
        return true;
    }

    private function validateExist(){
        $DB = new DB();
        $res = $DB->select("SELECT * FROM state_requests WHERE id_state='{$this->id_state}' AND id_request='{$this->id_request}'  LIMIT 1");
        if(count($res)>0){
           
            return false;
        }
        return true;
    }

    /*************** CREATE ****************/
    public function create(){

        if($this->id !=null){
            return false;
        }
        if(!$this->validateAtributes() || !$this->validateExist()){
            return false;
        }
        $DB = new DB();

        $result = $DB->insert("state_requests",array(
            'id'                =>null,
            'date_change_state' =>$this->date_change_state,
            'id_state'          =>$this->id_state,
            'id_request'        =>$this->id_request,
            'id_user'           =>$this->id_user,
        ));
        if($result >0){
            return $result;
        }
        return false;
    }



    /**************** OTHERS *****************/
    /**
     * 
     */

    

}

?>

