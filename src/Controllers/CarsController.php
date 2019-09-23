<?php

namespace App\Controllers;
use App\Models\Car;

class CarsController
{
    public function __construct($c) 
    {
        $this->settings = $c;
    }
    /**
     * List information cars
     * @param Request $request
     * @param Response $response
     * @param Array $args 
     * @return Json $todos
     */
    public function listCars($request, $response, $args) 
    {
        $this->settings->logger->info("List cars");
        // print_r( $request->getAttribute('decoded_token_data') );
        $carModel = new Car($this->settings);
        $todos = $carModel->listCars();
        return $response->withJson($todos);
    }
    /**
     * List information of one car
     * @param Request $request
     * @param Response $response
     * @param Array $args 
     * @return Json $todos
     */
    public function infoCar($request, $response, $args)
    {
        $this->settings->logger->info("Information car");
        $carModel = new Car($this->settings);
        $id = $args['id'];
        $todos = $carModel->infoCar($id);
        return $response->withJson($todos);
    }
    /**
     * Register new car
     * @param Request $request
     * @param Response $response
     * @param Array $args 
     * @return Json $input
     */
    function createCar($request, $response)
    {
        $this->settings->logger->info("Create car");
        $carModel = new Car($this->settings);
        $params = $request->getParsedBody();
        $input = $carModel->CreateCar($params);
        return $response->withJson($input);
    }
    /**
     * Search cars in car list
     * @param Request $request
     * @param Response $response
     * @param Array $args 
     * @return Json $todos
     */
    function searchCar($request, $response, $args)
    {
        $this->settings->logger->info("Search cars");
        $carModel = new Car($this->settings);
        $query = $args['query'];
        $todos = $carModel->searchCar($query);
        return $response->withJson($todos);
    }
    /**
     * Remove car
     * @param Request $request
     * @param Response $response
     * @param Array $args
     * @return Json $input
     */
    function removeCar($request, $response, $args)
    {
        $this->settings->logger->info("Delete car");
        $carModel = new Car($this->settings);
        $id = $args['id'];
        $todos = $carModel->removeCar($id);
        return $response->withJson($todos);
    }
    /**
     * Update car
     * @param Request $request
     * @param Response $response
     * @param Array $args 
     * @return Json $input
     */
    function updatedCar($request, $response, $args)
    {
        $this->settings->logger->info("Updated car");
        $id = $args['id'];
        $input = $request->getParsedBody();
        $carModel = new Car($this->settings);
        $input = $carModel->updatedCar($id, $input);
        return $response->withJson($input);        
    }
}
