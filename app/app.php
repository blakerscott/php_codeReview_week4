<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";


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

    //////Brands/////////////
    ////////////////////////

    $app->get("/admin", function() use ($app) {
        //Get all brands
        return $app['twig']->render('admin.html.twig', array(
            'brands' => Brand::getAll(),
            'stores' => Store::getAll()
        ));
    });

    $app->get("/brand/{id}", function($id) use ($app) {
        //Navigate to a specific edit/update page
        $brand = Brand::find($id);
        var_dump($brand->getStore());
        return $app['twig']->render('editbrand.html.twig', array(
            'stores' => Store::getAll(),
            'brand' => $brand
        ));
    });

    $app->patch("/update_brand/{id}", function($id) use ($app) {
        //Route for when you click on update brand button
        $new_title = $_POST['title'];
        $brand = Brand::find($id);
        $brand->updateTitle($new_title);
        return $app['twig']->render('admin.html.twig', array(
            'brand' => $brand,
            'brands' => Brand::getAll(),
            'stores' => Store::getAll()
        ));
    });



    $app->post("/admin_add_brand", function() use ($app) {
        //Add a brand to the database
        $title = $_POST['title'];
        $copies_total = $_POST['copies_total'];
        $copies_available = $_POST['copies_total'];
        $brand = new Brand($id = null, $title, $copies_total, $copies_available);
        $brand->save();
        return $app['twig']->render('admin.html.twig', array(
            'stores' => Store::getAll(),
            'brands' => Brand::getAll()
        ));
    });

    $app->delete('/delete_all_brands', function() use ($app) {
		//Nuke all brands
		Brand::deleteAll();
		return $app['twig']->render('admin.html.twig', array(
            'stores' => Store::getAll(),
			'brands' => Brand::getAll()
	  ));
	});

    $app->delete('/delete_this_brand/{id}', function($id) use ($app) {
		//Delete a single brand
        $brand = Brand::find($id);
        $brand->delete();
		return $app['twig']->render('admin.html.twig', array(
            'stores' => Store::getAll(),
			'brands' => Brand::getAll()
	  ));
	});

    //////Store/////////////
    ////////////////////////

    $app->post('/admin_add_store', function() use ($app) {
        //adds an store Yay
        $name = $_POST['store'];
        $store = new Store($id = null, $name);
        $store->save();
        return $app['twig']->render('admin.html.twig', array(
            'brands' => Brand::getAll(),
            'stores' => Store::getAll()
        ));
    });

    $app->post('/add_store_to_brand', function() use ($app) {
        //adds store to individual brand
        $store = Store::find($_POST['store_id']);
        $brand = Brand::find($_POST['brand_id']);
        $brand->addStore($store);
        return $app['twig']->render('admin.html.twig', array(
            'brand' => $brand,
            'brands' => Brand::getAll(),
            'stores' => Store::getAll()
        ));
    });

    $app->delete('/delete_all_stores', function() use ($app) {
		//Nuke all stores
		Store::deleteAll();
		return $app['twig']->render('admin.html.twig', array(
            'stores' => Store::getAll(),
			'brands' => Brand::getAll()
	  ));
	});

    return $app;
?>
