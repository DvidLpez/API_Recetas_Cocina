<?php

namespace App\Controllers;

class CarsController
{
    
    public function __construct($c) {
        // Logs
        $c->logger->info("Slim-Skeleton '/' route");
        $this->settings = $c;
    }

    // List alls cars
    public function listCars($request, $response, $args) {

        $sth = $this->settings->db->prepare("SELECT * FROM coches");
        $sth->execute();
        $todos = $sth->fetchAll();
        return $response->withJson($todos);
    }

    // List Info car
    public function infoCar($request, $response, $args) {

        $sth = $this->settings->db->prepare("SELECT * FROM coches WHERE id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $todos = $sth->fetchObject();
        return $response->withJson($todos);
    }

    // Add a new car
    function createCar($request, $response) {

        $input = $request->getParsedBody();
        $sql = "INSERT INTO coches (fabricante, modelo, epoca) VALUES (:fabricante, :modelo, :epoca)";
        $sth = $this->settings->db->prepare($sql);
        $sth->bindParam("fabricante", $input['fabricante']);
        $sth->bindParam("modelo", $input['modelo']);
        $sth->bindParam("epoca", $input['epoca']);
        $sth->execute();
        $input['id'] = $this->settings->db->lastInsertId();
        return $response->withJson($input);
    }

    // Delete a car
    function removeCar($request, $response, $args) {

        $sth = $this->settings->db->prepare("DELETE FROM coches WHERE id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $sth = $this->settings->db->prepare("SELECT * FROM coches");
        $sth->execute();
        $todos = $sth->fetchAll();
        return $response->withJson($todos);
   }

   // Update todo with given id
    function updatedCar($request, $response, $args) {
        $input = $request->getParsedBody();
        $sql = "UPDATE coches SET modelo=:modelo, fabricante=:fabricante, epoca=:epoca WHERE id=:id";
        $sth = $this->settings->db->prepare($sql);
        $sth->bindParam("id", $args['id']);
        $sth->bindParam("fabricante", $input['fabricante']);
        $sth->bindParam("modelo", $input['modelo']);
        $sth->bindParam("epoca", $input['epoca']);
        $sth->execute();
        $input['id'] = $args['id'];
        return $response->withJson($input);
    }
}
