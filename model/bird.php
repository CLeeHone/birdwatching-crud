<?php
	class Bird{		
		// variables
		private $bird_id;
		private $common_name;
		private $latin_name;
		private $number_of_birds;
		private $date_observed;
		private $img;
		
		// Constructor
		function __construct($bird_id, $common_name, $latin_name, $number_of_birds, $date_observed, $img)  {
			$this->setId($bird_id);
			$this->setCommonName($common_name);
			$this->setLatinName($latin_name);
			$this->setNumberOfBirds($number_of_birds);
			$this->setDateObserved($date_observed);
			$this->setImage($img);
		}		
		
		// Getter and Setter methods
		public function getId() {
			return $this->bird_id;
		}

		public function setId($new_id) {
			$this->bird_id = $new_id;
		}

		public function getCommonName() {
			return $this->common_name;
		}
		
		public function setCommonName($c_name) {
			$this->common_name = $c_name;
		}
		
		public function getLatinName() {
			return $this->latin_name;
		}
		
		public function setLatinName($l_name) {
			$this->latin_name = $l_name;
		}

		public function getNumberOfBirds(){
			return $this->number_of_birds;
		}

		public function setNumberOfBirds($new_num) {
			$this->number_of_birds = $new_num;
		}

		public function getDateObserved() {
			return $this->date_observed;
		}

		public function setDateObserved($new_date) {
			$this->date_observed = $new_date;
		}

		public function getImage() {
			return $this->img;
		}

		public function setImage($new_img) {
			$this->img = $new_img;
		}
	}
?>