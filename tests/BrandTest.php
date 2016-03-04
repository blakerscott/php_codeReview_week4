<?php

/**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

	require_once 'src/Brand.php';
    require_once 'src/Store.php';

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);



	class BrandTest extends PHPUnit_Framework_TestCase

	{


		protected function tearDown()

		{
			Brand::deleteAll();
            Store::deleteAll();
		}


		function testGetName()

		{
            //Arrange
            $name = "Foot Action";
            $test_brand = new Brand($id = null, $name);

            //Act
            $result = $test_brand->getName();

            //Assert
            $this->assertEquals($name, $result);
        }


		function testSetName()

		{
            //Arrange
			$name = "Foot Action";
            $test_brand = new Brand($id = null, $name);

            //Act
            $test_brand->setName('Foot Locker');
            $result = $test_brand->getName();

            //Assert
            $this->assertEquals('Foot Locker', $result);

        }

        function testGetId()

		{
            //Arrange
            $name = "Foot Locker";
            $id = 1;
            $test_brand = new Brand($id, $name);

            //Act
            $result = $test_brand->getId();

            //Assert
            $this->assertEquals(1, $result);

        }


		function testSave()

		{
            //Arrange
            $name = "Foot Locker";
            $id = 1;
            $test_brand = new Brand($id, $name);
            $test_brand->save();


            //Act
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([$test_brand], $result);
    	}

		function testGetAll()
		{

            //Arrange
            $name = "Nike";
            $test_brand = new Brand($id = null, $name);
            $test_brand->save();

            $name2 = "Adidas";
            $test_brand2 = new Brand($id = null, $name2);
            $test_brand2->save();

			//Act
			$result = Brand::getAll();

			//Assert
			$this->assertEquals([$test_brand, $test_brand2], $result);
		}

		function testDeleteAll()
		{
			//Arrange
			$name = "Nike";
            $test_brand = new Brand($id = null, $name);
            $test_brand->save();

            $name2 = "Adidas";
            $test_brand2 = new Brand($id = null, $name2);
            $test_brand2->save();

			//Act
			Brand::deleteAll();
			$result = Brand::getAll();
			//Assert
			$this->assertEquals([], $result);
		}


		function testUpdateName()

	  	{
            //Arrange
            $name = "Foot Locker";
            $id = 1;
            $test_brand = new Brand($id, $name);
            $test_brand->save();

            //Act
            $test_brand->updateName('Johns Shoe Shop');
            //Assert
            $this->assertEquals('Johns Shoe Shop', $test_brand->getName());
    	}


		function testFind()

		{
            //Arrange
            $name = "Foot Locker";
            $id = 1;
            $test_brand = new Brand($id, $name);
            $test_brand->save();

            //Act
            $result = Brand::find($test_brand->getId());

            //Arrange
            $this->assertEquals($test_brand, $result);
        }

        function testDelete()
        //delete one course
        {
			//Arrange
            $name = "Nike";
            $test_brand = new Brand($id = null, $name);
            $test_brand->save();

            $name2 = "Vans";
            $test_brand2 = new Brand($id = null, $name2);
            $test_brand2->save();
			//Act
			$test_brand->delete();
			$result = Brand::getAll();
			//Assert
			$this->assertEquals([$test_brand2], $result);
		}

        function testAddStore()
        {
            //Arrange
            $name = "Foot Locker";
            $test_store = new Store($id = null, $name);
            $test_store->save();

            $name = "Nike";
            $test_brand = new Brand($id = null, $name);
            $test_brand->save();

            //Act
            $test_brand->addStore($test_store);
			$result = $test_brand->getStore();

            //Assert
            $this->assertEquals('Foot Locker', $result);

        }

        function testGetStores()
        {
            //Arrange
            $name = "Foot Locker";
            $id = 1;
            $test_store = new Store($id, $name);
            $test_store->save();

            $name2 = "Dumb Shoe Store";
            $id2 = 2;
            $test_store2 = new Store($id2, $name2);
            $test_store2->save();

            $name3 = "Vans";
            $id3 = 2;
            $test_brand = new Brand($id3, $name3);
            $test_brand->save();

            //Act
            $test_brand->addStore($test_store);
            $test_brand->addStore($test_store2);
			$result = $test_brand->getStore();

            //Assert
            $this->assertEquals('Foot Locker, Dumb Shoe Store', $result);

		}


    }

?>
