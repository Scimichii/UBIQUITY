<?php
namespace controllers;
use Ubiquity\attributes\items\router\Get;

use models\Product;
use models\Section;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\orm\DAO;
/**
 * Controller StoreController
 */

class StoreController extends \controllers\ControllerBase{
    #[Route('_default', name: 'home')]
    public function index(){
        $prods = DAO::getAll(Section::class);
        $this->loadView("StoreController/index.html",compact('prods'));
    }

	#[Get(path: "Store/OtherProducts/{id}",name: "store.OtherProducts")]
	public function OtherProducts($id){
        $prod = DAO::getById(Section::class,"id=".$id);
		$this->loadView('StoreController/OtherProducts.html',compact('prod'));

	}

}
