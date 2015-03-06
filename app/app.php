<?php
  require_once __DIR__."/../vendor/autoload.php";
  require_once __DIR__."/../src/Addressbook.php";

  session_start();
  if (empty($_SESSION['list_of_contacts'])) {
    $_SESSION['list_of_contacts'] = array();
  }

  $app = new Silex\Application();
  $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
  ));

  $app->get("/", function() use ($app) {
    return $app['twig']->render('contact_homepage.twig', array('contacts' => Contact::getAll()));
  });

  $app->post("/create_contact", function() use ($app) {
    $contact = new Contact($_POST['name'], $_POST['number'], $_POST['address']);
    $contact ->save();
    return $app['twig']->render('create_contact.twig', array('newcontact' => $contact));
  });

  $app->post("/delete_contacts", function() use ($app) {
    Contact::deleteAll();
    return $app['twig']->render('delete_contacts.twig');
  });

  return $app;
?>
