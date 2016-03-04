<?php

/**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

	require_once 'src/Store.php';
	require_once 'src/Brand.php';

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);



	class StoreTest extends PHPUnit_Framework_TestCase

	{


		protected function tearDown()

		{
			Store::deleteAll();
		}


		function testGetName()

		{
            //Arrange
            $name = "Foot Action";
            $test_store = new Store($id = null, $name);

            //Act
            $result = $test_store->getName();

            //Assert
            $this->assertEquals($name, $result);
        }


		function testSetName()

		{
            //Arrange
						$name = "Foot Action";
            $test_store = new Store($id = null, $name);

            //Act
            $test_store->setName('Foot Locker');
            $result = $test_store->getName();

            //Assert
            $this->assertEquals('Foot Locker', $result);

        }

        function testGetId()

		{
            //Arrange
            $name = "Foot Locker";
            $id = 1;
            $test_store = new Store($id, $name);

            //Act
            $result = $test_store->getId();

            //Assert
            $this->assertEquals(1, $result);

        }


		function testSave()

		{
            //Arrange
            $name = "Foot Locker";
            $id = 1;
            $test_store = new Store($id, $name);
            $test_store->save();


            //Act
            $result = Store::getAll();

            //Assert
            $this->assertEquals([$test_store], $result);
    	}

		function testGetAll()
		{

            //Arrange
            $name = "Nike";
            $test_store = new Store($id = null, $name);
            $test_store->save();

            $name2 = "Adidas";
            $test_store2 = new Store($id = null, $name2);
            $test_store2->save();

			//Act
			$result = Store::getAll();

			//Assert
			$this->assertEquals([$test_store, $test_store2], $result);
		}

		function testDeleteAll()
		{
			//Arrange
			$name = "Nike";
            $test_store = new Store($id = null, $name);
            $test_store->save();

            $name2 = "Adidas";
            $test_store2 = new Store($id = null, $name2);
            $test_store2->save();

			//Act
			Store::deleteAll();
			$result = Store::getAll();
			//Assert
			$this->assertEquals([], $result);
		}


		function testUpdateName()

	  	{
            //Arrange
            $name = "Foot Locker";
            $id = 1;
            $test_store = new Store($id, $name);
            $test_store->save();

            //Act
            $test_store->updateName('Johns Shoe Shop');
            //Assert
            $this->assertEquals('Johns Shoe Shop', $test_store->getName());
    	}


		function testFind()

		{
            //Arrange
            $name = "Foot Locker";
            $id = 1;
            $test_store = new Store($id, $name);
            $test_store->save();

            //Act
            $result = Store::find($test_store->getId());

            //Arrange
            $this->assertEquals($test_store, $result);
        }


		function testDelete()
		//delete one Store
		{
			//Arrange
            $name = "Foot Locker";
            $id = 1;
            $test_store = new Store($id, $name);
            $test_store->save();

            $name2 = "Joes Shoe Shop";
            $id2 = 2;
            $test_store2 = new Store($id2, $name2);
            $test_store2->save();

			//Act
			$test_store->delete();
			$result = Store::getAll();

			//Assert
			$this->assertEquals([$test_store2], $result);
		}



	}
?>
