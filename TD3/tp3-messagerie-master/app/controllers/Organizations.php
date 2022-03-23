<?php
namespace controllers;
 use Ubiquity\orm\DAO;
use models\Organization;

 /**
 * Controller Organizations
 **/
class Organizations extends ControllerBase{

	public function index(){
	    $orgas=DAO::getAll(Organization::class,'',['users']);
		$this->loadView("Organizations/index.html",['orgas'=>$orgas]);
	}

	public function display($idOrga){
		$orga=DAO::getOne(Organization::class, $idOrga,true);
		$this->loadView('Organizations/display.html',['orga'=>$orga]);

	}

}
