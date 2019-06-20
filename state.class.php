<?php
require_once('utils.class.php');

class State{

    public $id = null;
    public $code_state = null;
    public $description_state = null;

    /**
	 * Public constructor
	 *
	 * @param int $ID if is null, instance a generic object otherwise tries to create the object from the data base
	 * @return bool true if the object was instanced correctly
	 * @return bool false if the object was not instanced correctly
	*/

    public function __construct($id = null){
        $DB = new DB();

        if($id != NULL){
            $res = $DB->select("SELECT * FROM states WHERE id='{$id}'");

            if(count($res)>0){
                $this->id                   =$res[0]->id;
                $this->code_state           =$res[0]->code_state;
                $this->description_state    =$res[0]->description_state;

                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }
/********************** CREATE ************************/

    private function ValidateAtributesOnCreate(){
        $DB  = new DB();
        
        $res = $DB->select("SELECT * FROM states WHERE code_state='{$this->code_state}' LIMIT 1");
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
        if($this->id != null){
            return false;
        }
        if(!$this->ValidateAtributesOnCreate()){
            return false;
        }

        $DB = new DB();
        $result = $DB->insert("states",array(

            'id'                        =>null,                  
            'code_state'                =>$this->code_state,           
            'description_state'         =>$this->description_state, 
        ));
        if($result>0){
			return $result;
		}
		return false;
    }




/************ DELETE ***********/
    public function delete(){
        if($this->id==null){
            return false;
        }
        $DB = new DB();
        $result = $DB->delete("states","id={$this->id}");

        return true;
    }

/************* OTHERS *************/
    public function getAllStates(){
        $DB = new DB();

        $res = $DB->select("SELECT * FROM states");

        if(count($res)<0){
            return false;
        }
    
        return $res;
    }


}


?>