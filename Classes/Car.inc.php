<?php


abstract class Auto{
    protected $plateNumber = '';
    protected $serialNumber = '';
    protected $make = '';
    protected $model = '';

    public function __construct($plateNumber, $serialNumber ,$make, $model){
        $this->setPlateNumber($plateNumber);
        $this->setSerialNumber($serialNumber);
        $this->setMake($make);
        $this->setModel($model);

    }
    public function getPlateNumber(){
        return $this->plateNumber;
    }
    public function setPlateNumber($plateNumber){
        $this->plateNumber = $plateNumber;
    }
    public function getSerialNumber(){
        return $this->serialNumber;
    }
    public function setSerialNumber($serialNumber){
        $this->serialNumber = $serialNumber;
    }
    public function getMake(){
        return $this->make;
    }
    public function setMake($make){
        $this->make = $make;
    }
    public function getModel(){
        return $this->model;
    }
    public function setModel($model){
        $this->model = $model;
    }


    abstract public function start();
}

class Truck extends Auto{
    protected $load = 0;

    public function __construct($plateNumber, $serialNumber, $load, $make, $model){
        parent::__construct($plateNumber, $serialNumber, $make, $model);
        $this->setLoad($load);
    }
    public function getLoad(){
        return $this->load;
    }
    public function setLoad($load){
        $this->load = $load . 'kg';
    }
    public function start(){
        return "$this->make $this->model starts with a key.";
    }
}

class Car extends Auto{
    protected $seats = 0;
    
    public function __construct($plateNumber, $serialNumber, $seats, $make, $model){
        parent::__construct($plateNumber, $serialNumber, $make, $model);
        $this->setSeats($seats);
    }
    public function getSeats(){
        return $this->seats;
    }
    public function setSeats($seats){
        $this->seats = $seats;
    }
    public function start(){
        return "$this->make $this->model starts with a button.";
    }
}

$truck = new Truck('ABC123', '123456789', 400, 'Ford', 'F150');
$car = new Car('HH B123', '123456789', 5, 'Honda', 'Civic');
echo $truck->start() . '<br>';
echo $car->start() . '<br>';




?>