<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";


    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app = new Silex\Application();
    use Symfony\Component\Debug\Debug;
    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));
 // instantiate Silex app, add twig capability to app


    $app->get("/", function() use ($app) {
        //home page
        return $app['twig']->render('index.html.twig');
    });

    //////Stores/////////////
    ////////////////////////

    $app->get("/admin", function() use ($app) {
        //Get all stores
        return $app['twig']->render('admin.html.twig', array(
            'stores' => Store::getAll(),
            'brands' => Brand::getAll()
        ));
    });

    $app->get("/store/{id}", function($id) use ($app) {
        //Navigate to a specific edit/update page
        $store = Store::find($id);
        var_dump($store->getBrand());
        return $app['twig']->render('editstore.html.twig', array(
            'brands' => Brand::getAll(),
            'store' => $store
        ));
    });

    $app->patch("/update_store/{id}", function($id) use ($app) {
        //Route for when you click on update store button
        $new_name = $_POST['name'];
        $store = Store::find($id);
        $store->updateTitle($new_name);
        return $app['twig']->render('admin.html.twig', array(
            'store' => $store,
            'stores' => Store::getAll(),
            'brands' => Brand::getAll()
        ));
    });



    $app->post("/admin_add_store", function() use ($app) {
        //Add a store to the database
        $name = $_POST['name'];
        $store = new Store($id = null, $name;
        $store->save();
        return $app['twig']->render('admin.html.twig', array(
            'brands' => Brand::getAll(),
            'stores' => Store::getAll()
        ));
    });

    $app->delete('/delete_all_stores', function() use ($app) {
		//Nuke all stores
		Store::deleteAll();
		return $app['twig']->render('admin.html.twig', array(
            'brands' => Brand::getAll(),
			'stores' => Store::getAll()
	  ));
	});

    $app->delete('/delete_this_store/{id}', function($id) use ($app) {
		//Delete a single store
        $store = Store::find($id);
        $store->delete();
		return $app['twig']->render('admin.html.twig', array(
            'brands' => Brand::getAll(),
			'stores' => Store::getAll()
	  ));
	});

    //////Brand/////////////
    ////////////////////////

    $app->post('/admin_add_brand', function() use ($app) {
        //adds an brand Yay
        $name = $_POST['brand'];
        $brand = new Brand($id = null, $name);
        $brand->save();
        return $app['twig']->render('admin.html.twig', array(
            'stores' => Store::getAll(),
            'brands' => Brand::getAll()
        ));
    });

    $app->post('/add_brand_to_store', function() use ($app) {
        //adds brand to individual store
        $brand = Brand::find($_POST['brand_id']);
        $store = Store::find($_POST['store_id']);
        $store->addBrand($brand);
        return $app['twig']->render('admin.html.twig', array(
            'store' => $store,
            'stores' => Store::getAll(),
            'brands' => Brand::getAll()
        ));
    });

    $app->delete('/delete_all_brands', function() use ($app) {
		//Nuke all brands
		Brand::deleteAll();
		return $app['twig']->render('admin.html.twig', array(
            'brands' => Brand::getAll(),
			'stores' => Store::getAll()
	  ));
	});

    return $app;
?>
