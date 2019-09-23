<?php

namespace App\Models;

class Car
{
    
    public function __construct($c) 
    {
        $this->settings = $c;
    }
    /**
     * List information cars 
     * @return Array $todos
     */
    public function listCars() 
    {       
        $sth = $this->settings->db->prepare("SELECT * FROM coches");
        $sth->execute();
        $todos = $sth->fetchAll();
        return $todos;
    }
    /**
     * List information of one car
     * @param String $id     
     * @return Array $todos
     */
    public function infoCar($id)
    {
        $sth = $this->settings->db->prepare("SELECT * FROM coches WHERE id=:id");
        $sth->bindParam("id", $id);
        $sth->execute();
        $todos = $sth->fetchObject();
        return $todos;
    }
    /**
     * Register new car
     * @param Array $input    
     * @return Array $input
     */
    function createCar($input) 
    {
        $sql =  "INSERT INTO coches (
                                fabricante, 
                                modelo, 
                                epoca, 
                                colores, 
                                cilindrada, 
                                potencia) 
                VALUES (
                    :fabricante, 
                    :modelo, 
                    :epoca, 
                    :colores, 
                    :cilindrada, 
                    :potencia)";

        $sth = $this->settings->db->prepare($sql);
        $sth->bindParam("fabricante", $input['fabricante']);
        $sth->bindParam("modelo", $input['modelo']);
        $sth->bindParam("epoca", $input['epoca']);
        $sth->bindParam("colores", $this->arrayEncode($input['colores']) );
        $sth->bindParam("cilindrada", $input['cilindrada']);
        $sth->bindParam("potencia", $input['potencia']);
        $sth->execute();
        $input[id] = $this->settings->db->lastInsertId();
        return $input;
    }
    /**
     * Search cars in car list
     * @param String $query     
     * @return Array $todos
     */
    function searchCar($query)
    {
        $sth = $this->settings->db->prepare("SELECT * FROM coches WHERE UPPER(modelo) LIKE :query ORDER BY modelo");
        $query = "%".$query."%";
        $sth->bindParam("query", $query);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $todos;
    }
    /**
     * Remove car
     * @param String $id     
     * @return Array $todos
     */
    function removeCar($id)
    {

        $sth = $this->settings->db->prepare("DELETE FROM coches WHERE id=:id");
        $sth->bindParam("id", $id);
        $sth->execute();
        $sth = $this->settings->db->prepare("SELECT * FROM coches");
        $sth->execute();
        $todos = $sth->fetchAll();
        return $todos;
    }
    /**
     * Update car
     * @param String $id 
     * @param Array $input              
     * @return Array $todos
     */
    function updatedCar($id, $input)
    {   

        $value = $this->infoCar($id);

        if($value == false){
            return false;
        }

        $sql = "UPDATE coches SET 
                                modelo=:modelo, 
                                fabricante=:fabricante, 
                                epoca=:epoca, 
                                colores=:colores, 
                                cilindrada=:cilindrada, 
                                potencia=:potencia,
                                updated_at= true
                            WHERE 
                                id=:id";

        $sth = $this->settings->db->prepare($sql);
        $sth->bindParam("id", $id);
        $sth->bindParam("fabricante", $input['fabricante']);
        $sth->bindParam("modelo", $input['modelo']);
        $sth->bindParam("epoca", $input['epoca']);
        $sth->bindParam("colores", $this->arrayEncode($input['colores']) );
        $sth->bindParam("cilindrada", $input['cilindrada']);
        $sth->bindParam("potencia", $input['potencia']);
        $sth->execute();
        $input['id'] = $id;
        return $input;

        
    }
    /**
    * Crea un string codificado a partir de un array
    * @param Array $array:
    * @return String $array
    */
    static function arrayEncode($array)
    {
        return base64_encode(json_encode($array));
    }
    /** 
    * Crea un array a partir de un string codificado
    * @param string $array_texto
    * @return Array $array
    */
    static function arrayDecode($array_texto)
    {
        return json_decode((base64_decode($array)),true);
    }
}
