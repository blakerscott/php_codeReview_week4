<?php

    class Store
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
            $GLOBALS['DB']->exec("INSERT INTO stores (name)
            VALUES ('{$this->getName()}');
            ");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

		static function find($search_id)
		{
			$found_store = null;
			$all_stores = Store::getAll();
			foreach($all_stores as $store) {
				if ($search_id == $store->getId()){
					$found_store = $store;
				}
			}
			return $found_store;
		}

		static function getAll()
		//gets every single store
        {
			$returned_stores = array();
			$all_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
			foreach ($all_stores as $store) {
				$id = $store['id'];
				$name = $store['name'];
				$new_store = new Store($id, $name);
                array_push($returned_stores, $new_store);
			}
            return $returned_stores;
		}

		function updateName($new_name)

        {
            $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

		static function deleteAll()
		//nuclear option for stores
        {
    		$GLOBALS['DB']->exec("DELETE FROM stores;");
    	}

	}

?>
