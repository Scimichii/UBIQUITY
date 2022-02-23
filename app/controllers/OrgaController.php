<?php
namespace controllers;
use Ubiquity\attributes\items\router\Route;
use models\Organization;
use Ubiquity\orm\DAO;
 /**
  * Controller OrgaController
  */
class OrgaController extends \controllers\ControllerBase{

	public function index(){
		$orgas = DAO::getAll(Organization::class);
		$this->loadView("OrgaController/index.html",compact('orgas'));	
	}

	#[Route(path: "orga/getOne/{idOrga}",name: "orga.getOne")]
	public function getOne($idOrga){
		$orga= DAO::getById(Organization::class,$idOrga);
		$this->loadView('OrgaController/getOne.html',compact("orga"));

	}

}
