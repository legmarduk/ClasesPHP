<?php 
require_once('utils.class.php');

class Material{

   public $id = null;
   public $name_material = null;	
   public $description_material = null;	
   public $provider_material	= null;
   public $code_material	= null;
   public $unity = null;

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
            $res=$DB->select("SELECT * FROM materials WHERE id='{$id}'");
            if(count($res)>0){
                $this->id                      =$res[0]->id;
                $this->name_material           =$res[0]->name_material;	
                $this->description_material    =$res[0]->description_material;
                $this->provider_material	   =$res[0]->provider_material;
                $this->code_material	       =$res[0]->code_material;
                $this->unity                   =$res[0]->unity;

                return true;
            }else{
                return false;
            }
        }else{
            return true; //empty materials
        }
    }

    private function ValidateAtributes(){
        $DB = new DB();
        if( !preg_match('/[a-z\s]{3,}/mis',$this->name_material) ){
			return false;	
        }
        return true;
    }


    /************* CREATE ***********/

    private function ValidateAtributesOnCreate(){
		$DB  = new DB();
		// Validate there is no other user whit the same code of material
		$res = $DB->select("SELECT * FROM materials WHERE code_material='{$this->code_material}' LIMIT 1");
		if(count($res)>0){
			return false;  //al repetir el codigo no inserta pero no crea un error
		}
		return true;
	}

    public function create(){
        if($this->id!=null){
            return false;
        }
        if( !$this->ValidateAtributes() ||  !$this->ValidateAtributesOnCreate()){
			return false;
        }
        $DB =new DB();
        $result = $DB->insert("materials", array(
            'id'                    => null,
            'name_material'	        => $this->name_material,
            'description_material'	=> $this->description_material,
            'provider_material'     => $this->provider_material,
            'code_material'         => $this->code_material,
            'unity'                 => $this->unity,
        ));
        if($result >0){
            return $result;
        }
    return false;
    }

    /*************** UPDATE  ****************/

    private function ValidateAtributesOnUpdate(){
		$DB  = new DB();		

		// Validate there is no other user whit the same email address
		$res = $DB->select("SELECT * FROM users WHERE code_material='{$this->code_material}' AND id!='{$this->id}' LIMIT 1");
		if(count($res)>0){
			return false;
		}
 
		return true;
    }


    public function update(){
        if($this->id==null){
            return false;
        }
        if(!$this->ValidateAtributes() || !$this->ValidateAtributesOnUpdate()){
          return false;  
        }
        $DB = new DB();

        $result = $DB->update("materials", array(
            'name_material'	        => $this->name_material,
            'description_material'	=> $this->description_material,
            'provider_material'     => $this->provider_material,
            'code_material'         => $this->code_material,
            'unity'                 => $this->unity,
        ),"id={$this->id}");
        return true;
    }

/*************delete REVISAR ***********/
    public function delete(){
        if($this->id==null){
            return false;
        }
        $DB = new DB();
        $result = $DB->delete("materials","id={$this->id}");

        return true;
    }

    /************* OTHERS ***************/
    public function getMaterialsByCode($code_material){
        $DB = new DB();
        
        $res = $DB->select("SELECT * FROM materials WHERE 
        code_material='{$code_material}' LIMIT 1");

        if(count($res)<0){
            return false;
        }
    return $res;
    }
}
?>

    