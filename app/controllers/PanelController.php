<?php

class PanelController extends BaseController {
	protected $layout = 'panel.master';
	public function login(){
		$this->layout->content = View::make('panel.login');
	}
	public function loginProcess(){
		$rules = array(
			'user'=>'required|regex:/^[a-zA-Z-_]+$/',
			'pass'=>'required|alpha_num|min:6',
 		);
 		$validation = Validator::make(Input::all(), $rules);
		if($validation->fails()) 
			return "Username/Password combination incorrect.<br/>" . link_to('/login','Try again !');
			
		if( Auth::attempt( array('name' => Input::get('user'), 'password' => Input::get('pass') ) ) ){
			return Redirect::to('/admin');
		}
		return "Username/Password combination incorrect.<br/>" . link_to('/login','Try again !');
	}
	public function showAdd(){
		$this->layout->content = View::make('panel.add');
	}
	public function showDel(){
		$this->layout->content = View::make('panel.del');
	}
	public function showEdit(){
		$this->layout->content = View::make('panel.edit');
	}

	public function showNewUser(){
		$this->layout->content = View::make('panel.newuser');
	}

	public function uploadImage(){
		if(!Input::hasFile('myfile'))
			return Response::json(array('status_code' => 403));
		$rules = array(
				'myfile' => 'required|image|mimes:jpeg,png'
			);
		$validation = Validator::make(Input::all(), $rules);
		if($validation->fails())
			return Response::json(array('status_code' => 401));
		$file = Input::file('myfile');
		if($file->getSize() > 12 * 1024 * 1024)
			return Response::json(array('status_code' => 413));
		$filename =  Str::quickRandom(26) . ".jpg";
		$file->move(public_path() . '/gallery/' , $filename);
		return Response::json(array('status_code' => 200,'url' => URL::to('/gallery') . '/' . $filename));
	}
	public function add(){
		if(!Input::has('postData'))
			return Response::json(array('status_code' => 400));
		$ob = json_decode(Input::get('postData'));
		$exits = Place::where('url_referencia',$ob->ref_url)->get();
		if(count($exits)>0)
			return Response::json(array('status_code' => 304));
		$house = new Place;
		$house->descripcion = $ob->description;
		$house->descripcionEs = $ob->descriptionEs;
		$house->front_image = $ob->imgs->{0};
		$house->direccion = $ob->address;
		$house->dimensionesFeet = $ob->ft;
		$house->dimensionesMeter = $ob->m2;
		$house->area = $ob->mrkt_area;
		$house->dormitorios = $ob->bedrooms;
		$house->banios = $ob->baths;
		$house->garage = $ob->garage;
		$house->contruida_anio = $ob->year_built;
		$house->piscina = $ob->swimming_pool;
		$house->distritoEscolar = $ob->district;
		$house->escuelaKinder = $ob->elementaryl;
		$house->escuelaPrimaria = $ob->middle;
		$house->escuelaSecundaria = $ob->high;
		$house->url_referencia = $ob->ref_url;
		$house->precio = $ob->price;
		$house->permLink = $ob->permlink;
		$house->save();
		
		foreach($ob->imgs as $url){
			$article = Place::find($house->id);
			$img = new Image;
			$img->url = $url;
			$article->images()->save($img);
		}
		return Response::json(array('status_code' => 200));
	}
	public function delete(){
		$place = Place::find(Input::get('id'));
		if(!$place)
			return Response::json(array('status_code' => 404));
		$place->delete();
		return Response::json(array('status_code' => 200));
	}
	public function patch(){
		if(!Input::has('postData'))
			return Response::json(array('status_code' => 400));
		$ob = json_decode(Input::get('postData'));
		$house = Place::find($ob->id);
		if(count($house)<0)
			return Response::json(array('status_code' => 404,$house));
		$house->descripcion = $ob->descripcion;
		$house->descripcionEs = $ob->descripcionEs;
		$house->front_image = $ob->imgs->{0};
		$house->direccion = $ob->direccion;
		$house->dimensionesFeet = $ob->dimensionesFeet;
		$house->dimensionesMeter = $ob->dimensionesMeter;
		$house->area = $ob->area;
		$house->dormitorios = $ob->dormitorios;
		$house->banios = $ob->banios;
		$house->garage = $ob->garage;
		$house->contruida_anio = $ob->contruida_anio;
		$house->piscina = $ob->piscina;
		$house->distritoEscolar = $ob->distritoEscolar;
		$house->escuelaKinder = $ob->escuelaKinder;
		$house->escuelaPrimaria = $ob->escuelaPrimaria;
		$house->escuelaSecundaria = $ob->escuelaSecundaria;
		$house->url_referencia = $ob->url_referencia;
		$house->precio = $ob->precio;
		$house->permLink = $ob->permLink;
		$house->save();
		Image::where('place_id', '=', $house->id)->forceDelete();
		foreach($ob->imgs as $url){
			$article = Place::find($house->id);
			$img = new Image;
			$img->url = $url;
			$article->images()->save($img);
		}
		return Response::json(array('status_code' => 200));
	}
	public function addUser(){
		try {
			$return = array('status_code' => 400);
			$user_data = Input::all();
			$rules = array(
				'user' => 'required|min:6',
				'pass' => 'required|alpha_num|min:6',
				'repass' => 'required|alpha_num|min:6'
			);
			$validation = Validator::make($user_data,$rules);
			if($validation->fails())
				return Response::json($return);
			if($user_data['pass'] !== $user_data['repass'])
				return Response::json($return);
			$newUser = new User;
			$newUser->name = $user_data['user'];
			$newUser->password = Hash::make($user_data['pass']);
			if(!$newUser->save())
				return Response::json($return);
			$return['status_code'] = 200;
			return $return;
		}catch(ErrorException $e){
			$return['status_code'] = 500;
			return Response::json($return);
		}
	}
			
}