<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerModel;
use Validator;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class CustomerController extends Controller {

	public function index()
    {
        $userData = CustomerModel::latest()->paginate(5);

        return view('index', ['userData' => $userData])->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|regex:/^[a-zA-Z.]+$/u',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|min:10|max:12',
            'country' => 'required'
        ]);

        $newUserData = $request->all();
        $newUserData['created_at'] = date("Y-m-d H:i:s");
  
        CustomerModel::create($newUserData);
print_r($newUserData);

        $url = env('AUTH_URL');
        
        $client = new Client();
        $result = $client->get( $url,[
            'query' => [
               "grant_type" => "client_credentials",
               "client_id"=> env('CLIENT_ID'),
               "client_secret" => env('CLIENT_SECRET')
            ]
        ] );
        $contents = json_decode($result->getBody()->getContents());
         

        $accessToken = $contents->access_token;
  

// print_r(json_encode(['access_token' => $accessToken,
//                           	[  
// 	                          	'action' => 'createOnly',
// 	                            'lookupField' => 'email',
// 	                            'input' => [
// 	                            	"email" => "kjashaedd-1@klooblept.com",
// 							         "firstName" =>"Kataldar-1",
// 							         "postalCode"=> "04828"
// 	                            ]
// 	                        ]]));
        $apiPostResponse = $client->post(env('POST_URL'), [
        					'headers' => [
					            'Accept' => 'application/json',
					            'Authorization' => 'Bearer ' . $accessToken,
					            'Content-Type' => 'application/json',
					        ],
                            // 'access_token' => $accessToken,
                          	'action' => 'createOnly',
                            'lookupField' => 'email',
                            'input' => [[
                            	"email" => $newUserData['email'],
						         "firstName" =>$newUserData['name'],
						         "postalCode"=> "04828"
                            ]]
	                        
                        ]);
		$contentsrES = json_decode($apiPostResponse->getBody()->getContents());

 
        return redirect()->route('customer.index')
                        ->with('success','User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserData  $userData
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userData = CustomerModel::find($id);
        return view('show',compact('userData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserData  $userData
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userData = CustomerModel::find($id);
        return view('edit',compact('userData','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserData  $userData
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {

    	$request->validate([
            'name'  => 'required|regex:/^[a-zA-Z.]+$/u',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|min:10|max:12',
            'country' => 'required'
        ]);


        $userData = CustomerModel::find($id);
        $userData->name = request('name');
        $userData->email = request('email');
        $userData->save();
                $request->validate([
                'name' => 'required',
                'email' => 'required',
         ]);
        $userData->update($request->all());
  
        return redirect()->route('customer.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserData  $userData
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CustomerModel::find($id)->delete();
  
        return redirect()->route('userData.index')
                        ->with('success','User deleted successfully');
    }

    public function dashboard(){
        
        $url = env('THIRDPARTY_API_URL');
        
        $client = new Client();
        $result = $client->get( $url );
        $contents = json_decode($result->getBody()->getContents());
    
        return view('dashboard',['data'=>$contents]);
    }
}
