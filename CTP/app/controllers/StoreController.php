<?php
namespace controllers;
use Ubiquity\attributes\items\router\Post;
use Ubiquity\attributes\items\router\Get;

use models\Product;
use models\Section;
use Ubiquity\attributes\items\router\Route;
use Ubiquity\orm\DAO;
use Ubiquity\utils\http\UResponse;
use Ubiquity\utils\http\USession;

/**
 * Controller StoreController
 */

class StoreController extends \controllers\ControllerBase{
    public function initialize()
    {
        $tot = USession::get('totpannier')??0;
        $prix = USession::get('prixtot')??0;
        $this->view->setVar('totpannier',$tot);
        $this->view->setVar('prixtot',$prix);
        parent::initialize();

    }

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
        $prod = DAO::getById(Product::class,$idproduct);
        USession::start();
        $products = 0;
        if(USession::get($idproduct) != null) {
            $products = USession::get($idproduct) + $count;
        }
        else{
             $products =$count;
            }
        USession::set($idproduct,$products);
        $prixtot = 0;
        if(USession::get("prixtot") != null) {
            $prixtot = USession::get("prixtot") + $prod->getPrice() * $count;
        }
        else{
            $prixtot=$prod->getPrice() * $count;
        }
        USession::set("prixtot",$prixtot);

        $totpannier = 0;
        if(USession::get("totpannier") != null) {
            $totpannier = USession::get("totpannier") + $count;
        }
        else{
            $totpannier =$count;
        }
        USession::set("totpannier",$totpannier);
        UResponse::header('Location', '/');
	}



	#[Route(path: "Store/allProducts",name: "store.allProducts")]
	public function allProducts(){
        $prod = DAO::getAll(Product::class);
		$this->loadView('StoreController/allProducts.html',compact('prod'));

	}

}
