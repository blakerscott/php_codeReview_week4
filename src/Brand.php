<?php

    class Brand
    {
        private $id;
        private $name;

        function __construct($id = null, $name)
        {
            $this->id = $id;
            $this->name = $name;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO brands (name)
            VALUES ('{$this->getName()}');
            ");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

		static function find($search_id)
		{
			$found_brand = null;
			$all_brands = Brand::getAll();
			foreach($all_brands as $brand) {
				if ($search_id == $brand->getId()){
					$found_brand = $brand;
				}
			}
			return $found_brand;
		}

		static function getAll()
		//gets every single brand
        {
			$returned_brands = array();
			$all_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
			foreach ($all_brands as $brand) {
				$id = $brand['id'];
				$name = $brand['name'];
				$new_brand = new Brand($id, $name);
                array_push($returned_brands, $new_brand);
			}
            return $returned_brands;
		}

		function updateName($new_name)

        {
            $GLOBALS['DB']->exec("UPDATE brands SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

		static function deleteAll()
		//nuclear option for brands
        {
    		$GLOBALS['DB']->exec("DELETE FROM brands;");
    	}

		function delete()
		//delete one brand
		{

			$GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
			$GLOBALS['DB']->exec("DELETE FROM brands WHERE brand_id = {$this->getId()};");

		}

	}

?>
