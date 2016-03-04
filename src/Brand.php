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


        // function addStore($new_store)
        // {
        //     $GLOBALS['DB']->exec("INSERT INTO brands_stores (store_id, brand_id) VALUES ({$new_store->getId()}, {$this->getId()})");
        // }
        //
        //
        // function getStore()
        // {
        //     $returned_stores = $GLOBALS['DB']->query("SELECT stores.* FROM brands
        //         JOIN brands_stores ON (brands_stores.brand_id = brands.id)
        //         JOIN stores ON (stores.id = brands_stores.store_id)
        //         WHERE brands.id = {$this->getId()};");
		// 		$stores = array();
        //     foreach($returned_stores as $store) {
        //         $name = $store['name'];
        //         $id = $store['id'];
        //         $new_store = new Store($id, $name);
        //         array_push($stores, $new_store->getName());
        //     }
		// 	$stores_implode = implode(', ', $stores);
        //     return $stores_implode;
        // }

		// So what's going on inside this JOIN statement? It's happening in a few simple steps: We set our destination: stores.*. This means we want a complete stores table.
// We set our starting point: brands. *We collect an id from the brands table (chosen at the end of the statement, after WHERE), and join it up with any matching rows in the brands_stores table.
// We use the store_id from the matching rows in the brands_stores table to select rows from the stores table.
// Finally, our statement returns a complete stores table, as a PDO, composed of only those rows which match our query.
// This single query takes the place of a potentially huge number of other queries, and returns information in an extremely usable PDO format.

	}

?>
