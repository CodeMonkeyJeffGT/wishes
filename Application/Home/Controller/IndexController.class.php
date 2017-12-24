<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	if( ! empty(session('user')))
    	{
    		header('location:/1214/index.html');die;
    	}
    	else if( ! empty(session('acc')))
    	{
    		header('location:/1217/list.html');die;
    	}
    	else
    	{
    		header('location:/page.html');die;
    	}
    }
}