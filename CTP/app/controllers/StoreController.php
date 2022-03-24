<?php
namespace controllers;
use Ubiquity\attributes\items\router\Post;
use Ubiquity\attributes\items\router\Get;

use models\Product;
use models\Section;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\orm\DAO;
use Ubiquity\utils\http\USession;

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


	#[Post(path: "Store/addtocart/{idproduct}/{count}",name: "store.addtocart")]
	public function addtocart($idproduct,$count){
        $prod = DAO::getById(Section::class,"id=".$idproduct,"count = .$count");
		$this->index();

        if(USession::get("checkout") == null){
            USession::set("checkout",[[$idproduct=>1]]);


        }else{
            $pannier = USession::get("checkout");
            $pannier = array_merge($pannier,[[$idproduct=>1]]) ;
            USession::set("checkout",$pannier);
        }

	}


	#[Route(path: "Store/allProducts",name: "store.allProducts")]
	public function allProducts(){
        $prods = DAO::getAll(Section::class);
		$this->loadView('StoreController/allProducts.html',compact('prods'));

	}

}
