<?php
// Namespace
namespace App\Http\Controllers\Api;
// Models
use App\Connections;
// Helpers
use AuthHelper;
use ConnectionsHelper;
// Others Dependencies
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConnectionsController extends Controller
{
    private $connections;
    private $requestData;
    private $authHelper;
    private $connHelper;
    public function __construct(Connections $connections, AuthHelper $authHelper, ConnectionsHelper $connHelper, Request $request)
    {
        $this->connections = $connections;
        $this->authHelper = $authHelper;
        $this->connHelper = $connHelper;
        $this->requestData = $request->all();
    }
    public function index()
    {
        $statusCode = 404;
        $request = $this->requestData;
        $data = $this->authHelper->autenticate($request);
        $errors = $data['errors'];
        $warnings = $data['warning'];
        if(count($errors)===0){
            $id = $data['id'];
            $collection = $this->connections->all()->where('user_id','=',$id);
            $data = ['data' => $collection];
        }else{
            unset($data);
            foreach ($errors as $err){
                $data['errors'][] = $err;
            }
        }
        if(count($warnings)>0){
            foreach ($warnings as $warning){
                $data['notice'][] = $warning;
            }
        }
        return response()->json($data,$statusCode);
    }
    public function dev()
    {
        $collection = $this->connections->all();
        $data = ['data' => $collection];
        return response()->json($data,200);
    }
    public function destroy($id)
    {
        $data['connection'] = $id;
        $data['delete'] = $this->connections->find($id)->delete();
    }
}
