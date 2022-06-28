<?php
	//Car model class with constructor and variable and getter setter methods
    class Car{
        private $id;
		private $name;
		private $year;
		private $image;

        function __construct($id ,$name,$year,$image )
        {
            $this->setId($id);
            $this->setName($name);
            $this->setYear($year);
            $this->setImage($image);
        }

        public function getName(){
			return $this->name;
		}
		
		public function setName($name){
			$this->name = $name;
		}
		
		public function getYear(){
			return $this->year;
		}
		
		public function setYear($year){
			$this->year = $year;
		}

		public function getImage(){
			return $this->image;
		}

		public function setImage($image){
			$this->image = $image;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

		// to string method to print the car object 
		public function __toString(){
     	return $this->getName() . ' '. $this->getId() . ' ' . $this->getImage();
   		}
    }
    